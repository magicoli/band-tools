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

function bndtls_genres_names($genre_ids, $separator = ', ') {
  if(empty($genre_ids)) return;
  $bndtls_id3_genres=bndtls_id3_genres();

  if(!is_array($genre_ids)) $genre_ids = [ $genre_ids ];
  // $genres = array_fill_keys($genre_ids, $bndtls_id3_genres);
  $genres = array_intersect_key($bndtls_id3_genres, array_flip($genre_ids));

  if($separator) return join($separator, $genres);
  return $genres;
}

### Interesting 1
add_filter('the_title', 'bndtls_add_after_title', 10, 2);
function bndtls_add_after_title($title, $id) {
  if ( ! is_admin() && ! is_null( $id ) ) {
    $post = get_post( $id );
    if ( $post instanceof WP_Post ) {
      switch($post->post_type) {
        case 'bands':
        $genres = bndtls_genres_names(rwmb_meta( 'genre', array(), $post_id ), ', ');
        $title_after=$genres;
        break;

        case 'albums':
        $genres = bndtls_genres_names(rwmb_meta( 'genre', array(), $post_id ), ', ');
        if($genres) $genres = "<div class=genres>$genres</div>";
        $by = build_relationship($post, 'bands', [ 'direction' => 'to', 'title' => '' ]);
        if($by) $by="<div class='by'>" . sprintf(__('by %s', 'band-tools'), $by ) . "</div>";
        $title_after=$by . $genres;
        break;

        case 'songs':
        $genres = bndtls_genres_names(rwmb_meta( 'genre', array(), $post_id ), ', ');
        if($genres) $genres = "<div class=genres>$genres</div>";
        $by = build_relationship($post, 'bands', [ 'direction' => 'to', 'title' => '' ]);
        if($by) $by="<div class='by'>" . sprintf(__('by %s', 'band-tools'), $by ) . "</div>";
        $title_after=$by . $genres;
        break;
      }
    }
    // if ( is_single() )
    // if (is_singular(array('bands')))
    // $title= $title . "</h1>-after<h1>";
  }
  if(!empty($title_after)) $title_after="</h1><div class='subtitle'>$title_after</div>";
  if(!empty($title_before)) $title_before="</h1><div class='surtitle'>$title_before</div>";
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
