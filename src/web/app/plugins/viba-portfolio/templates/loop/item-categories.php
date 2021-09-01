<?php
/**
 * Viba Portfolio Categories.
 *
 * @package 	Viba_Portfolio/Templates/Loop
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( ! is_viba_portfolio_info( 'categories' ) ) return; 

$viba_portfolio_categories = get_the_terms( get_the_id(), viba_portfolio()->category_taxonomy ); 
if ( empty( $viba_portfolio_categories ) ) return;
?>
<div class="viba-portfolio-categories">
	<?php foreach ( $viba_portfolio_categories as $cat ) {
		echo '<span>' . $cat->name . '</span>';
	} ?>
</div>