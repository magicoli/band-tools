<?php

function cptui_register_my_cpts() {

	/**
	 * Post Type: Bands.
	 */

	$labels = [
		"name" => __( "Bands", "twentytwentyone" ),
		"singular_name" => __( "Band", "twentytwentyone" ),
	];

	$args = [
		"label" => __( "Bands", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
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
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "bands", $args );

	/**
	 * Post Type: Albums.
	 */

	$labels = [
		"name" => __( "Albums", "twentytwentyone" ),
		"singular_name" => __( "Album", "twentytwentyone" ),
	];

	$args = [
		"label" => __( "Albums", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
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
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "albums", $args );

	/**
	 * Post Type: Songs.
	 */

	$labels = [
		"name" => __( "Songs", "twentytwentyone" ),
		"singular_name" => __( "Song", "twentytwentyone" ),
	];

	$args = [
		"label" => __( "Songs", "twentytwentyone" ),
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
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "songs", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );
