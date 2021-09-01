<?php
/**
 * Viba Portfolio Pagination.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_pagination() && ! is_viba_portfolio_layout( 'carousel' ) ) : 

do_action( 'viba_portfolio_before_pagination' ); ?>

<div <?php 
		/**
		 * viba_portfolio_pagination_classes filter
		 *
		 * @hooked viba_portfolio_get_pagination_classes - 10
		 */
		viba_portfolio_get_classes( 'viba_portfolio_pagination_classes' ); ?>>

	<?php

	switch ( viba_portfolio_get_style_option( 'pagination-type' ) ) :

		case 'vp-pagination-numbers':
			echo paginate_links( apply_filters( 'viba_portfolio_pagination_numbers_args', array(
				'base'         => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
				'format'       => '',
				'current'      => viba_portfolio_get_paged(),
				'total'        => viba_portfolio_get_max_num_pages(),
				'prev_text'    => '&laquo;',
				'next_text'    => '&raquo;',
				'type'         => 'list',
				'end_size'     => 1,
				'mid_size'     => 2
			) ) );
			break;

		case 'vp-pagination-arrows':
			echo '<div class="vp-pagination-arrow vp-nav-previous">' . get_previous_posts_link( '<span>' . viba_portfolio_translate( 'i18n-pagination-prev', __( '&laquo; Previous', 'viba-portfolio' ) ) . '</span>' ) . '</div>';
			echo '<div class="vp-pagination-arrow vp-nav-next">' . get_next_posts_link( '<span>' . viba_portfolio_translate( 'i18n-pagination-next', __( 'Next &raquo;', 'viba-portfolio' ) ) . '</span>', viba_portfolio_get_max_num_pages() ) . '</div>';
			echo '<span class="vp-pagination-arrow-desc">' . sprintf( viba_portfolio_translate( 'i18n-pagination-pages', __( 'Page %1$d of %2$d', 'viba-portfolio' ) ), viba_portfolio_get_paged(), viba_portfolio_get_max_num_pages() ) . '</span>';
			break;

		case 'vp-pagination-load-more':
			echo '<a class="vp-load-more"' . 
				/**
				 * viba_portfolio_load_more_data_attr filter
				 *
				 * @hooked viba_portfolio_get_load_more_data_attr - 10
				 */
				viba_portfolio_get_data_attr( 'viba_portfolio_load_more_data_attr', false ) . '><span class="vp-load-more-loader"></span><span class="vp-load-more-text">' . viba_portfolio_translate( 'i18n-load-more', __( 'Load more', 'viba-portfolio' ) ) . '</span></a>';
			break;
		
		default:
			break;
	
	endswitch;
		
	?>

</div>

<?php do_action( 'viba_portfolio_after_pagination' ); 

endif;