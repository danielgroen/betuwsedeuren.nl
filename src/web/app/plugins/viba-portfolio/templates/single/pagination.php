<?php
/**
 * Viba Portfolio Pagination.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'viba_portfolio_before_single_pagination' ); ?>

<div class="viba-portfolio-single-pagination">
	
	<?php 
	if ( get_previous_post() ) {
		echo '<div class="vp-pagination-single-arrow vp-nav-previous">';
		previous_post_link( '%link', '<span>%title</span>', apply_filters( 'viba_portfolio_single_pagination_same_term', false ), apply_filters( 'viba_portfolio_single_pagination_excluded_terms', '' ), viba_portfolio()->category_taxonomy );
		echo '</div>';
	}

	if ( viba_portfolio_get_archive_page() || apply_filters( 'viba_portfolio_single_pagination_archive', false ) ) { 
		echo '<a class="vp-pagination-single-archives" href="' . apply_filters( 'viba_portfolio_single_pagination_archive_link', esc_url( get_permalink( viba_portfolio_get_archive_page() ) ) ) .'"><span>' . apply_filters( 'viba_portfolio_single_pagination_archive_title', get_the_title( viba_portfolio_get_archive_page() ) ) .'</span></a>';
	}

	if ( get_next_post_link() ) {
		echo '<div class="vp-pagination-single-arrow vp-nav-next">';
		next_post_link( '%link', '<span>%title</span>', apply_filters( 'viba_portfolio_single_pagination_same_term', false ), apply_filters( 'viba_portfolio_single_pagination_excluded_terms', '' ), viba_portfolio()->category_taxonomy ); 
		echo '</div>';
	}
	?>

</div>

<?php do_action( 'viba_portfolio_after_single_pagination' ); ?>