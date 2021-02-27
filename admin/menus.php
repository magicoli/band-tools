<?php
/**
 * Settings
 *
 * Author: Olivier van Helden
 * Version: 0.0.1
 */

if ( ! defined( 'WPINC' ) ) die;

global $bndtls_options;
function bndtls_register_settings_pages() {
  // default Settings submenu
  // add_options_page(Band Tools, Band Tools, 'manage_options', band-tools, 'bndtls_display_settings_page');

  // Own menu
  add_menu_page(
    'Band Tools', // page title
    'Band Tools', // menu title
    'list_users', // capability
    'band-tools', // slug
    'bndtls_display_settings_page', // callable function
    // plugin_dir_path(__FILE__) . 'options.php', // slug
    // null,	// callable function
    plugin_dir_url(__FILE__) . '../assets/svg-microphone-stand-20x20.svg', // plugin_dir_url(__FILE__) . '../assets/icon-24x24.jpg', // icon url
    2 // position
  );
  // add_submenu_page(
  //   'band-tools',  // parent_slug
  //   __('Band Tools Settings', "band-tools"), // $page_title
  //   __('Settings'), // menu_title
  //   'list_users',
  //   // 'manage_options', // capability
  //   'band-tools-settings', // menu_slug
  //   'bndtls_display_settings_page', // callable function
  // );
  // add_submenu_page(
  //   '', // parent_slug
  //   '', // $page_title
  //   '', // menu_title
  //   '', // capability
  //   '', // menu_slug
  //   '', // callable function
  //   '', // position
  // );
}
add_action('admin_menu', 'bndtls_register_settings_pages');
