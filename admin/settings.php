<?php if ( ! is_admin() ) die;

add_action( 'admin_menu', 'bndtls_remove_meta_box_menu', 20 );
function bndtls_remove_meta_box_menu() {
	if(is_plugin_active('meta-box/meta-box.php')) return;
	if(is_plugin_active('meta-box-builder/meta-box-builder.php')) return;
	if(is_plugin_active('mb-core/mb-core.php')) return;
	remove_menu_page( 'meta-box' );
	$meta_box_updater = get_option('meta_box_updater');
	if( ! $meta_box_updater['api_key'] ) {
		$meta_box_updater['api_key'] = BNDTLS_SLUG . ' bundle';
		$meta_box_updater['status'] = 'active';
		update_option('meta_box_updater', $meta_box_updater);
	}
}

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

add_filter( 'mb_settings_pages', 'bndtls_settings' );

function bndtls_settings( $settings_pages ) {
  $settings_pages[] = [
    'id' => 'band-tools-settings',
		'option_name' => 'bndtls-settings',
    'menu_title'  => __( 'Settings', 'band-tools' ),
		'icon_url'    => 'dashicons-admin-generic',
    'position'    => 25,
    'parent'      => 'band-tools',
    'capability'  => 'manage_options',
    'columns'     => 1,
  ];

  return $settings_pages;
}


add_filter( 'rwmb_meta_boxes', 'bndtls_settings_naming' );

