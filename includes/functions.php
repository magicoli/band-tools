<?php if ( ! defined( 'WPINC' ) ) die;

function bndtls_get_option( $option, $default = false, $sub_option='' ) {
  $options=get_option('bndtls-settings');
  if ( $sub_option && $options[$option][$sub_option] ) return $options[$option][$sub_option];
  else if ( $options[$option] ) return $options[$option];
  else return $default;
}

function bndtls_license_key($string = '') {
  return get_option('license_key_band-tools');
}
