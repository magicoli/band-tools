<?php
if ( ! defined( 'WPINC' ) ) die;

add_action( 'init', 'bndtls_register_taxonomies' );
function bndtls_register_taxonomies() {
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
	register_taxonomy( 'genre', ['records', 'songs', 'bands'], $args );

	$labels = [
	  'name'                       => esc_html__( 'Authors', 'band-tools' ),
	  'singular_name'              => esc_html__( 'Author', 'band-tools' ),
	  'menu_name'                  => esc_html__( 'Authors', 'band-tools' ),
	  'search_items'               => esc_html__( 'Search Authors', 'band-tools' ),
	  'popular_items'              => esc_html__( 'Popular Authors', 'band-tools' ),
	  'all_items'                  => esc_html__( 'All Authors', 'band-tools' ),
	  'parent_item'                => esc_html__( 'Parent Author', 'band-tools' ),
	  'parent_item_colon'          => esc_html__( 'Parent Author', 'band-tools' ),
	  'edit_item'                  => esc_html__( 'Edit Author', 'band-tools' ),
	  'view_item'                  => esc_html__( 'View Author', 'band-tools' ),
	  'update_item'                => esc_html__( 'Update Author', 'band-tools' ),
	  'add_new_item'               => esc_html__( 'Create new author', 'band-tools' ),
	  'new_item_name'              => esc_html__( 'New author name', 'band-tools' ),
	  'separate_items_with_commas' => esc_html__( 'Separate authors with commas', 'band-tools' ),
	  'add_or_remove_items'        => esc_html__( 'Add or remove authors', 'band-tools' ),
	  'choose_from_most_used'      => esc_html__( 'Choose most used authors', 'band-tools' ),
	  'not_found'                  => esc_html__( 'No authors found', 'band-tools' ),
	  'no_terms'                   => esc_html__( 'No authors found', 'band-tools' ),
	  'items_list_navigation'      => esc_html__( 'Authors list pagination', 'band-tools' ),
	  'items_list'                 => esc_html__( 'Authors list', 'band-tools' ),
	  'most_used'                  => esc_html__( 'Most Used', 'band-tools' ),
	  'back_to_items'              => esc_html__( 'Back to authors', 'band-tools' ),
	  'text_domain'                => esc_html__( 'band-tools', 'band-tools' ),
	];
	$args = [
	  'label'              => esc_html__( 'Authors', 'band-tools' ),
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
	register_taxonomy( 'authors', ['songs'], $args );

	$labels = [
	  'name'                       => esc_html__( 'Release Types', 'band-tools' ),
	  'singular_name'              => esc_html__( 'Release Type', 'band-tools' ),
	  'menu_name'                  => esc_html__( 'Release Types', 'band-tools' ),
	  'search_items'               => esc_html__( 'Search Release Types', 'band-tools' ),
	  'popular_items'              => esc_html__( 'Popular Release Types', 'band-tools' ),
	  'all_items'                  => esc_html__( 'All Release Types', 'band-tools' ),
	  'parent_item'                => esc_html__( 'Parent Release Type', 'band-tools' ),
	  'parent_item_colon'          => esc_html__( 'Parent Release Type', 'band-tools' ),
	  'edit_item'                  => esc_html__( 'Edit Release Type', 'band-tools' ),
	  'view_item'                  => esc_html__( 'View Release Type', 'band-tools' ),
	  'update_item'                => esc_html__( 'Update Release Type', 'band-tools' ),
	  'add_new_item'               => esc_html__( 'Create new release type', 'band-tools' ),
	  'new_item_name'              => esc_html__( 'New release type name', 'band-tools' ),
	  'separate_items_with_commas' => esc_html__( 'Separate release types with commas', 'band-tools' ),
	  'add_or_remove_items'        => esc_html__( 'Add or remove release types', 'band-tools' ),
	  'choose_from_most_used'      => esc_html__( 'Choose most used release types', 'band-tools' ),
	  'not_found'                  => esc_html__( 'No release types found', 'band-tools' ),
	  'no_terms'                   => esc_html__( 'No release types found', 'band-tools' ),
	  'items_list_navigation'      => esc_html__( 'Release Types list pagination', 'band-tools' ),
	  'items_list'                 => esc_html__( 'Release Types list', 'band-tools' ),
	  'most_used'                  => esc_html__( 'Most Used', 'band-tools' ),
	  'back_to_items'              => esc_html__( 'Back to release types', 'band-tools' ),
	  'text_domain'                => esc_html__( 'band-tools', 'band-tools' ),
	];
	$args = [
	  'label'              => esc_html__( 'Release Types', 'band-tools' ),
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
	register_taxonomy( 'release_type', ['records'], $args );

	bndtls_taxonomies_default_release_types();
}

function bndtls_taxonomies_default_release_types() {
  if(get_option('bndtls_release_types_updated')) return;
  $terms = [
    esc_html__('Single', 'band-tools') => [
      'slug' => 'single',
      'description' => 'Usually 1 track, up to 3 for historical reasons.',
    ],
    esc_html__('EP / Mini-album', 'band-tools') => [
      'slug' => 'ep',
      'description' => 'Extended play, up to 6 tracks.',
    ],
		esc_html__('Album', 'band-tools') => [
      'slug' => 'lp',
      'description' => 'Long play, 6 tracks/28 minutes or more. Usually first release for all included tracks.',
    ],
		esc_html__('Compilation', 'band-tools') => [
      'slug' => 'lp',
      'description' => 'Previously released tracks.',
    ],
		esc_html__('Compilation', 'band-tools') => [
      'slug' => 'compilation',
      'description' => 'Usually contains previously released tracks.',
    ],
		esc_html__('Mixtape', 'band-tools') => [
      'slug' => 'mixtape',
      'description' => 'Old or new material, revisited with original artist consent.',
    ],
		esc_html__('DJ Mix', 'band-tools') => [
			'slug' => 'djmix',
			'description' => 'Mixset session by a DJ.',
		],
		esc_html__('Bootleg / Unauthorized', 'band-tools') => [
      'slug' => 'bootleg',
      'description' => 'Musical work not endorsed by original artist.',
    ],
  ];
  $i=0;
  foreach($terms as $term => $args) {
    $slug=$args['slug'];
    if(term_exists( $slug, 'release_type' )) continue;
    wp_insert_term( $term, 'release_type', $args );
    $i++;
  }
  if($i > 0)
	bndtls_admin_notice(sprintf(__('%s release types added', 'band-tools'), $i), 'success');
  update_option('bndtls_release_types_updated', true);
}
