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

function bndtls_license_key($string = '') {
  return get_option('license_key_band-tools');
}

function build_relationship($post, $slugs, $args = array() ) {
  if(is_array($args)) {
    if($args['title']) $title=$args['title'];
    if($args['class']) $class=$args['class'];
    if($args['parent']) $parent=$args['parent'];
  }

  if(!is_object($post)) return "not a post";
  if(is_array($slugs)) {
    $child_slug = array_shift($slugs);
    $grand_child_slug = $slugs;
  } else {
    $child_slug = $slugs;
  }
  $parent_slug = $post->post_type;
  if($parent) {
    $parent=$args['parent'];
    $rel="$child_slug-$parent_slug";
    $direction="to";
  } else {
    $rel="$parent_slug-$child_slug";
    $direction="from";
  }
  if($parent) $rel_slug="rel-$child_slug-$parent_slug";
  else $rel_slug="rel-$rel";
  $childs = MB_Relationships_API::get_connected( [
      'id'   => "rel-$rel",
      $direction => $post->ID,
  ] );
  if(empty($childs)) return "<p>rel-$rel $direction empty</p>";

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

  if($title) $output.="<h3>$title</h3>";
  $output .= "<div class='$rel'>";
  $output .= "<ul class='$rel list'>";
  foreach($childs as $child) {
    $li_classes=array($child->post_type);
    if(get_queried_object_id() == $child->ID) {
      $li_classes[]='current-page';
      $before = "<span>";
      $after  = "</span>";
    } else {
      unset($current_page);
      $before = "<a href='" . get_permalink($child) . "'>";
      $after  = "</a>";
    }
    $output .= "<li class='" . join(' ', $li_classes) . "'>";
    $output .= $before . $child->post_title . $after;
    if(!empty($grand_child_slug)) {
      $output .= build_relationship($child, $grand_child_slug );
    }
    //
    // $output .= "<p>Link: " . get_permalink($child) . "</p>";
    // $output .= "<pre>" . print_r($child, true) . "</pre>";
    $output .= '</li>';
  }
  $output .= '</ul>';
  $output .= "</div>";
  return $output;
}
