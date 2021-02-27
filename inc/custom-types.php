<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

function bndtls_register_my_cpts() {

	/**
	 * Post Type: Bands.
	 */

	$labels = [
		"name" => __( "Bands", "band-tools" ),
		"singular_name" => __( "Band", "band-tools" ),
		"menu_name" => __( "Bands", "band-tools" ),
		"all_items" => __( "All Bands", "band-tools" ),
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
		"archives" => __( "All bands", "band-tools" ),
		"insert_into_item" => __( "Insert into Band", "band-tools" ),
		"uploaded_to_this_item" => __( "Upload to this Band", "band-tools" ),
		"filter_items_list" => __( "Filter Bands list", "band-tools" ),
		"items_list_navigation" => __( "Bands list navigation", "band-tools" ),
		"items_list" => __( "Bands list", "band-tools" ),
		"attributes" => __( "Bands attributes", "band-tools" ),
		"name_admin_bar" => __( "Band", "band-tools" ),
		"item_published" => __( "Band published", "band-tools" ),
		"item_published_privately" => __( "Band published privately.", "band-tools" ),
		"item_reverted_to_draft" => __( "Band reverted to draft.", "band-tools" ),
		"item_scheduled" => __( "Band scheduled", "band-tools" ),
		"item_updated" => __( "Band updated.", "band-tools" ),
		"parent_item_colon" => __( "Parent Band:", "band-tools" ),
	];

	$args = [
		"label" => __( "Bands", "band-tools" ),
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
		"menu_icon" => "/w/wp-content/plugins/band-tools/assets/svg-user-music-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields" ],
	];

	register_post_type( "bands", $args );

	/**
	 * Post Type: Albums.
	 */

	$labels = [
		"name" => __( "Albums", "band-tools" ),
		"singular_name" => __( "Album", "band-tools" ),
		"menu_name" => __( "Albums", "band-tools" ),
		"all_items" => __( "All Albums", "band-tools" ),
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
		"archives" => __( "All Albums", "band-tools" ),
		"insert_into_item" => __( "Insert into Album", "band-tools" ),
		"uploaded_to_this_item" => __( "Upload to this Album", "band-tools" ),
		"filter_items_list" => __( "Filter Albums list", "band-tools" ),
		"items_list_navigation" => __( "Albums list navigation", "band-tools" ),
		"items_list" => __( "Albums list", "band-tools" ),
		"attributes" => __( "Albums attributes", "band-tools" ),
		"name_admin_bar" => __( "Album", "band-tools" ),
		"item_published" => __( "Album published", "band-tools" ),
		"item_published_privately" => __( "Album published privately.", "band-tools" ),
		"item_reverted_to_draft" => __( "Album reverted to draft.", "band-tools" ),
		"item_scheduled" => __( "Album scheduled", "band-tools" ),
		"item_updated" => __( "Album updated.", "band-tools" ),
		"parent_item_colon" => __( "Parent Album:", "band-tools" ),
	];

	$args = [
		"label" => __( "Albums", "band-tools" ),
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
		"menu_icon" => "/w/wp-content/plugins/band-tools/assets/svg-album-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields" ],
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "albums", $args );

	/**
	 * Post Type: Songs.
	 */

	$labels = [
		"name" => __( "Songs", "band-tools" ),
		"singular_name" => __( "Song", "band-tools" ),
		"menu_name" => __( "Songs", "band-tools" ),
		"all_items" => __( "All Songs", "band-tools" ),
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
		"archives" => __( "All Songs", "band-tools" ),
		"insert_into_item" => __( "Insert into Song", "band-tools" ),
		"uploaded_to_this_item" => __( "Upload to this Song", "band-tools" ),
		"filter_items_list" => __( "Filter Songs list", "band-tools" ),
		"items_list_navigation" => __( "Songs list navigation", "band-tools" ),
		"items_list" => __( "Songs list", "band-tools" ),
		"attributes" => __( "Songs attributes", "band-tools" ),
		"name_admin_bar" => __( "Song", "band-tools" ),
		"item_published" => __( "Song published", "band-tools" ),
		"item_published_privately" => __( "Song published privately.", "band-tools" ),
		"item_reverted_to_draft" => __( "Song reverted to draft.", "band-tools" ),
		"item_scheduled" => __( "Song scheduled", "band-tools" ),
		"item_updated" => __( "Song updated.", "band-tools" ),
		"parent_item_colon" => __( "Parent Song:", "band-tools" ),
	];

	$args = [
		"label" => __( "Songs", "band-tools" ),
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
		"menu_icon" => "/w/wp-content/plugins/band-tools/assets/svg-comment-music-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields" ],
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "songs", $args );
}

add_action( 'init', 'bndtls_register_my_cpts' );
