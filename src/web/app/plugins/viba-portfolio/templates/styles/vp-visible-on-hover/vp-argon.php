<?php
/**
 * Viba Portfolio Visible On Hover Argon Style
 *
 * @package 	Viba_Portfolio/Styles/Visible_On_Hover/Argon
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();
		
	viba_portfolio_item_overlay();
	
	if ( is_viba_portfolio_info() ) :

		echo '<div class="viba-portfolio-cover">';
			echo '<div class="viba-portfolio-cover-content"'.
				/**
			 	 * viba_portfolio_cover_content_inline_styles filter
			 	 *
			  	 * @hooked viba_portfolio_get_cover_content_inline_styles - 10
			 	 */
				viba_portfolio_inline_styles( 'viba_portfolio_cover_content_inline_styles', false ) . '>';
				
				if ( is_viba_portfolio_info( array( 'title', 'likes' ) ) ) :
					echo '<div class="viba-portfolio-argon-wrapper">';
						echo '<div class="viba-portfolio-argon-content"'.
						/**
					 	 * viba_portfolio_content_inline_styles filter
					 	 *
					  	 * @hooked viba_portfolio_get_content_inline_styles - 10
					 	 */
						viba_portfolio_inline_styles( 'viba_portfolio_content_inline_styles', false ) . '>';

						viba_portfolio_item_title();
						viba_portfolio_likes();

						echo '</div><!-- .viba-portfolio-argon-content -->';
					echo '</div><!-- .viba-portfolio-argon-wrapper -->';
				endif;

				viba_portfolio_item_categories();
				viba_portfolio_item_description();
				viba_portfolio_item_buttons();

			echo '</div><!-- .viba-portfolio-cover-content -->';
		echo '</div><!-- .viba-portfolio-cover -->';

	endif;

echo '</div><!-- .viba-portfolio-cover-wrapper -->';