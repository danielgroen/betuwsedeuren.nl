<?php
/**
 * Viba Portfolio Searchform Widget.
 *
 * @package 	Viba_Portfolio/Widgets
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Widget_Searchform' ) ) :

class Viba_Portfolio_Widget_Searchform extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {

		$widget_ops = array(	
			'classname' 	=> 'widget_viba_portfolio_searchform',
			'description' 	=> __( 'A search form for your portfolio items.', 'viba-portfolio' ) 
		);
		parent::__construct( 'viba_portfolio_widget_searchform', _x( 'Viba Portfolio Search', 'Searchform Widget Name', 'viba-portfolio' ), $widget_ops);

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
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			
		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		viba_portfolio_searchform();

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
		$instance 			= $old_instance;
		$instance['title'] 	= strip_tags( stripslashes( $new_instance['title'] ) );
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
			'title' => _x( 'Search Portfolios', 'Searchform Widget Title', 'viba-portfolio' )
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'title' ) .'">'. _x( 'Title:', 'Widget Title', 'viba-portfolio' ) .'</label>';
			echo '<input class="widefat" id="'. $this->get_field_id( 'title' ) .'" name="'. $this->get_field_name( 'title' ) .'" type="text" value="'. $title .'" />';
		echo '</p>';

	}
	
}

endif;