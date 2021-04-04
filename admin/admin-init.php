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
require(plugin_dir_path(__FILE__) . 'dashboard.php');
require(plugin_dir_path(__FILE__) . 'settings.php');
require(plugin_dir_path(__FILE__) . 'layout.php');
// require(plugin_dir_path(__FILE__) . 'woocommerce.php');

function bndtls_load_admin_css() {
  // dev (force no cache)
  // wp_enqueue_style( BNDTLS_SLUG . '-admin', plugin_dir_url( __FILE__ ) . 'admin.css', array(), BNDTLS_VERSION . '.' . time() );
  wp_enqueue_style( BNDTLS_SLUG . '-admin', plugin_dir_url( __FILE__ ) . 'admin.css', array(), BNDTLS_VERSION );
  // add_editor_style('custom-editor-style.css');
}
add_action( 'admin_enqueue_scripts', 'bndtls_load_admin_css' );

// function bndtls_mce_css( $mce_css ) {
//   if ( !empty( $mce_css ) )
//     $mce_css .= ',';
//     $mce_css .= plugins_url( 'admin-editor.css', __FILE__ );
//     return $mce_css;
//   }
// add_filter( 'mce_css', 'bndtls_mce_css' );

add_action( 'admin_head', 'bndtls_load_admin_js' );
function bndtls_load_admin_js() {
  $handle = BNDTLS_SLUG . '-admin';
  $js = plugin_dir_url(__FILE__) . 'admin.js';
  // wp_register_script( $handle, $js, array( 'wp-i18n', 'jquery' ) );
  // $ver=BNDTLS_VERSION;
  wp_enqueue_script( $handle, $js, array(), BNDTLS_VERSION );
  // wp_enqueue_script( $handle, $js );
}

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

register_activation_hook( __FILE__, 'bndtls_rewrite_flush' );
function bndtls_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    bndtls_register_post_types();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
