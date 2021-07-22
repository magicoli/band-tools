<?php if ( ! defined( 'WPINC' ) ) die;

function bndtls_get_option( $param, $default = false, $sub_option='' ) {
  $explode=explode(':',$param);
  $option=$explode[0];
  isset($explode[1]) && $sub_option = $explode['1'];
  $settings=get_option('bndtls-settings');
  if ( ! $settings ) return $default;
  if ( $sub_option ) {
    if(isset($settings[$option])) {
      if (is_array($settings[$option]) && in_array($sub_option, $settings[$option]))
      return true;
    }
    if(isset($settings[$option]) && is_array($settings[$option]) &! empty ($settings[$option]))
    return $settings[$option][$sub_option];

    return $default;
  }
  else if ( $settings[$option] ) return $settings[$option];
  else return $default;
}

function get_type_name_n($type, $default, $default_plural=NULL, $count=NULL) {
  if( ! $default_plural ) $default_plural = $default;
  if( ! $count ) $count = bndtls_count_posts($type);

  if($count == 1)
  return __(bndtls_get_option( 'naming_' . $type, "$default", 'singular' ), 'band-tools');

  return __(bndtls_get_option( 'naming_' . $type, "$default_plural", 'plural' ), 'band-tools');

  return "$name ($count)";
}

function bndtls_license_key($string = '') {
  return get_option('license_key_band-tools');
}

function child_title($child, $args = array()) {
  if(empty($child)) return;
  $post_type_obj = get_post_type_object( $child->post_type );
  $label = $post_type_obj->labels->singular_name; //Ice Cream.
  // $label_play = ($post_type_obj->labels->play_item) ? $post_type_obj->labels->play_item : __('Play', 'band-tools');
  // $label_buy = ($post_type_obj->labels->buy_item) ? $post_type_obj->labels->buy_item : __('Buy', 'band-tools');
  $label_read = __('Read', 'band-tools');
  $label_play = __('Play', 'band-tools');
  $label_buy = __('Buy', 'band-tools');

  $before = $args['before'];
  $after = $args['after'];
  if(empty($before)) {
    $before = "<span>";
    $after .= "</span>";
  }

  if(get_queried_object_id() == $child->ID) {
    $li_classes[]='current-page';
    // $before = $args['before'] . "<span>";
    // $after  = "</span>";
  } else {
    unset($current_page);
    $before = "$before<a href='" . get_permalink($child) . "'>";
    $after  = "</a>$after";
  }
  $title = $before . $child->post_title . $after;

  // if($child->post_type == 'songs') {
    $actions=array();
    // $sample = rwmb_meta( 'audio_sample', array(), $child->ID );
    if(!empty($args['track_nr'])) {
      // $actions[] = '<span class="small-toggle-btn"><i class="small-play-btn"><span class="screen-reader-text">Small toggle button</span></i></span>'
      $actions[] =       sprintf(
              '<a class="playlist-track action play play-song small-toggle-btn small-play-btn" href="#" data-play-track=%1$d data-play-list=%2$d>%3$s</a>',
              $args['track_nr'], $args['playlist'], $label_play
            );
 // "<a class='playlist-track action play play-song small-toggle-btn small-play-btn' href='#' data-play-track='" . $args['track_nr'] . "'>$label_play</a>";
    }

    $child_products = MB_Relationships_API::get_connected( [
      'id'   => "rel-$child->post_type-products",
      'from' => $child->ID,
      ]
    );
    if(!empty($child_products)) {
      $product_count=count($child_products);
      // if($product_count > 1) echo $child->ID . "<pre>"; print_r($child_products); echo "</pre>";
      $product = $child_products[0];
      if(woo_in_cart($product->ID)) {
          $actions[] = "<a class='action added buy buy-song' href='" . wc_get_cart_url() . "'>" . __("View cart", "band-tools") . "</a>";
      } else {
        $actions[] = "<a class='action buy buy-song' href='" . do_shortcode( '[add_to_cart_url id='.$product->ID.']' ) . "'>$label_buy</a>";
      }
    }
    if(!empty($actions)) {
      $title .= " <span class='actions child-actions'>";
      $title .= join(' ', $actions);
      $title .= "</span>";
    }
  // }
  return "<div class=child-title>$title</div>";
}

