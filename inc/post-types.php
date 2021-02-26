<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {die;}

require_once __DIR__ . '/custom-types.php';
require_once __DIR__ . '/custom-fields.php';

register_activation_hook( __FILE__, 'bndtls_rewrite_flush' );
function bndtls_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    bndtls_register_post_types();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}

### Bi-directional relations sync

new acf_post2post();

class acf_post2post {

	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activate'));
		register_deactivation_hook(__FILE__, array($this, 'deactivate'));
		add_action('after_setup_theme', array($this, 'plugins_loaded'));
	} // end public function __construct

	public function plugins_loaded() {
		if (!function_exists('acf_get_setting')) {
			add_action('admin_init', array($this, 'missing_acf5'));
			return;
		}
		$acf_version = acf_get_setting('version');
		if (version_compare($acf_version, '5.0.0', '<')) {
			add_action('admin_init', array($this, 'missing_acf5'));
			return;
		}
		add_filter('acf/update_value/type=relationship', array($this, 'update_relationship_field'), 11, 3);
		add_filter('acf/update_value/type=post_object', array($this, 'update_relationship_field'), 11, 3);
	} // end public function plugins_loaded

	public function missing_acf5() {
		deactivate_plugins(plugin_basename( __FILE__ ));
	} // end public function missing_acf5

	public function update_relationship_field($value, $post_id, $field) {
		$update = true;
		$update = apply_filters('acf/post2post/update_relationships/key='.$field['key'], $update);
		if (!$update) {
			return $value;
		}
		$updated_posts = array();
		$field_name = $field['name'];
		$previous = maybe_unserialize(get_post_meta($post_id, $field_name, true));
		if ($previous === '') {
			$previous = array();
		}
		if (!is_array($previous)) {
			$previous = array($previous);
		}
		$previous = array_map('intval', $previous);
		// get new value
		$new = $value;
		if (!$new) {
			$new = array();
		}
		if (!is_array($new)) {
			$new = array($new);
		}
		if (count($previous)) {
			foreach ($previous as $related_id) {
				if (!in_array($related_id, $new)) {
					$this->remove_relationship($related_id, $field_name, $post_id);
					$updated_posts[] = $related_id;
				}
			}
		}
		if (count($new)) {
			foreach ($new as $related_id) {
				$this->add_relationship($related_id, $field_name, $post_id);
				$updated_posts[] = $related_id;
			}
		}
		if (count($updated_posts)) {
			do_action('acf/post2post/relationships_updated', $updated_posts, $field_name, $new, $previous);
		}
		return $value;
	} // end public function update_relationship_field

	private function remove_relationship($post_id, $field_name, $related_id) {
		/*
			$post_id = the post id to remove the relationship from
			$field_name = the field name to update
			$related_id = the relationship to remove
		*/
		$field = $this->get_field($post_id, $field_name);
		if (!$field) {
			// field not found attached to this post
			return;
		}
		$array_value = true;
		if ($field['type'] == 'post_object') {
			if (!$field['multiple']) {
				$array_value = false;
			}
		}
		$values = maybe_unserialize(get_post_meta($post_id, $field_name, true));
		if ($values === '') {
			$values = array();
		}
		if (!is_array($values)) {
			$values = array($values);
		}
		if (!count($values)) {
			// nothing to delete
			return;
		}
		$values = array_map('intval', $values);
		$new_values = array();
		foreach ($values as $value) {
			if ($value != $related_id) {
				$new_values[] = $value;
			}
		}
		if (!count($new_values) && !$array_value) {
			$new_values = '';
		} elseif (!$array_value) {
			$new_values = $new_values[0];
		} elseif (count($new_values)) {
			$new_values = array_map('strval', $new_values);
		}
		update_post_meta($post_id, $field_name, $new_values);
		update_post_meta($post_id, '_'.$field_name, $field['key']);
		do_action('acf/post2post/relationship_updated', $post_id, $field_name, $new_values);
	} // end private function remove_relationship

	private function add_relationship($post_id, $field_name, $related_id) {
		/*
			$post_id = the post id to add the relationship to
			$field_name = the field name to update
			$related_id = the relationship to add
		*/
		$field = $this->get_field($post_id, $field_name);
		if (!$field) {
			// field not found attached to this post
			return;
		}
		$max_posts = 0;
		$array_value = true;
		if ($field['type'] == 'post_object') {
			if (!$field['multiple']) {
				$max_posts = 1;
				$array_value = false;
			}
		} elseif ($field['type'] == 'relationship') {
			if ($field['max']) {
				$max_posts = $field['max'];
			}
		}
		$value = maybe_unserialize(get_post_meta($post_id, $field_name, true));
		if ($value == '') {
			$value = array();
		}
		if (!is_array($value)) {
			$value = array($value);
		}
		$value = array_map('intval', $value);
		if (($max_posts == 0 || count($value) < $max_posts) &&
				!in_array($related_id, $value)) {
			$value[] = $related_id;
		} elseif ($max_posts > 0) {
			$overwrite_settings = apply_filters('acf-post2post/overwrite-settings', array());
			if (isset($overwrite_settings[$field_name]) &&
				isset($overwrite_settings[$field_name]['overwrite']) &&
				$overwrite_settings[$field_name]['overwrite']) {
				$type = 'first';
				if (isset($overwrite_settings[$field_name]['type']) &&
						in_array(strtolower($overwrite_settings[$field_name]['type']), array('first', 'last'))) {
					$type = strtolower($overwrite_settings[$field_name]['type']);
				}
				if ($type == 'first') {
					$remove = array_shift($value);
				} else {
					$remove = array_pop($value);
				}
				// remove this relationship from the post that was just removed
				$this->remove_relationship(intval($remove), $field_name, $post_id);
				$append_where = 'append';
				$append_where = apply_filters('acf/post2post/append-prepend', $append_where); // all field
				$append_where = apply_filters('acf/post2post/append-prepend/name='.$field['name'], $append_where); // field name
				$append_where = apply_filters('acf/post2post/append-prepend/key='.$field['key'], $append_where); // field key
				if ($append_where == 'append') {
					$value[] = $related_id;
				} else {
					array_unshift($value, $related_id);
				}
			} // end field overwrite
		} // end if else
		if (!$array_value) {
			$value = $value[0];
		} else {
			$value = array_map('strval', $value);
		}
		update_post_meta($post_id, $field_name, $value);
		update_post_meta($post_id, '_'.$field_name, $field['key']);
		do_action('acf/post2post/relationship_updated', $post_id, $field_name, $value);
	} // end private function add_relationship

	public function get_field($post_id, $field_name) {
		$field = false;
		$found = false;
		$cache_key = 'get_field-'.$post_id.'-'.$field_name;
		$cache = wp_cache_get($cache_key, 'acfpost2post', false, $found);
		if ($found) {
			return $cache;
		}
		$found = false;
		$field_groups = $this->post_field_groups($post_id);
		$field_group_count = count($field_groups);
		for ($g=0; $g<$field_group_count; $g++) {
			$field_count = count($field_groups[$g]['fields']);
			for ($f=0; $f<$field_count; $f++) {
				if ($field_groups[$g]['fields'][$f]['name'] == $field_name &&
					in_array($field_groups[$g]['fields'][$f]['type'], array('relationship', 'post_object'))) {
					$field = $field_groups[$g]['fields'][$f];
					$found == true;
					break;
				}
			} // end for $f
			if ($found) {
				break;
			}
		} // end for $g
		wp_cache_set($cache_key, $field, 'acfpost2post');
		return $field;
	} // end public function get_field

	public function post_field_groups($post_id) {
		$found = false;
		$cache = wp_cache_get('post_field_groups-'.$post_id, 'acfpost2post', false, $found);
		if ($found) {
			return $cache;
		}
		$args = array('post_id' => $post_id);
		$field_groups = acf_get_field_groups($args);
		$count = count($field_groups);
		for ($i=0; $i<$count; $i++) {
			$field_groups[$i]['fields'] = acf_get_fields($field_groups[$i]['key']);
		}
		wp_cache_set('post_field_groups-'.$post_id, $field_groups, 'acfpost2post');
		return $field_groups;
	} // end public function post_field_groups

	public function activate() {
		// just in case I need to do something to activate
	} // end public function activate

	public function deactivate() {
		// just in case I need to do something to deactivate
	} // end public function deactivate

} // end class acf_post2post

