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

$content_after = '';
if(bndtls_get_option('layout_page_content:records_songs')) {
  $content_after .= bndtls_get_relations(get_post(), [ 'records', 'songs' ] );
} else if(bndtls_get_option('layout_page_content:records')) {
  $content_after .= bndtls_get_relations(get_post(), [ 'records' ] );
}

?>
<div class='<?=$post_type_slug?>-content'>
  <?=$content?>
</div>
<?= $content_after ?>
