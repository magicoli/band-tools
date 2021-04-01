<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

if ( ! is_plugin_active('mb-core/mb-core.php' ) || ! bndtls_get_option( 'developer_mode') ):

add_filter( 'rwmb_meta_boxes', 'bndtls_fields_bands' );
function bndtls_fields_bands( $meta_boxes ) {
    $prefix = 'band';

    $meta_boxes[] = [
        'title'      => __( 'Info', 'band-tools' ),
        'id'         => 'fields-band-info',
        'post_types' => ['bands'],
        'fields'     => [
            [
                'name' => __( 'Creation', 'band-tools' ),
                'id'   => $prefix . 'creation',
                'type' => 'date',
            ],
            [
                'name'  => __( 'Members', 'band-tools' ),
                'id'    => $prefix . 'members',
                'type'  => 'text',
                'clone' => true,
            ],
            [
                'name'            => __( 'Genre', 'band-tools' ),
                'id'              => $prefix . 'genre',
                'type'            => 'select_advanced',
                'options'         => bndtls_id3_genres(),
                'multiple'        => true,
                // 'select_all_none' => true,
                'admin_columns'   => [
                    'position'   => 'after title',
                    'sort'       => true,
                    'searchable' => true,
                    'filterable' => true,
                ],
            ],
        ],
    ];

    return $meta_boxes;
}

endif;
