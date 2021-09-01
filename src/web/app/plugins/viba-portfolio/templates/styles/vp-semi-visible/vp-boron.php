<?php
/**
 * Viba Portfolio Semi Visible Boron Style
 *
 * @package 	Viba_Portfolio/Styles/Semi_Visible/Boron
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();

	viba_portfolio_item_overlay();
	
	if ( is_viba_portfolio_info( array( 'zoom-button', 'link-button', 'likes', 'categories', 'description' ) ) ) :

		echo '<div class="viba-portfolio-cover"'.
				/**
			 	 * viba_portfolio_cover_content_inline_styles filter
			 	 *
			  	 * @hooked viba_portfolio_get_cover_content_inline_styles - 10
			 	 */
				viba_portfolio_inline_styles( 'viba_portfolio_cover_content_inline_styles', false ) . '>';
			echo '<div class="viba-portfolio-cover-content">';
				viba_portfolio_likes();
				viba_portfolio_item_categories();
				viba_portfolio_item_description();
				viba_portfolio_item_buttons();
			echo '</div><!-- .viba-portfolio-cover-content -->';
		echo '</div><!-- .viba-portfolio-cover -->';

	endif;

echo '</div><!-- .viba-portfolio-cover-wrapper -->';

if ( is_viba_portfolio_info( 'title' ) ) :
		
	echo '<div class="viba-portfolio-content viba-portfolio-arrow">';
		viba_portfolio_item_title();
	echo '</div><!-- .viba-portfolio-content -->';

endif;