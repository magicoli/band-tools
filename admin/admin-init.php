<?php if ( ! is_admin() ) die;

// Redirect to settings page after activation
function band_tools_activation_redirect( $plugin ) {
  if( $plugin == BNDTLS_PLUGIN ) {
    exit( wp_redirect( admin_url( 'admin.php?page=band-tools' ) ) );
  }
}
add_action( 'activated_plugin', 'band_tools_activation_redirect' );

// require(plugin_dir_path(__FILE__) . 'dependencies.php');
// require(plugin_dir_path(__FILE__) . 'activation.php');
require(plugin_dir_path(__FILE__) . 'menus.php');
require(plugin_dir_path(__FILE__) . 'settings.php');
// require(plugin_dir_path(__FILE__) . 'woocommerce.php');


// Fix license key warning on plugins page if there is a license key
//
add_action( 'admin_head', 'bndtls_alter_license_notice', 99, 0 );
function bndtls_alter_license_notice() {
  // global $bndtls_alter_license_form;
  // if ( $bndtls_alter_license_form ) return;
  $handle = BNDTLS_SLUG . '-wppus-hide-licence-warnings';
  $js = plugins_url(BNDTLS_SLUG . '/includes/js/wppus-hide-licence-warnings.js');
  wp_register_script( $handle, $js, array( 'wp-i18n', 'jquery' ) );
  // wp_set_script_translations( $handle, 'band-tools' );
  wp_enqueue_script( $handle, $js );
  foreach ( [ 'BNDTLS_SLUG', 'BNDTLS_DATA_SLUG', 'BNDTLS_PLUGIN', 'BNDTLS_TXDOM', 'BNDTLS_REGISTER_TEXT' ] as $CONST ) {
    wp_add_inline_script( $handle, "const $CONST = '" . constant($CONST) . "';", 'before' );
  }
  wp_add_inline_script( $handle, "const BNDTLS_SHOW_HIDE = '" . __( 'Show/Hide License key', 'band-tools' ) . "';", 'before' );
}
