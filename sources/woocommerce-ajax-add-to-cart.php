<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

add_action('wp_enqueue_scripts', 'woocommerce_ajax_add_to_cart_js', 99);
function woocommerce_ajax_add_to_cart_js() {
    if (function_exists('is_product') && is_product()) {
        wp_enqueue_script('woocommerce-ajax-add-to-cart', plugin_dir_url(__FILE__) . 'js/woocommerce-ajax-add-to-cart.js', array('jquery'), '', true);
    }
}

add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart() {

  $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
  $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
  $variation_id = absint($_POST['variation_id']);
  $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
  $product_status = get_post_status($product_id);

  if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

    do_action('woocommerce_ajax_added_to_cart', $product_id);

    if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
      wc_add_to_cart_message(array($product_id => $quantity), true);
    }

    WC_AJAX :: get_refreshed_fragments();
  } else {

    $data = array(
      'error' => true,
      'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
    );

    echo wp_send_json($data);
  }

  wp_die();
}

// require_once __DIR__ . '/custom-fields.php';
// require_once __DIR__ . '/taxonomies.php';

// if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

// add_filter( 'the_content', 'bndtls_wc_print_notices');
// function bndtls_wc_print_notices ( $content ) {
//   // global $template;
//   // $plugindir = dirname( __DIR__ );
//   if( get_post_type() === "songs") wc_print_notices();
// }

// add_action( 'mb_relationships_init', 'bndtls_register_relationships_woocommerce' );
// function bndtls_register_relationships_woocommerce() {
	// $singular['bands'] = __(bndtls_get_option( 'naming_' . 'band', 'Band', 'singular' ), 'band-tools');
	// $singular['records'] = __(bndtls_get_option( 'naming_' . 'record', 'Record', 'singular' ), 'band-tools');
	// $singular['songs'] = __(bndtls_get_option( 'naming_' . 'song', 'Song', 'singular' ), 'band-tools');
	// $singular['tracks'] = __(bndtls_get_option( 'naming_' . 'track', 'Track', 'singular' ), 'band-tools');
	// $singular['products'] = __(bndtls_get_option( 'naming_' . 'product', 'Product', 'singular' ), 'band-tools');
	// $adaptive['bands'] = get_type_name_n('band', 'Band', 'Bands', bndtls_count_posts('bands'));
	// $adaptive['records'] = get_type_name_n('record', 'Record', 'Records', bndtls_count_posts('records'));
	// $adaptive['songs'] = get_type_name_n('song', 'Song', 'Songs', bndtls_count_posts('songs'));
	// $adaptive['tracks'] = get_type_name_n('track', 'Track', 'Tracks', bndtls_count_posts('songs'));
	// $adaptive['products'] = get_type_name_n('product', 'Product', 'Products', bndtls_count_posts('songs'));

	// MB_Relationships_API::register( [
	// 	'id'         => 'rel-records-products',
	// 	// 'reciprocal' => true,
	// 	'from'       => [
	// 		'object_type'  => 'post',
	// 		'post_type'    => 'records',
	// 		'admin_column' => [
	// 			'position' => 'after title',
	// 			'title'    => $adaptive['products'],
	// 			'singular' => $singular['products'],
	// 			'link'     => 'view',
	// 		],
	// 		'meta_box'     => [
	// 			'title'   => $adaptive['products'],
	// 			'singular' => $singular['products'],
	// 			'context'  => 'normal',
	// 			'priority' => 'high',
	// 			'class'    => 'record-product',
	// 		],
	// 		'field'        => [
	// 			'name'  => 'Products',
	// 			'class' => 'record-product',
	// 		],
	// 	],
	// 	'to'         => [
	// 		'object_type'  => 'post',
	// 		'post_type'    => 'product',
	// 		'admin_column' => [
	// 			'position' => 'after title',
	// 			'link'     => 'view',
	// 		],
	// 		'admin_column' => [
	// 			'position' => 'after title',
	// 			'title'    => $adaptive['records'],
	// 			'singular' => $singular['records'],
	// 			'link'     => 'view',
	// 			'class' => 'record-product',
	// 		],
	// 		'meta_box'    => [
	// 			'title'   => $adaptive['records'],
	// 			'singular'   => $singular['records'],
	// 			'context' => 'normal',
	// 			'class' => 'record-product',
	// 		],
	// 	],
	// ] );
	//
  // MB_Relationships_API::register( [
	// 	'id'         => 'rel-songs-products',
	// 	// 'reciprocal' => true,
	// 	'from'       => [
	// 		'object_type'  => 'post',
	// 		'post_type'    => 'songs',
	// 		'admin_column' => [
	// 			'position' => 'after title',
	// 			'title'    => $adaptive['products'],
	// 			'singular' => $singular['products'],
	// 			'link'     => 'view',
	// 		],
	// 		'meta_box'     => [
	// 			'title'   => $adaptive['products'],
	// 			'singular' => $singular['products'],
	// 			'context'  => 'normal',
	// 			'priority' => 'high',
	// 			'class'    => 'song-product',
	// 		],
	// 		'field'        => [
	// 			'name'  => 'Products',
	// 			'class' => 'song-product',
	// 		],
	// 	],
	// 	'to'         => [
	// 		'object_type'  => 'post',
	// 		'post_type'    => 'product',
	// 		'admin_column' => [
	// 			'position' => 'after title',
	// 			'link'     => 'view',
	// 		],
	// 		'admin_column' => [
	// 			'position' => 'after title',
	// 			'title'    => $adaptive['songs'],
	// 			'singular' => $singular['songs'],
	// 			'link'     => 'view',
	// 			'class' => 'song-product',
	// 		],
	// 		'meta_box'    => [
	// 			'title'   => $adaptive['songs'],
	// 			'singular'   => $singular['songs'],
	// 			'context' => 'normal',
	// 			'class' => 'song-product',
	// 		],
	// 	],
	// ] );
// }
// endif;
