<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

require_once __DIR__ . '/custom-fields.php';
require_once __DIR__ . '/taxonomies.php';

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

// add_filter( 'the_content', 'bndtls_wc_print_notices');
// function bndtls_wc_print_notices ( $content ) {
//   // global $template;
//   // $plugindir = dirname( __DIR__ );
//   if( get_post_type() === "songs") wc_print_notices();
// }

add_action( 'mb_relationships_init', 'bndtls_register_relationships_woocommerce' );
function bndtls_register_relationships_woocommerce() {
	$singular['bands'] = __(bndtls_get_option( 'naming_' . 'band', 'Band', 'singular' ), 'band-tools');
	$singular['records'] = __(bndtls_get_option( 'naming_' . 'record', 'Record', 'singular' ), 'band-tools');
	$singular['songs'] = __(bndtls_get_option( 'naming_' . 'song', 'Song', 'singular' ), 'band-tools');
	$singular['tracks'] = __(bndtls_get_option( 'naming_' . 'track', 'Track', 'singular' ), 'band-tools');
	$singular['products'] = __(bndtls_get_option( 'naming_' . 'product', 'Product', 'singular' ), 'band-tools');
	$adaptive['bands'] = get_type_name_n('band', 'Band', 'Bands', bndtls_count_posts('bands'));
	$adaptive['records'] = get_type_name_n('record', 'Record', 'Records', bndtls_count_posts('records'));
	$adaptive['songs'] = get_type_name_n('song', 'Song', 'Songs', bndtls_count_posts('songs'));
	$adaptive['tracks'] = get_type_name_n('track', 'Track', 'Tracks', bndtls_count_posts('songs'));
	$adaptive['products'] = get_type_name_n('product', 'Product', 'Products', bndtls_count_posts('songs'));

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
}

endif;
