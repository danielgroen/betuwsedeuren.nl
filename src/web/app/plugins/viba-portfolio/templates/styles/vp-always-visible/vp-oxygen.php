<?php
/**
 * Viba Portfolio Always Visible Oxygen Style
 *
 * @package 	Viba_Portfolio/Styles/Always_Visible/Oxygen
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_info( array( 'likes', 'title', 'categories', 'description' ) ) ) :
		
	echo '<div class="viba-portfolio-content viba-portfolio-arrow">';
		viba_portfolio_likes();
		viba_portfolio_item_title();
		viba_portfolio_item_categories();
		viba_portfolio_item_description();
	echo '</div><!-- .viba-portfolio-content -->';

endif;

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();

	viba_portfolio_item_overlay();
	
	if ( is_viba_portfolio_info( array( 'zoom-button', 'link-button' ) ) ) :

		echo '<div class="viba-portfolio-cover">';
			echo '<div class="viba-portfolio-cover-content"'.
				/**
			 	 * viba_portfolio_cover_content_inline_styles filter
			 	 *
			  	 * @hooked viba_portfolio_get_cover_content_inline_styles - 10
			 	 */
				viba_portfolio_inline_styles( 'viba_portfolio_cover_content_inline_styles', false ) . '>';
				viba_portfolio_item_buttons();
			echo '</div><!-- .viba-portfolio-cover-content -->';
		echo '</div><!-- .viba-portfolio-cover -->';

	endif;

echo '</div><!-- .viba-portfolio-cover-wrapper -->';