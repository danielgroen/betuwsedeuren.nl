<?php
/**
 * Viba Portfolio Widget Filter.
 *
 * @package 	Viba_Portfolio/Widgets
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Widget_Filter' ) ) :

class Viba_Portfolio_Widget_Filter extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {

		$widget_ops = array(
			'classname' 	=> 'widget_viba_portfolio_filter',
			'description' 	=> __( 'Display a list of categories or tags for portfolio filter.', 'viba-portfolio' ) 
		);
		parent::__construct( 'viba_portfolio_widget_filter', _x( 'Viba Portfolio Filter', 'Filter Widget Name', 'viba-portfolio' ), $widget_ops );

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
		$terms 		= viba_portfolio_get_terms( $taxonomy, array(), 'slug', 'name' );
		$style 		= viba_portfolio_get_selected_style();

		if ( is_viba_portfolio() || is_viba_portfolio_shortcode_active() ) :
			
			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

            viba_portfolio_get_template( 'widgets/viba-portfolio-filter.php', array( 'terms' => $terms ) );

			echo $args['after_widget'];

		endif;
		
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
			'title' 	=> _x( 'Viba Portfolio Filter', 'Filter Widget Title', 'viba-portfolio' ), 
			'taxonomy' 	=> viba_portfolio()->category_taxonomy, 
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
			echo '<label for="'. $this->get_field_id( 'taxonomy' ) .'">'. _x( 'Filtey by:', 'Widget Filter Taxonomy', 'viba-portfolio' ) .'</label>';
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