<?php
/**
 * Viba Portfolio Overlay.
 *
 * @package 	Viba_Portfolio/Templates/Loop
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( is_viba_portfolio_overlay() ) :
	echo '<span class="viba-portfolio-overlay"'.
		/**
		 * viba_portfolio_overlay_inline_styles filter
		 *
		 * @hooked viba_portfolio_get_overlay_inline_styles - 10
		 */
		viba_portfolio_inline_styles( 'viba_portfolio_overlay_inline_styles', false ) . '></span>';

endif;