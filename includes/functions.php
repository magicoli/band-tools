<?php if ( ! defined( 'WPINC' ) ) die;

function bndtls_get_option( $option, $default = false, $sub_option='' ) {
  $options=get_option('bndtls-settings');
  if (!$options) return $default;
  if ( $sub_option ) {
    if(is_array($options[$option]) && $options[$option])
    return $options[$option][$sub_option];
    else;
    return $default;
  }
  else if ( $options[$option] ) return $options[$option];
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
  if(is_array($args)) {
    if($args['title']) $title=$args['title'];
    if($args['class']) $class=$args['class'];
    if(!empty($args['before'])) $block_before="<span class='before'>" . $args['before'] . "</span>";
    if(!empty($args['after'])) $block_after= "<span class='after'>" . $args['after'] . "</span>";
    if($args['direction']) $direction=$args['direction'];
    else $direction='from';
    if($args['level']) $l=$args['level'];
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
    $parent=$args['parent'];
    $rel="$childs_slug-$parent_slug";
  } else {
    $rel="$parent_slug-$childs_slug";
  }
  if($parent) $rel_slug="rel-$childs_slug-$parent_slug";
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

  if(is_array($args)) {
    $link = $args['link'];
    $before = $args['before'];
    $after = $args['after'];
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
    if(is_array($values)) $values = join(', ', $values);
    if(!empty($values)) $output .= "<div class='$meta'>$before $values $after</div>";
  }
  return $output;
}
