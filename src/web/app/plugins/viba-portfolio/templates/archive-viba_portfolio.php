<?php
/**
 * The Template for displaying archives, including the main page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/viba-portfolio/archive-viba_portfolio.php
 *
 * @package 	Viba_Portfolio/Templates
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'viba_portfolio' ); ?>

	<?php
		/**
		 * viba_portfolio_before_main_content hook
		 *
		 * @hooked viba_portfolio_output_content_wrapper - 10 (outputs opening divs for the content)
		 */
		do_action( 'viba_portfolio_before_main_content' );
	?>

		<?php if ( apply_filters( 'viba_portfolio_show_page_title', true ) ) : ?>
				<?php viba_portfolio_title(); ?>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			
			<div <?php 
				/**
				 * viba_portfolio_wrapper_classes filter
				 *
				 * @hooked viba_portfolio_get_wrapper_classes - 10
				 */
				viba_portfolio_get_classes( 'viba_portfolio_wrapper_classes' ); ?> <?php
				/**
				 * viba_portfolio_wrapper_data_attr filter
				 *
				 * @hooked viba_portfolio_get_wrapper_data_attr - 10
				 */
				viba_portfolio_get_data_attr( 'viba_portfolio_wrapper_data_attr' ); ?>>

			<?php 
				/**
				 * viba_portfolio_before_loop hook
				 *
				 * @hooked viba_portfolio_filter - 10
				 */
				do_action( 'viba_portfolio_before_loop' ); 
			?>
			
			<?php viba_portfolio_loop_start(); // Outputs the start of a loop. By default this is a opening UL tag ?>
	
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php viba_portfolio_get_template_part( 'content', 'viba_portfolio' ); ?>

				<?php endwhile; // end of the loop. ?>
			
			<?php viba_portfolio_loop_end(); // Outputs the end of a loop. By default this is a closing UL tag ?>

			<?php 
				/**
				 * viba_portfolio_after_loop hook
				 *
				 * @hooked viba_portfolio_pagination - 10
				 */
				do_action( 'viba_portfolio_after_loop' ); 
			?>

			</div>

		<?php else : ?>

			<?php viba_portfolio_get_template( 'no-viba-portfolio-items.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * viba_portfolio_after_main_content hook
		 *
		 * @hooked viba_portfolio_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'viba_portfolio_after_main_content' );
	?>

<?php get_footer( 'viba_portfolio' ); ?>