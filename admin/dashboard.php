<?php if ( ! is_admin() ) die;

if ( is_plugin_active('mb-core/mb-core.php' ) ) {
add_action('admin_menu', 'bndtls_register_settings_pages');
function bndtls_register_settings_pages() {
  // Own menu
  add_menu_page(
    'Band Tools', // page title
    'Band Tools', // menu title
    'manage_options', // capability
    'band-tools', // slug
    '', // callable function
  //   // plugin_dir_path(__FILE__) . 'options.php', // slug
  //   // null,	// callable function
    plugin_dir_url(__DIR__) . 'assets/svg-microphone-stand-20x20.svg', // plugin_dir_url(__FILE__) . '../assets/icon-24x24.jpg', // icon url
    2 // position
  );
}
}

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

add_filter( 'mb_settings_pages', 'bndtls_dashboard' );

function bndtls_dashboard( $settings_pages ) {
  $settings_pages[] = [
    'id' => 'band-tools',
    'option_name' => 'bndtls-settings',
    'menu_title'  => __( 'Band Tools', 'band-tools' ),
    'submenu_title' => __( 'Dashboard', 'band-tools' ),
    'page_title'  => sprintf(__( '%s Dashboard', 'band-tools' ), 'Band Tools'),
    'icon_url'    => plugin_dir_url(__DIR__) . 'assets/svg-microphone-stand-20x20.svg',
    // 'style'       => 'no-boxes',
    'position'    => 2,
    // 'capability'  => 'manage_options',
    'class'       => 'no-submit',
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

    $prefix = 'shortcodes_';

    $meta_boxes[] = [
      'title'          => __( 'Shortcodes', 'band-tools' ),
      'id'             => 'shortcodes',
      'settings_pages' => ['band-tools'],
      'fields'         => [
        [
          'name' => sprintf('<code>[bt-all]</code> %s <nobr><code>[band-tools]</code></nobr>', __('or', 'band-tools')),
          'id'   => $prefix . 'bt-auto',
          'type' => 'custom_html',
          'std'  => 'All bands, albums, songs',
        ],
        [
          'name' => sprintf('<code>[bt-auto]</code>', __('or', 'band-tools')),
          'id'   => $prefix . 'bt-auto',
          'type' => 'custom_html',
          'std'  => 'Most relevant details for current post',
        ],
        [
          'name' => '<code>[bt-bands]</code>',
          'id'   => $prefix . 'bt-bands',
          'type' => 'custom_html',
          'std'  => 'Bands of current post',
        ],
        [
          'name' => '<code>[bt-albums]</code>',
          'id'   => $prefix . 'bt-albums',
          'type' => 'custom_html',
          'std'  => 'Albums of current post',
        ],
        [
          'name' => '<code>[bt-songs]</code>',
          'id'   => $prefix . 'bt-songs',
          'type' => 'custom_html',
          'std'  => 'Songs of current post',
        ],
      ],
    ];

    return $meta_boxes;
}

endif;
