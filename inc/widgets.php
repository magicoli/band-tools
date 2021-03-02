<?php

// Register Widget Area
register_sidebar(
    array (
        'name' => 'Band Sidebar',
        'id' => 'bndtls-sidebar',
        'description' => __('Show only on bands pages'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    )
);

// Bands widget
class bndtls_widget_bands extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtls_widget_bands',
      sprintf('Band Tools (%s)', __(get_option( 'bndtls_naming_bands', 'Bands'), 'band-tools')),
      array( 'description' => __( 'Display related bands', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    global $wp_post_types;
    $labels = $wp_post_types['bands']->labels;
    $queried_object = get_queried_object();

    if(get_post_type($queried_object->ID)=="band") return;

    $out=array();
    if(is_object($queried_object) && $queried_object->ID)
    {
      if(get_post_type($queried_object->ID)=="songs")
      $result=get_post_meta($queried_object->ID, 'band', true);
      else
      $result=get_post_meta($queried_object->ID, 'album_band', true);
      if(is_array($result)) $results=$result;
      else $results[]=$result;
      if(empty($results)) return;
      $title = _n($labels->singular_name, $labels->name, count($results), 'band-tools');
      // $title = (count($results) > 1) ? $labels->name : $labels->singular_name;
      foreach($results as $id) {
        if(is_numeric($id) && get_post_type($id)=="bands")
        $out[] = sprintf( '<a href="%s" class="acf-field %s" data-id="%s">%s</span>', get_permalink($id), $column_name, $id, get_the_title($id) ) . "</a>";
      }
      $content.=join('<br>', $out);
    }

    if(empty($content)) return;
    $content="<div>$content</div>";
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    echo $content;
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( get_option( 'bndtls_naming_bands', 'Bands'), 'band-tools' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}

// albums widget
class bndtsl_widget_albums extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtsl_widget_albums',
      sprintf('Band Tools (%s)', __(get_option( 'bndtls_naming_Albums', 'Songs'), 'band-tools')),
      array( 'description' => __( 'Display related albums', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    global $wp_post_types;
    $labels = $wp_post_types['albums']->labels;
    $queried_object = get_queried_object();

    if(get_post_type($queried_object->ID)=="albums") return;

    $out=array();
    if(is_object($queried_object) && $queried_object->ID)
    {
      if(get_post_type($queried_object->ID)=="bands")
      $results=get_post_meta($queried_object->ID, 'album_band', true);
      else
      $results=get_post_meta($queried_object->ID, 'tracks', true);
      if(empty($results)) return;
      $title = __(_n($labels->singular_name, $labels->name, count($results)), 'band-tools');
      if(is_array($results)) {
        foreach($results as $id) {
          if(get_post_type($id)=="albums")
          $out[] = sprintf( '<a href="%s" class="acf-field %s" data-id="%s">%s</span>', get_permalink($id), $column_name, $id, get_the_title($id) ) . "</a>";
        }
        $content=join('<br/>', $out);
      }
    }
    if(empty($content)) return;
    $content="<div>$content</div>";

    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    echo $content;
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( get_option( 'bndtls_naming_Albums', 'Songs'), 'band-tools' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}

// songs widget
class bndtsl_widget_songs extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtsl_widget_songs',
      sprintf('Band Tools (%s)', __(get_option( 'bndtls_naming_songs', 'Songs'), 'band-tools')),
      array( 'description' => __( 'Display related songs', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    global $wp_post_types;
    $labels = $wp_post_types['songs']->labels;
    $queried_object = get_queried_object();

    if(get_post_type($queried_object->ID)=="songs") return;

    $out=array();
    if(is_object($queried_object) && $queried_object->ID)
    {
      if(get_post_type($queried_object->ID)=="albums")
      $results=get_post_meta($queried_object->ID, 'tracks', true);
      else
      $results=get_post_meta($queried_object->ID, 'band', true);
      if(empty($results)) return;
      $title = __(_n($labels->singular_name, $labels->name, count($results)), 'band-tools');
      if(is_array($results)) {
        foreach($results as $id) {
          // if(get_post_type($id)=="albums")
          $out[] = sprintf( '<a href="%s" class="acf-field %s" data-id="%s">%s</span>', get_permalink($id), $column_name, $id, get_the_title($id) ) . "</a>";
        }
        $content=join('<br/>', $out);
      }
    }

    if(empty($content)) return;
    $content="<div>$content</div>";

    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    echo $content;
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( get_option( 'bndtls_naming_songs', 'Songs'), 'band-tools' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}

// wc_products widget
class bndtsl_widget_wc_products extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtsl_widget_wc_products',
      sprintf('Band Tools (%s)', __('WC Products', 'band-tools')),
      array( 'description' => __( 'Display related WooCommerce products', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    global $wp_post_types;
    $queried_object = get_queried_object();

    // if(get_post_type($queried_object->ID)=="wc_products") return;

    $out=array();

    if(is_object($queried_object) && $queried_object->ID)
    {
      $results=get_post_meta($queried_object->ID, 'wc_product', true);
      if(!is_array($results) &! empty($results)) $results=array($results);
      // if(empty($results)) return;
      $title = __('Order online', 'band-tools');
      if(is_array($results)) {
        foreach($results as $id) {
          // if(get_post_type($id)=="albums")
          $out[] = sprintf( '<a href="%s" class="acf-field %s" data-id="%s">%s</span>', get_permalink($id), $column_name, $id, get_the_title($id) ) . "</a>";
        }
      }
    }
    $content=join('<br/>', $out);

    if(empty($content)) return;
    $content="<div>$content</div>";

    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    echo $content;
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'Products', 'band-tools' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}


// video_posts widget
class bndtsl_widget_video_posts extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtsl_widget_video_posts',
      sprintf('Band Tools (%s)', __('Videos', 'band-tools')),
      array( 'description' => __( 'Display related videos', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    global $wp_post_types;
    $queried_object = get_queried_object();

    // if(get_post_type($queried_object->ID)=="video_posts") return;

    $out=array();
    if(is_object($queried_object) && $queried_object->ID)
    {
      $results=get_post_meta($queried_object->ID, 'video_posts', true);
      if(!is_array($results) &! empty($results)) $results=array($results);
      // if(empty($results)) return;
      if(get_post_type($queried_object->ID)=="songs")
      $title = __('Videos', 'band-tools');
      else
      $title = __(get_option( 'bndtls_naming_songs', 'Songs'), 'band-tools');
      if(is_array($results)) {
        foreach($results as $id) {
          // if(get_post_type($id)=="albums")
          $out[] = sprintf( '<a href="%s" class="acf-field %s" data-id="%s">%s</span>', get_permalink($id), $column_name, $id, get_the_title($id) ) . "</a>";
        }
      }
    }
    $content=join('<br/>', $out);

    if(empty($content)) return;
    $content="<div>$content</div>";

    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    echo $content;
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'Products', 'band-tools' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}

// Register and load the widget
function bndtsl_load_widgets() {
  register_widget( 'bndtls_widget_bands' );
  register_widget( 'bndtsl_widget_albums' );
  register_widget( 'bndtsl_widget_songs' );
  register_widget( 'bndtsl_widget_video_posts' );
}
add_action( 'widgets_init', 'bndtsl_load_widgets' );
