<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */
$content = get_the_content( $more_link_text, $strip_teaser );

$content_after = '';
if(bndtls_get_option('layout_page_content:albums_songs')) {
  $content_after .= bndtls_get_relations(get_post(), [ 'albums', 'songs' ] );
} else if(bndtls_get_option('layout_page_content:albums')) {
  $content_after .= bndtls_get_relations(get_post(), [ 'albums' ] );
}

?>
<div class='<?=$post_type_slug?>-content'>
  <?=$content?>
</div>
<?= $content_after ?>
