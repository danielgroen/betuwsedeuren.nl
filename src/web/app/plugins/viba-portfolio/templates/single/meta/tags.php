<?php
/**
 * Viba Portfolio Meta Tags.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$tags = viba_portfolio_get_the_term_list( get_the_ID(), viba_portfolio()->tag_taxonomy, '<li>', '</li><li>', '</li>', is_viba_portfolio_archive_enabled() );

if ( $tags && is_viba_portfolio_meta( 'tags' ) ) {
	echo '<div class="vp-single-meta viba-portfolio-single-tags">';
	echo '<h3>' . viba_portfolio_translate( 'i18n-meta-tags', __( 'Tags', 'viba-portfolio' ) ) . '</h3>';
	echo '<ul>';
	echo $tags;
	echo '</ul>';
	echo '</div>';
}