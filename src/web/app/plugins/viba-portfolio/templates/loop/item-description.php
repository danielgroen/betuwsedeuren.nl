<?php
/**
 * Viba Portfolio Short Description.
 *
 * @package 	Viba_Portfolio/Templates/Loop
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( ! is_viba_portfolio_info( 'description' ) ) return; ?>

<div class="viba-portfolio-short-description">
	<?php echo wpautop( viba_portfolio_get_short_description() ); ?>
</div>