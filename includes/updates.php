<?php if ( ! defined( 'WPINC' ) ) die;

if ( ! defined( 'BNDTLS_UPDATES' ) ) define('BNDTLS_UPDATES', 2 );

if(get_option('bndtls_upated') < BNDTLS_UPDATES ) {
  bndls_updates();
}

function bndls_updates() {
  $u = get_option('bndtls_upated') + 1;
  $messages = array();
  while ($u <= BNDTLS_UPDATES) {
    $messages[] = sprintf(__('applying update %s', 'band-tools'), $u );
    $update="bndtls_update_$u";
    if(function_exists($update)) {
      $result=$update();
      if($result && $result==='wait') {
        // not a success nor an error, will be processed after confirmation
        break;
      } else if($result) {
        $success[]=$u;
        if($result != 1)
        $messages[] = $result;
        update_option('bndtls_upated', $u);
      } else {
        $errors[]=$u;
        break;
      }
    }
    $u++;
  }
  if($success) {
    $messages[] = sprintf( _n('Update %s applied sucessfully', 'Updates %s applied sucessfully', count($success), 'band-tools'), join(', ', $success) );
    $class='success';
    $return=true;
  }
  if($errors) {
    $messages[] = sprintf(
      __('Error processing update %s', 'band-tools'),
      $errors[0] );
    $class='error';
    $return=false;
  }
  if($messages)
  bndtls_admin_notice(join('<br/>', $messages), $class);
  return $return;
}

/*
 * Change 'albums' post type to 'records'
 * No check or confirmation because the plugin is in very early stage and
 * probably used only by the developer yet.
 */
function bndtls_update_1() {
  global $wpdb;
  $from='album';
  $to='record';
  $post_ids = get_posts(array('post_per_page' => -1, 'post_type' => "${from}s"));
  $i = 0;
  $results=array();
  foreach($post_ids as $p){
    $po = array();
    $po = get_post($p->ID,'ARRAY_A');
    $po['post_type'] = "${to}s";
    wp_update_post($po);
    $i++;
  }
  if($i > 0) $results[] = "$i posts converted from 'albums' to 'records'";
  if($wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}mb_relationships SET type = replace(type, '$from', '$to') WHERE type like '%$from%'")))
  $results[] = $wpdb->affected_rows . " Relationships updated";
  if($wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}postmeta SET meta_value = '${to}s' WHERE meta_key='_menu_item_object' AND meta_value = '{$from}s'")))
  $results[] = $wpdb->affected_rows . " Menus updated";
  $options=get_option('bndtls-settings');
  $renames=array(
    "naming_${from}" => "naming_${to}",
    "naming_${from}s" => "naming_${to}s",
  );
  foreach($renames as $old => $new) {
    if($options[$old] &! $options[$new]) {
      $options[$new]=$options[$old];
      unset($options[$old]);
    }
  }
  $options['allow_front_page']=str_replace($from, $to, $options['allow_front_page']);
  $options['layout_page_content']=str_replace($from, $to, $options['layout_page_content']);
  if($options != get_option('bndtls-settings')) {
    update_option('bndtls-settings', $options);
    $results[] = "options updated";
  }
  update_option('bndtls_rewrite_rules', true);
  if(!empty($results)) return join("<br/>", $results);
  return true;
}

function bndtls_update_2() {
  global $wpdb;
  add_action( 'init', 'bndtls_update_2_init', 30 );
  return 'wait';
}
function bndtls_update_2_init() {
  global $wpdb;
  // echo "<pre>"; $n = "\n"; $br = "<br/>";
  $relations_tracks = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}mb_relationships WHERE `type`='rel-records-songs' ORDER BY `from`, `order_from`" );
  foreach ($relations_tracks as $rel) {
        // echo "record id $$r";
    $record = get_post($rel->from);
    $song = get_post($rel->to);
    $track_nr = $rel->to;
    $current_tracks = rwmb_meta('tracks', array(), $record->ID);
    // $debug[] = "Current tracks: <pre>" . print_r($current_tracks, true) . "</pre>";
    $sample_id ="";
    $sample_info = rwmb_meta('audio_sample', array(), $song->ID);
    if(is_array($sample_info)) {
      $sample_id = array_key_first($sample_info);
    } else if (is_numeric($sample_info)) {
      $sample_id = $sample_info;
    }
    if(!empty($sample_id)) $sample = get_post($sample_id)->guid;

    $new_track = array(
      'track_song' => $song->ID,
      'track_audio_sample_url' => $sample,
      // 'track_isrc' => '',
    );

    $song_products = $wpdb->get_results( "SELECT `to` FROM {$wpdb->prefix}mb_relationships
      WHERE `from`= $song->ID AND `type`='rel-songs-products'
      ORDER BY `from`, `order_from`" );
      if($song_products) $new_track['track_product'] = array_shift($song_products)->to;
    $new_tracks[$record->ID][] = $new_track;
    $records_updates[] = $record;
    // break;
    // $debug[] = "new_track " . print_r($new_track, true)  . "";
    // // $current_record = get_post_meta( $band_id, 'fredningszone_data', true );
    // //         $meta = get_post_meta( $post["id"], 'fredningszone_data', true );
  }
  // $debug[] = "New tracks: <pre>" . print_r($new_tracks, true) . "</pre>";
  foreach($new_tracks as $record_id => $tracks) {
    // $debug[] = "<pre>rwmb_set_meta( $record_id, 'tracks', " . print_r($new_tracks[$record_id], true) . " );</pre>";
    rwmb_set_meta( $record_id, 'tracks', $new_tracks[$record_id] );
    // update_post_meta( $record_id, 'tracks', serialize($new_tracks[$record_id]) );
    $current_tracks = rwmb_meta('tracks', array(), $record_id);
    // $current_tracks = get_post_meta('tracks', $record_id);
    // $debug[] = "$record_id after update: <pre>" . print_r($current_tracks, true) . "</pre>";

  }

  $rel_records_bands = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}mb_relationships WHERE `type`='rel-bands-records' ORDER BY `to`, `order_to`, `from`");
  foreach ($rel_records_bands as $rel) {
    $record = get_post($rel->to);
    $band_id = $rel->from;
    rwmb_set_meta( $record->ID, 'band', $band_id );
  }
  // foreach($rel_records_bands as $record) {
  //   // rel-bands-records_from
  //
    // $debug[] = "rel_records_bands " . "<pre>" . print_r($rel_records_bands, true) . "</pre>";
  // }*
  if($debug) bndtls_admin_notice('<br/>' . join('<br/>', $debug), 'info');

  // echo "</pre>";
  // die();
  // if($wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}mb_relationships SET type = replace(type, '$from', '$to') WHERE type like '%$from%'")))

  // update_option('bndtls_rewrite_rules', true);
  // if(!empty($results)) return join("<br/>", $results);
  return false;
}
