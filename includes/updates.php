<?php if ( ! defined( 'WPINC' ) ) die;

if ( ! defined( 'BNDTLS_UPDATES' ) ) define('BNDTLS_UPDATES', 1 );

if(get_option('bndtls_upated') < BNDTLS_UPDATES ) {
  bndls_updates();
}

function bndls_updates() {
  $u = get_option('bndtls_upated') + 1;
  $messages = array();
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

  update_option('bndtls_rewrite_rules', true);
  if(!empty($results)) return join("<br/>", $results);
  return true;
}
