<?php

// Register Widget Area
if(get_option('bndtls_widget_area')) {
  register_sidebar(
    array (
      'name' => 'Band Tools Sidebar',
      'id' => 'bndtls-sidebar',
      /* translators: %s is replaced by the name of the plugin, untranslated */
      'description' => sprintf(__('Add widgets here to appear on %s pages'), 'Band Tools'),
      'before_widget' => '<div class="widget">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    )
  );
}

// songs widget
class bndtls_widget_all extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtls_widget_all',
      sprintf('Band Tools (%s)', __('all relations', 'band-tools')),
      array( 'description' => __( 'Display related songs', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    foreach(['videos','bands','albums','songs','products'] as $type) {
      $content = bndtls_block_relations_list($type, $args) ;
      if (!empty($content)) {
        $before_widget=preg_replace('/(id=.)bndtls_widget_all/', '$1bndtls_widget_' . $type, $args['before_widget'] );
        echo $before_widget . "<div>" . $content . "</div>" ;;
        echo $args['after_widget'];
      }
    }

    // if(empty($content)) return;
    // $content="<div>$content</div>";
    // // echo $args['before_widget'];
    // echo $content;
    // echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    // if ( isset( $instance[ 'title' ] ) ) {
    //   $title = $instance[ 'title' ];
    // }
    // else {
    //   $title = __( get_option( 'bndtls_naming_songs', 'Songs'), 'band-tools' );
    // }
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
    $content=bndtls_block_relations_list("bands", $args);

    if(empty($content)) return;
    $content="<div>$content</div>";
    echo $args['before_widget'];
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
class bndtls_widget_albums extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtls_widget_albums',
      sprintf('Band Tools (%s)', __(get_option( 'bndtls_naming_Albums', 'Songs'), 'band-tools')),
      array( 'description' => __( 'Display related albums', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    $content=bndtls_block_relations_list("albums", $args);

    if(empty($content)) return;
    $content="<div>$content</div>";
    echo $args['before_widget'];
    echo $content;
    echo $args['after_widget'];
    return;
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
class bndtls_widget_songs extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtls_widget_songs',
      sprintf('Band Tools (%s)', __(get_option( 'bndtls_naming_songs', 'Songs'), 'band-tools')),
      array( 'description' => __( 'Display related songs', 'band-tools' ), )
    );
  }

  // Widget front-end
  public function widget( $args, $instance ) {
    $content = bndtls_block_relations_list("songs", $args) ;

    if(empty($content)) return;
    $content="<div>$content</div>";
    echo $args['before_widget'];
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
class bndtls_widget_wc_products extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtls_widget_wc_products',
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
class bndtls_widget_video_posts extends WP_Widget {

  function __construct() {
    parent::__construct(
      'bndtls_widget_video_posts',
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
function bndtls_load_widgets() {
  register_widget( 'bndtls_widget_all' );
  register_widget( 'bndtls_widget_bands' );
  register_widget( 'bndtls_widget_albums' );
  register_widget( 'bndtls_widget_songs' );
  register_widget( 'bndtls_widget_video_posts' );
}
add_action( 'widgets_init', 'bndtls_load_widgets' );