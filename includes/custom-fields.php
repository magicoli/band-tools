<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

add_filter( 'rwmb_meta_boxes', 'bndtls_fields_bands' );
function bndtls_fields_bands( $meta_boxes ) {
  $prefix = '';
  $meta_boxes[] = [
    'title'      => __( 'Info', 'band-tools' ),
    'id'         => 'fields-band-info',
    'post_types' => ['bands'],
    'class'      => 'bndtls-fields bndtls-fields-info bndtls-fields-info-bands',
    'fields'     => [
      [
        'name'       => __( 'Genre', 'band-tools' ),
        'id'         => 'tax_genre',
        'type'       => 'taxonomy',
        'taxonomy'   => ['genre'],
        'field_type' => 'select_advanced',
        'add_new'    => true,
        'multiple'   => true,
      ],
      [
          'name' => __( 'Official Website', 'band-tools' ),
          'id'   => $prefix . 'official_website',
          'type' => 'url',
          'desc' => __( 'Leave empty if the same as this website', 'band-tools' ),
      ],
      [
          'name' => __( 'Official Store', 'band-tools' ),
          'id'   => $prefix . 'official_store',
          'type' => 'url',
          'desc' => __( 'Leave empty if the same as this website', 'band-tools' ),
      ],
      [
        'name' => __( 'Band Creation Date', 'band-tools' ),
        'id'   => 'creation',
        'type' => 'date',
        'placeholder' => 'YYYY-MM-YY',
        'desc' => 'Year, year-month or full date',
      ],
      [
        'name'  => __( 'Members', 'band-tools' ),
        'id'    => 'members',
        'type'  => 'text',
        'clone' => true,
      ],
    ],
  ];

  return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'bndtls_fields_records' );
function bndtls_fields_records( $meta_boxes ) {
  $meta_boxes[] = [
    'title'      => __( 'Info', 'band-tools' ),
    'id'         => 'fields-record-info',
    'post_types' => ['records'],
    'class'      => 'bndtls-fields bndtls-fields-info bndtls-fields-info-records',
    'fields'     => [
      [
        'name' => __( 'Initial Release', 'band-tools' ),
        'id'   => 'release',
        'type' => 'date',
        'placeholder' => 'YYYY-MM-YY',
        'desc' => 'Year, year-month or full date',
      ],
      [
        'name'       => __( 'Release Type', 'band-tools' ),
        'id'         => 'release_type',
        'type'       => 'taxonomy',
        'taxonomy'   => ['release_type'],
        'field_type' => 'select',
        'add_new'    => true,
        // 'multiple'   => true,
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
        'name'       => __( 'Genre', 'band-tools' ),
        'id'         => 'tax_genre',
        'type'       => 'taxonomy',
        'taxonomy'   => ['genre'],
        'field_type' => 'select_advanced',
        'add_new'    => true,
        'multiple'   => true,
      ],
      [
        'name'       => __( 'Authors', 'band-tools' ),
        'id'         => 'authors',
        'type'       => 'taxonomy',
        'taxonomy'   => ['authors'],
        'field_type' => 'select_advanced',
        'add_new'    => true,
        'multiple'   => true,
      ],
      [
        'name' => __( 'Initial Release', 'band-tools' ),
        'id'   => 'release',
        'type' => 'date',
        'placeholder' => 'YYYY-MM-YY',
        'desc' => 'Year, year-month or full date',
      ],
    ],
    'title'      => __( 'Files', 'band-tools' ),
    'id'         => 'fields-song-files',
    'post_types' => ['songs'],
    'class'      => 'bndtls-fields bndtls-fields-info bndtls-fields-info-files',
    'fields'     => [
      [
        'name'          => __( 'Audio sample', 'band-tools' ),
        'id'            => 'audio_sample',
        'desc'          => __('30 seconds samples for use in player, on songs and records pages. Add both mp3 and ogg formats for maximum compatibility. Wav format is supported but not recommended.', 'band-tools' ),
        'type'          => 'file_advanced',
        'mime_type'     => 'audio',
        'upload_dir'    => WP_CONTENT_DIR . '/band-tools/audio-sample',
        // 'max_file_uploads' => 3,
        'multiple'      => true,
        'force_delete'  => true,
      ],
      // [
      //   'name'          => __( 'Full audio', 'band-tools' ),
      //   'desc'   => __('Full length audio, will be trimmed to sample default length for song and album player. Only use if no sample available.'),
      //   'id'            => 'audio_full',
      //   'type'          => 'file_advanced',
      //   'mime_type'     => 'audio',
      //   'upload_dir'    => WP_CONTENT_DIR . '/band-tools/audio-full',
      //   'multiple'      => true,
      //   'force_delete'  => true,
      // ],
    ],
  ];

  return $meta_boxes;
}

endif;
