<?php
/**
 * Plugin Name:     Bands Tools
 * Plugin URI:      https://git.magiiic.com/wordpress/band-tools
 * Description:     Tools for bands, artists, musicians
 * Author:          Olivier van Helden
 * Author URI:      https://magiiic.com/
 * Text Domain:     band-tools
 * Domain Path:     /languages
 * Version:         0.2.6
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
