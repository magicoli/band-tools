<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

// if( function_exists('acf_add_local_field_group') ):
//
// acf_add_local_field_group(array(
// 	'key' => 'group_6036ca9f301ee',
// 	'title' => __('Album info', "band-tools"),
// 	'fields' => array(
// 		array(
// 			'key' => 'field_60370454ae3d1',
// 			'label' => __('Album band', "band-tools"),
// 			'name' => 'album_band',
// 			'type' => 'post_object',
// 			'instructions' => '',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'bands',
// 			),
// 			'taxonomy' => '',
// 			'allow_null' => 0,
// 			'multiple' => 0,
// 			'return_format' => 'object',
// 			'ui' => 1,
// 		),
// 		array(
// 			'key' => 'field_6036cdea22a7b',
// 			'label' => __('Release date', "band-tools"),
// 			'name' => 'release_date',
// 			'type' => 'date_picker',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'display_format' => 'd/m/Y',
// 			'return_format' => 'd/m/Y',
// 			'first_day' => 1,
// 		),
// 		array(
// 			'key' => 'field_6036caa495dc2',
// 			'label' => __('Tracks', "band-tools"),
// 			'name' => 'tracks',
// 			'type' => 'relationship',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'songs',
// 			),
// 			'taxonomy' => '',
// 			'filters' => array(
// 				0 => 'search',
// 			),
// 			'elements' => '',
// 			'min' => '',
// 			'max' => '',
// 			'return_format' => 'object',
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'post_type',
// 				'operator' => '==',
// 				'value' => 'albums',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'left',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));
//
// acf_add_local_field_group(array(
// 	'key' => 'group_6036da015238e',
// 	'title' => __('Band info', "band-tools"),
// 	'fields' => array(
// 		array(
// 			'key' => 'field_6037040409e52',
// 			'label' => __('Album Band', "band-tools"),
// 			'name' => 'album_band',
// 			'type' => 'relationship',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'albums',
// 			),
// 			'taxonomy' => '',
// 			'filters' => array(
// 				0 => 'search',
// 			),
// 			'elements' => array(
// 				0 => 'featured_image',
// 			),
// 			'min' => '',
// 			'max' => '',
// 			'return_format' => 'object',
// 		),
// 		array(
// 			'key' => 'field_6036da45bee9d',
// 			'label' => __('Songs', "band-tools"),
// 			'name' => 'band',
// 			'type' => 'relationship',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'songs',
// 			),
// 			'taxonomy' => '',
// 			'filters' => array(
// 				0 => 'search',
// 			),
// 			'elements' => '',
// 			'min' => '',
// 			'max' => '',
// 			'return_format' => 'object',
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'post_type',
// 				'operator' => '==',
// 				'value' => 'bands',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'left',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));
//
// acf_add_local_field_group(array(
// 	'key' => 'group_6036c84abbd81',
// 	'title' => __('Song info', "band-tools"),
// 	'fields' => array(
// 		array(
// 			'key' => 'field_6036d7b066e19',
// 			'label' => __('Band', "band-tools"),
// 			'name' => 'band',
// 			'type' => 'post_object',
// 			'instructions' => '',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'bands',
// 			),
// 			'taxonomy' => '',
// 			'allow_null' => 0,
// 			'multiple' => 0,
// 			'return_format' => 'object',
// 			'ui' => 1,
// 		),
// 		array(
// 			'key' => 'field_6036d3caa9666',
// 			'label' => __('Albums', "band-tools"),
// 			'name' => 'tracks',
// 			'type' => 'relationship',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'albums',
// 			),
// 			'taxonomy' => '',
// 			'filters' => array(
// 				0 => 'search',
// 			),
// 			'elements' => array(
// 				0 => 'featured_image',
// 			),
// 			'min' => '',
// 			'max' => '',
// 			'return_format' => 'object',
// 		),
// 		array(
// 			'key' => 'field_603addac395f3',
// 			'label' => __('Videos', "band-tools"),
// 			'name' => 'video_posts',
// 			'type' => 'relationship',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'videos',
// 			),
// 			'taxonomy' => '',
// 			'filters' => array(
// 				0 => 'search',
// 				1 => 'taxonomy',
// 			),
// 			'elements' => array(
// 				0 => 'featured_image',
// 			),
// 			'min' => '',
// 			'max' => '',
// 			'return_format' => 'object',
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'post_type',
// 				'operator' => '==',
// 				'value' => 'songs',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'left',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));
//
// acf_add_local_field_group(array(
// 	'key' => 'group_603adf0d77972',
// 	'title' => __('Video info', "band-tools"),
// 	'fields' => array(
// 		array(
// 			'key' => 'field_603adf4871553',
// 			'label' => __('Related posts', "band-tools"),
// 			'name' => 'video_posts',
// 			'type' => 'relationship',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'songs',
// 				1 => 'albums',
// 				2 => 'product',
// 			),
// 			'taxonomy' => '',
// 			'filters' => array(
// 				0 => 'search',
// 				1 => 'post_type',
// 			),
// 			'elements' => '',
// 			'min' => '',
// 			'max' => '',
// 			'return_format' => 'object',
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'post_type',
// 				'operator' => '==',
// 				'value' => 'videos',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'left',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));
//
// endif;
