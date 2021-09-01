<?php
/**
 * Viba Portfolio Single Media.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'viba_portfolio_before_single_media' ); ?>

<div class="viba-portfolio-single-media" <?php
	
	/**
	 * viba_portfolio_single_media_data_attr filter
	 *
	 * @hooked viba_portfolio_get_single_media_data_attr - 10
	 */
	viba_portfolio_get_data_attr( 'viba_portfolio_single_media_data_attr' ); ?>>

	<?php switch ( get_post_format( get_the_ID() ) ) {

		case 'gallery':
			viba_portfolio_single_gallery();
			break;

		case 'video':
			viba_portfolio_single_video();
			break;

		case 'audio':
			viba_portfolio_single_audio();
			break;
		
		default:
			viba_portfolio_single_thumbnail();
			break;
	} ?>

</div>

<?php do_action( 'viba_portfolio_after_single_media' ); ?>