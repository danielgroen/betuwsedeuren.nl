<?php
/**
 * The Template for displaying all single portfolios.
 *
 * Override this template by copying it to yourtheme/viba-portfolio/single-viba_portfolio.php
 *
 * @package 	Viba_Portfolio/Templates
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

	<?php
		/**
		 * viba_portfolio_before_main_content hook
		 *
		 * @hooked viba_portfolio_output_content_wrapper - 10 (outputs opening divs for the content)
		 */
		do_action('viba_portfolio_before_main_content');
	?>
	
	<?php while ( have_posts() ) : the_post(); ?>

		<?php viba_portfolio_get_template_part( 'content', 'single-viba_portfolio' ); ?>

	<?php endwhile; // end of the loop. ?>


	<?php
		/**
		 * viba_portfolio_after_main_content hook
		 *
		 * @hooked viba_portfolio_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('viba_portfolio_after_main_content');
	?>

<?php get_footer(); ?>