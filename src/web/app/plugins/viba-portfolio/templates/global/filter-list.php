<?php
/**
 * Viba Portfolio Filter List.
 *
 * @package 	Viba_Portfolio/Templates
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<ul class="viba-portfolio-filter-list" data-isotope-key="viba-portflio-filter">

	<?php
	$terms = viba_portfolio_get_filter_terms();
	echo '<li><a data-isotope-filter="*" class="selected">' . viba_portfolio_translate( 'i18n-filter-all', __( 'All', 'viba-portfolio') ) . '</a></li>';
	foreach ( $terms as $slug => $name ) :
		echo '<li><a data-isotope-filter=".vp-term-' . $slug . '">' . esc_attr( $name ) . '</a></li>';
	endforeach; ?>

</ul>
