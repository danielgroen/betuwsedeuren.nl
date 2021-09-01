<?php
/**
 * Viba Portfolio Filter.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_filter() && ! is_viba_portfolio_taxonomy() && ! is_viba_portfolio_layout( 'carousel' ) && ! is_viba_portfolio_search() ) : 

do_action( 'viba_portfolio_before_filter' ); ?>

<div <?php 
		/**
		 * viba_portfolio_filter_classes filter
		 *
		 * @hooked viba_portfolio_get_filter_classes - 10
		 */
		viba_portfolio_get_classes( 'viba_portfolio_filter_classes' ); ?>>

	<?php

	switch ( viba_portfolio_get_style_option( 'filter-type' ) ) :

		case 'vp-filter-default':
			viba_portfolio_filter_list();
			break;

		case 'vp-filter-slide-in':
			echo '<span class="vp-filter-button">' . viba_portfolio_translate( 'i18n-filter', __( 'Filter', 'viba-portfolio' ) ) . '</span>';
			viba_portfolio_filter_list();
			break;

		case 'vp-filter-dropdown':
			echo '<div class="vp-filter-dropdown-button">';
				echo '<span class="vp-filter-button">' . viba_portfolio_translate( 'i18n-filter', __( 'Filter', 'viba-portfolio' ) ) . '</span>';
				viba_portfolio_filter_list();
			echo '</div>';
			break;
		
		default:
			break;
	
	endswitch;
		
	?>

</div>

<?php do_action( 'viba_portfolio_after_filter' ); 

endif;