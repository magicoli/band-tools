<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6036ca9f301ee',
	'title' => 'Album info',
	'fields' => array(
		array(
			'key' => 'field_60370454ae3d1',
			'label' => 'Album band',
			'name' => 'album_band',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'bands',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array(
			'key' => 'field_6036cdea22a7b',
			'label' => 'Release date',
			'name' => 'release_date',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array(
			'key' => 'field_6036caa495dc2',
			'label' => 'Tracks',
			'name' => 'tracks',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'songs',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => '',
			'min' => '',
			'max' => '',
			'return_format' => 'object',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'albums',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_6036da015238e',
	'title' => 'Band info',
	'fields' => array(
		array(
			'key' => 'field_6037040409e52',
			'label' => 'Album Band',
			'name' => 'album_band',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'albums',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => array(
				0 => 'featured_image',
			),
			'min' => '',
			'max' => '',
			'return_format' => 'object',
		),
		array(
			'key' => 'field_6036da45bee9d',
			'label' => 'Songs',
			'name' => 'band',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'songs',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => '',
			'min' => '',
			'max' => '',
			'return_format' => 'object',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'bands',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_6036c84abbd81',
	'title' => 'Song info',
	'fields' => array(
		array(
			'key' => 'field_6036d7b066e19',
			'label' => 'Band',
			'name' => 'band',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'bands',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array(
			'key' => 'field_6036d3caa9666',
			'label' => 'Tracks',
			'name' => 'tracks',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'albums',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => '',
			'min' => '',
			'max' => '',
			'return_format' => 'object',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'songs',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

// acf_add_local_field_group(array(
// 	'key' => 'group_603855c7af062',
// 	'title' => 'WooCommerce',
// 	'fields' => array(
// 		array(
// 			'key' => 'field_6038543ae14e5',
// 			'label' => 'Product',
// 			'name' => 'wc_product',
// 			'type' => 'post_object',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => array(
// 				array(
// 					array(
// 						'field' => 'field_603856ffbc3ce',
// 						'operator' => '==empty',
// 					),
// 				),
// 			),
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'product',
// 			),
// 			'taxonomy' => '',
// 			'allow_null' => 1,
// 			'multiple' => 0,
// 			'return_format' => 'object',
// 			'ui' => 1,
// 		),
// 		array(
// 			'key' => 'field_603856ffbc3ce',
// 			'label' => 'Categories',
// 			'name' => 'wc_categories',
// 			'type' => 'taxonomy',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => array(
// 				array(
// 					array(
// 						'field' => 'field_6038543ae14e5',
// 						'operator' => '==empty',
// 					),
// 				),
// 			),
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'taxonomy' => 'product_cat',
// 			'field_type' => 'checkbox',
// 			'add_term' => 1,
// 			'save_terms' => 0,
// 			'load_terms' => 0,
// 			'return_format' => 'object',
// 			'multiple' => 0,
// 			'allow_null' => 0,
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
// 	'menu_order' => 1,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'left',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));

endif;