function bndtls_get_relations($post, $slugs, $args = array() ) {
  $output='';
  $block_before='';
  $block_after='';
  if(is_array($args)) {
    if(isset($args['parent'])) $parent=$args['parent'];
    if(isset($args['title'])) $title=$args['title'];
    if(isset($args['class'])) $class=$args['class'];
    if(isset($args['before'])) $block_before=$args['before'];
    if(isset($args['after'])) $block_after=$args['after'];
    if(isset($args['direction'])) $direction=$args['direction'];
    else $direction='from';
    if(isset($args['level'])) $l=$args['level'];
    else $l='4';
  }
  if(!is_object($post)) return "not a post";
  if(is_array($slugs)) {
    $childs_slug = array_shift($slugs);
    $grand_child_slug = $slugs;
    // $grand_child_args = $args;
    $grand_child_args['level']=$l + 1;
    $grand_child_args['title']='';
  } else {
    $childs_slug = $slugs;
  }
  $parent_slug = $post->post_type;
  if($direction == 'to') {
    // if(isset($args['parent'])) $parent=$args['parent'];
    $rel="$childs_slug-$parent_slug";
  } else {
    $rel="$parent_slug-$childs_slug";
  }
  if(isset($parent)) $rel_slug="rel-$childs_slug-$parent_slug";
  else $rel_slug="rel-$rel";
  $childs = MB_Relationships_API::get_connected( [
      'id'   => "rel-$rel",
      $direction => $post->ID,
  ] );
  if(empty($childs)) return;

  if(! isset($args['title'])) {
    $relation = MB_Relationships_API::get_relationship( "rel-$rel" );
    if(count($childs)==1)
    $title=$relation->$direction['meta_box']['singular'];
    else
    $title = $relation->$direction['meta_box']['title'];
  }

  $output .= "<div class='$rel'>";
  $output .= $block_before;
  if($title) $output.="<h$l>$title</h$l>";
  // $output .= "[mb_relationships id='rel-$rel' direction='$direction' mode='ul']";
  $child_slug=preg_replace('/s$/', '', $childs_slug);
  $t = 0;
  foreach($childs as $child) {
    $child_args=array();
    $li_classes=array("child-$child_slug", $child->post_type);
    if(get_queried_object_id() == $child->ID) {
      $li_classes[]='current-page';
    }
    if(!empty($grand_child_slug)) {
      $child_args = array(
        'before' => "<h" . ($l + 1) . ">",
        'after' => "</h" . ($l + 1) . ">",
        'parent' => 'p' . print_r($args['parent'], true),
      );
    }
    $samples = rwmb_meta( 'audio_sample', array(), $child->ID );
    // $samples = array();
    if(!empty($samples)) {
      $sample = array_shift($samples);
      $t++;
      $sample_url = wp_get_attachment_url($sample['url']);
      // str_replace(
      //   wp_normalize_path( untrailingslashit( ABSPATH ) ),
      //   site_url(),
      //   wp_normalize_path( $sample['path'] )
      // );
      $child_args['track_nr'] = $t;
      $child_args['track_url'] = $sample_url;
      $child_args['playlist'] = $post->ID;
      // echo "<pre>" . $child->post_title . "\n" . $sample_url . "\n" . print_r($sample, true) . "</pre>"; die();
      $tracks[] = array(
        'nr' => $t,
        'url' => $sample_url,
        'name' => $child->post_title,
      );
      $li_classes[] .= 'playlist-row classtest';
    }

    $output_childs .= "<li class='" . join(' ', $li_classes) . "'>";
    $output_childs .= child_title($child, $child_args);

    if(!empty($grand_child_slug)) {
      $output_childs .= bndtls_get_relations($child, $grand_child_slug, [ 'title' => '', 'parent_id' => $post->ID ] );
    }
    $output_childs .= '</li>';
  }
  $output_childs .= '</ul>';
  if(!empty($tracks)) {
    $output_childs = "<ul id='playlist-$post->ID' class='childs $rel childs-$childs_slug list playlist'>$output_childs";
    wp_enqueue_style( 'audioplayer-js', plugin_dir_url(__FILE__) . 'css/audioplayer.css', array(), BNDTLS_VERSION . "-" . time() );
    wp_enqueue_script( 'audioplayer-css', plugin_dir_url(__FILE__) . 'js/audioplayer.js', array(), BNDTLS_VERSION . "-" . time() );
    $output .= '<figure class=audioplayer>';
    $output .= sprintf('<audio id="audio-%d" controls=controls preload=auto>', $post->ID);
    foreach($tracks as $track) {
      $output .= '<source title="Hello" src="' . $track['url'] . '" data-track-number="' . $track['nr'] . '" />';
    }
    $output .= 'Your browser does not support HTML5 audio.</audio>';
    ob_start();
    include "audioplayer-controls.php";
    $output .= ob_get_clean();
    // $output .= "css " . plugin_dir_url(__FILE__) . 'css/audioplayer.css' . "</br>";
    // $output .= "js " . plugin_dir_url(__FILE__) . 'js/audioplayer.js' . "</br>";
    // $output .= "playlist " . count($tracks);
    // add_action( 'wp_enqueue_scripts', function() {
    // } );
    $output .= "<figcaption></figcaption>";
    $output .= "</figure>";
  } else {
    $output_childs = "<ul class='childs $rel childs-$childs_slug list'>$output_childs";
  }
  $output .= $output_childs . $block_after;
  $output .= "</div>";
  return $output;
}

