<?php if ( ! defined( 'WPINC' ) ) die;

add_action( 'template_include', 'bndtls_template_include' );
function bndtls_template_include( $template ) {
  $plugindir = dirname( __DIR__ );
  $template_slug=str_replace('.php', '', basename($template));
  $post_type_slug=get_post_type();
  $custom = "$plugindir/templates/$template_slug-$post_type_slug.php";
  if(file_exists($custom)) return $custom;
  return $template;
}

add_filter( 'the_content', 'bndtls_the_content');
function bndtls_the_content ( $more_link_text = null, $strip_teaser = false ) {
  global $template;
  $plugindir = dirname( __DIR__ );
  $post_type_slug=get_post_type();
  $template_slug=str_replace('.php', '', basename($template));
  $custom_slug = "content-$template_slug-$post_type_slug";
  $custom = "$plugindir/templates/$custom_slug.php";
  if(file_exists($custom)) {
    // $content=include $custom;
    ob_start();
    include $custom;
    $custom_content = ob_get_clean();
    $content = "<div class='" . BNDTLS_SLUG . " content $template_slug $post_type_slug'>$custom_content</div>";
    // ## Uncomment below to allow html in archive content
    // # (probably a bad idea)
    // if($template_slug == "archive") {
    //   echo $content;
    //   return;
    // }
    // ##
  } else {
    $content = get_the_content( $more_link_text, $strip_teaser );
  }
  return $content;
}

### Interesting 1
add_filter('the_title', 'bndtls_add_after_title', 10, 2);
function bndtls_add_after_title($title, $post_id) {
  if ( ! is_admin() && ! is_null( $post_id ) ) {
    $post = get_post( $post_id );
    if ( $post instanceof WP_Post ) {
      switch($post->post_type) {
        case 'bands':
        $title_after =
        bndtls_get_meta([ 'tax_genres', 'members' ], $post_id)
        . bndtls_get_meta('members', $post_id);;
        break;

        case 'albums':
        $title_after =
        bndtls_get_relations($post, 'bands', [ 'direction' => 'to', 'title' => '', 'before' => __('by', 'band-tools') ] )
        . bndtls_get_meta([ 'release' ], $post_id )
        . bndtls_get_meta([ 'tax_genres' ], $post_id);
        break;

        case 'songs':
        $title_after =
        bndtls_get_relations($post, 'bands', [ 'direction' => 'to', 'title' => '', 'before' => __('by', 'band-tools') ] )
        . bndtls_get_meta([ 'tax_genres' ], $post_id);
        break;
      }
    }
    // if ( is_single() )
    // if (is_singular(array('bands')))
    // $title= $title . "</h1>-after<h1>";
  }
  $title_before = (!empty($title_before)) ? "</h1><div class='surtitle'>$title_before</div>" : '';
  $title_after = (!empty($title_after)) ? "</h1><div class='subtitle'>$title_after</div>" : '';
  return $title_before . $title . $title_after;
}

// this filter fires just before the nav menu item creation process
add_filter( 'pre_wp_nav_menu', 'bndtls_remove_title_filter_nav_menu', 10, 2 );
function bndtls_remove_title_filter_nav_menu( $nav_menu, $args ) {
    // we are working with menu, so remove the title filter
    remove_filter( 'the_title', 'bndtls_add_after_title', 10, 2 );
    return $nav_menu;
}

// this filter fires after nav menu item creation is done
add_filter( 'wp_nav_menu_items', 'bndtls_add_title_filter_non_menu', 10, 2 );
function bndtls_add_title_filter_non_menu( $items, $args ) {
    // we are done working with menu, so add the title filter back
    add_filter( 'the_title', 'bndtls_add_after_title', 10, 2 );
    return $items;
}
### /Interesting 1
