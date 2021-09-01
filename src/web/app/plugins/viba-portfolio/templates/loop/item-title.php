<?php
/**
 * Viba Portfolio Item Title.
 *
 * @package 	Viba_Portfolio/Templates/Loop
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( ! is_viba_portfolio_info( 'title' ) ) return; ?>

<h3 class="viba-portfolio-title"><a <?php
	 	/**
		 * viba_portfolio_link_tag_attr filter
		 *
		 * @hooked viba_portfolio_get_link_tag_attr - 10
		 */
		viba_portfolio_get_tag_attr( 'viba_portfolio_link_tag_attr' ); ?>><?php the_title(); ?></a></h3>