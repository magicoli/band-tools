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
