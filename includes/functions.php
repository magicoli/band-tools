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
    if(isset($settings[$option]) && is_array($settings[$option]) &! empty ($settings[$option][$sub_option]))
    return $settings[$option][$sub_option];
    else
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

  $show_title = ( isset($args[ 'show_title' ]) ) ? $args[ 'show_title' ] : true;

  $post_type_obj = get_post_type_object( $child->post_type );
  $label = $post_type_obj->labels->singular_name;
  $label_read = __( bndtls_get_option( 'naming_actions:details', 'Details' ), 'band-tools' );
  $label_play = __( bndtls_get_option( 'naming_actions:play', 'Play' ), 'band-tools' );
  $label_buy = __( bndtls_get_option( 'naming_actions:buy', 'Buy' ), 'band-tools' );

  $before = $args['before'];
  $after = $args['after'];
  if(empty($before)) {
    $before = "<span>";
    $after .= "</span>";
  }

  if(get_queried_object_id() == $child->ID) {
    $li_classes[]='current-page';
  } else {
    unset($current_page);
    $before = "$before<a href='" . get_permalink($child) . "'>";
    $after  = "</a>$after";
  }

  if($child->post_type == 'records') {
    $show_record_poster = bndtls_get_option('layout_record_default:poster');
    $show_record_title = bndtls_get_option('layout_record_default:title');
    $show_record_band = bndtls_get_option('layout_record_default:band');
    $show_record_info = bndtls_get_option('layout_record_default:info');
    $show_record_tracks = bndtls_get_option('layout_record_default:tracks');

    $title = (($show_record_title) ? $before . $child->post_title . $after : $before . $after );
    $before_title = (($show_record_poster) ? sprintf('<a href="%s">%s</a>', get_permalink($child), get_the_post_thumbnail($child) ) : '' );
    $after_title = (($show_record_band) && get_post_type() != 'bands' ? bndtls_get_relations($child, [ 'bands' ], [ 'direction' => 'from', 'mode' => 'inline' ] ) : '' )
    . (($show_record_info) ? bndtls_get_meta( [ 'release_type', 'release', 'tax_genres' ], $child->ID ) : '' );
  } else {
    $title = $before . $child->post_title . $after;
  }

  $actions=array();

  if(bndtls_get_option('layout_record_default:player')) {
    if(!empty($args['track_nr'])) {
      $actions[] = sprintf(
        '<a class="playlist-track action play play-song small-toggle-btn small-play-btn" href="#" data-play-track=%1$d data-play-list=%2$d>%3$s</a>',
        $args['track_nr'], $args['playlist'], $label_play
      );
    }
  }

  if(is_woocommerce_active()) {
    $product_id = rwmb_meta( 'record_product', array(), $child->ID );
    $playlist_product_id = rwmb_meta( 'record_product', array(), $args['playlist'] );
    if(empty($product_id)) $product_id = $child->track_product;

    if (!empty($product_id) && get_post_status($product_id) ==  'publish' ) {
      $link_classes=array("action" );
      if(is_in_cart($product_id) || is_in_cart($playlist_product_id)) {
        $link_url = wc_get_cart_url();
        $link_text = __("View cart", "band-tools");
        $link_classes[] = "added";
        if (is_in_cart($playlist_product_id)) $link_classes[] = "included";
      } else if($product_id == $playlist_product_id){
        $link_url = '#';
        $link_text = '';
        $link_classes[] = "record_$playlist_product_id";
      } else {
        wp_enqueue_script( 'woocommerce-ajax-add-to-cart-js', plugin_dir_url(__FILE__) . 'js/woocommerce-ajax-add-to-cart.js', array(), BNDTLS_VERSION . "-" . time() );
        $link_url = do_shortcode( '[add_to_cart_url id='.$product_id.']');
        $link_text = $label_buy;
        $link_classes = array_merge($link_classes, [ "add_to_cart_button", "ajax_add_to_cart", "record_$playlist_product_id" ]);
        $link_data = 'data-quantity="1" data-product_id="' . $product_id . '" data-product_sku=""';
      }
      $actions[] = "<a id='buy-" . $product_id . "' class='" . join(' ', $link_classes) . "' href='" . $link_url . "' " . $link_data . ">" . $link_text . "</a>";
    }
  }

  if(!empty($actions)) {
    if( bndtls_get_option( 'naming_actions:show_details_link' ) ) {
      $readlink = sprintf( "<a class='action read' href='%s'>%s</a>", get_permalink($child), $label_read );
      $actions = array_merge([ $readlink ], $actions);
    }
    $title .= " <span class='actions child-actions'>";
    $title .= join(' ', $actions);
    $title .= "</span>";
  }
  // }
  return "$before_title<div class=child-title>$title</div>$after_title";
}

