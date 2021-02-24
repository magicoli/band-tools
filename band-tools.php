<?php
/**
 * Plugin Name:     Bands Tools
 * Plugin URI:      https://git.magiiic.com/wordpress/band-tools
 * Description:     Tools for bands, artists, musicians
 * Author:          Olivier van Helden
 * Author URI:      https://magiiic.com/
 * Text Domain:     band-tools
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Band_Tools
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

/** Enable plugin updates with license check **/
require_once plugin_dir_path( __FILE__ ) . 'lib/wp-package-updater/class-wp-package-updater.php';
$band_tools_updater = new WP_Package_Updater(
	'https://magiiic.com',
	wp_normalize_path( __FILE__ ),
	wp_normalize_path( plugin_dir_path( __FILE__ ) ),
	// true
);
