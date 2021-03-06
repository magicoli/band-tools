<?php
if ( ! defined( 'WPINC' ) ) die;

if ( ! defined( 'BNDTLS_SLUG' ) ) define('BNDTLS_SLUG', 'band-tools' );

$plugin_data = get_file_data(WP_PLUGIN_DIR . "/" . BNDTLS_SLUG .'/' . BNDTLS_SLUG .'.php', array(
  'Name' => 'Plugin Name',
  'PluginURI' => 'Plugin URI',
  'Version' => 'Version',
  'Description' => 'Description',
  'Author' => 'Author',
  'AuthorURI' => 'Author URI',
  'TextDomain' => 'Text Domain',
  'DomainPath' => 'Domain Path',
  'Network' => 'Network',
));
if ( ! defined( 'BNDTLS_PLUGIN_NAME' ) ) define('BNDTLS_PLUGIN_NAME', $plugin_data['Name'] );
if ( ! defined( 'BNDTLS_SHORTNAME' ) ) define('BNDTLS_SHORTNAME', preg_replace('/ - .*/', '', BNDTLS_PLUGIN_NAME ) );
if ( ! defined( 'BNDTLS_PLUGIN_URI' ) ) define('BNDTLS_PLUGIN_URI', $plugin_data['PluginURI'] );
if ( ! defined( 'BNDTLS_AUTHOR_NAME' ) ) define('BNDTLS_AUTHOR_NAME', $plugin_data['Author'] );
if ( ! defined( 'BNDTLS_TXDOM' ) ) define('BNDTLS_TXDOM', ($plugin_data['TextDomain']) ? $plugin_data['TextDomain'] : BNDTLS_SLUG );
if ( ! defined( 'BNDTLS_DATA_SLUG' ) ) define('BNDTLS_DATA_SLUG', sanitize_title(BNDTLS_PLUGIN_NAME) );
if ( ! defined( 'BNDTLS_STORE_LINK' ) ) define('BNDTLS_STORE_LINK', "<a href=" . BNDTLS_PLUGIN_URI . " target=_blank>" . BNDTLS_SHORTNAME . "</a>");
/* translators: %s is replaced by the name of the plugin, untranslated */
if ( ! defined( 'BNDTLS_REGISTER_TEXT' ) ) define('BNDTLS_REGISTER_TEXT', sprintf(__('Get a license key on %s website', BNDTLS_TXDOM), BNDTLS_STORE_LINK) );

require(plugin_dir_path(__FILE__) . 'dependencies.php');
require(plugin_dir_path(__FILE__) . 'menus.php');
require(plugin_dir_path(__FILE__) . 'settings.php');
require(plugin_dir_path(__FILE__) . 'updater.php');
// require(plugin_dir_path(__FILE__) . 'woocommerce.php');
