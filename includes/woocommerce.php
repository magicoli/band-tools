<?php
if (!defined('WPINC')) {die;}

add_action( 'woocommerce_add_to_cart', 'action_woocommerce_add_to_cart', 10, 6 );
function action_woocommerce_add_to_cart( $cart_item_key,  $product_id,  $quantity,  $variation_id = 0,  $variation = array(),  $cart_item_data = array() ) {
  $query_args = array(
    'post_type' => 'records',
    // 'orderby'          => 'post_date',
    // 'order'            => 'DESC',
    // 'posts_per_page'  => -1,
    // 'meta_key' => 'record_product',
    // 'meta_value' => $product_id,
    // 'meta_compare' => 'IN',
    // 'meta_query' => array(
    //   array(
    //     'key' => 'record_product',
    //     'value' => $product_id,
    //     'compare' => '=',
    //     'type' => 'NUMERIC'
    //   ),
    // )
  );
  $meta_query = new WP_Query( $query_args );
  $records = $meta_query->posts;
  foreach($records as $record) {
    if(rwmb_meta('record_product', array(), $record->ID ) == $product_id) {
      $related[] = $record->ID;
      $tracks = array_shift(get_post_meta($record->ID, 'tracks'));
      foreach($tracks as $track) {
        $track_product = $track['track_product'];
        if($track_product) {
          foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            if ( $cart_item['product_id'] == $track_product ) {
              WC()->cart->remove_cart_item( $cart_item_key );
              $removed[] = $cart_item;
            }
          }
        }
      }
    }
  }
};
