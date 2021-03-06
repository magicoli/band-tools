<?php if ( ! defined( 'WPINC' ) ) die;

if ( ! defined( 'BNDTLS_UPDATES' ) ) define('BNDTLS_UPDATES', 3 );

if(get_option('bndtls_upated') < BNDTLS_UPDATES ) {
  bndls_updates();
}

function bndls_updates($args = array()) {
  $u = get_option('bndtls_upated') + 1;
  $messages = array();
  if($args['message']) $messages[] = $args['message'];
  while ($u <= BNDTLS_UPDATES) {
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
        else $messages[] = sprintf(__('Update %s applied', 'band-tools'), $u );
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
  $post_IDs = get_posts(array('post_per_page' => -1, 'post_type' => "${from}s"));
  $i = 0;
  $results=array();
  foreach($post_IDs as $p){
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
  $rows_updated = 0;
  // echo "<pre>"; $n = "\n"; $br = "<br/>";
  $relations_tracks = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}mb_relationships WHERE `type`='rel-records-songs' ORDER BY `from`, `order_from`" );
  foreach ($relations_tracks as $rel) {
        // echo "record id $$r";
    $record = get_post($rel->from);
    $song = get_post($rel->to);
    $track_nr = $rel->to;
    $current_tracks = rwmb_meta('tracks', array(), $record->ID);
    // $debug[] = "Current tracks: <pre>" . print_r($current_tracks, true) . "</pre>";
    $sample_ID ="";
    $sample_info = rwmb_meta('audio_sample', array(), $song->ID);
    if(is_array($sample_info)) {
      $sample_ID = array_key_first($sample_info);
    } else if (is_numeric($sample_info)) {
      $sample_ID = $sample_info;
    }
    if(!empty($sample_ID)) $sample = get_post($sample_ID)->guid;

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
    $rows_updated++;
    // break;
    // $debug[] = "new_track " . print_r($new_track, true)  . "";
    // // $current_record = get_post_meta( $band_ID, 'fredningszone_data', true );
    // //         $meta = get_post_meta( $post["id"], 'fredningszone_data', true );
  }
  // $debug[] = "New tracks: <pre>" . print_r($new_tracks, true) . "</pre>";
  if($new_tracks) foreach($new_tracks as $record_ID => $tracks) {
    // $debug[] = "<pre>rwmb_set_meta( $record_ID, 'tracks', " . print_r($new_tracks[$record_ID], true) . " );</pre>";
    rwmb_set_meta( $record_ID, 'tracks', $new_tracks[$record_ID] );
    // update_post_meta( $record_ID, 'tracks', serialize($new_tracks[$record_ID]) );
    // $current_tracks = rwmb_meta('tracks', array(), $record_ID);
    // $current_tracks = get_post_meta('tracks', $record_ID);
    // $debug[] = "$record_ID after update: <pre>" . print_r($current_tracks, true) . "</pre>";
    $rows_updated++;
  }

  $rel_records_bands = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}mb_relationships WHERE `type`='rel-bands-records' ORDER BY `to`, `order_to`, `from`");
  foreach ($rel_records_bands as $rel) {
    $record = get_post($rel->to);
    $band_ID = $rel->from;
    rwmb_set_meta( $record->ID, 'band', $band_ID );
    $rows_updated++;
  }
  $rel_records_products = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}mb_relationships WHERE `type`='rel-records-products' ORDER BY `from`, `order_from`");
  foreach ($rel_records_products as $rel) {
    $record = get_post($rel->from);
    // $record_ID = $rel->from;
    $product_ID = $rel->to;
    rwmb_set_meta( $record->ID, 'record_product', $product_ID );
    $rows_updated++;
    // echo "record $record->ID product $product_ID <pre>"; print_r($record); die;
  }

  $rel_records_bands = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}mb_relationships WHERE `type`='rel-bands-songs' ORDER BY `from`, `order_from`, `order_to`");
  foreach ($rel_records_bands as $rel) {
    $song = get_post($rel->to);
    $band_ID = $rel->from;
    rwmb_set_meta( $song->ID, 'band', $band_ID );
    $rows_updated++;
  }

  $wpdb->query( "DELETE FROM {$wpdb->prefix}mb_relationships WHERE `type`='rel-bands-records' OR `type`='rel-records-products' OR `type`='rel-bands-songs' OR `type`='rel-records-songs'" );
  // if($debug) bndtls_admin_notice('<br/>' . join('<br/>', $debug), 'info');
  $messages[] = sprintf(__('database updated, %s rows affected', 'band-tools'), $u, $rows_updated );
  if($messages)
  bndtls_admin_notice(join('<br/>', $messages), 'success');
  update_option('bndtls_upated', 2);
}

/*
 * Added settings to toggle elements in records list
 * Set the default to previous behaviour for continuity
 */
function bndtls_update_3() {
  $settings=get_option('bndtls-settings');
  $settings['layout_record_default'] = [ 'tracks', 'player' ];
  update_option('bndtls-settings', $settings);
  return true;
}
