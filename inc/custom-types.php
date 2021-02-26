<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

function bndtls_register_post_types() {

	/**
	 * Post Type: Bands.
	 */

	$labels = [
		"name" => __("Bands", "band-tools"),
		"singular_name" => __("Band", "band-tools"),
	];

	$args = [
		"label" => __("Bands", "band-tools"),
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
		"menu_icon" => plugin_dir_url(__FILE__) . "../assets/svg-user-music-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
	];

	register_post_type( "bands", $args );

	/**
	 * Post Type: Albums.
	 */

	$labels = [
		"name" => __("Albums", "band-tools"),
		"singular_name" => __("Album", "band-tools"),
	];

	$args = [
		"label" => __("Albums", "band-tools"),
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
		"menu_icon" => plugin_dir_url(__FILE__) . "../assets/svg-album-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "albums", $args );

	/**
	 * Post Type: Songs.
	 */

	$labels = [
		"name" => __("Songs", "band-tools"),
		"singular_name" => __("Song", "band-tools"),
	];

	$args = [
		"label" => __("Songs", "band-tools"),
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
		"menu_icon" => plugin_dir_url(__FILE__) . "../assets/svg-comment-music-20x20.svg",
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "songs", $args );
}

add_action( 'init', 'bndtls_register_post_types' );
