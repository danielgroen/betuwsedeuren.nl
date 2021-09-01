<?php
/**
 * Viba Portfolio Single Thumbnail.
 *
 * @package 	Viba_Portfolio/Templates/Media
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="viba-portfolio-single-thumbnail">
	<?php 
		the_post_thumbnail( apply_filters( 'viba_portfolio_single_thumbnail_size', 'viba_portfolio_single' ) ); 
		echo viba_portfolio_image_meta( get_post_thumbnail_id( get_the_ID() ) );
	?>
</div>