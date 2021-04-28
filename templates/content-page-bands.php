<?php
/**
 * Single band show, but when it's the front page
 * Nearly the same except other record view
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */
// $content = get_the_content( $more_link_text, $strip_teaser );
// $records = MB_Relationships_API::get_connected( [
//     'id'   => 'rel-band-record',
//     'from' => get_the_ID(),
// ] );
// $songs = MB_Relationships_API::get_connected( [
//     'id'   => 'rel-band-song',
//     'from' => get_the_ID(),
// ] );
?>
<div class='<?=$post_type_slug?>-content'>
  <?=$content?>
</div>
<?php
if(bndtls_get_option('frontpage_full_content')) :
  echo bndtls_get_relations(get_post(), [ 'records' ] );
endif;
