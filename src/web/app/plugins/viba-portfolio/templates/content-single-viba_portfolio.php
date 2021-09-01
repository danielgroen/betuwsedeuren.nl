<?php
/**
 * The template for displaying content in the single-viba_portfolio.php template.
 *
 * Override this template by copying it to yourtheme/viba-portfolio/content-single-viba_portfolio.php
 *
 * @package 	Viba_Portfolio/Templates
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

do_action( 'viba_portfolio_before_single' ); ?>

<div id="viba-portfolio-item-<?php the_ID(); ?>" <?php 
	/**
	 * viba_portfolio_item_classes filter
	 *
	 * @hooked viba_portfolio_get_item_classes - 10
	 */
	viba_portfolio_get_classes( 'viba_portfolio_item_classes', true, array( 'viba-portfolio-single-item', 'vp-style-default' ) ); ?>>
	
	<?php  if ( post_password_required() ) : ?>
			
		<?php
			/**
			 * viba_portfolio_before_password_required hook
			 *
			 * @hooked viba_portfolio_title - 10
			 */
			do_action( 'viba_portfolio_before_password_required' );
		?>
			
		<?php
			/**
			 * viba_portfolio_password_required hook
			 *
			 * @hooked viba_portfolio_password_form - 10
			 */
			do_action( 'viba_portfolio_password_required' );
		?>

		<?php do_action( 'viba_portfolio_after_password_required' ); ?>

	<?php else : ?>

		<?php
			/**
			 * viba_portfolio_before_single_content hook
			 *
			 * @hooked viba_portfolio_title - 10
			 * @hooked viba_portfolio_single_media - 20
			 */
			do_action( 'viba_portfolio_before_single_content' );
		?>

		<div class="viba-portfolio-single-content">

			<?php
				/**
				 * viba_portfolio_single_content hook
				 *
				 * @hooked viba_portfolio_single_description - 10
				 * @hooked viba_portfolio_single_meta - 20
				 */
				do_action( 'viba_portfolio_single_content' );
			?>

		</div><!-- .viba-portfolio-single-content -->

	<?php endif; ?>

</div><!-- #viba-portfolio-item-<?php the_ID(); ?> -->

<?php if ( ! post_password_required() ) :

	/**
	 * viba_portfolio_after_single_content hook
	 *
	 * @hooked viba_portfolio_single_pagination - 10
	 * @hooked viba_portfolio_related - 20
	 */
	do_action( 'viba_portfolio_after_single_content' ); 

endif; ?>

<?php do_action( 'viba_portfolio_after_single' ); ?>