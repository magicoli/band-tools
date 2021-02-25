<?php


$bndtls_dependencies = [
  [
    "name" =>  "Advanced Custom Fields",
    "host" =>  "wordpress",
    "slug" =>  "advanced-custom-fields/acf.php",
    "uri" =>  "https://wordpress.org/plugins/advanced-custom-fields/",
    "optional" =>  false
  ],
  [
    "name" =>  "Custom Post Type UI",
    "host" =>  "wordpress",
    "slug" =>  "custom-post-type-ui/custom-post-type-ui.php",
    "uri" =>  "https://wordpress.org/plugins/custom-post-type-ui/",
    "optional" =>  true
  ],
];

add_action( 'admin_init', 'bndtls_dependencies_check' );

function bndtls_dependencies_check() {
  global $bndtls_dependencies;
  global $message, $required, $recommanded;
  if(empty($bndtls_dependencies)) return;
  // $unmet=array();
  $installed_plugins = get_plugins();
  foreach ($bndtls_dependencies as $dependency) {
    $actions=array();
    $plugin_file=$dependency['slug'];
    $plugin = basename(dirname($plugin_file));
    if(is_plugin_active($plugin_file)) {
      $actions[]="Active";
    } else {
      $action = 'install-plugin';
      if ( array_key_exists( $plugin_file, $installed_plugins )
      || in_array( $plugin_file, $installed_plugins, true )) {
        $activate_url = wp_nonce_url(
          admin_url('plugins.php?action=activate&plugin='.$plugin_file),
          'activate-plugin_'.$plugin_file
        );
        $actions[]="<a href='$activate_url'>" . __("Activate") . "</a>";
      } else {
        $install_url=wp_nonce_url(
          add_query_arg(
            array(
              'action' => 'install-plugin',
              'plugin' => $plugin
            ),
            admin_url( 'update.php' )
          ),
          $action.'_'.$plugin
        );
        $actions[]="<a href='$install_url'>" . __("Install") . "</a>";
      }
      if($dependency['optional']) $recommanded[]=$dependency['name'] . _(' (recommanded) ') . join(' ', $actions);
      else $required[]=$dependency['name'] . __(' (required) ') . join(' ', $actions);
      // $unmet[]="$plugin " . $dependency['name'] . ' ' . join(' ', $actions);
    }
  }
  if(!empty($required)) {
    add_action( 'admin_notices', function() {
      global $required, $recommanded;
      echo '<div class="notice notice-error is-dismissible">';
      if(!empty($required)) echo "<h2>" . __("band-tools requires these extensions:") . "</h2><ul><li><strong>" . join("</li><li>", $required) . "</strong></li></ul>";
      if(!empty($recommanded)) echo "<ul><li>" . join("</li><li>", $recommanded) . "</li></ul></p>";
      echo '</div>';
    } );
  }
  // if(count($unmet) > "0") {
  // }
  // return $unmet;
}
