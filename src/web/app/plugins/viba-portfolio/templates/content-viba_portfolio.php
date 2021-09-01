<?php
/**
 * The Template for displaying portfolio items within loops.
 *
 * Override this template by copying it to yourtheme/viba-portfolio/content-viba_portfolio.php
 *
 * @package 	Viba_Portfolio/Templates
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<li <?php 
	/**
	 * viba_portfolio_item_classes filter
	 *
	 * @hooked viba_portfolio_get_item_classes - 10
	 */
	viba_portfolio_get_classes( 'viba_portfolio_item_classes' ); ?>>

	<div <?php 
	/**
	 * viba_portfolio_item_inner_classes filter
	 *
	 * @hooked viba_portfolio_get_item_inner_classes - 10
	 */
	viba_portfolio_get_classes( 'viba_portfolio_item_inner_classes' ); ?>>
		
		<?php viba_portfolio_get_style_template( viba_portfolio_get_template_skin() ); ?>
	
	</div>

</li>