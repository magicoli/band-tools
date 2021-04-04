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
		'message'     => __( 'Layout saved', 'band-tools' ),
		'customizer'  => true,
		'icon_url'    => 'dashicons-admin-generic',
	];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_settings_layout_title' );

function bndtls_settings_layout_title( $meta_boxes ) {
	$prefix = 'layout_';

	$meta_boxes[] = [
		'title'          => __( 'Page Title', 'band-tools' ),
		'id'             => 'band_tools_layout_page_title',
		'settings_pages' => ['band_tools_layout'],
		'class'          => 'band-tools-layout band-tools-layout-title',
		'fields'         => [
			[
				'name'              => __( 'Page title', 'band-tools' ),
				'id'                => $prefix . 'page_title',
				'type'              => 'checkbox_list',
				'label_description' => __( 'Add details under the title in page header', 'band-tools' ),
				'options'           => [
					'band_members' => __( 'Add band Members', 'band-tools' ),
					'band'         => __( 'Add album/song Band', 'band-tools' ),
					'release'      => __( 'Add album/song Release year', 'band-tools' ),
					'genre'        => __( 'Add Genre', 'band-tools' ),
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
		'title'          => __( 'Page Content', 'band-tools' ),
		'id'             => 'band_tools_layout_page_content',
		'settings_pages' => ['band_tools_layout'],
		'class'          => 'band-tools-layout band-tools-layout-content',
		'fields'         => [
			[
				'name'              => __( 'Page content', 'band-tools' ),
				'id'                => $prefix . 'page_content',
				'type'              => 'checkbox_list',
				'label_description' => __( 'Add details under the main content', 'band-tools' ),
				'options'           => [
					'bands' => __( 'Add Bands', 'band-tools' ),
					'albums'         => __( 'Add Albums', 'band-tools' ),
					'albums_songs'      => __( 'Add Albums and Tracks', 'band-tools' ),
					'songs'        => __( 'Add Songs', 'band-tools' ),
				],
				'std'               => ['true', 'true', 'true', 'true'],
				'select_all_none'   => true,
			],
		],
	];

	return $meta_boxes;
}

endif;
