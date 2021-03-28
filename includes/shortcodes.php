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
		return $output;
	}
	add_shortcode('bndtls', 'bndtls_bndtls_shortcode');

	function bndtls_shortcode_list($atts, $content = null, $tag = '' )
	{
		$args = array(
			'before_title' => '<h3 class=bndtls-block>',
			'after_title' => '</h3>',
		);
		if(isset($atts['title'])) $args['title'] = $atts['title'];

		$output = bndtls_block_relations_list($tag, $args );

    if(!empty($output))
    return "<div class='bndtls-relations bndtls-relations-$tag'>$output</div>";
	}
	add_shortcode('bands', 'bndtls_shortcode_list');
	add_shortcode('albums', 'bndtls_shortcode_list');
	add_shortcode('songs', 'bndtls_shortcode_list');
	add_shortcode('videos', 'bndtls_shortcode_list');

}
add_action('init', 'bndtls_shortcodes_init');
