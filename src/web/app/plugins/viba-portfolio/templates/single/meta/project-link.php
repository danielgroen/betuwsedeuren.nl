<?php
/**
 * Viba Portfolio Meta Categories.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$project_url = esc_url( get_post_meta( get_the_ID(), '_viba_portfolio_project_url', true ) );

if ( $project_url && is_viba_portfolio_meta( 'project-link' ) ) {
	$project_text = viba_portfolio_translate( 'i18n-meta-project-link', __( 'View Project', 'viba-portfolio' ) );
	$project_link = '<a target="_blank" href="' . $project_url . '">' . $project_text . '</a>';
	echo '<div class="viba-portfolio-single-project-link">';
	echo apply_filters( 'viba_portfolio_project_link', $project_link, $project_url, $project_text );
	echo '</div>';
}