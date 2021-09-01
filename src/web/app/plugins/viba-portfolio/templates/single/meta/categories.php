<?php
/**
 * Viba Portfolio Meta Categories.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$categories = viba_portfolio_get_the_term_list( get_the_ID(), viba_portfolio()->category_taxonomy, '<li>', '</li><li>', '</li>', is_viba_portfolio_archive_enabled() );

if ( $categories && is_viba_portfolio_meta( 'categories' ) ) {
	echo '<div class="vp-single-meta viba-portfolio-single-categories">';
	echo '<h3>' . viba_portfolio_translate( 'i18n-meta-categories', __( 'Categories', 'viba-portfolio' ) ) . '</h3>';
	echo '<ul>';
	echo $categories;
	echo '</ul>';
	echo '</div>';
}