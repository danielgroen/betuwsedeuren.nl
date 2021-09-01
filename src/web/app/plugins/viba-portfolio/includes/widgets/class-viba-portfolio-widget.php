<?php
/**
 * Viba Portfolio Widget.
 *
 * @package 	Viba_Portfolio/Widgets
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Widget' ) ) :

class Viba_Portfolio_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {

		$widget_ops = array(
			'classname' 	=> 'widget_viba_portfolio',
			'description' 	=> __( 'Display a list of your portfolio items on your site.', 'viba-portfolio' ) 
		);
		parent::__construct( 'viba_portfolio_widget', _x( 'Viba Portfolio', 'Widget Name', 'viba-portfolio' ), $widget_ops );
		
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
		$number 	= (int) $instance['number'];
		$columns 	= isset( $instance['columns'] ) ? (int) $instance['columns'] : 3;
		$order 		= $instance['order'];
		$orderby 	= $instance['orderby'];
			
		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$query_args = array(
			'post_type' => viba_portfolio()->post_type,
			'posts_per_page' => $number,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => '_viba_portfolio_likes'
		);
		
		$viba_query = new WP_Query( $query_args );

		ob_start();

		if ( $viba_query->have_posts() ) :

			echo '<div class="viba-portfolio-widget-wrapper vp-widget-col-'. $columns .'">';
			while ( $viba_query->have_posts() ) : $viba_query->the_post(); 

				viba_portfolio_widget();

			endwhile; // end of the loop.
			echo '</div>';
			
		else :

			viba_portfolio_get_template( 'no-viba-portfolio-items.php' );

		endif;

		wp_reset_postdata();
		$content = ob_get_clean();	
		echo $content;

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
		$instance['number'] 	= (int) esc_attr( $new_instance['number'] );
		$instance['columns'] 	= (int) $new_instance['columns'];
		$instance['order'] 		= $new_instance['order'];
		$instance['orderby'] 	= $new_instance['orderby'];
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
		$defaults 	= array( 
			'title' 	=> _x( 'Recent Projects', 'Viba Portfolio Widget Title', 'viba-portfolio' ), 
			'number' 	=> 6,
			'columns' 	=> 3,
			'order' 	=> 'desc',
			'orderby' 	=> 'date'
		);
		$instance 	= wp_parse_args( (array) $instance, $defaults );

		$title 		= $instance['title'];
		$number 	= $instance['number'];
		$columns 	= $instance['columns'];
		$order 		= $instance['order'];
		$orderby 	= $instance['orderby'];

		$columns_args = array( '1', '2', '3', '4', '5', '6' );
		$order_args = array(
			'asc' 	=> __( 'ASC', 'viba-portfolio' ),
			'desc' 	=> __( 'DESC', 'viba-portfolio' )
		);
		$orderby_args = array(
			'date' 				=> __( 'Order by date', 'viba-portfolio' ),
			'title' 			=> __( 'Order by title', 'viba-portfolio' ),
			'modified' 			=> __( 'Order by last modified date', 'viba-portfolio' ),
			'rand' 				=> __( 'Random order', 'viba-portfolio' ),
			'menu_order' 		=> __( 'Order by Page Order', 'viba-portfolio' ),
			'meta_value_num' 	=> __( 'Order by likes', 'viba-portfolio' )
		);

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'title' ) .'">'. _x( 'Title:', 'widget title', 'viba-portfolio' ) .'</label>';
			echo '<input class="widefat" id="'. $this->get_field_id( 'title' ) .'" name="'. $this->get_field_name( 'title' ) .'" type="text" value="'. $title .'" />';
		echo '</p>';

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'number' ) .'">'. __( 'Number ot items to show:', 'viba-portfolio' ) .'</label>';
			echo '<input class="widefat" id="'. $this->get_field_id( 'number' ) .'" name="'. $this->get_field_name( 'number' ) .'" type="number" step="1" min="1" max="12" value="'. $number .'" />';
		echo '</p>';

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'columns' ) .'">'. __( 'Columns:', 'viba-portfolio' ) .'</label>';
			echo '<select class="widefat" id="'. $this->get_field_id( 'columns' ) .'" name="'. $this->get_field_name( 'columns' ) .'">';
			foreach ( $columns_args as $value ) {
				echo '<option value="'. $value .'" '. selected( $columns, $value ) .'>'. esc_html( $value ) .'</option>';
			}
			echo '<select>';
		echo '</p>';

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'order' ) .'">'. __( 'Order:', 'viba-portfolio' ) .'</label>';
			echo '<select class="widefat" id="'. $this->get_field_id( 'order' ) .'" name="'. $this->get_field_name( 'order' ) .'">';
			foreach ( $order_args as $key => $value ) {
				echo '<option value="'. $key .'" '. selected( $order, $key ) .'>'. esc_html( $value ) .'</option>';
			}
			echo '<select>';
		echo '</p>';

		echo '<p>';
			echo '<label for="'. $this->get_field_id( 'orderby' ) .'">'. __( 'Order by:', 'viba-portfolio' ) .'</label>';
			echo '<select class="widefat" id="'. $this->get_field_id( 'orderby' ) .'" name="'. $this->get_field_name( 'orderby' ) .'">';
			foreach ( $orderby_args as $key => $value ) {
				echo '<option value="'. $key .'" '. selected( $orderby, $key ) .'>'. esc_html( $value ) .'</option>';
			}
			echo '<select>';
		echo '</p>';

	}
	
}

endif;