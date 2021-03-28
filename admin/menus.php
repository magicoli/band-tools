<?php if ( ! is_admin() ) die;

if ( is_plugin_active('mb-core/mb-core.php' ) ) {
add_action('admin_menu', 'bndtls_register_settings_pages');
function bndtls_register_settings_pages() {
  // Own menu
  add_menu_page(
    'Band Tools', // page title
    'Band Tools', // menu title
    'list_users', // capability
    'band-tools', // slug
    '', // callable function
  //   // plugin_dir_path(__FILE__) . 'options.php', // slug
  //   // null,	// callable function
  //   plugin_dir_url(__DIR__) . 'assets/svg-microphone-stand-20x20.svg', // plugin_dir_url(__FILE__) . '../assets/icon-24x24.jpg', // icon url
  //   2 // position
  );
}
}

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

add_filter( 'mb_settings_pages', 'bndtls_dashboard' );

function bndtls_dashboard( $settings_pages ) {
	$settings_pages[] = [
      'id' => 'band-tools',
        'menu_title'  => __( 'Band Tools', 'band-tools' ),
        'title' =>  __( 'Dashboard', 'band-tools' ),
        'option_name' => 'bndtls-settings',
        'position'    => 2,
        'capability'  => 'manage_options',
        'class'       => 'no-submit',
        'icon_url'    => plugin_dir_url(__DIR__) . 'assets/svg-microphone-stand-20x20.svg',

    ];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_dashboard_plugin_info' );

function bndtls_dashboard_plugin_info( $meta_boxes ) {
    $prefix = '';

    $meta_boxes[] = [
        'title'          => __( 'Plugin info', 'band-tools' ),
        'id'             => 'plugin-info',
        'settings_pages' => ['band-tools'],
        'fields'         => [
            [
                'name'     => __( 'License key', 'band-tools' ),
                'id'       => $prefix . 'license_key',
                'type'     => 'custom_html',
                'callback' => 'bndtls_license_key',
            ],
        ],
    ];

    return $meta_boxes;
}

endif;
