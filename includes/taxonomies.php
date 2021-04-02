<?php
if ( ! defined( 'WPINC' ) ) die;

add_action( 'init', 'bndtls_tax_genres' );
function bndtls_tax_genres() {
	$labels = [
		'name'                       => esc_html__( 'Genres', 'band-tools' ),
		'singular_name'              => esc_html__( 'Genre', 'band-tools' ),
		'menu_name'                  => esc_html__( 'Genres', 'band-tools' ),
		'search_items'               => esc_html__( 'Search Genres', 'band-tools' ),
		'popular_items'              => esc_html__( 'Popular Genres', 'band-tools' ),
		'all_items'                  => esc_html__( 'All Genres', 'band-tools' ),
		'parent_item'                => esc_html__( 'Parent Genre', 'band-tools' ),
		'parent_item_colon'          => esc_html__( 'Parent Genre', 'band-tools' ),
		'edit_item'                  => esc_html__( 'Edit Genre', 'band-tools' ),
		'view_item'                  => esc_html__( 'View Genre', 'band-tools' ),
		'update_item'                => esc_html__( 'Update Genre', 'band-tools' ),
		'add_new_item'               => esc_html__( 'Create new genre', 'band-tools' ),
		'new_item_name'              => esc_html__( 'New genre name', 'band-tools' ),
		'separate_items_with_commas' => esc_html__( 'Separate genres with commas', 'band-tools' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove genres', 'band-tools' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used genres', 'band-tools' ),
		'not_found'                  => esc_html__( 'No genres found', 'band-tools' ),
		'no_terms'                   => esc_html__( 'No genres found', 'band-tools' ),
		'items_list_navigation'      => esc_html__( 'Genres list pagination', 'band-tools' ),
		'items_list'                 => esc_html__( 'Genres list', 'band-tools' ),
		'most_used'                  => esc_html__( 'Most Used', 'band-tools' ),
		'back_to_items'              => esc_html__( 'Back to genres', 'band-tools' ),
		'text_domain'                => esc_html__( 'band-tools', 'band-tools' ),
	];
	$args = [
		'label'              => esc_html__( 'Genres', 'band-tools' ),
		'labels'             => $labels,
		'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'meta_box_cb'        => false,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
    'show_admin_column'  => true,
		'query_var'          => true,
		'sort'               => true,
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'genre', ['albums', 'songs', 'bands'], $args );
}
