<?php
/**
 * Viba Portfolio Always Visible Potassium Style
 *
 * @package 	Viba_Portfolio/Styles/Always_Visible/Potassium
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_info( 'title' ) ) :
		
	echo '<div class="viba-portfolio-content viba-portfolio-potassium-content-top">';
		viba_portfolio_item_title();
	echo '</div><!-- .viba-portfolio-content -->';

endif;

echo '<div class="viba-portfolio-cover-wrapper">';

	viba_portfolio_item_media();
		
	viba_portfolio_item_overlay();

echo '</div><!-- .viba-portfolio-cover-wrapper -->';

if ( is_viba_portfolio_info( array( 'likes', 'zoom-button', 'link-button', 'categories', 'description' ) ) ) :
		
	echo '<div class="viba-portfolio-content viba-portfolio-potassium-content-bottom">';
		viba_portfolio_likes();
		viba_portfolio_item_buttons();
		viba_portfolio_item_categories();
		viba_portfolio_item_description();
	echo '</div><!-- .viba-portfolio-content -->';

endif;