<?php
/**
 * Viba Portfolio Semi Visible Neon Style
 *
 * @package 	Viba_Portfolio/Styles/Semi_Visible/Neon
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();

	viba_portfolio_item_overlay();
	
	if ( is_viba_portfolio_info( array( 'zoom-button', 'link-button',  ) ) ) :

		echo '<div class="viba-portfolio-cover viba-portfolio-js-height"'.
				/**
			 	 * viba_portfolio_cover_content_inline_styles filter
			 	 *
			  	 * @hooked viba_portfolio_get_cover_content_inline_styles - 10
			 	 */
				viba_portfolio_inline_styles( 'viba_portfolio_cover_content_inline_styles', false ) . '>';
			echo '<div class="viba-portfolio-cover-content">';
				viba_portfolio_item_buttons();
			echo '</div><!-- .viba-portfolio-cover-content -->';
		echo '</div><!-- .viba-portfolio-cover -->';

	endif;

echo '</div><!-- .viba-portfolio-cover-wrapper -->';

if ( is_viba_portfolio_info( array( 'title', 'likes', 'categories', 'description' ) ) ) :

	echo '<div class="viba-portfolio-content viba-portfolio-neon-content  viba-portfolio-arrow"'.
		/**
		 * viba_portfolio_content_inline_styles filter
		 *
		 * @hooked viba_portfolio_get_content_inline_styles - 10
		 */
		viba_portfolio_inline_styles( 'viba_portfolio_content_inline_styles', false ) . '>';
		viba_portfolio_likes();
		viba_portfolio_item_title();
		if ( is_viba_portfolio_info( array( 'categories', 'description' ) ) ) :
			echo '<div class="viba-portfolio-max-height">';
				viba_portfolio_item_categories();
				viba_portfolio_item_description();
			echo '</div><!-- .viba-portfolio-max-height -->';
		endif;
	echo '</div><!-- .viba-portfolio-content -->';

endif;