function bndtls_get_childs($post, $slug = '', $args = array() ) {
  if(!is_object($post)) return; // Should never happen
  switch ($post->post_type) {
    case 'bands':
      $lgth = strlen($post->ID);
      $query_args = array(
        'post_type' => 'records',
        'orderby'          => 'post_date',
        'order'            => 'DESC',
      );
      $meta_query = new WP_Query( $query_args );
      $records = $meta_query->posts;
      $childs = $records;
      break;

    case 'songs':
      $lgth = strlen($post->ID);
      $query_args = array(
        'post_type' => 'records',
        'orderby'          => 'post_date',
        'order'            => 'DESC',
      );
      $meta_query = new WP_Query( $query_args );
      $records = $meta_query->posts;
      foreach($records as $record) {
        $tracks = array_shift(get_post_meta($record->ID, 'tracks'));
        foreach($tracks as $track_key => $track) {
          if($track['track_song'] == $post->ID) {
            // $record = get_post($track_key);
            $childs[] = $record;
          }

        }
      }
      break;

    case 'records':
      switch($slug) {
        case 'bands':
          $result=get_post_meta($post->ID, 'band', true);
          return array(get_post($result));
          break;

        case 'songs':
          $tracks = array_shift(get_post_meta($post->ID, 'tracks'));
          $i=0;
          if(is_array($tracks)) {
            foreach($tracks as $track) {
              if(!is_array($track)) continue;
              $i++;
              $child=$track;
              $song = get_post($track['track_song']);
              $song->track_audio_sample_url = $track['track_audio_sample_url'];
              $song->track_product = $track['track_product'];
              $childs[] = $song;
            }
          }
          break;
      }
      break;

    default:
      // We only make specific queries here, so return empty if not defined
      return;
  }

  return $childs;
}

function bndtls_get_relations($post, $slugs = array(), $args = array() ) {
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
  if(!is_object($post)) return "not a post"; // Should never happen
  if(is_array($slugs)) {
    $childs_slug = array_shift($slugs);
    // $childs_slug = array_values($slugs)[0];
    $grand_child_slug = $slugs;
    // $grand_child_args = $args;
    $grand_child_args['level']=$l + 1;
    $grand_child_args['title']='';
  } else {
    $childs_slug = $slugs;
  }
  if($childs_slug == 'records') {

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
  // return "<p>$rel<br>$rel_slug<br>$childs_slug</p>";

  $childs = bndtls_get_childs($post, $childs_slug, $args);
  if(empty($childs)) return;

  $output .= "<div class='$rel'>";
  $output .= $block_before;
  if($title) $output.="<h$l>$title</h$l>";
  // $output .= "[mb_relationships id='rel-$rel' direction='$direction' mode='ul']";
  $child_slug=preg_replace('/s$/', '', $childs_slug);

  $show_record_poster = bndtls_get_option('layout_record_default:poster');
  $show_record_title = bndtls_get_option('layout_record_default:title');

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
      // if($child_slug == 'record') {
      //   $child_args['before'] .= (($show_record_poster) ? get_the_post_thumbnail($child) : '' );
      //   $child_args['show_title'] = $show_record_title;
      // } else {
      //   $child_args['before'] .= "$child_slug ";
      // }
    }

    if(!empty($child->track_audio_sample_url)) {
      $t++;
      $child_args['track_nr'] = $t;
      $child_args['track_url'] = $child->track_audio_sample_url;
      $child_args['playlist'] = $post->ID;
      $tracks[] = array(
        'nr' => $t,
        'url' => $child->track_audio_sample_url,
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
    if(bndtls_get_option('layout_record_default:player')) {
      wp_enqueue_style( 'audioplayer-css', plugin_dir_url(__FILE__) . 'css/audioplayer.css', array(), BNDTLS_VERSION . "-" . time() );
      wp_enqueue_script( 'audioplayer-js', plugin_dir_url(__FILE__) . 'js/audioplayer.js', array(), BNDTLS_VERSION . "-" . time() );
      $output .= '<figure class=audioplayer>';
      $output .= sprintf('<audio id="audio-%d" controls=controls preload=auto>', $post->ID);
      foreach($tracks as $track) {
        $output .= '<source title="Hello" src="' . $track['url'] . '" data-track-number="' . $track['nr'] . '" />';
      }
      $output .= 'Your browser does not support HTML5 audio.</audio>';
      ob_start();
      include "audioplayer-controls.php";
      $output .= ob_get_clean();
      $output .= "<figcaption></figcaption>";
      $output .= "</figure>";
    }
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

function bndtls_date_format($format, $date_string) {
  $dateTime = DateTime::createFromFormat("Y-m-d", $date_string );
  if($dateTime) return $dateTime->format($format);
  return false;
}

function bndtls_get_meta($metas, $post_id = NULL, $args = array() ) {
  if(empty($metas)) return;
  $output = '';
  $post = get_post($post_id);
  if(!$post) return;

  if(is_array($args)) {
    $link = (isset($args['link'])) ? $args['link'] : false;
    $before = (isset($args['before'])) ? $args['before'] : false;
    $after = (isset($args['before'])) ? $args['after'] : false;
  }
  if(!$post_id) $post_id = get_post()->ID;
  if(!is_array($metas)) $metas = [ $meta ];
  $values = array();
  $strings = array();
  foreach ( $metas as $meta ) {
    if(is_array($meta)) continue; // should not happen
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
      $values[] = bndtls_date_format('Y', rwmb_meta( $meta, array(), $post_id ) );
      break;

      default:
      $values[] = rwmb_meta( $meta, array(), $post_id );
    }

  }
  if(empty($values)) return;
  if(!is_array($values)) $values = [ $values ];
  $values = array_filter($values);
  foreach ($values as $value) {
    if(is_object($value)) {
      $value = $value->name;
    } else if (is_array($value)) {
      $value = join(" ", $value);
    }
    $strings[] = $value;
  }
  $strings = join(', ', $strings);
  if(!empty($values)) $output .= "<div class='$meta'>$before $strings $after</div>";
  return $output;
}

if (!function_exists('is_woocommerce_active')) {
  function is_woocommerce_active() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    return is_plugin_active( 'woocommerce/woocommerce.php');
  }
}

function is_in_cart($product_id) {
  global $woocommerce;
  if($woocommerce->cart) {
    foreach($woocommerce->cart->get_cart() as $key => $val ) {
      $_product = $val['data'];

      if($product_id == $_product->id ) {
        return true;
      }
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
