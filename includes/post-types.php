<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

require_once __DIR__ . '/custom-fields.php';

function bndtls_frontpage_add_types_to_dropdown( $pages ){
	$types = bndtls_get_option('front_page_allow');
	foreach($types as $type) {
		// echo "been there " . __FILE__; die;
		$args = array(
			'post_type' => $type,
		);
		$items = get_posts($args);
		$pages = array_merge($pages, $items);
	}

	return $pages;
}
add_filter( 'get_pages', 'bndtls_frontpage_add_types_to_dropdown' );

function bndtls_frontpage_enable_types( $query ){
	$types = bndtls_get_option('front_page_allow');
	foreach($types as $type) {
		if('' == $query->query_vars['post_type'] && 0 != $query->query_vars['page_id'])
		$query->query_vars['post_type'] = array( 'page', $type );
	}
}
add_action( 'pre_get_posts', 'bndtls_frontpage_enable_types' );

add_action( 'init', 'bndtls_register_post_types' );
function bndtls_register_post_types() {
	$adaptive['bands'] = get_type_name_n('band', 'Band', 'Bands', wp_count_posts('bands')->publish);
	$adaptive['albums'] = get_type_name_n('album', 'Album', 'Albums', wp_count_posts('albums')->publish);
	$adaptive['songs'] = get_type_name_n('song', 'Song', 'Songs', wp_count_posts('songs')->publish);

	$labels = [
		'name'                     => $adaptive['bands'],
		'menu_name'                => $adaptive['bands'],
		'archives'                 => $adaptive['bands'],
		'singular_name'            => __( 'Band', 'band-tools' ),
		'add_new'                  => __( 'Add New', 'band-tools' ),
		'add_new_item'             => __( 'Add new band', 'band-tools' ),
		'edit_item'                => __( 'Edit Band', 'band-tools' ),
		'new_item'                 => __( 'New Band', 'band-tools' ),
		'view_item'                => __( 'View Band', 'band-tools' ),
		'view_items'               => __( 'View Bands', 'band-tools' ),
		'search_items'             => __( 'Search Bands', 'band-tools' ),
		'not_found'                => __( 'No bands found', 'band-tools' ),
		'not_found_in_trash'       => __( 'No bands found in Trash', 'band-tools' ),
		'parent_item_colon'        => __( 'Parent Band:', 'band-tools' ),
		'all_items'                => __( 'All Bands', 'band-tools' ),
		'attributes'               => __( 'Band Attributes', 'band-tools' ),
		'insert_into_item'         => __( 'Insert into band', 'band-tools' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this band', 'band-tools' ),
		'featured_image'       	   => __( 'Featured image', 'band-tools' ),
		'set_featured_image'       => __( 'Set featured image', 'band-tools' ),
		'remove_featured_image'    => __( 'Remove featured image', 'band-tools' ),
		'use_featured_image'       => __( 'Use as featured image', 'band-tools' ),
		'filter_items_list'        => __( 'Filter bands list', 'band-tools' ),
		'items_list_navigation'    => __( 'Bands list navigation', 'band-tools' ),
		'items_list'               => __( 'Bands list', 'band-tools' ),
		'item_published'           => __( 'Band published', 'band-tools' ),
		'item_published_privately' => __( 'Band published privately', 'band-tools' ),
		'item_reverted_to_draft'   => __( 'Band reverted to draft', 'band-tools' ),
		'item_scheduled'           => __( 'Band scheduled', 'band-tools' ),
		'item_updated'             => __( 'Band updated', 'band-tools' ),
		'text_domain'              => __( 'band-tools', 'band-tools' ),
	];
	$args = [
		'label'               => __( 'Label Bands', 'band-tools' ),
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
		'name'                     => $adaptive['albums'],
		'menu_name'                => $adaptive['albums'],
		'archives'                 => $adaptive['albums'],
		'singular_name'            => __( 'Album', 'band-tools' ),
		'add_new'                  => __( 'Add New', 'band-tools' ),
		'add_new_item'             => __( 'Add new album', 'band-tools' ),
		'edit_item'                => __( 'Edit Album', 'band-tools' ),
		'new_item'                 => __( 'New Album', 'band-tools' ),
		'view_item'                => __( 'View Album', 'band-tools' ),
		'view_items'               => __( 'View Albums', 'band-tools' ),
		'search_items'             => __( 'Search Albums', 'band-tools' ),
		'not_found'                => __( 'No albums found', 'band-tools' ),
		'not_found_in_trash'       => __( 'No albums found in Trash', 'band-tools' ),
		'parent_item_colon'        => __( 'Parent Album:', 'band-tools' ),
		'all_items'                => __( 'All Albums', 'band-tools' ),
		'attributes'               => __( 'Album Attributes', 'band-tools' ),
		'insert_into_item'         => __( 'Insert into album', 'band-tools' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this album', 'band-tools' ),
		'featured_image'           => __( 'Featured image', 'band-tools' ),
		'set_featured_image'       => __( 'Set featured image', 'band-tools' ),
		'remove_featured_image'    => __( 'Remove featured image', 'band-tools' ),
		'use_featured_image'       => __( 'Use as featured image', 'band-tools' ),
		'filter_items_list'        => __( 'Filter albums list', 'band-tools' ),
		'items_list_navigation'    => __( 'Albums list navigation', 'band-tools' ),
		'items_list'               => __( 'Albums list', 'band-tools' ),
		'item_published'           => __( 'Album published', 'band-tools' ),
		'item_published_privately' => __( 'Album published privately', 'band-tools' ),
		'item_reverted_to_draft'   => __( 'Album reverted to draft', 'band-tools' ),
		'item_scheduled'           => __( 'Album scheduled', 'band-tools' ),
		'item_updated'             => __( 'Album updated', 'band-tools' ),
		'text_domain'              => __( 'band-tools', 'band-tools' ),
	];
	$args = [
		'label'               => __( 'Albums', 'band-tools' ),
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
		'name'                     => $adaptive['songs'],
		'menu_name'                => $adaptive['songs'],
		'archives'                 => $adaptive['songs'],
		'singular_name'            => __( 'Song', 'band-tools' ),
		'add_new'                  => __( 'Add New', 'band-tools' ),
		'add_new_item'             => __( 'Add new song', 'band-tools' ),
		'edit_item'                => __( 'Edit Song', 'band-tools' ),
		'new_item'                 => __( 'New Song', 'band-tools' ),
		'view_item'                => __( 'View Song', 'band-tools' ),
		'view_items'               => __( 'View Songs', 'band-tools' ),
		'search_items'             => __( 'Search Songs', 'band-tools' ),
		'not_found'                => __( 'No songs found', 'band-tools' ),
		'not_found_in_trash'       => __( 'No songs found in Trash', 'band-tools' ),
		'parent_item_colon'        => __( 'Parent Song:', 'band-tools' ),
		'all_items'                => __( 'All Songs', 'band-tools' ),
		'attributes'               => __( 'Song Attributes', 'band-tools' ),
		'insert_into_item'         => __( 'Insert into song', 'band-tools' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this song', 'band-tools' ),
		'featured_image'           => __( 'Featured image', 'band-tools' ),
		'set_featured_image'       => __( 'Set featured image', 'band-tools' ),
		'remove_featured_image'    => __( 'Remove featured image', 'band-tools' ),
		'use_featured_image'       => __( 'Use as featured image', 'band-tools' ),
		'filter_items_list'        => __( 'Filter songs list', 'band-tools' ),
		'items_list_navigation'    => __( 'Songs list navigation', 'band-tools' ),
		'items_list'               => __( 'Songs list', 'band-tools' ),
		'item_published'           => __( 'Song published', 'band-tools' ),
		'item_published_privately' => __( 'Song published privately', 'band-tools' ),
		'item_reverted_to_draft'   => __( 'Song reverted to draft', 'band-tools' ),
		'item_scheduled'           => __( 'Song scheduled', 'band-tools' ),
		'item_updated'             => __( 'Song updated', 'band-tools' ),
		'text_domain'              => __( 'band-tools', 'band-tools' ),
	];
	$args = [
		'label'               => __( 'Songs', 'band-tools' ),
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
	$adaptive['bands'] = get_type_name_n('band', 'Band', 'Bands', wp_count_posts('bands')->publish);
	$adaptive['albums'] = get_type_name_n('album', 'Album', 'Albums', wp_count_posts('albums')->publish);
	$adaptive['songs'] = get_type_name_n('song', 'Song', 'Songs', wp_count_posts('songs')->publish);
	$adaptive['tracks'] = get_type_name_n('track', 'Track', 'Tracks', wp_count_posts('songs')->publish);

	MB_Relationships_API::register( [
		'id'   => 'rel-bands-albums',
		'from' => [
			'object_type' => 'post',
			'post_type'   => 'bands',
			'admin_column' => [
				'position' => 'after title',
				'title'    => $adaptive['albums'],
				'link'     => 'view',
			],
			'meta_box'    => [
				'title'    => $adaptive['albums'],
				'context'  => 'normal',
				'priority' => 'high',
			],
		],
		'to'   => [
			'object_type' => 'post',
			'post_type'   => 'albums',
			'admin_column' => [
				'position' => 'after title',
				'title'    => $adaptive['bands'],
				'link'     => 'view',
			],
			'meta_box'    => [
				'title'    => $adaptive['bands'],
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
				'title'    => $adaptive['songs'],
				'link'     => 'view',
			],
			'meta_box'     => [
				'title'    => $adaptive['songs'],
				'context'  => 'normal',
				'priority' => 'high',
			],
		],
		'to'   => [
			'object_type'  => 'post',
			'post_type'    => 'songs',
			'admin_column' => [
				'position' => 'after title',
				'title'    => $adaptive['bands'],
				'link'     => 'view',
			],
			'meta_box'     => [
				'title'    => $adaptive['bands'],
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
				'position' => 'after title',
				'title'    => $adaptive['tracks'],
				'link'     => 'view',
			],
			'meta_box'     => [
				'title'   => $adaptive['tracks'],
				'context' => 'normal',
			],
		],
		'to'   => [
			'object_type' => 'post',
			'post_type'   => 'songs',
			'admin_column' => [
				'position' => 'after title',
				'title'    => $adaptive['albums'],
				'link'     => 'view',
			],
			'meta_box'    => [
				'title'   => $adaptive['albums'],
				'context' => 'normal',
			],
		],
	] );
}