//Add the columns for the "page" post type
add_filter('manage_edit-songs_columns', 'bndtls_add_songs_columns');
function bndtls_add_songs_columns($columns) {
  $columns = array(
         'cb' => '<input type="checkbox" />',
         'title' => 'Title',
         'band' => 'Band',
         'tracks' => 'Albums',
         'date' => 'Date',
     );
  return $columns;
}

add_filter('manage_edit-albums_columns', 'bndtls_add_albums_columns');
function bndtls_add_albums_columns($columns) {
  $columns = array(
         'cb' => '<input type="checkbox" />',
         'title' => 'Title',
         'band' => 'Band',
         'date' => 'Date',
     );
  return $columns;
}

if( function_exists('get_field') ) {
  // Render the custom columns for the "albums" and "songs" post types
  add_action('manage_albums_posts_custom_column', 'bndtls_render_acf_columns', 10, 2);
  add_action('manage_songs_posts_custom_column', 'bndtls_render_acf_columns', 10, 2);
  function bndtls_render_acf_columns($column_name) {
    global $post;
    switch ($column_name) {
      case 'band':
      case 'tracks':
      $band = get_field($column_name, $post->ID);
      // print_r($band);
      if(is_array($band)) $bands=$band;
      else $bands[] = $band;
      $out = array();
      foreach($bands as $foo) {
        $out[] = sprintf( '<a href="%s" class="acf-field %s" data-id="%s">%s</span>', get_permalink($foo->ID), $column_name, $foo->ID, $foo->post_title );
      }
      echo( join('<br>', $out) );
      break;
    }
  }
}