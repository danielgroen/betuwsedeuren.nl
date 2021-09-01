<?php
/**
 * Viba Portfolio Title.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php
	/**
	 * viba_portfolio_before_title hook
	 *
	 * @hooked viba_portfolio_title_wrapper - 10 ( outputs opening divs for the title )
	 */
	do_action( 'viba_portfolio_before_title' );
?>

<h1 itemprop="name" class="viba-portfolio-entry-title entry-title"><?php viba_portfolio_the_title(); ?></h1>

<?php
	/**
	 * viba_portfolio_after_title hook
	 *
	 * @hooked viba_portfolio_title_wrapper_end - 10 ( outputs closing divs for the title )
	 */
	do_action( 'viba_portfolio_after_title' );
?>