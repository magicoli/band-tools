<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

add_filter( 'rwmb_meta_boxes', 'bndtls_fields_bands' );
function bndtls_fields_bands( $meta_boxes ) {
  $meta_boxes[] = [
    'title'      => __( 'Info', 'band-tools' ),
    'id'         => 'fields-band-info',
    'post_types' => ['bands'],
    'class'      => 'bndtls-fields bndtls-fields-info bndtls-fields-info-bands',
    'fields'     => [
      [
        'name' => __( 'Creation', 'band-tools' ),
        'id'   => 'creation',
        'type' => 'date',
      ],
      [
        'name'  => __( 'Members', 'band-tools' ),
        'id'    => 'members',
        'type'  => 'text',
        'clone' => true,
      ],
      [
        'name'       => __( 'Genres', 'band-tools' ),
        'id'         => 'tax_genre',
        'type'       => 'taxonomy',
        'taxonomy'   => ['genre'],
        'field_type' => 'select_advanced',
        'add_new'    => true,
        'multiple'   => true,
      ],
    ],
  ];

  return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_fields_albums' );
function bndtls_fields_albums( $meta_boxes ) {
  $meta_boxes[] = [
    'title'      => __( 'Info', 'band-tools' ),
    'id'         => 'fields-album-info',
    'post_types' => ['albums'],
    'class'      => 'bndtls-fields bndtls-fields-info bndtls-fields-info-albums',
    'fields'     => [
      [
        'name' => __( 'Release', 'band-tools' ),
        'id'   => 'release',
        'type' => 'date',
      ],
      [
      'name'       => __( 'Genres', 'band-tools' ),
      'id'         => 'tax_genre',
      'type'       => 'taxonomy',
      'taxonomy'   => ['genre'],
      'field_type' => 'select_advanced',
      'add_new'    => true,
      'multiple'   => true,
      ],
    ],
  ];

  return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_fields_songs' );
function bndtls_fields_songs( $meta_boxes ) {
  $meta_boxes[] = [
    'title'      => __( 'Info', 'band-tools' ),
    'id'         => 'fields-song-info',
    'post_types' => ['songs'],
    'class'      => 'bndtls-fields bndtls-fields-info bndtls-fields-info-songs',
    'fields'     => [
      [
        'name'       => __( 'Genres', 'band-tools' ),
        'id'         => 'tax_genre',
        'type'       => 'taxonomy',
        'taxonomy'   => ['genre'],
        'field_type' => 'select_advanced',
        'add_new'    => true,
        'multiple'   => true,
      ],
    ],
  ];

  return $meta_boxes;
}

endif;
