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
function bndtls_the_content ( $content ) {
  global $template;
  if(function_exists('wc_print_notices')) wc_print_notices();
  $plugindir = dirname( __DIR__ );
  $post_type_slug=get_post_type();
  $template_slug=str_replace('.php', '', basename($template));
  $custom_slug = "content-$template_slug-$post_type_slug";
  $custom = "$plugindir/templates/$custom_slug.php";
  if(file_exists($custom)) {
    ob_start();
    include $custom;
    $custom_content = ob_get_clean();
    $content = "<div class='" . BNDTLS_SLUG . " content $template_slug $post_type_slug'>$custom_content</div>";
  }
  return $content;
}

### Interesting 1
add_filter('the_title', 'bndtls_add_after_title', 10, 2);
function bndtls_add_after_title($title, $post_ID) {
  if ( is_single() && is_main_query() && ! is_admin() && ! is_null( $post_ID ) ) {
    if(bndtls_backtrace_match('breadcrumb')) return $title;

    $post = get_post( $post_ID );
    $title_after = '';
    if ( $post instanceof WP_Post ) {
      switch($post->post_type) {
        case 'bands':
        $title_after .= (bndtls_get_option('layout_page_title:genre')) ? bndtls_get_meta([ 'tax_genres' ], $post_ID) : '';
        $title_after .= (bndtls_get_option('layout_page_title:band_members')) ? bndtls_get_meta([ 'members' ], $post_ID) : '';
        if(bndtls_get_option('layout_page_title:official_website')) {
          $url = rwmb_meta( 'official_website', array(), $post_ID );
          if($url) {
            $links[] = sprintf("<li class=link><a href='%s'>%s</a></li>", $url, __('Official Website', 'band-tools'));
          }
        }
        if(bndtls_get_option('layout_page_title:official_store')) {
          $url = rwmb_meta( 'official_store', array(), $post_ID );
          if($url) {
            $links[] = sprintf("<li class=link><a href='%s'>%s</a></li>", $url, __('Official Store', 'band-tools'));
          }
        }
        if(!empty($links)) $title_after .= "<ul class=links>" . join(' ', $links) . "</ul>";
        break;

        case 'records':
        case 'songs':
        if(bndtls_get_option('layout_page_title:band')) {
          if($band_ID = rwmb_meta( 'band', array(), $post_ID )) {
            $band = get_post($band_ID);
            // echo "<pre>"; print_r($band); die;
            $title_after .= sprintf(__('by <a href="%s">%s</a>', 'band-tools'), get_permalink($band), $band->post_title);
          }
        }

        $title_after .= (bndtls_get_option('layout_page_title:release_type')) ? bndtls_get_meta([ 'release_type' ], $post_ID) : '';
        $title_after .= (bndtls_get_option('layout_page_title:release')) ? bndtls_get_meta([ 'release' ], $post_ID, [ 'before' => '&#x2117;' ]) : '';
        $title_after .= (bndtls_get_option('layout_page_title:authors')) ? bndtls_get_meta([ 'authors' ], $post_ID, [ 'before' => '&#169;' ] ) : '';
        $title_after .= (bndtls_get_option('layout_page_title:genre')) ? bndtls_get_meta([ 'tax_genres' ], $post_ID) : '';
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
