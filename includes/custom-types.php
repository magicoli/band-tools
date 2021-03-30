<?php if (!defined('WPINC')) {die;}

// 		'menu_icon' => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-user-music-20x20.svg',
// 		'menu_icon' => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-album-20x20.svg',
// 		'menu_icon' => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-comment-music-20x20.svg',
// 		'menu_icon' => dirname(plugin_dir_url( __FILE__ )) . '/assets/tv-music-20x20.svg',

add_action( 'init', 'bndtls_register_post_types' );
function bndtls_register_post_types() {
	$labels = [
		'name'                     => esc_html__( 'Bands', 'band-tools' ),
		'singular_name'            => esc_html__( 'Band', 'band-tools' ),
		'add_new'                  => esc_html__( 'Add New', 'band-tools' ),
		'add_new_item'             => esc_html__( 'Add new band', 'band-tools' ),
		'edit_item'                => esc_html__( 'Edit Band', 'band-tools' ),
		'new_item'                 => esc_html__( 'New Band', 'band-tools' ),
		'view_item'                => esc_html__( 'View Band', 'band-tools' ),
		'view_items'               => esc_html__( 'View Bands', 'band-tools' ),
		'search_items'             => esc_html__( 'Search Bands', 'band-tools' ),
		'not_found'                => esc_html__( 'No bands found', 'band-tools' ),
		'not_found_in_trash'       => esc_html__( 'No bands found in Trash', 'band-tools' ),
		'parent_item_colon'        => esc_html__( 'Parent Band:', 'band-tools' ),
		'all_items'                => esc_html__( 'All Bands', 'band-tools' ),
		'archives'                 => esc_html__( 'Band Archives', 'band-tools' ),
		'attributes'               => esc_html__( 'Band Attributes', 'band-tools' ),
		'insert_into_item'         => esc_html__( 'Insert into band', 'band-tools' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this band', 'band-tools' ),
		'featured_image'           => esc_html__( 'Featured image', 'band-tools' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'band-tools' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'band-tools' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'band-tools' ),
		'menu_name'                => esc_html__( 'Bands', 'band-tools' ),
		'filter_items_list'        => esc_html__( 'Filter bands list', 'band-tools' ),
		'items_list_navigation'    => esc_html__( 'Bands list navigation', 'band-tools' ),
		'items_list'               => esc_html__( 'Bands list', 'band-tools' ),
		'item_published'           => esc_html__( 'Band published', 'band-tools' ),
		'item_published_privately' => esc_html__( 'Band published privately', 'band-tools' ),
		'item_reverted_to_draft'   => esc_html__( 'Band reverted to draft', 'band-tools' ),
		'item_scheduled'           => esc_html__( 'Band scheduled', 'band-tools' ),
		'item_updated'             => esc_html__( 'Band updated', 'band-tools' ),
		'text_domain'              => esc_html__( 'band-tools', 'band-tools' ),
	];
	$args = [
		'label'               => esc_html__( 'Bands', 'band-tools' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'menu_position'       => 20,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'menu_icon'           => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-user-music-20x20.svg',
		'capability_type'     => 'post',
		'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'comments'],
		'taxonomies'          => [],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'bands', $args );

	$labels = [
		'name'                     => esc_html__( 'Albums', 'band-tools' ),
		'singular_name'            => esc_html__( 'Album', 'band-tools' ),
		'add_new'                  => esc_html__( 'Add New', 'band-tools' ),
		'add_new_item'             => esc_html__( 'Add new album', 'band-tools' ),
		'edit_item'                => esc_html__( 'Edit Album', 'band-tools' ),
		'new_item'                 => esc_html__( 'New Album', 'band-tools' ),
		'view_item'                => esc_html__( 'View Album', 'band-tools' ),
		'view_items'               => esc_html__( 'View Albums', 'band-tools' ),
		'search_items'             => esc_html__( 'Search Albums', 'band-tools' ),
		'not_found'                => esc_html__( 'No albums found', 'band-tools' ),
		'not_found_in_trash'       => esc_html__( 'No albums found in Trash', 'band-tools' ),
		'parent_item_colon'        => esc_html__( 'Parent Album:', 'band-tools' ),
		'all_items'                => esc_html__( 'All Albums', 'band-tools' ),
		'archives'                 => esc_html__( 'Album Archives', 'band-tools' ),
		'attributes'               => esc_html__( 'Album Attributes', 'band-tools' ),
		'insert_into_item'         => esc_html__( 'Insert into album', 'band-tools' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this album', 'band-tools' ),
		'featured_image'           => esc_html__( 'Featured image', 'band-tools' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'band-tools' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'band-tools' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'band-tools' ),
		'menu_name'                => esc_html__( 'Albums', 'band-tools' ),
		'filter_items_list'        => esc_html__( 'Filter albums list', 'band-tools' ),
		'items_list_navigation'    => esc_html__( 'Albums list navigation', 'band-tools' ),
		'items_list'               => esc_html__( 'Albums list', 'band-tools' ),
		'item_published'           => esc_html__( 'Album published', 'band-tools' ),
		'item_published_privately' => esc_html__( 'Album published privately', 'band-tools' ),
		'item_reverted_to_draft'   => esc_html__( 'Album reverted to draft', 'band-tools' ),
		'item_scheduled'           => esc_html__( 'Album scheduled', 'band-tools' ),
		'item_updated'             => esc_html__( 'Album updated', 'band-tools' ),
		'text_domain'              => esc_html__( 'band-tools', 'band-tools' ),
	];
	$args = [
		'label'               => esc_html__( 'Albums', 'band-tools' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'menu_position'       => 23,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'menu_icon'           => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-album-collection-20x20.svg',
		// 'menu_icon'           => 'dashicons-album',
		'capability_type'     => 'post',
		'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'comments'],
		'taxonomies'          => [],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'albums', $args );

	$labels = [
		'name'                     => esc_html__( 'Songs', 'band-tools' ),
		'singular_name'            => esc_html__( 'Song', 'band-tools' ),
		'add_new'                  => esc_html__( 'Add New', 'band-tools' ),
		'add_new_item'             => esc_html__( 'Add new song', 'band-tools' ),
		'edit_item'                => esc_html__( 'Edit Song', 'band-tools' ),
		'new_item'                 => esc_html__( 'New Song', 'band-tools' ),
		'view_item'                => esc_html__( 'View Song', 'band-tools' ),
		'view_items'               => esc_html__( 'View Songs', 'band-tools' ),
		'search_items'             => esc_html__( 'Search Songs', 'band-tools' ),
		'not_found'                => esc_html__( 'No songs found', 'band-tools' ),
		'not_found_in_trash'       => esc_html__( 'No songs found in Trash', 'band-tools' ),
		'parent_item_colon'        => esc_html__( 'Parent Song:', 'band-tools' ),
		'all_items'                => esc_html__( 'All Songs', 'band-tools' ),
		'archives'                 => esc_html__( 'Song Archives', 'band-tools' ),
		'attributes'               => esc_html__( 'Song Attributes', 'band-tools' ),
		'insert_into_item'         => esc_html__( 'Insert into song', 'band-tools' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this song', 'band-tools' ),
		'featured_image'           => esc_html__( 'Featured image', 'band-tools' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'band-tools' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'band-tools' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'band-tools' ),
		'menu_name'                => esc_html__( 'Songs', 'band-tools' ),
		'filter_items_list'        => esc_html__( 'Filter songs list', 'band-tools' ),
		'items_list_navigation'    => esc_html__( 'Songs list navigation', 'band-tools' ),
		'items_list'               => esc_html__( 'Songs list', 'band-tools' ),
		'item_published'           => esc_html__( 'Song published', 'band-tools' ),
		'item_published_privately' => esc_html__( 'Song published privately', 'band-tools' ),
		'item_reverted_to_draft'   => esc_html__( 'Song reverted to draft', 'band-tools' ),
		'item_scheduled'           => esc_html__( 'Song scheduled', 'band-tools' ),
		'item_updated'             => esc_html__( 'Song updated', 'band-tools' ),
		'text_domain'              => esc_html__( 'band-tools', 'band-tools' ),
	];
	$args = [
		'label'               => esc_html__( 'Songs', 'band-tools' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'menu_position'       => 23,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		// 'menu_icon'           => 'dashicons-format-audio',
		'menu_icon'           => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-comment-music-16x16.svg',
		'capability_type'     => 'post',
		'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'comments'],
		'taxonomies'          => [],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'songs', $args );
}

add_action( 'mb_relationships_init', 'bndtls_register_relationships' );

function bndtls_register_relationships() {
	MB_Relationships_API::register( [
		'id'   => 'rel-bands-albums',
		'from' => [
			'object_type' => 'post',
			'post_type'   => 'bands',
			'meta_box'    => [
				'title'    => 'This Band Albums',
				'context'  => 'normal',
				'priority' => 'high',
			],
		],
		'to'   => [
			'object_type' => 'post',
			'post_type'   => 'albums',
			'meta_box'    => [
				'title'    => 'Bands',
				'context'  => 'normal',
				'priority' => 'high',
			],
		],
	] );

	MB_Relationships_API::register( [
		'id'   => 'rel-bands-songs',
		'from' => [
			'object_type'  => 'post',
			'post_type'    => 'bands',
			'admin_column' => [
				'position' => 'after title',
				'title'    => 'Songs',
				'link'     => 'view',
			],
			'meta_box'     => [
				'title'    => 'This Band Songs',
				'context'  => 'normal',
				'priority' => 'high',
			],
		],
		'to'   => [
			'object_type'  => 'post',
			'post_type'    => 'songs',
			'admin_column' => [
				'position' => 'after title',
				'title'    => 'Bands',
				'link'     => 'view',
			],
			'meta_box'     => [
				'title'    => 'By Bands',
				'context'  => 'normal',
				'priority' => 'high',
			],
		],
	] );

	MB_Relationships_API::register( [
		'id'   => 'rel-albums-songs',
		'from' => [
			'object_type'  => 'post',
			'post_type'    => 'albums',
			'admin_column' => [
				'position' => 'after',
				'link'     => 'view',
			],
			'meta_box'     => [
				'title'   => 'Included Songs',
				'context' => 'normal',
			],
		],
		'to'   => [
			'object_type' => 'post',
			'post_type'   => 'songs',
			'meta_box'    => [
				'title'   => 'In Albums',
				'context' => 'normal',
			],
		],
	] );
}
