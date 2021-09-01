<?php
/**
 * Viba Portfolio Filter Widget
 *
 * @package 	Viba_Portfolio/Templates/Widgets
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="viba-portfolio-filter viba-portfolio-widget-filter">
    <ul class="viba-portfolio-filter-list">
        <?php
        echo '<li><a data-isotope-filter="*" class="selected">' . viba_portfolio_translate( 'i18n-filter-all', __( 'All', 'viba-portfolio') ) . '</a></li>';
        foreach ( $terms as $slug => $name ) :
            echo '<li><a data-isotope-filter=".vp-term-' . $slug . '">' . esc_attr( $name ) . '</a></li>';
        endforeach; ?> 
    </ul>
</div>
