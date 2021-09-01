<?php
/**
 * Viba Portfolio Shortcode.
 *
 * @package 	Viba_Portfolio/Classes
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Shortcode' ) ) :

class Viba_Portfolio_Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_shortcode( 'viba_portfolio', array( $this, 'shortcode' ) );
		
	}

	/**
	 * Get the shortcode content.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function shortcode( $atts, $content = null, $code ) {

		$atts = shortcode_atts( array(
			'slug' => 'default',
		), $atts, 'viba_portfolio' );
		

		if ( is_viba_portfolio_style_available( $atts['slug'] ) ) {
			viba_portfolio_set_selected_style( $atts['slug'] );
		} else {
			return sprintf( __( 'There is no Viba Portfolio %s style. Please create the style first.', 'viba-portfolio' ), $atts['slug'] );
		}

		$query_args = viba_portfolio_get_query_args();
		$viba_query = new WP_Query( $query_args );

		viba_portfolio_override_value( 'max-num-pages', $viba_query->max_num_pages );

		ob_start();

		if ( $viba_query->have_posts() ) :

			echo '<div ' . 
				/**
				 * viba_portfolio_wrapper_classes filter
				 *
				 * @hooked viba_portfolio_wrapper_classes - 10
				 */
				viba_portfolio_get_classes( 'viba_portfolio_wrapper_classes', false ) . ' ' .
				
				/**
				 * viba_portfolio_wrapper_data_attr filter
				 *
				 * @hooked viba_portfolio_get_wrapper_data_attr - 10
				 */
				viba_portfolio_get_data_attr( 'viba_portfolio_wrapper_data_attr', false ) . '>';

			/**
			 * viba_portfolio_before_loop hook
			 *
			 * @hooked viba_portfolio_filter - 10
			 */
			do_action( 'viba_portfolio_before_loop' );
				
			viba_portfolio_loop_start(); // Outputs the start of a loop. By default this is a opening UL tag 
		
				while ( $viba_query->have_posts() ) : $viba_query->the_post(); 

					viba_portfolio_get_template_part( 'content', 'viba_portfolio' );

				endwhile; // end of the loop.
				
			viba_portfolio_loop_end(); // Outputs the end of a loop. By default this is a closing UL tag

			/**
			 * viba_portfolio_after_loop hook
			 *
			 * @hooked viba_portfolio_pagination - 10
			 */
			do_action( 'viba_portfolio_after_loop' );

			echo '</div>';

		else :

			viba_portfolio_get_template( 'no-viba-portfolio-items.php' );

		endif;

		wp_reset_postdata();
		$content = ob_get_clean();	
		return $content;
	}
}

new Viba_Portfolio_Shortcode();

endif;