function bndtls_count_posts( $type = 'post', $perm = '', $status='publish' ) {
	return (isset(wp_count_posts($type)->$status)) ? wp_count_posts($type)->$status : 0;
}

// function bndtls_genres_names($genre_ids, $separator = ', ') {
//   if(empty($genre_ids)) return;
//   $bndtls_id3_genres=bndtls_id3_genres();
//
//   if(!is_array($genre_ids)) $genre_ids = [ $genre_ids ];
//   // $genres = array_fill_keys($genre_ids, $bndtls_id3_genres);
//   $genres = array_intersect_key($bndtls_id3_genres, array_flip($genre_ids));
//
//   if($separator) return join($separator, $genres);
//   return $genres;
// }

function bndtls_date_format($format, $date_string) {
  $dateTime = DateTime::createFromFormat("Y-m-d", $date_string );
  if($dateTime) return $dateTime->format($format);
  return false;
}

function bndtls_get_meta($metas, $post_id = NULL, $args = array() ) {
  if(empty($metas)) return;
  $output = '';

  if(is_array($args)) {
    $link = (isset($args['link'])) ? $args['link'] : false;
    $before = (isset($args['before'])) ? $args['before'] : false;
    $after = (isset($args['before'])) ? $args['after'] : false;
  }
  if(!$post_id) $post_id = get_post()->ID;
  if(!is_array($metas)) $metas = [ $meta ];
  foreach ( $metas as $meta ) {
    if(is_array($meta)) continue; // should not happen
    $values = array();
    switch($meta) {
      case 'tax_genres':
      $terms = get_the_terms( $post_id, 'genre' );
      if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
          foreach ( $terms as $term ) {
            $values[] = ($link) ? sprintf( '<a href="%s">%s</a>', get_term_link( $term ), $term->name ) : $term->name;
          }
      }
      break;

      case 'release':
      // $date = DateTime::createFromFormat("Y-m-d", );
      $values = bndtls_date_format('Y', rwmb_meta( $meta, array(), $post_id ) );
      break;

      default:
      $values = rwmb_meta( $meta, array(), $post_id );
    }

    if(empty($values)) return;
    if(!is_array($values)) $values = [ $values ];

    foreach ($values as $value) {
      if(is_object($value)) {
        $value = $value->name;
        // $value = "<pre>" . print_r($value->name, true) . "</pre>";
      }
      $strings[] = $value;
    }
    $strings = join(', ', $strings);
    if(!empty($values)) $output .= "<div class='$meta'>$before $strings $after</div>";
  }
  return $output;
}

function woo_in_cart($product_id) {
  global $woocommerce;
  foreach($woocommerce->cart->get_cart() as $key => $val ) {
    $_product = $val['data'];

    if($product_id == $_product->id ) {
      return true;
    }
  }
  return false;
}

function bndtls_admin_notice($notice, $class='info', $dismissible=true ) {
  if(empty($notice)) return;
  // $class="success";
  if($dismissible) $is_dismissible = 'is-dismissible';
  add_action( 'admin_notices', function() use ($notice, $class, $is_dismissible) {
    ?>
    <div class="notice notice-<?=$class?> <?=$is_dismissible?>">
        <p><strong><?=BNDTLS_PLUGIN_NAME?></strong>: <?php _e( $notice, 'band-tools' ); ?></p>
    </div>
    <?php
  } );
}

function bndtls_backtrace_match($needle)
{
	foreach (debug_backtrace() as $k => $v) {
		if ($k < 2) continue; // ignore self & caller
		if (preg_match("/$needle/", $v['function'])) return true;
	}
	return false;
}
