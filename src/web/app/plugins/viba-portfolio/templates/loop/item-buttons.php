<?php
/**
 * Viba Portfolio Buttons.
 *
 * @package 	Viba_Portfolio/Templates/Loop
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( ! is_viba_portfolio_info( 'link-button' ) && ! is_viba_portfolio_info( 'zoom-button' ) ) return; ?>

<div class="viba-portfolio-buttons-wrapper">

	<?php if ( is_viba_portfolio_info( 'zoom-button' ) ) : ?>
		<a <?php
	 	/**
		 * viba_portfolio_zoom_button_tag_attr filter
		 *
		 * @hooked viba_portfolio_get_zoom_button_tag_attr - 10
		 */
		viba_portfolio_get_tag_attr( 'viba_portfolio_zoom_button_tag_attr', true, array( 'class' => array( 'viba-portfolio-item-button', 'vp-zoom-button' ) ) ); ?>><span><?php viba_portfolio_translate( 'i18n-button-zoom', __( 'Zoom', 'viba-portfolio' ), true ); ?></span></a>
	<?php endif; ?>

	<?php if ( is_viba_portfolio_info( 'link-button' ) ) : ?>
		<a <?php
	 	/**
		 * viba_portfolio_link_tag_attr filter
		 *
		 * @hooked viba_portfolio_get_link_tag_attr - 10
		 */
		viba_portfolio_get_tag_attr( 'viba_portfolio_link_tag_attr', true, array( 'class' => array( 'viba-portfolio-item-button', 'vp-link-button' ) ) ); ?>><span><?php viba_portfolio_translate( 'i18n-button-link', __( 'Case Study', 'viba-portfolio' ), true ); ?></span></a>
	<?php endif; ?>

</div>