<?php
/**
 * Plugin Name:     Band Tools
 * Plugin URI:      https://magiiic.com/wordpress/band-tools/
 * Description:     Tools for artists, bands, musicians, ...
 * Author:          Magiiic
 * Author URI:      https://magiiic.com/
 * Text Domain:     band-tools
 * Domain Path:     /languages
 * Version:         0.11
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
if(is_admin() || isset( $_REQUEST['wp_customize'] ) ) {
	require_once __DIR__ . '/admin/layout.php';
}

if(!bndtls_get_option('disable_templates'))
require_once __DIR__ . '/templates/templates.php';

register_activation_hook( __FILE__, 'activate_band_tools' );
function activate_band_tools() {
	update_option('bndtls_rewrite_rules', true);
}

register_deactivation_hook( __FILE__, 'deactivate_band_tools' );
function deactivate_band_tools() {
	update_option('bndtls_rewrite_rules', true);
}

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
