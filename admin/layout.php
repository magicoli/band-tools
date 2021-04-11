<?php if ( ! is_admin() ) die;

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

add_filter( 'mb_settings_pages', 'bndtls_settings_layout' );

function bndtls_settings_layout( $settings_pages ) {
	$title = (is_customize_preview()) ? 'Band Tools Layout' : 'Layout';
	$settings_pages[] = [
		'id' => 'band_tools_layout',
		'menu_title'  => __( $title, 'band-tools' ),
		'option_name' => 'bndtls-settings',
		'position'    => 2,
		'parent'      => 'band-tools',
		'class'       => 'band-tools-settings-layout',
		'columns'     => 1,
		'message'     => _x( 'Layout saved', 'layout-settings', 'band-tools' ),
		'customizer'  => true,
		'icon_url'    => 'dashicons-admin-generic',
	];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_settings_layout_title' );

function bndtls_settings_layout_title( $meta_boxes ) {
	$prefix = 'layout_';

	$meta_boxes[] = [
		'title'          => _x( 'Page Header', 'layout-settings', 'band-tools' ),
		'id'             => 'band_tools_layout_page_title',
		'settings_pages' => ['band_tools_layout'],
		'class'          => 'band-tools-layout band-tools-layout-title',
		'fields'         => [
			[
				'name'              => _x( 'Title', 'layout-settings', 'band-tools' ),
				'id'                => $prefix . 'page_title',
				'type'              => 'checkbox_list',
				'label_description' => _x( 'Add details under the title', 'layout-settings', 'band-tools' ),
				'options'           => [
					'band_members' => _x( 'Show band Members', 'layout-settings', 'band-tools' ),
					'band'         => _x( 'Show record/song Band', 'layout-settings', 'band-tools' ),
					'release'      => _x( 'Show record/song Release year', 'layout-settings', 'band-tools' ),
					'genre'        => _x( 'Show Genre', 'layout-settings', 'band-tools' ),
				],
				'std'               => ['true', 'true', 'true', 'true'],
				'select_all_none'   => true,
			],
		],
	];

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_settings_layout_content' );

function bndtls_settings_layout_content( $meta_boxes ) {
	$prefix = 'layout_';

	$meta_boxes[] = [
		'title'          => _x( 'Content', 'layout-settings', 'band-tools' ),
		'id'             => 'band_tools_layout_page_content',
		'settings_pages' => ['band_tools_layout'],
		'class'          => 'band-tools-layout band-tools-layout-content',
		'fields'         => [
			[
				'name'              => _x( 'Main content', 'layout-settings', 'band-tools' ),
				'id'                => $prefix . 'page_content',
				'type'              => 'checkbox_list',
				'label_description' => _x( 'Add details under main content', 'layout-settings', 'band-tools' ),
				'options'           => [
					'bands' => _x( 'Show Bands', 'layout-settings', 'band-tools' ),
					'records'         => _x( 'Show Records', 'layout-settings', 'band-tools' ),
					'records_songs'      => _x( 'Show Records and Tracks', 'layout-settings', 'band-tools' ),
					'songs'        => _x( 'Show Songs', 'layout-settings', 'band-tools' ),
					'products'        			=> _x( 'Show Products', 'layout-settings', 'band-tools' ),
				],
				'std'               => [ true, true, true, true, true ],
				'select_all_none'   => true,
			],
			[
				'name'              => _x( 'Content Sidebar', 'layout-settings', 'band-tools' ),
				'id'                => $prefix . 'content_sidebar',
				'type'              => 'checkbox_list',
				'label_description' => _x( '(to be implemented)', 'layout-settings', 'band-tools' ),
				'options'           => [
					'bands'					  	=> _x( 'Show Bands', 'layout-settings', 'band-tools' ),
					'records'          	=> _x( 'Show Records', 'layout-settings', 'band-tools' ),
					'records_songs'    	=> _x( 'Show Records and Tracks', 'layout-settings', 'band-tools' ),
					'songs'        			=> _x( 'Show Songs', 'layout-settings', 'band-tools' ),
					'products'        			=> _x( 'Show Products', 'layout-settings', 'band-tools' ),
				],
				'std'               => [ true, true, true, true, true ],
				'readonly'          => true,
				'disabled'          => true,
				// 'select_all_none'   => true,
			],
		],
	];

	return $meta_boxes;
}

endif;
