<?php if ( ! defined( 'WPINC' ) ) die;

if ( ! defined( 'BNDTLS_UPDATES' ) ) define('BNDTLS_UPDATES', 0 );

if(get_option('bndtls_upated') < BNDTLS_UPDATES ) {
  bndls_updates();
}

function bndls_updates() {
  $u = get_option('bndtls_upated') + 1;
  while ($u <= BNDTLS_UPDATES) {
    $update="bndtls_update_$u";
    if(function_exists($update)) {
      $result=$update();
      if($result && $result='wait') {
        // not a success nor an error, will be processed after confirmation
        break;
      } else if($result) {
        $success[]=$u;
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

function bndtls_update_1() {
  // bndtls_admin_notice("Processing update 1");
  return true;
}
