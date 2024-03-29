<?php
/**
 * Shortcodes
 *
 * @package	band-tools
 */

//
function custom_add_to_cart_on_page() {
    global $post;

    // Check if WooCommerce is active
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

        $product_id = get_post_meta($post->ID, 'record_product', true);

        if (!empty($product_id)) {
            // $product = wc_get_product($product_id);
            $product = new WC_Product($product_id);

            if ($product) {
                ob_start();

                // Set up necessary global variables for the template
                $original_post = $post;
                $post = get_post($product_id);
                setup_postdata($post);

                // Retrieve and display the price
                $price = $product->get_price();
                $price_html = $product->get_price_html();
                echo empty($price) ? '' : '<p class=price>' . $price_html . '</p>';

                // Display the add to cart button and related elements
                woocommerce_template_single_add_to_cart();

                $output = ob_get_clean();

                // Restore the original post
                $post = $original_post;
                setup_postdata($post);
                $output = empty($output) ? '' : '<div class="product bndtls">' . $output . '</div>';
                return $output;
            } else {
                return; // 'Product not found.';
            }
        } else {
            return; // 'Product ID not found.';
        }
    } else {
        return; // 'WooCommerce plugin is not active.';
    }
}
add_shortcode('display_add_to_cart', 'custom_add_to_cart_on_page');

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
		/*
		 * TODO: allow passed parameters from shortcode
		 */
		$show_record_addtocart = bndtls_get_option('layout_record_default:addtocart');
		$show_record_poster = bndtls_get_option('layout_record_default:poster');
		$show_record_title = bndtls_get_option('layout_record_default:title');
		$show_record_band = bndtls_get_option('layout_record_default:band');
		$show_record_info = bndtls_get_option('layout_record_default:info');
		$show_record_tracks = bndtls_get_option('layout_record_default:tracks');
		// $show_record_player = bndtls_get_option('layout_record_default:player');

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

				// $output = ;

				// $output = (($show_record_poster) ? get_the_post_thumbnail($post) : '' )
				$output .= (($show_record_addtocart) ? custom_add_to_cart_on_page() : '' )
				. (($show_record_poster) ? sprintf('<a href="%s">%s</a>', get_permalink($post), get_the_post_thumbnail($post) ) : '' )
				. (($show_record_title) ? sprintf('<h4><a href="%s">%s</a></h4>', get_permalink($post), get_the_title($post)) : '' )
				. (($show_record_band) ? bndtls_get_relations($post, [ 'bands' ], [ 'direction' => 'from', 'mode' => 'inline' ] ) : '' )
				. (($show_record_info) ? bndtls_get_meta( [ 'release_type', 'release', 'tax_genres' ], $post->ID ) : '' )
				. (($show_record_tracks) ? bndtls_get_relations($post, [ 'songs' ], [ 'mode' => 'ol' ] ) : '' );
				break;

				case 'songs':
				$output =
				bndtls_get_relations($post, [ 'records', 'songs' ], [ 'direction' => 'to', 'mode' => 'inline' ] );
				// bndtls_get_relations($post, [ 'bands' ], [ 'direction' => 'to', 'mode' => 'inline' ] )
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
