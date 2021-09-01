<?php
/**
 * Viba Portfolio Searchform.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

$format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';
$format = apply_filters( 'search_form_format', $format );

$text = viba_portfolio_translate( 'i18n-searchform', __( 'Search portfolios', 'viba-portfolio' ) );
$search_text = array(
	'label' 		=> $text,
	'placeholder' 	=> $text,
	'button' 		=> $text
);

if ( 'html5' == $format ) {

$form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
			<label>
				<span class="screen-reader-text">' . $search_text['label'] . '</span>
				<input type="search" class="search-field" placeholder="' . $search_text['placeholder'] . '" value="' . get_search_query() . '" name="s" />
			</label>
			<input type="submit" class="search-submit" value="'. $search_text['button'] .'" />
			<input type="hidden" name="post_type" value="' . viba_portfolio()->post_type . '" />
		</form>';

} else {

$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
			<div>
				<label class="screen-reader-text" for="s">' . $search_text['label'] . '</label>
				<input type="text" value="' . get_search_query() . '" name="s" id="s" />
				<input type="submit" id="searchsubmit" value="'. $search_text['button'] .'" />
				<input type="hidden" name="post_type" value="' . viba_portfolio()->post_type . '" />
			</div>
		</form>';
}

echo apply_filters( 'viba_portfolio_searchform', $form, $search_text );