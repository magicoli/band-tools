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
    if(is_array($settings[$option]) &! empty ($settings[$option]))
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

function bndtls_get_relations($post, $slugs, $args = array() ) {
  $output='';
  $block_before='';
  $block_after='';
  if(is_array($args)) {
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
    if(isset($args['parent'])) $parent=$args['parent'];
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
  $output .= "<ul class='childs $rel childs-$childs_slug list'>";
  $child_slug=preg_replace('/s$/', '', $childs_slug);
  foreach($childs as $child) {
    $li_classes=array("child-$child_slug", $child->post_type);
    if(get_queried_object_id() == $child->ID) {
      $li_classes[]='current-page';
      $before = "<span>";
      $after  = "</span>";
    } else {
      unset($current_page);
      $before = "<a href='" . get_permalink($child) . "'>";
      $after  = "</a>";
    }
    if(!empty($grand_child_slug)) {
      $before="<h" . ($l + 1) . ">$before";
      $after="</h" . ($l + 1) . ">$after";
    }
    $output .= "<li class='" . join(' ', $li_classes) . "'>";
    $output .= $before . $child->post_title . $after;
    if(!empty($grand_child_slug)) {
      $output .= bndtls_get_relations($child, $grand_child_slug, [ 'title' => '' ] );
    }
    //
    // $output .= "<p>Link: " . get_permalink($child) . "</p>";
    // $output .= "<pre>" . print_r($child, true) . "</pre>";
    $output .= '</li>';
  }
  $output .= '</ul>';
  $output .= $block_after;
  $output .= "</div>";
  return $output;

  // ## For future reference
  // $title="Boo";
  // ## Query method
  //
  // $connected = new WP_Query( [
  //     'relationship' => [
  //         'id'   => "rel-$rel",
  //         'from' => get_the_ID(), // You can pass object ID or full object
  //     ],
  //     'nopaging'     => true,
  // ] );
  // if(! $connected->have_posts() ) return;
  // while ( $connected->have_posts() ) : $connected->the_post();
  // echo "<a href='". the_permalink() . "'>". the_title() . "</a>
  // endwhile;
  // wp_reset_postdata();
  //
  // ## /QueryMethod


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
