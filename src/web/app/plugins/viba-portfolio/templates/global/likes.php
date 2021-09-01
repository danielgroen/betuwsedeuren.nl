<?php
/**
 * Viba Portfolio Likes.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( ! is_viba_portfolio_info( 'likes' ) ) return; ?>

<a <?php 
	/**
	 * viba_portfolio_likes_classes filter
	 *
	 * @hooked viba_portfolio_get_likes_classes - 10
	 */
	viba_portfolio_get_classes( 'viba_portfolio_likes_classes' ); ?> data-id="<?php echo get_the_ID(); ?>">
	<span class="viba-portfolio-likes-count"><?php echo viba_portfolio_get_likes(); ?></span>
</a>