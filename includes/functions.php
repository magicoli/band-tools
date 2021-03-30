<?php if ( ! defined( 'WPINC' ) ) die;

function bndtls_get_option( $option, $default = false, $sub_option='' ) {
  $options=get_option('bndtls-settings');
  if ( $sub_option && $options[$option][$sub_option] ) return $options[$option][$sub_option];
  else if ( $options[$option] ) return $options[$option];
  else return $default;
}

function bndtls_license_key($string = '') {
  return get_option('license_key_band-tools');
}

function build_relationship($post, $slugs, $title=NULL, $class=NULL) {
  if(!is_object($post)) return "not a post";
  if(is_array($slugs)) {
    $child_slug = array_shift($slugs);
    $grand_child_slug = $slugs;
  } else {
    $child_slug = $slugs;
  }
  $parent_slug = $post->post_type;
  $rel="$parent_slug-$child_slug";
  $childs = MB_Relationships_API::get_connected( [
      'id'   => "rel-$rel",
      'from' => $post->ID,
  ] );
  if(empty($childs)) return;

  if($title) $output.="<h3>$title</h3>";
  $output .= "<div class='$rel'>";
  $output .= "<ul class='$rel list'>";
  foreach($childs as $child) {
    $output .= "<li class=" . $child->post_type . ">";
    $output .= "<a href='" . get_permalink($child) . "'>";
    $output .= $child->post_title;
    $output .= "</a>";
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
