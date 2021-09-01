<?php
/**
 * Viba Portfolio Related Items.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_related() ) : 

	$args = apply_filters( 'viba_portfolio_related_items_args', array(
		'post_type'            => viba_portfolio()->post_type,
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => viba_portfolio_get_related_number(),
		'post__in'             => viba_portfolio_get_related_items()
	) );

	$viba_portfolio_query = new WP_Query( $args ); 

	do_action( 'viba_portfolio_before_related' ); ?>
	
	<div <?php 
		/**
		 * viba_portfolio_wrapper_classes filter
		 *
		 * @hooked viba_portfolio_get_wrapper_classes - 10
		 */
		viba_portfolio_get_classes( 'viba_portfolio_wrapper_classes', true, 'viba-portfolio-related' ); ?>>
		
		<?php if ( apply_filters( 'viba_portfolio_show_related_title', true ) ) : ?>
		
			<h3><?php viba_portfolio_translate( 'i18n-related', __( 'Related Items', 'viba-portfolio' ), true ); ?></h3>
		
		<?php endif;
		
		viba_portfolio_loop_start(); // Outputs the start of a loop. By default this is a opening UL tag
	
			while ( $viba_portfolio_query->have_posts() ) : $viba_portfolio_query->the_post();

				viba_portfolio_get_template_part( 'content', 'viba_portfolio' );

			endwhile; // end of the loop.
			
		viba_portfolio_loop_end(); // Outputs the end of a loop. By default this is a closing UL tag ?>

	</div><?php 

	wp_reset_postdata(); 

	do_action( 'viba_portfolio_after_related' );
	
endif; ?>