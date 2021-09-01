<?php
/**
 * Viba Portfolio Loop Start.
 *
 * @package 	Viba_Portfolio/Templates/Loop
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<ul <?php 
	/**
	 * viba_portfolio_container_classes filter
	 *
	 * @hooked viba_portfolio_get_container_classes - 10
	 */
	viba_portfolio_get_classes( 'viba_portfolio_container_classes' );?> <?php
	
	/**
	 * viba_portfolio_container_data_attr filter
	 *
	 * @hooked viba_portfolio_get_container_data_attr - 10
	 */
	viba_portfolio_get_data_attr( 'viba_portfolio_container_data_attr' ); ?>>