<?php

add_action( 'admin_head', 'bndtls_alter_license_notice', 99, 0 );
function bndtls_alter_license_notice() {
  global $bndtls_alter_license_form;
  if ( $bndtls_alter_license_form ) return;
  // plugin_dir_path( MY_PLUGIN )
  $handle = BNDTLS_SLUG . '/js/wppus-hide-licence-warnings.js';
  $js = plugins_url($handle);
  wp_register_script( $handle, $js, array( 'wp-i18n', 'jquery' ) );
  wp_set_script_translations( $handle, BNDTLS_TXDOM );
  wp_enqueue_script( $handle, $js );
  $bndtls_alter_license_form = true;
}
