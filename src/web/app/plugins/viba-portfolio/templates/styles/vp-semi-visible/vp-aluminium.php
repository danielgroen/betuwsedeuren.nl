<?php
/**
 * Viba Portfolio Semi Visible Aluminium Style
 *
 * @package 	Viba_Portfolio/Styles/Semi_Visible/Aluminium
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();

	viba_portfolio_item_overlay();
	
	if ( is_viba_portfolio_info() ) :

		echo '<div class="viba-portfolio-cover-fixed">';
			echo '<div class="viba-portfolio-cover-content"'.
				/**
			 	 * viba_portfolio_cover_content_inline_styles filter
			 	 *
			  	 * @hooked viba_portfolio_get_cover_content_inline_styles - 10
			 	 */
				viba_portfolio_inline_styles( 'viba_portfolio_cover_content_inline_styles', false ) . '>';

				if ( is_viba_portfolio_info( array( 'likes', 'categories', 'zoom-button', 'link-button' ) ) ) :
				echo '<div class="viba-portfolio-aluminium-content-wrapper">';
					echo '<div class="viba-portfolio-aluminium-content"'.
					/**
				 	 * viba_portfolio_content_inline_styles filter
				 	 *
				  	 * @hooked viba_portfolio_get_content_inline_styles - 10
				 	 */
					viba_portfolio_inline_styles( 'viba_portfolio_content_inline_styles', false ) . '>';
						viba_portfolio_item_categories();
						viba_portfolio_likes();
						viba_portfolio_item_buttons();
					echo '</div><!-- .viba-portfolio-aluminium-content -->';
				echo '</div><!-- .viba-portfolio-aluminium-content-wrapper -->';
				endif;

				if ( is_viba_portfolio_info( array( 'title', 'description' ) ) ) :
				echo '<div class="viba-portfolio-max-height">';
					viba_portfolio_item_title();
					viba_portfolio_item_description();
				echo '</div><!-- .viba-portfolio-max-height -->';
				endif;

			echo '</div><!-- .viba-portfolio-cover-content -->';
		echo '</div><!-- .viba-portfolio-cover -->';

	endif;

echo '</div><!-- .viba-portfolio-cover-wrapper -->';