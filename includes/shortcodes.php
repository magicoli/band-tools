<?php
/**
 * Shortcodes
 *
 * @package	band-tools
 */

/**
 * Initialize bndtls shortcodes
 * @return void
 */
function bndtls_shortcodes_init()
{
	function bndtls_bndtls_shortcode($atts = [], $content = null, $tag = '' )
	{
    // $atts = array_change_key_case( (array) $atts, CASE_LOWER );

    if($atts['title']) $output .= "<h3>${atts['title']}</h3>";
    if($content) $output .= '<p>' . apply_filters( 'the_content', $content ) . '</p>';

    if(!empty($output))
    $output = "<div class='bndtls bndtls-$tag'>$output</div>";
		// echo $output; die;
		return $output;
	}
	// add_shortcode('bndtls', 'bndtls_bndtls_shortcode');

	function bndtls_shortcode_list($atts, $content = null, $tag = '' )
	{
		$output = '';
		$type=(isset($atts['type'])) ? $atts['type'] : preg_replace('/^bt-/', '', $tag);
		if(isset($atts['id'])) $post=get_post($atts['id']);
		else $post=get_post();
		// $post_type=$post->post_type;
		$args = array(
			'before_title' => '<h3 class=bndtls-block>',
			'after_title' => '</h3>',
		);
		if(isset($atts['title'])) $args['title'] = $atts['title'];
		if($type == "band-tools" || $type == "bndtls" || $type=="auto" ) {
			switch($post->post_type) {
				case 'bands':
				$output = bndtls_get_relations($post, [ 'records', 'songs' ] );
				break;

				case 'records':
				$output = bndtls_get_relations($post, [ 'bands' ], [ 'direction' => 'to', 'mode' => 'inline' ] )
				 . bndtls_get_relations($post, [ 'songs' ], [ 'mode' => 'ol' ] );
				break;

				case 'songs':
				$output = bndtls_get_relations($post, [ 'bands' ], [ 'direction' => 'to', 'mode' => 'inline' ] )
				. bndtls_get_relations($post, [ 'records', 'songs' ], [ 'direction' => 'to', 'mode' => 'inline' ] );
				break;

				default:
				// $output .= "<code>been there " . basename(__DIR__) . "/" . basename(__FILE__) . " " . __METHOD__ . "() $tag $type for $post_type</code>";
			}
		} else if($type) {
			$output .= bndtls_get_relations($post, [ $type ], $args );
			// $output .= "<code>been there " . basename(__DIR__) . "/" . basename(__FILE__) . " " . __METHOD__ . "() $tag $type for $post_type</code>";
		} else {
			$output .= "no tag (should not happen, should it?)";
		}
		// $output = bndtls_block_relations_list($tag, $args );
		// $output = "<pre>" . print_r($tag, true) . "</pre>";
		// $output = bndtls_get_relations($post, [ $tag ] );

    if(!empty($output))
    return "<div class='bndtls-relations bndtls-relations-$tag'>$output</div>";
	}
	add_shortcode('bt-auto', 'bndtls_shortcode_list');
	add_shortcode('bt-bands', 'bndtls_shortcode_list');
	add_shortcode('bt-records', 'bndtls_shortcode_list');
	add_shortcode('bt-songs', 'bndtls_shortcode_list');
	add_shortcode('bt-player', 'bndtls_shortcode_list');
	add_shortcode('band-tools', 'bndtls_shortcode_list');
	add_shortcode('bndtls', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('bands', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('records', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('songs', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('videos', 'bndtls_shortcode_list'); // deprecated, backward compatibility

	if(function_exists('vc_map')) {
		vc_map(array(
			'name'				=> __('Band Tools', 'band-tools'),
			'base'				=> 'band-tools',
			'description'	=> __('Show relevant items', 'band-tools'),
			'category'		=> 'Band Tools',
			'icon'				=>     plugin_dir_url(__DIR__) . 'assets/svg-microphone-stand-20x20-turquoise.svg',
			'params'			=> [
				[
					'param_name'	=> 'type',
					'heading' 		=> _x( 'Type', 'WPBakery Block', 'band-tools' ),
					'type'				=> 'dropdown',
					'value'			=> [
						__('Auto', 'band-tools')		=> 'auto',
						__('Bands', 'band-tools')		=> 'bands',
						__('Records', 'band-tools')	=> 'records',
						__('Songs', 'band-tools')		=> 'songs',
						__('Player', 'band-tools')		=> 'songs',
						],
				],
				[
					'param_name'	=> 'title',
					'heading' 		=> __( 'Block Title', 'band-tools' ),
					'type'				=> 'textfield',
					'holder'			=> 'div',
				],
				[
					'param_name'	=> 'id',
					'heading' 		=> __( 'Specific Post ID', 'band-tools' ),
					'type'				=> 'textfield',
					'holder'			=> 'div',
				],
			],
		));
		vc_map(array(
			'name'				=> __('Bands', 'band-tools'),
			'base'				=> 'bt-bands',
			'description'	=> __('Show related bands', 'band-tools'),
			'category'		=> 'Band Tools',
			'icon'				=> dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-user-music-20x20-turquoise.svg',
			'params'			=> [
				[
					'param_name'	=> 'title',
					'heading' 		=> __( 'Block Title', 'band-tools' ),
					'type'				=> 'textfield',
					'holder'			=> 'div',
				],
			],
		));
		vc_map(array(
			'name'				=> __('Records', 'band-tools'),
			'base'				=> 'bt-records',
			'description'	=> __('Show related records', 'band-tools'),
			'category'		=> 'Band Tools',
			'icon'           => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-album-collection-20x20-turquoise.svg',
			'params'			=> [
				[
					'param_name'	=> 'title',
					'heading' 		=> __( 'Block Title', 'band-tools' ),
					'type'				=> 'textfield',
					'holder'			=> 'div',
				],
			],
		));
		vc_map(array(
			'name'				=> __('Songs', 'band-tools'),
			'base'				=> 'bt-songs',
			'description'	=> __('Show related songs', 'band-tools'),
			'category'		=> 'Band Tools',
			'icon'           => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-comment-music-20x20-turquoise.svg',
			'params'			=> [
				[
					'param_name'	=> 'title',
					'heading' 		=> __( 'Block Title', 'band-tools' ),
					'type'				=> 'textfield',
					'holder'			=> 'div',
				],
			],
		));
		vc_map(array(
			'name'				=> __('Player', 'band-tools'),
			'base'				=> 'bt-player',
			'description'	=> __('Player for songs or albums', 'band-tools'),
			'category'		=> 'Band Tools',
			'icon'           => dirname(plugin_dir_url( __FILE__ )) . '/assets/svg-player-20x20-turquoise.svg',
			'params'			=> [
				[
					'param_name'	=> 'title',
					'heading' 		=> __( 'Block Title', 'band-tools' ),
					'type'				=> 'textfield',
					'holder'			=> 'div',
				],
			],
		));
	}
}
add_action('init', 'bndtls_shortcodes_init');
