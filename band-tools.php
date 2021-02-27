<?php
/**
 * Plugin Name:     Bands Tools
 * Plugin URI:      https://git.magiiic.com/wordpress/band-tools
 * Description:     Tools for artists, bands, musicians, ...
 * Author:          Olivier van Helden
 * Author URI:      https://magiiic.com/
 * Text Domain:     band-tools
 * Domain Path:     /languages
 * Version:         0.3.5
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

function bndtls_load_textdomain() {
	$textdomain = "band-tools";
	load_plugin_textdomain( $textdomain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'bndtls_load_textdomain' );

require_once __DIR__ . '/inc/post-types.php';
require_once __DIR__ . '/inc/widgets.php';

/** Enable plugin updates with license check **/
require_once plugin_dir_path( __FILE__ ) . 'lib/wp-package-updater/class-wp-package-updater.php';
$band_tools_updater = new WP_Package_Updater(
	'https://magiiic.com',
	wp_normalize_path( __FILE__ ),
	wp_normalize_path( plugin_dir_path( __FILE__ ) ),
	// true
);

if(is_admin()) {
	require_once __DIR__ . '/admin/init.php';
	// require_once __DIR__ . '/admin/wp-dependencies.php';
}

function bndtls_load_plugin_css() {
	// $plugin_url = plugin_dir_url( __FILE__ );
	wp_enqueue_style( 'cdt', plugin_dir_url( __FILE__ ) . 'style.css' );
	// dev only
	// wp_enqueue_style( 'cdt', plugin_dir_url( __FILE__ ) . 'style.css', array(), time() , 'all' );
}
add_action( 'wp_enqueue_scripts', 'bndtls_load_plugin_css' );

if(get_option('bndtls_clean_titles')) {
	function cendryn_prefix_category_title( $title ) {
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
	add_filter( 'get_the_archive_title', 'cendryn_prefix_category_title',20 );
}
