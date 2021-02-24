<?php
/**
 * Settings
 *
 * Author: Olivier van Helden
 * Version: 0.0.1
 */

if ( ! defined( 'WPINC' ) ) die;

require(plugin_dir_path(__FILE__) . 'menus.php');
require(plugin_dir_path(__FILE__) . 'settings.php');
// require(plugin_dir_path(__FILE__) . 'woocommerce.php');

add_action( 'wp_loaded', 'disable_theme_registration_notice' );
function disable_theme_registration_notice() {
  update_site_option( 'the7_registered', 'yes' );
}
