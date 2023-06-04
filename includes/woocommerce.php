<?php
if (!defined('WPINC')) {die;}

add_action( 'woocommerce_add_to_cart', 'action_woocommerce_add_to_cart', 10, 6 );
function action_woocommerce_add_to_cart( $cart_item_key,  $product_id,  $quantity,  $variation_id = 0,  $variation = array(),  $cart_item_data = array() ) {
  $query_args = array(
    'post_type' => 'records',
  );
  $meta_query = new WP_Query( $query_args );
  $records = $meta_query->posts;
  foreach($records as $record) {
    $record_product = rwmb_meta('record_product', array(), $record->ID );
    if($record_product == $product_id) {
      $related[] = $record->ID;
      $tracks = array_shift(get_post_meta($record->ID, 'tracks'));
      foreach($tracks as $track) {
        $track_product = $track['track_product'];
        if($track_product) {
          foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            if ( $cart_item['product_id'] == $track_product && $track_product != $record_product ) {
              WC()->cart->remove_cart_item( $cart_item_key );
              $removed[] = $cart_item;
            }
          }
        }
      }
    }
  }
};

add_filter( 'rwmb_meta_boxes', 'bndtls_settings_layout_woocommerce', 20 );

function bndtls_settings_layout_woocommerce( $meta_boxes ) {
  if(isset($meta_boxes['band_tools_customizer']['fields']['record_default']['options'])) {
    $meta_boxes['band_tools_customizer']['fields']['record_default']['options'] = array_merge(
      array(
        'addtocart'							=> _x( 'Show add to cart button', 'layout-settings', 'band-tools' ),
      ),
      $meta_boxes['band_tools_customizer']['fields']['record_default']['options'],
    );
  }
  return $meta_boxes;
}
