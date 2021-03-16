<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

function bndtls_rel_link($relid, $args=[]) {
  if(!$relid) return;
  return sprintf(
    '<a href="%s" class="acf-field %s" data-id="%s">%s</a>',
    get_permalink($relid),
    get_post_type($relid),
    $relid,
    get_the_title($relid) );
}

function bndtls_block_relations_list($type='', $args) {
  global $wp_post_types;
  $labels = $wp_post_types[$type]->labels;
  $queried_object = get_queried_object();

  $thistype=get_post_type($queried_object->ID);
  if($thistype==$type) return;

  $out=array();
  if(is_object($queried_object) && $queried_object->ID)
  {
    switch ($type) {
      case 'bands':
        if( $thistype=="songs" )
        $result=get_post_meta($queried_object->ID, 'band', true);
        else
        $result=get_post_meta($queried_object->ID, 'album_band', true);
        break;

      case 'albums':
        if( $thistype == "bands" ) {
          // $result=get_post_meta($queried_object->ID, 'album_band', true);
          $queryargs = array(
            // 'posts_per_page'   => -1,
            'post_type'        => 'albums',
            'meta_key'         => 'album_band',
            'meta_value'       => $queried_object->ID
          );
          $query = new WP_Query($queryargs);
          // echo "<pre>Albums: ";
          foreach($query->posts as $album) {
            $result[]=$album->ID;
            $albumout = ($args['before_widget']) ? $args['before_widget'] : '<div class="bnttls list flex">';

            // $albumout .= ($args['before_title']) ? $args['before_title'] : "<h3>";
            $albumout .= "<ul class=album><li><h5>";
            $albumout .= bndtls_rel_link($album->ID);
            $albumout .= "</h5>";
            // $albumout .= ($args['before_title']) ? $args['after_title'] : "</h3>";

            $albumout .= "<ul>";
            $songs=get_post_meta($album->ID, 'tracks', true);
            foreach ($songs as $songid) $albumout .= "<li>" . bndtls_rel_link($songid) . "</li>";
            $albumout .= "</ul>";
            $albumout .= "</li></ul>";

            $albumout .= ($args['before_widget']) ? $args['after_widget'] : "</div>";
            $out[] = $albumout;
          }
          // echo "\n";
          // echo print_r($query->posts, true) . " (end posts)</pre>"; die;

        }
        else
        $result=get_post_meta($queried_object->ID, 'tracks', true);
        break;

      case 'songs':
        if( $thistype == "bands" ) {
        }
        else
        $result=get_post_meta($queried_object->ID, 'tracks', true);
        break;

      default:
        $result=get_post_meta($queried_object->ID, $type, true);
        break;
    }
    if(empty($result) && empty($out)) return;
    if(is_array($result)) $results=$result;
    else $results[]=$result;

      if(isset($args['title']))
      $title = $args['title'];
      else $title = _n($labels->singular_name, $labels->name, count($results), 'band-tools');
    // $title = (count($results) > 1) ? $labels->name : $labels->singular_name;
    if(empty($out)) {
      $out[]="<ul>";
      foreach($results as $id) {
        if(is_numeric($id) && get_post_type($id)==$type)
        $out[] = "<li>" . bndtls_rel_link($id) . "</li>";
      }
      $out[]="</ul>";
    }
    $content.=join('', $out);
  }

  if(empty($content)) return;

  if ( ! empty( $title ) )
  $content = $args['before_title'] . $title . $args['after_title'] . $content;

  return $content;
}
