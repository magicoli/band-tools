<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

function bndtls_block_relations_list($type='', $args) {
  global $wp_post_types;
  $labels = $wp_post_types[$type]->labels;
  $queried_object = get_queried_object();

  $thistype=get_post_type($queried_object->ID);
  if($thistype==$type) return;

  $out=array();
  if(is_object($queried_object) && $queried_object->ID)
  {
    if( $type=="bands" && $thistype=="songs" )
      $result=get_post_meta($queried_object->ID, 'band', true);
    else if ( $type=="bands" )
      $result=get_post_meta($queried_object->ID, 'album_band', true);
    else if( $type == "albums" && $thistype == "bands" )
      $result=get_post_meta($queried_object->ID, 'album_band', true);
    else if( $type == "albums" )
      $result=get_post_meta($queried_object->ID, 'tracks', true);
    else if( $type == "songs" && $thistype == "albums" )
      $result=get_post_meta($queried_object->ID, 'tracks', true);
    else if( $type == "songs" )
      $result=get_post_meta($queried_object->ID, 'band', true);
    else
      $result=get_post_meta($queried_object->ID, $type, true);

    if(empty($result)) return;
    if(is_array($result)) $results=$result;
    else $results[]=$result;

    if(isset($args['title']))
    $title = $args['title'];
    else $title = _n($labels->singular_name, $labels->name, count($results), 'band-tools');
    // $title = (count($results) > 1) ? $labels->name : $labels->singular_name;
    foreach($results as $id) {
      if(is_numeric($id) && get_post_type($id)==$type)
      $out[] = sprintf( '<a href="%s" class="acf-field %s" data-id="%s">%s</span>', get_permalink($id), $column_name, $id, get_the_title($id) ) . "</a>";
    }
    $content.=join('<br>', $out);
  }

  if(empty($content)) return;

  if ( ! empty( $title ) )
  $content = $args['before_title'] . $title . $args['after_title'] . $content;

  return $content;
}
