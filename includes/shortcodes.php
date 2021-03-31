<?php
/**
 * Shortcodes
 *
 * @package	band-tools
 */

/**
 * Initialize bndtls shortcodes
 * @return [type] [description]
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
		$type=preg_replace('/^bt-/', '', $tag);
		$post=get_post();
		// $post_type=$post->post_type;
		$args = array(
			'before_title' => '<h3 class=bndtls-block>',
			'after_title' => '</h3>',
		);
		if(isset($atts['title'])) $args['title'] = $atts['title'];
		if($type == "band-tools" || $type == "bndtls" || $type=="auto" ) {
			switch($post->post_type) {
				case 'bands':
				$output = build_relationship($post, [ 'albums', 'songs' ] );
				break;

				case 'albums':
				$output = build_relationship($post, [ 'bands' ], [ 'direction' => 'to', 'mode' => 'inline' ] )
				 . build_relationship($post, [ 'songs' ], [ 'mode' => 'ol' ] );
				break;

				case 'songs':
				$output = build_relationship($post, [ 'bands' ] ) . build_relationship($post, [ 'songs' ] );
				break;

				default:
				$output .= "<code>been there " . basename(__DIR__) . "/" . basename(__FILE__) . " " . __METHOD__ . "() $tag $type for $post_type</code>";
			}
		} else if($type) {
			$output .= build_relationship($post, [ $tag ], $args );
		} else {
			$output .= "no tag (should not happen, should it?)";
		}
		// $output = bndtls_block_relations_list($tag, $args );
		// $output = "<pre>" . print_r($tag, true) . "</pre>";
		// $output = build_relationship($post, [ $tag ] );

    if(!empty($output))
    return "<div class='bndtls-relations bndtls-relations-$tag'>$output</div>";
	}
	add_shortcode('bt-auto', 'bndtls_shortcode_list');
	add_shortcode('bt-bands', 'bndtls_shortcode_list');
	add_shortcode('bt-albums', 'bndtls_shortcode_list');
	add_shortcode('bt-songs', 'bndtls_shortcode_list');
	add_shortcode('band-tools', 'bndtls_shortcode_list');
	add_shortcode('bndtls', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('bands', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('albums', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('songs', 'bndtls_shortcode_list'); // deprecated, backward compatibility
	add_shortcode('videos', 'bndtls_shortcode_list'); // deprecated, backward compatibility

}
add_action('init', 'bndtls_shortcodes_init');
