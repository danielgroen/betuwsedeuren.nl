<?php
/**
 * Viba Portfolio Visible On Hover Silicon Style
 *
 * @package 	Viba_Portfolio/Styles/Visible_On_Hover/Silicon
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();

	viba_portfolio_item_overlay();
	
	if ( is_viba_portfolio_info() ) :

		echo '<div class="viba-portfolio-cover-fixed">';
			echo '<div class="viba-portfolio-cover-content viba-portfolio-silicon-content viba-portfolio-arrow"'.
				/**
			 	 * viba_portfolio_content_inline_styles filter
			 	 *
			  	 * @hooked viba_portfolio_get_content_inline_styles - 10
			 	 */
				viba_portfolio_inline_styles( 'viba_portfolio_content_inline_styles', false ) . '>';
	
				echo '<div class="viba-portfolio-max-height">';
					viba_portfolio_likes();		
					viba_portfolio_item_title();
					viba_portfolio_item_categories();
					viba_portfolio_item_description();
					viba_portfolio_item_buttons();
				echo '</div><!-- .viba-portfolio-max-height -->';

			echo '</div><!-- .viba-portfolio-cover-content -->';
		echo '</div><!-- .viba-portfolio-cover -->';

	endif;

echo '</div><!-- .viba-portfolio-cover-wrapper -->';