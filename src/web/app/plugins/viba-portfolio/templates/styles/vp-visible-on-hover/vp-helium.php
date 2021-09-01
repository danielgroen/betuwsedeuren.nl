<?php
/**
 * Viba Portfolio Visible On Hover Helium Style
 *
 * @package 	Viba_Portfolio/Styles/Visible_On_Hover/Helium
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();

	if ( is_viba_portfolio_overlay() ) :
		
		viba_portfolio_item_overlay();

		echo '<span class="viba-portfolio-helium-overlay"'.
			/**
			 * viba_portfolio_overlay_inline_styles filter
			 *
			 * @hooked viba_portfolio_get_overlay_inline_styles - 10
			 */
			viba_portfolio_inline_styles( 'viba_portfolio_overlay_inline_styles', false ) . '></span>';
			
	endif;
	
	if ( is_viba_portfolio_info() ) :

		echo '<div class="viba-portfolio-cover"'.
				/**
			 	 * viba_portfolio_cover_content_inline_styles filter
			 	 *
			  	 * @hooked viba_portfolio_get_cover_content_inline_styles - 10
			 	 */
				viba_portfolio_inline_styles( 'viba_portfolio_cover_content_inline_styles', false ) . '>';
			echo '<div class="viba-portfolio-cover-content">';
				viba_portfolio_likes();
				viba_portfolio_item_title();
				viba_portfolio_item_categories();
				viba_portfolio_item_description();
				viba_portfolio_item_buttons();
			echo '</div><!-- .viba-portfolio-cover-content -->';
		echo '</div><!-- .viba-portfolio-cover -->';

	endif;

echo '</div><!-- .viba-portfolio-cover-wrapper -->';