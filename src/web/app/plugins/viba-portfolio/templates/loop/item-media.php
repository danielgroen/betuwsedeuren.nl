<?php
/**
 * Viba Portfolio Media.
 *
 * @package 	Viba_Portfolio/Templates/Loop
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

do_action( 'viba_portfolio_before_media' ); ?>

<div class="viba-portfolio-media">
		
	<a <?php
	 	/**
		 * viba_portfolio_link_tag_attr filter
		 *
		 * @hooked viba_portfolio_get_link_tag_attr - 10
		 */
		viba_portfolio_get_tag_attr( 'viba_portfolio_link_tag_attr' ); ?>>

		<?php the_post_thumbnail( viba_portfolio_get_thumbnail_size(), array( 'class' => 'viba-portfolio-thumbnail' ) ); ?>
			
	</a>

</div><!-- .viba-portfolio-media -->

<?php do_action( 'viba_portfolio_after_media' ); ?>