function bndtls_settings_naming( $meta_boxes ) {
  bndtls_load_textdomain();

  $prefix = '';

  $meta_boxes[] = [
    'title'          => __( 'Nomenclature', 'band-tools' ),
    'id'             => 'naming',
    'settings_pages' => ['band-tools-settings'],
    'fields'         => [
      [
        'name'   => __( 'Band', 'band-tools' ),
        'id'     => $prefix . 'naming_band',
        'type'   => 'group',
        'class'  => 'inline',
        'fields' => [
          [
            'id'          => $prefix . 'singular',
            'type'        => 'text',
            'desc'        => __( 'Singular', 'band-tools' ),
            'std'         => __('Band', 'band-tools' ),
            'placeholder' => __( 'Singular', 'band-tools' ),
            'class'       => 'inline',
            'datalist'    => [
              'id'      => '6060ef87d6b26',
              'options' => [
                __('Artist', 'band-tools'),
                __('Band', 'band-tools'),
                __('DJ', 'band-tools'),
                __('Musician', 'band-tools'),
                __('Performer', 'band-tools'),
                __('Singer', 'band-tools'),
              ],
            ],
          ],
          [
            'id'          => $prefix . 'plural',
            'type'        => 'text',
            'desc'        => __( 'Plural', 'band-tools' ),
            'std'         => __( 'Bands', 'band-tools' ),
            'placeholder' => __( 'Plural', 'band-tools' ),
            'class'       => 'inline',
            'datalist'    => [
              'id'      => '6060ef87d6b45',
              'options' => [
                __('Artists', 'band-tools'),
                __('Bands', 'band-tools'),
                __('DJs', 'band-tools'),
                __('Musicians', 'band-tools'),
                __('Performers', 'band-tools'),
                __('Singers', 'band-tools'),
              ],
            ],
          ],
        ],
      ],
      [
        'name'   => __( 'Album', 'band-tools' ),
        'id'     => $prefix . 'naming_album',
        'type'   => 'group',
        'class'  => 'inline',
        'fields' => [
          [
            'id'          => $prefix . 'singular',
            'type'        => 'text',
            'desc'        => __( 'Singular', 'band-tools' ),
            'std'         => __( 'Album', 'band-tools' ),
            'placeholder' => __( 'Singular', 'band-tools' ),
            'class'       => 'inline',
            'datalist'    => [
              'id'      => '6060ef87d6b88',
              'options' => [
                __('Album', 'band-tools'),
                __('Disc', 'band-tools'),
                __('Record', 'band-tools'),
                __('Set', 'band-tools'),
              ],
            ],
          ],
          [
            'id'          => $prefix . 'plural',
            'type'        => 'text',
            'desc'        => __( 'Plural', 'band-tools' ),
            'std'         => __( 'Albums', 'band-tools' ),
            'placeholder' => __( 'Plural', 'band-tools' ),
            'class'       => 'inline',
            'datalist'    => [
              'id'      => '6060ef87d6b9e',
              'options' => [
                __('Albums', 'band-tools'),
                __('Discs', 'band-tools'),
                __('Records', 'band-tools'),
                __('Sets', 'band-tools'),
              ],
            ],
          ],
        ],
      ],
      [
        'name'   => __( 'Song', 'band-tools' ),
        'id'     => $prefix . 'naming_song',
        'type'   => 'group',
        'class'  => 'inline',
        'fields' => [
          [
            'id'          => $prefix . 'singular',
            'type'        => 'text',
            'desc'        => __( 'Singular', 'band-tools' ),
            'std'         => __( 'Song', 'band-tools' ),
            'placeholder' => __( 'Singular', 'band-tools' ),
            'class'       => 'inline',
            'datalist'    => [
              'id'      => '6060ef87d6bda',
              'options' => [
                __('Song', 'band-tools'),
                __('Mix', 'band-tools'),
                __('Piece', 'band-tools'),
              ],
            ],
          ],
          [
            'id'          => $prefix . 'plural',
            'type'        => 'text',
            'desc'        => __( 'Plural', 'band-tools' ),
            'std'         => __( 'Songs', 'band-tools' ),
            'placeholder' => __( 'Plural', 'band-tools' ),
            'class'       => 'inline',
            'datalist'    => [
              'id'      => '6060ef87d6bef',
              'options' => [
                __('Songs', 'band-tools'),
                __('Mixes', 'band-tools'),
                __('Pieces', 'band-tools'),
              ],
            ],
          ],
        ],
      ],
    ],
  ];

  return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_settings_tweaks' );

function bndtls_settings_tweaks( $meta_boxes ) {
  $prefix = '';

  $meta_boxes[] = [
    'title'          => __( 'Tweaks', 'band-tools' ),
    'id'             => 'tweaks',
    'settings_pages' => ['band-tools-settings'],
    'visible'        => [
      'when'     => [['', '=', '']],
      'relation' => 'or',
    ],
    'fields'         => [
			[
				'name' => __( 'Disable plugin templates', 'band-tools' ),
        'id'   => $prefix . 'disable_templates',
        'type' => 'switch',
        'desc' => __( 'Customize with theme, widgets and shortcodes', 'band-tools' ),
        'std'  => false,
      ],
			[
				'name' => __( 'Redirect single post archives', 'band-tools' ),
        'id'   => $prefix . 'redirect_single_post_archives',
        'type' => 'switch',
        'desc' => __( 'Redirect archives containing only one post', 'band-tools' ),
        'std'  => true,
      ],
      [
				'name' => __( 'Clean titles', 'band-tools' ),
        'id'   => $prefix . 'clean_titles',
        'type' => 'switch',
        'desc' => __( 'Remove prefixes from titles for Categories, Taxonomies, Archives, Authors', 'band-tools' ),
        'std'  => true,
      ],
      [
				'name' => __( 'Widget Area', 'band-tools' ),
        'id'   => $prefix . 'widget_area',
        'type' => 'switch',
        'desc' => __( 'Add a custom widget area (must be activated in your theme)', 'band-tools' ),
      ],
      [
				'name' => __( 'Make coffee after boot', 'band-tools' ),
        'id'   => $prefix . 'make_coffee_after_boot',
        'type' => 'hidden',
        'desc' => '',
        'std'  => true,
      ],
      [
				'name' => __( 'Developer mode', 'band-tools' ),
        'id'   => $prefix . 'developer_mode',
        'type' => 'switch',
        'desc' => '',
        'std'  => true,
      ],
    ],
  ];

  return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_settings_frontpage' );
function bndtls_settings_frontpage( $meta_boxes ) {
	$prefix = '';

	$meta_boxes[] = [
		'title'          => __( 'Front page', 'band-tools' ),
		'id'             => 'front-page',
		'settings_pages' => ['band-tools-settings'],
		'fields'         => [
			[
				'name'            => __( 'Allow as Front Page', 'band-tools' ),
				'id'              => $prefix . 'front_page_allow',
				'type'            => 'select_advanced',
				'desc'            => __( 'Allow to select these as front page in Appearance > Customize menu', 'band-tools' ),
				'options'         => [
					'bands'  => __( 'Bands', 'band-tools' ),
					'albums' => __( 'Albums', 'band-tools' ),
					'songs'  => __( 'Songs', 'band-tools' ),
				],
				'std'             => ['bands'],
				'multiple'        => true,
				'select_all_none' => true,
			],
			[
				'name'    => __( 'Show full content', 'band-tools' ),
				'id'      => $prefix . 'frontpage_full_content',
				'type'    => 'switch',
				'desc'    => __( 'Show full content when item is selected as home page', 'band-tools' ),
				'std'     => true,
				'visible' => [
					'when'     => [['front_page_allow', '!=', '']],
					'relation' => 'or',
				],
			],
		],
	];

	return $meta_boxes;
}

endif;
