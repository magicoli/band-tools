<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

function bndtls_register_my_cpts() {

	/**
	* Post Type: Bands.
	*/
	$plural = bndtls_get_option( 'naming_band', 'Bands', 'plural' );
	$singular = bndtls_get_option( 'naming_band', 'Band', 'singular' );
	$labels = [
		"name" => __( $plural, "band-tools" ),
		"singular_name" => __( $singular, "band-tools" ),
		"menu_name" => __( $plural, "band-tools" ),
		"all_items" => __( "All", "band-tools" ),
		"add_new" => __( "Add new", "band-tools" ),
		"add_new_item" => __( "Add new Band", "band-tools" ),
		"edit_item" => __( "Edit Band", "band-tools" ),
		"new_item" => __( "New Band", "band-tools" ),
		"view_item" => __( "View Band", "band-tools" ),
		"view_items" => __( "View Bands", "band-tools" ),
		"search_items" => __( "Search Bands", "band-tools" ),
		"not_found" => __( "No Bands found", "band-tools" ),
		"not_found_in_trash" => __( "No Bands found in trash", "band-tools" ),
		"parent" => __( "Parent Band:", "band-tools" ),
		"featured_image" => __( "Featured image", "band-tools" ),
		"set_featured_image" => __( "Set featured image", "band-tools" ),
		"remove_featured_image" => __( "Remove featured image", "band-tools" ),
		"use_featured_image" => __( "Use as featured image", "band-tools" ),
		"archives" => __( $plural, "band-tools" ),
		"insert_into_item" => __( "Insert into Band", "band-tools" ),
		"uploaded_to_this_item" => __( "Upload to this Band", "band-tools" ),
		"filter_items_list" => __( "Filter Bands list", "band-tools" ),
		"items_list_navigation" => __( "Bands list navigation", "band-tools" ),
		"items_list" => __( "Bands list", "band-tools" ),
		"attributes" => __( "Band attributes", "band-tools" ),
		"name_admin_bar" => __( $singular, "band-tools" ),
		"item_published" => __( "Band published", "band-tools" ),
		"item_published_privately" => __( "Band published privately.", "band-tools" ),
		"item_reverted_to_draft" => __( "Band reverted to draft.", "band-tools" ),
		"item_scheduled" => __( "Band scheduled", "band-tools" ),
		"item_updated" => __( "Band updated.", "band-tools" ),
		"parent_item_colon" => __( "Parent Band:", "band-tools" ),
	];

	$args = [
		"label" => __( $plural, "band-tools" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "bands", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => dirname(plugin_dir_url( __FILE__ )) . "/assets/svg-user-music-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "page-attributes", "post-formats" ],
		"taxonomies" => [ "post_tag", "band_categories" ],
	];

	register_post_type( "bands", $args );

	/**
	 * Post Type: Albums.
	 */

	$plural = bndtls_get_option( 'naming_album', 'Albums', 'plural' );
	$singular = bndtls_get_option( 'naming_album', 'Album', 'singular' );
	$labels = [
		"name" => __( $plural, "band-tools" ),
		"singular_name" => __( $singular, "band-tools" ),
		"menu_name" => __( $plural, "band-tools" ),
		"all_items" => __( "All", "band-tools" ),
		"add_new" => __( "Add new", "band-tools" ),
		"add_new_item" => __( "Add new Album", "band-tools" ),
		"edit_item" => __( "Edit Album", "band-tools" ),
		"new_item" => __( "New Album", "band-tools" ),
		"view_item" => __( "View Album", "band-tools" ),
		"view_items" => __( "View Albums", "band-tools" ),
		"search_items" => __( "Search Albums", "band-tools" ),
		"not_found" => __( "No Albums found", "band-tools" ),
		"not_found_in_trash" => __( "No Albums found in trash", "band-tools" ),
		"parent" => __( "Parent Album:", "band-tools" ),
		"featured_image" => __( "Featured image", "band-tools" ),
		"set_featured_image" => __( "Set featured image", "band-tools" ),
		"remove_featured_image" => __( "Remove featured image", "band-tools" ),
		"use_featured_image" => __( "Use as featured image", "band-tools" ),
		"archives" => __( $plural, "band-tools" ),
		"insert_into_item" => __( "Insert into Album", "band-tools" ),
		"uploaded_to_this_item" => __( "Upload to this Album", "band-tools" ),
		"filter_items_list" => __( "Filter Albums list", "band-tools" ),
		"items_list_navigation" => __( "Albums list navigation", "band-tools" ),
		"items_list" => __( "Albums list", "band-tools" ),
		"attributes" => __( "Album attributes", "band-tools" ),
		"name_admin_bar" => __( $singular, "band-tools" ),
		"item_published" => __( "Album published", "band-tools" ),
		"item_published_privately" => __( "Album published privately.", "band-tools" ),
		"item_reverted_to_draft" => __( "Album reverted to draft.", "band-tools" ),
		"item_scheduled" => __( "Album scheduled", "band-tools" ),
		"item_updated" => __( "Album updated.", "band-tools" ),
		"parent_item_colon" => __( "Parent Album:", "band-tools" ),
	];

	$args = [
		"label" => __( $plural, "band-tools" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "albums", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => dirname(plugin_dir_url( __FILE__ )) . "/assets/svg-album-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "page-attributes", "post-formats" ],
		"taxonomies" => [ "post_tag", "album_categories" ],
	];

	register_post_type( "albums", $args );

	/**
	 * Post Type: Songs.
	 */

 	$plural = bndtls_get_option( 'naming_song', 'Songs', 'plural' );
	$singular = bndtls_get_option( 'naming_song', 'Song', 'singular' );
	$labels = [
		"name" => __( $plural, "band-tools" ),
		"singular_name" => __( $singular, "band-tools" ),
		"menu_name" => __( $plural, "band-tools" ),
		"all_items" => __( "All", "band-tools" ),
		"add_new" => __( "Add new", "band-tools" ),
		"add_new_item" => __( "Add new Song", "band-tools" ),
		"edit_item" => __( "Edit Song", "band-tools" ),
		"new_item" => __( "New Song", "band-tools" ),
		"view_item" => __( "View Song", "band-tools" ),
		"view_items" => __( "View Songs", "band-tools" ),
		"search_items" => __( "Search Songs", "band-tools" ),
		"not_found" => __( "No Songs found", "band-tools" ),
		"not_found_in_trash" => __( "No Songs found in trash", "band-tools" ),
		"parent" => __( "Parent Song:", "band-tools" ),
		"featured_image" => __( "Featured image", "band-tools" ),
		"set_featured_image" => __( "Set featured image", "band-tools" ),
		"remove_featured_image" => __( "Remove featured image", "band-tools" ),
		"use_featured_image" => __( "Use as featured image", "band-tools" ),
		"archives" => __( $plural, "band-tools" ),
		"insert_into_item" => __( "Insert into Song", "band-tools" ),
		"uploaded_to_this_item" => __( "Upload to this Song", "band-tools" ),
		"filter_items_list" => __( "Filter Songs list", "band-tools" ),
		"items_list_navigation" => __( "Songs list navigation", "band-tools" ),
		"items_list" => __( "Songs list", "band-tools" ),
		"attributes" => __( "Song attributes", "band-tools" ),
		"name_admin_bar" => __( $singular, "band-tools" ),
		"item_published" => __( "Song published", "band-tools" ),
		"item_published_privately" => __( "Song published privately.", "band-tools" ),
		"item_reverted_to_draft" => __( "Song reverted to draft.", "band-tools" ),
		"item_scheduled" => __( "Song scheduled", "band-tools" ),
		"item_updated" => __( "Song updated.", "band-tools" ),
		"parent_item_colon" => __( "Parent Song:", "band-tools" ),
	];

	$args = [
		"label" => __( $plural, "band-tools" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "songs", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => dirname(plugin_dir_url( __FILE__ )) . "/assets/svg-comment-music-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "page-attributes", "post-formats" ],
		"taxonomies" => [ "post_tag", "song_categories" ],
	];

	register_post_type( "songs", $args );

	/**
	 * Post Type: Videos.
	 */

	$labels = [
		"name" => __( "Videos", "band-tools" ),
		"singular_name" => __( "Video", "band-tools" ),
		"menu_name" => __( "Videos", "band-tools" ),
		"all_items" => __( "All", "band-tools" ),
		"add_new" => __( "Add new", "band-tools" ),
		"add_new_item" => __( "Add new Video", "band-tools" ),
		"edit_item" => __( "Edit Video", "band-tools" ),
		"new_item" => __( "New Video", "band-tools" ),
		"view_item" => __( "View Video", "band-tools" ),
		"view_items" => __( "View Videos", "band-tools" ),
		"search_items" => __( "Search Videos", "band-tools" ),
		"not_found" => __( "No Videos found", "band-tools" ),
		"not_found_in_trash" => __( "No Videos found in trash", "band-tools" ),
		"parent" => __( "Parent Video:", "band-tools" ),
		"featured_image" => __( "Featured image", "band-tools" ),
		"set_featured_image" => __( "Set featured image", "band-tools" ),
		"remove_featured_image" => __( "Remove featured image", "band-tools" ),
		"use_featured_image" => __( "Use as featured image", "band-tools" ),
		"archives" => __( "Videos", "band-tools" ),
		"insert_into_item" => __( "Insert into Video", "band-tools" ),
		"uploaded_to_this_item" => __( "Upload to this Video", "band-tools" ),
		"filter_items_list" => __( "Filter Videos list", "band-tools" ),
		"items_list_navigation" => __( "Videos list navigation", "band-tools" ),
		"items_list" => __( "Videos list", "band-tools" ),
		"attributes" => __( "Video attributes", "band-tools" ),
		"name_admin_bar" => __( "Video", "band-tools" ),
		"item_published" => __( "Video published", "band-tools" ),
		"item_published_privately" => __( "Video published privately.", "band-tools" ),
		"item_reverted_to_draft" => __( "Video reverted to draft.", "band-tools" ),
		"item_scheduled" => __( "Video scheduled", "band-tools" ),
		"item_updated" => __( "Video updated.", "band-tools" ),
		"parent_item_colon" => __( "Parent Video:", "band-tools" ),
	];

	$args = [
		"label" => __( "Videos", "band-tools" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "videos", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => dirname(plugin_dir_url( __FILE__ )) . "/assets/tv-music-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "page-attributes", "post-formats" ],
		"taxonomies" => [ "video_tag" ],
	];

	register_post_type( "videos", $args );
}

add_action( 'init', 'bndtls_register_my_cpts' );

function bndtls_register_my_taxes() {

	/**
	 * Taxonomy: Video tags.
	 */

	$labels = [
		"name" => __( "Video tags", "band-tools" ),
		"singular_name" => __( "Video tag", "band-tools" ),
		"menu_name" => __( "Tags", "band-tools" ),
		"all_items" => __( "All tags", "band-tools" ),
		"edit_item" => __( "Edit tag", "band-tools" ),
		"view_item" => __( "View tag", "band-tools" ),
		"update_item" => __( "Update tag", "band-tools" ),
		"add_new_item" => __( "Add new Video tag", "band-tools" ),
		"new_item_name" => __( "New Video tag", "band-tools" ),
		"parent_item" => __( "Parent tag", "band-tools" ),
		"parent_item_colon" => __( "Parent tag:", "band-tools" ),
		"search_items" => __( "Search tags", "band-tools" ),
		"popular_items" => __( "Popular tags", "band-tools" ),
		"separate_items_with_commas" => __( "Separate tags with commas", "band-tools" ),
		"add_or_remove_items" => __( "Add or remove tags", "band-tools" ),
		"choose_from_most_used" => __( "Choose from the most used tags", "band-tools" ),
		"not_found" => __( "No tags found", "band-tools" ),
		"no_terms" => __( "No tags", "band-tools" ),
		"items_list_navigation" => __( "Video tags list navigation", "band-tools" ),
		"items_list" => __( "Video tags list", "band-tools" ),
		"back_to_items" => __( "Back to Video tags", "band-tools" ),
	];

	$args = [
		"label" => __( "Video tags", "band-tools" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'video_tag', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "video_tag",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
			];
	register_taxonomy( "video_tag", [ "videos" ], $args );

	/**
	 * Taxonomy: Video categories.
	 */

	$labels = [
		"name" => __( "Video categories", "band-tools" ),
		"singular_name" => __( "Video category", "band-tools" ),
		"menu_name" => __( "Categories", "band-tools" ),
		"all_items" => __( "All Categories", "band-tools" ),
		"edit_item" => __( "Edit Category", "band-tools" ),
		"view_item" => __( "View Category", "band-tools" ),
		"update_item" => __( "Update Category", "band-tools" ),
		"add_new_item" => __( "Add new Video Category", "band-tools" ),
		"new_item_name" => __( "New Video Category", "band-tools" ),
		"parent_item" => __( "Parent Category", "band-tools" ),
		"parent_item_colon" => __( "Parent Category:", "band-tools" ),
		"search_items" => __( "Search Categories", "band-tools" ),
		"popular_items" => __( "Popular Categories", "band-tools" ),
		"separate_items_with_commas" => __( "Separate categories with commas", "band-tools" ),
		"add_or_remove_items" => __( "Add or remove Categories", "band-tools" ),
		"choose_from_most_used" => __( "Choose from the most used categories", "band-tools" ),
		"not_found" => __( "No Categories found", "band-tools" ),
		"no_terms" => __( "No Categories", "band-tools" ),
		"items_list_navigation" => __( "Categories list navigation", "band-tools" ),
		"items_list" => __( "Categories list", "band-tools" ),
		"back_to_items" => __( "Back to Video Categories", "band-tools" ),
	];

	$args = [
		"label" => __( "Video categories", "band-tools" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'video_categories', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "video_categories",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
			];
	register_taxonomy( "video_categories", [ "videos" ], $args );

	/**
	 * Taxonomy: Album Categories.
	 */

	$labels = [
		"name" => __( "Album Categories", "band-tools" ),
		"singular_name" => __( "Album Category", "band-tools" ),
		"menu_name" => __( "Categories", "band-tools" ),
		"all_items" => __( "All Categories", "band-tools" ),
		"edit_item" => __( "Edit Category", "band-tools" ),
		"view_item" => __( "View Category", "band-tools" ),
		"update_item" => __( "Update Category Name", "band-tools" ),
		"add_new_item" => __( "Add new Category", "band-tools" ),
		"new_item_name" => __( "New Category Name", "band-tools" ),
		"parent_item" => __( "Parent Category", "band-tools" ),
		"parent_item_colon" => __( "Parent Category:", "band-tools" ),
		"search_items" => __( "Search Categories", "band-tools" ),
		"popular_items" => __( "Popular Categories", "band-tools" ),
		"separate_items_with_commas" => __( "Separate Categories with commas", "band-tools" ),
		"add_or_remove_items" => __( "Add or remove Categories", "band-tools" ),
		"choose_from_most_used" => __( "Choose from the most used Categories", "band-tools" ),
		"not_found" => __( "No Categories found", "band-tools" ),
		"no_terms" => __( "No Categories", "band-tools" ),
		"items_list_navigation" => __( "Categories list navigation", "band-tools" ),
		"items_list" => __( "Categories list", "band-tools" ),
		"back_to_items" => __( "Back to Album Categories", "band-tools" ),
	];

	$args = [
		"label" => __( "Album Categories", "band-tools" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'album_categories', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "album_categories",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
			];
	register_taxonomy( "album_categories", [ "albums" ], $args );

	/**
	 * Taxonomy: Band Categories.
	 */

	$labels = [
		"name" => __( "Band Categories", "band-tools" ),
		"singular_name" => __( "Band Category", "band-tools" ),
		"menu_name" => __( "Categories", "band-tools" ),
		"all_items" => __( "All Categories", "band-tools" ),
		"edit_item" => __( "Edit Category", "band-tools" ),
		"view_item" => __( "View Category", "band-tools" ),
		"update_item" => __( "Update Category name", "band-tools" ),
		"add_new_item" => __( "Add new Category", "band-tools" ),
		"new_item_name" => __( "New Category name", "band-tools" ),
		"parent_item" => __( "Parent Category", "band-tools" ),
		"parent_item_colon" => __( "Parent Category:", "band-tools" ),
		"search_items" => __( "Search Categories", "band-tools" ),
		"popular_items" => __( "Popular Categories", "band-tools" ),
		"separate_items_with_commas" => __( "Separate Categories with commas", "band-tools" ),
		"add_or_remove_items" => __( "Add or remove Categories", "band-tools" ),
		"choose_from_most_used" => __( "Choose from the most used Categories", "band-tools" ),
		"not_found" => __( "No Categories found", "band-tools" ),
		"no_terms" => __( "No Categories", "band-tools" ),
		"items_list_navigation" => __( "Categories list navigation", "band-tools" ),
		"items_list" => __( "Categories list", "band-tools" ),
		"back_to_items" => __( "Back to Band Categories", "band-tools" ),
	];

	$args = [
		"label" => __( "Band Categories", "band-tools" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'band_categories', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "band_categories",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
			"default_term" => ['name' => 'Singer', 'slug' => 'singer'],
		];
	register_taxonomy( "band_categories", [ "bands" ], $args );

	/**
	 * Taxonomy: Song Categories.
	 */

	$labels = [
		"name" => __( "Song Categories", "band-tools" ),
		"singular_name" => __( "Song Category", "band-tools" ),
		"menu_name" => __( "Categories", "band-tools" ),
		"all_items" => __( "All Categories", "band-tools" ),
		"edit_item" => __( "Edit Category", "band-tools" ),
		"view_item" => __( "View Category", "band-tools" ),
		"update_item" => __( "Update Category name", "band-tools" ),
		"add_new_item" => __( "Add new Category", "band-tools" ),
		"new_item_name" => __( "New Category name", "band-tools" ),
		"parent_item" => __( "Parent Category", "band-tools" ),
		"parent_item_colon" => __( "Parent Category:", "band-tools" ),
		"search_items" => __( "Search Categories", "band-tools" ),
		"popular_items" => __( "Popular Categories", "band-tools" ),
		"separate_items_with_commas" => __( "Separate Categories with commas", "band-tools" ),
		"add_or_remove_items" => __( "Add or remove Categories", "band-tools" ),
		"choose_from_most_used" => __( "Choose from the most used Categories", "band-tools" ),
		"not_found" => __( "No Categories found", "band-tools" ),
		"no_terms" => __( "No Categories", "band-tools" ),
		"items_list_navigation" => __( "Categories list navigation", "band-tools" ),
		"items_list" => __( "Categories list", "band-tools" ),
		"back_to_items" => __( "Back to Song Categories", "band-tools" ),
	];

	$args = [
		"label" => __( "Song Categories", "band-tools" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'song_categories', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "song_categories",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
			];
	register_taxonomy( "song_categories", [ "songs" ], $args );
}
add_action( 'init', 'bndtls_register_my_taxes' );

function bndtls_change_cpt_service_to_specialty_labels() {
	$types=array('bands', 'albums', 'songs', 'videos');
	foreach ($types as $type) {
		if (wp_count_posts($type)->publish <= 1 ) {
			$get_post_type = get_post_type_object($type);
			$singular=get_post_type_labels($get_post_type)->singular_name;
			$labels = $get_post_type->labels;
			$labels->name               = $singular;
			$labels->menu_name          = $singular;
			$labels->archives	          = $singular;
			// $labels->all_items          = $singular;
			// $labels->name_admin_bar     = $singular;
		}
	}
}
add_action( 'init', 'bndtls_change_cpt_service_to_specialty_labels' );
