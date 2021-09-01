<?php
/**
 * Viba Portfolio Meta Date
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_meta( 'date' ) ) {
	echo '<div class="vp-single-meta viba-portfolio-single-date">';
	echo '<h3>' . viba_portfolio_translate( 'i18n-meta-date', __( 'Date', 'viba-portfolio' ) ) . '</h3>';
	echo '<span>' . get_the_date( apply_filters( 'viba_portfolio_single_date_format', 'F Y' ) ) . '</span>';
	echo '</div>';
}