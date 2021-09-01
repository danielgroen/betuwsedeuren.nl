<?php
/**
 * Viba Portfolio Meta Client.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$client 		= esc_attr( get_post_meta( get_the_ID(), '_viba_portfolio_client', true ) );
$client_url 	= esc_url( get_post_meta( get_the_ID(), '_viba_portfolio_client_url', true ) );

if ( $client && is_viba_portfolio_meta( 'client' ) ) {
	echo '<div class="vp-single-meta viba-portfolio-single-client">';
	echo '<h3>' . viba_portfolio_translate( 'i18n-meta-client', __( 'Client', 'viba-portfolio' ) ) . '</h3>';
	if ( $client_url ) {
		echo '<span><a target="_blank" href="' . $client_url . '">' . $client . '</a></span>';
	} else {
		echo '<span>' . $client . '</span>';
	}
	echo '</div>';
}	