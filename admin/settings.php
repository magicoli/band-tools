<?php
/**
 * Settings
 *
 * Author: Olivier van Helden
 * Version: 0.0.1
 */

if ( ! defined( 'WPINC' ) ) die;

function bndtls_register_settings() {
  if ( ! current_user_can( 'manage_options' ) ) {
    $readonly=true;
  }

  // bndtls_settings_add_option( 'bndtls_licence_key', "", array(
  //   'name' => __('Licence key', 'band-tools'),
  //   'description' => __('Licence key will unlock automatic updates and future features.', 'band-tools'),
  //   'readonly' => $readonly,
  // ));
  // bndtls_settings_add_option( 'bndtls_token', "", array(
  //   'name' => __('Token', 'band-tools'),
  //   'description' => __('Random string, used to authenticate passwordless exports. If changed, any existing automation must be reconfigured with the new download url.', 'band-tools'),
  //   'readonly' => $readonly,
  // ));

  bndtls_settings_add_option('bndtls_clean_titles', "", array(
    'category' => __('Tweaks', 'band-tools'),
    'name' => __('Clean titles', 'band-tools'),
    'description' => __('Remove prefixes from titles for Categories, Taxonomies, Archives, Authors, Taxes', 'band-tools'),
    'type'=>'boolean',
    'readonly' => $readonly,
    'default' => true,
  ));
  bndtls_settings_add_option('bndtls_coffee', "", array(
    'category' => __('Tweaks', 'band-tools'),
    'name' => __('Make coffee after login', 'band-tools'),
    'type'=>'boolean',
    'readonly' => $readonly,
  ));
}
add_action( 'admin_init', 'bndtls_register_settings' );

function bndtls_display_settings_page()
{
  global $CastingDirectorOptions;
	// if ( ! current_user_can( 'manage_options' ) ) {
	// 		return;
	// }
	require(plugin_dir_path(__FILE__) . 'inc/settings-page.php');
}

function bndtls_settings_link( $links ) {
	// Build and escape the URL.
	$url = esc_url( add_query_arg(
		'page',
		'band-tools',
		get_admin_url() . 'options-general.php'
	) );
	// Create the link.
	$settings_link = "<a href='$url'>" . __( 'Settings', 'band-tools') . '</a>';
	// Adds the link to the end of the array.
	array_push(
		$links,
		$settings_link
	);
	return $links;
} //end bndtls_settings_link()
add_filter( 'plugin_action_links_band-tools/band-tools.php', 'bndtls_settings_link' );

function bndtls_settings_add_option($option, $default=NULL, $args) {
    global $CastingDirectorOptions;
    if(empty($option)) return;

    if(empty($args['category'])) $args['category'] = 'default';
    if(empty($args['type'])) $args['type'] = 'string';
    if(empty($args['name'])) $args['name'] = $option;

    $CastingDirectorOptions[$args['category']][$option]=$args;
    add_option( $option, $default);
    register_setting( 'band_tools', $option, $args);
}
