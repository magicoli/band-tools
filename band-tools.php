<?php
/**
 * Plugin Name:     Band Tools
 * Plugin URI:      https://magiiic.com/wordpress/band-tools/
 * Description:     Tools for artists, bands, musicians, ...
 * Author:          Magiiic
 * Author URI:      https://magiiic.com/
 * Text Domain:     band-tools
 * Domain Path:     /languages
 * Version:         0.7.6
 *
 * @package         Band_Tools
 *
 * Icon1x: https://git.magiiic.com/wordpress/band-tools/-/raw/master/assets/icon-128x128.jpg
 * Icon2x: https://git.magiiic.com/wordpress/band-tools/-/raw/master/assets/icon-256x256.jpg
 * BannerHigh: https://git.magiiic.com/wordpress/band-tools/-/raw/master/assets/banner-1544x500.jpg
 * BannerLow: https://git.magiiic.com/wordpress/band-tools/-/raw/master/assets/banner-772x250.jpg
 * Screenshot-1: https://git.magiiic.com/wordpress/band-tools/-/raw/master/assets/screenshot-1.jpg
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;
if ( ! defined( 'BNDTLS_PLUGIN' ) ) define('BNDTLS_PLUGIN', 'band-tools/band-tools.php' );

require_once __DIR__ . '/includes/init.php';
if(is_admin()) {
	require_once __DIR__ . '/admin/admin-init.php';
	// require_once __DIR__ . '/admin/wp-dependencies.php';
}
if(!bndtls_get_option('disable_templates'))
require_once __DIR__ . '/templates/templates.php';

if(bndtls_get_option('clean_titles')) {
	function bndtls__prefix_category_title( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>' ;
		} elseif ( is_tax() ) { //for custom post types
			$title = sprintf( '%1$s', __( single_term_title( '', false ) ) );
		} elseif (is_post_type_archive()) {
			$title = post_type_archive_title( '', false );
		}
		return $title;
	}
	add_filter( 'get_the_archive_title', 'bndtls__prefix_category_title',20 );
}

if(bndtls_get_option('redirect_single_post_archives')) {
	function bndtls_redirect_cpt_archive() {
		$type=get_queried_object()->name;
		if(wp_count_posts($type)->publish == 1) {
			$post=get_posts(array('post_type' => $type))[0];
			wp_redirect( get_permalink($post), 301 );
			exit();
		}
	}
	add_action( 'template_redirect', 'bndtls_redirect_cpt_archive' );
}

// function display_post_type_nav_box(){
//
//     $hidden_nav_boxes = get_user_option( 'metaboxhidden_nav-menus' );
//
//     $post_type = 'foobar'; //Can also be a taxonomy slug
//     $post_type_nav_box = 'add-'.$post_type;
//
//     if(is_array($hidden_nav_boxes) && in_array($post_type_nav_box, $hidden_nav_boxes)):
//         foreach ($hidden_nav_boxes as $i => $nav_box):
//             if($nav_box == $post_type_nav_box)
//                 unset($hidden_nav_boxes[$i]);
//         endforeach;
//         update_user_option(get_current_user_id(), 'metaboxhidden_nav-menus', $hidden_nav_boxes);
//     endif;
// }
// add_action('admin_init', 'display_post_type_nav_box');
