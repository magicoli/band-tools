<?php
if ( ! defined( 'WPINC' ) ) die;

// Set constants. Only BNDTLS_SLUG should be changed, other values are fetched from plugin file
// Some of these might also need to be defined in js files
if ( defined( 'BNDTLS_PLUGIN' ) ) {
  if ( ! defined( 'BNDTLS_SLUG' ) ) define('BNDTLS_SLUG', dirname ( BNDTLS_PLUGIN ) );
} else {
  if ( ! defined( 'BNDTLS_SLUG' ) ) define('BNDTLS_SLUG', 'band-tools' );
  define('BNDTLS_PLUGIN', BNDTLS_SLUG . "/" . BNDTLS_SLUG . ".php" );
}

function bndtls_load_textdomain() {
	$textdomain = "band-tools";
	load_plugin_textdomain( $textdomain, false, dirname( dirname(plugin_basename( __FILE__ )) ) . '/languages/' );
}
bndtls_load_textdomain();

require_once dirname(__DIR__) . '/vendor/autoload.php';
// WP_Dependency_Installer::instance( dirname(__DIR__) )->run();

$plugin_data = get_file_data(WP_PLUGIN_DIR . "/" . BNDTLS_PLUGIN, array(
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
if ( ! defined( 'BNDTLS_VERSION' ) ) define('BNDTLS_VERSION', $plugin_data['Version'] );
if ( ! defined( 'BNDTLS_AUTHOR_NAME' ) ) define('BNDTLS_AUTHOR_NAME', $plugin_data['Author'] );
if ( ! defined( 'BNDTLS_TXDOM' ) ) define('BNDTLS_TXDOM', ($plugin_data['TextDomain']) ? $plugin_data['TextDomain'] : BNDTLS_SLUG );
if ( ! defined( 'BNDTLS_DATA_SLUG' ) ) define('BNDTLS_DATA_SLUG', sanitize_title(BNDTLS_PLUGIN_NAME) );
if ( ! defined( 'BNDTLS_STORE_LINK' ) ) define('BNDTLS_STORE_LINK', "<a href=" . BNDTLS_PLUGIN_URI . " target=_blank>" . BNDTLS_AUTHOR_NAME . "</a>");
/* translators: %s is replaced by the name of the plugin, untranslated */
if ( ! defined( 'BNDTLS_REGISTER_TEXT' ) ) define('BNDTLS_REGISTER_TEXT', sprintf(__('Get a license key on %s website', BNDTLS_TXDOM), BNDTLS_STORE_LINK) );

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/post-types.php';
require_once __DIR__ . '/blocks.php';
require_once __DIR__ . '/shortcodes.php';
require_once __DIR__ . '/widgets.php';

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php') ) {
	require_once __DIR__ . '/woocommerce.php';
}

/** Enable plugin updates with license check **/
require_once plugin_dir_path( WP_PLUGIN_DIR . "/" . BNDTLS_PLUGIN ) . 'lib/wp-package-updater/class-wp-package-updater.php';
$bndtls_updater = new WP_Package_Updater(
	'https://magiiic.com',
	wp_normalize_path( WP_PLUGIN_DIR . "/" . BNDTLS_PLUGIN ),
	wp_normalize_path( plugin_dir_path( WP_PLUGIN_DIR . "/" . BNDTLS_PLUGIN ) ),
	true
);

function bndtls_load_plugin_css() {
  // dev (force no cache)
  // wp_enqueue_style( 'band-tools-main', plugin_dir_url( __FILE__ ) . 'css/main.css', array(), BNDTLS_VERSION . '.' . time() );
  wp_enqueue_style( BNDTLS_SLUG . '-main', plugin_dir_url( __FILE__ ) . 'css/main.css', array(), BNDTLS_VERSION );
}
add_action( 'wp_enqueue_scripts', 'bndtls_load_plugin_css' );

// dirty fix to include singular/plural forms in .pot
if(false) {
  $cache = _n('Band', 'Bands', $n, 'band-tools');
  $cache = _n('Album', 'Albums', $n, 'band-tools');
  $cache = _n('Song', 'Songs', $n, 'band-tools');
  $cache = _n('Track', 'Tracks', $n, 'band-tools');
  $cache = __('Track', 'band-tools');
  $cache = __('Tracks', 'band-tools');
}
