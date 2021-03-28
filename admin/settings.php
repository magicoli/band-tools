<?php if ( ! is_admin() ) die;
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

  bndtls_settings_add_option( 'license_key_band-tools', "", array(
  	'name' => __('License key', 'band-tools'),
  	'description' => BNDTLS_REGISTER_TEXT,
    'readonly' => true,
  ));

  bndtls_settings_add_option( 'bndtls_naming_bands', "", array(
    'category' => __('Naming', 'band-tools'),
    'name' => sprintf("%s (%s)", __('Bands', 'band-tools'), __('plural', 'band-tools')),
    'default' => __('Bands', 'band-tools'),
  ));
  bndtls_settings_add_option( 'bndtls_naming_band', "", array(
    'category' => __('Naming', 'band-tools'),
    'name' => sprintf("%s (%s)", __('Band', 'band-tools'), __('singular', 'band-tools')),
    'default' => __('Band', 'band-tools'),
  ));
  bndtls_settings_add_option( 'bndtls_naming_albums', "", array(
    'category' => __('Naming', 'band-tools'),
    'name' => sprintf("%s (%s)", __('Albums', 'band-tools'), __('plural', 'band-tools')),
    'default' => __('Albums', 'band-tools'),
  ));
  bndtls_settings_add_option( 'bndtls_naming_album', "", array(
    'category' => __('Naming', 'band-tools'),
    'name' => sprintf("%s (%s)", __('Album', 'band-tools'), __('singular', 'band-tools')),
    'default' => __('Album', 'band-tools'),
  ));
  bndtls_settings_add_option( 'bndtls_naming_songs', "", array(
    'category' => __('Naming', 'band-tools'),
    'name' => sprintf("%s (%s)", __('Songs', 'band-tools'), __('plural', 'band-tools')),
    'default' => __('Songs', 'band-tools'),
  ));
  bndtls_settings_add_option( 'bndtls_naming_song', "", array(
    'category' => __('Naming', 'band-tools'),
    'name' => sprintf("%s (%s)", __('Song', 'band-tools'), __('singular', 'band-tools')),
    'default' => __('Song', 'band-tools'),
  ));

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

  bndtls_settings_add_option('bndtls_widget_area', "", array(
    'category' => __('Tweaks', 'band-tools'),
    /* translators: %s is replaced by the name of the plugin, untranslated */
    'name' => sprintf(__('%s widget area', 'band-tools'), 'Band Tools'),
    'type'=>'boolean',
    'default' => false,
  ));

  bndtls_settings_add_option('bndtls_clean_titles', "", array(
    'category' => __('Tweaks', 'band-tools'),
    'name' => __('Clean titles', 'band-tools'),
    'description' => __('Remove prefixes from titles for Categories, Taxonomies, Archives, Authors', 'band-tools'),
    'type'=>'boolean',
    'readonly' => $readonly,
    'default' => true,
  ));
  bndtls_settings_add_option('bndtls_redirect_single_post_archives', "", array(
    'category' => __('Tweaks', 'band-tools'),
    'name' => __('Redirect archives containing only one post', 'band-tools'),
    'type'=>'boolean',
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
  global $bndtls_options;
	// if ( ! current_user_can( 'manage_options' ) ) {
	// 		return;
	// }
	require(plugin_dir_path(__FILE__) . 'includes/settings-page.php');
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
    global $bndtls_options;
    if(empty($option)) return;

    if(empty($args['category'])) $args['category'] = 'default';
    if(empty($args['type'])) $args['type'] = 'string';
    if(empty($args['name'])) $args['name'] = $option;

    $bndtls_options[$args['category']][$option]=$args;
    add_option( $option, $default);
    register_setting( 'band_tools', $option, $args);
}
