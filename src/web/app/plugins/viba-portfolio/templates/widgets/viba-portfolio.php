<?php
/**
 * Viba Portfolio Widget
 *
 * @package 	Viba_Portfolio/Templates/Widgets
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="viba-portfolio-widget-item">
	<a <?php
	 	/**
		 * viba_portfolio_link_tag_attr filter
		 *
		 * @hooked viba_portfolio_get_link_tag_attr - 10
		 */
		viba_portfolio_get_tag_attr( 'viba_portfolio_link_tag_attr' ); ?>><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'viba-portfolio-widget-thumbnail' ) ); ?></a>
</div>