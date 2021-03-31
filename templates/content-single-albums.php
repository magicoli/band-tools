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
// $albums = MB_Relationships_API::get_connected( [
//     'id'   => 'rel-band-album',
//     'from' => get_the_ID(),
// ] );
// $songs = MB_Relationships_API::get_connected( [
//     'id'   => 'rel-band-song',
//     'from' => get_the_ID(),
// ] );
?>
<?= build_relationship(get_post(), [ 'bands' ], [ 'direction' => 'to', 'mode' => 'inline' ] ) ?>
<div class='<?=$post_type_slug?>-content'>
  <?=$content?>
</div>
<?= build_relationship(get_post(), [ 'songs' ], [ 'mode' => 'ol' ] ) ?>
