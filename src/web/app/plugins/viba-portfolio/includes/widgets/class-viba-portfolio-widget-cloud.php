<?php
/**
 * Viba Portfolio Widget Cloud.
 *
 * @package 	Viba_Portfolio/Widgets
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Widget_Cloud' ) ) :

class Viba_Portfolio_Widget_Cloud extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {

		$widget_ops = array(
			'classname' 	=> 'widget_viba_portfolio_cloud',
			'description' 	=> __( 'A cloud of most used portfolio tags or categories.', 'viba-portfolio' ) 
		);
		parent::__construct( 'viba_portfolio_widget_cloud', _x( 'Viba Portfolio Cloud', 'Cloud Widget Name', 'viba-portfolio' ), $widget_ops );

	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $args
	 * @param 	array $instance
	 */
	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/default-widgets.php */
		$title 		= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$taxonomy 	= $instance['taxonomy'];

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="tagcloud">';

		wp_tag_cloud( apply_filters( 'viba_portfolio_widget_cloud_args', array(
			'taxonomy' => $taxonomy
		) ) );

		echo "</div>\n";

		echo $args['after_widget'];
		
	}

	/**
	 * Processing widget options on save.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $new_instance The new options
	 * @param 	array $old_instance The previous options
	 * @return 	array $instance Values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance 				= $old_instance;
		$instance['title'] 		= strip_tags( stripslashes( $new_instance['title'] ) );
		$instance['taxonomy'] 	= stripslashes( $new_instance['taxonomy'] );
		return $instance;
	}

	/**
	 * Outputs the options form on admin.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $instance The widget options
	 */
	public function form( $instance ) {

		// Set up default settings.
		$defaults = array( 
			'title' 	=> _x( 'Viba Portfolio Cloud', 'Cloud Widget Title', 'viba-portfolio' ), 
			'taxonomy' 	=> viba_portfolio()->tag_taxonomy, 
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title 			= $instance['title'];
		$current_tax	= $instance['taxonomy'];

		$taxonomies = get_object_taxonomies( viba_portfolio()->post_type );

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'title' ) .'">'. _x( 'Title:', 'Widget Title', 'viba-portfolio' ) .'</label>';
			echo '<input class="widefat" id="'. $this->get_field_id( 'title' ) .'" name="'. $this->get_field_name( 'title' ) .'" type="text" value="'. $title .'" />';
		echo '</p>';

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'taxonomy' ) .'">'. _x( 'Taxonomy:', 'Cloud Widget Taxonomy', 'viba-portfolio' ) .'</label>';
			echo '<select class="widefat" id="'. $this->get_field_id( 'taxonomy' ) .'" name="'. $this->get_field_name( 'taxonomy' ) .'">';
			foreach ( $taxonomies as $key => $taxonomy ) {
				$tax = get_taxonomy( $taxonomy );
				echo '<option value="'. esc_attr( $taxonomy ) .'" '. selected( $taxonomy, $current_tax ) .'>'. $tax->labels->name .'</option>';
			}
			echo '<select>';
		echo '</p>';

	}
	
}

endif;