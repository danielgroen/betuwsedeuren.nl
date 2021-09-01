<?php
/**
 * Viba Portfolio Gallery.
 *
 * @package 	Viba_Portfolio/Templates/Media
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$gallery_ids = viba_portfolio_get_gallery_images();

if ( $gallery_ids ) : ?>

	<div <?php 
	/**
	 * viba_portfolio_gallery_classes filter
	 *
	 * @hooked viba_portfolio_get_gallery_classes - 10
	 */
	viba_portfolio_get_classes( 'viba_portfolio_gallery_classes' ); ?>>

	<?php foreach ( $gallery_ids as $gallery_id ) {

			$image = wp_get_attachment_image( $gallery_id, apply_filters( 'viba_portfolio_single_thumbnail_size', 'viba_portfolio_single' ) );

			if ( $image ) {
				$image_meta = viba_portfolio_image_meta( $gallery_id );
				echo apply_filters( 'viba_portfolio_gallery_item_html', sprintf( '<div class="viba-portfolio-gallery-item"> %s %s </div>', $image, $image_meta ) );
			}

		}

	?>
	</div>

<?php 
else :
	viba_portfolio_single_thumbnail();
endif; ?>