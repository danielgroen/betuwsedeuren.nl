<?php
/**
 * Viba Portfolio Meta.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_meta() ) :

	do_action( 'viba_portfolio_before_single_meta' );

	echo '<div class="viba-portfolio-single-meta">';

		/**
		 * viba_portfolio_single_meta hook
		 *
		 * @hooked viba_portfolio_single_meta_date - 10
		 * @hooked viba_portfolio_single_meta_client - 20
		 * @hooked viba_portfolio_single_meta_categories - 30
		 * @hooked viba_portfolio_single_meta_tags - 40
		 * @hooked viba_portfolio_single_meta_project_link - 50
		 * @hooked viba_portfolio_single_meta_likes - 60
		 * @hooked viba_portfolio_single_meta_share - 70
		**/
		do_action( 'viba_portfolio_single_meta' );

	echo '</div>';

	do_action( 'viba_portfolio_after_single_meta' ); 

endif;