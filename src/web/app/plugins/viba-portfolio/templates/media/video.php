<?php
/**
 * Viba Portfolio Video.
 *
 * @package 	Viba_Portfolio/Templates/Media
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( viba_portfolio_get_video() ) : ?>

<div class="viba-portfolio-video">
	<?php
	
	foreach ( viba_portfolio_get_video() as $key => $video ) {
		$video_class = ( 'playlist' == strval( $key ) ) ? ' vp-video-playlist' : ' vp-video-item';
		echo '<div class="viba-portfolio-video-item' . $video_class . '">';
		echo apply_filters( 'the_content', $video );
		echo '</div>';
	}

	?>
</div>

<?php
else :
	viba_portfolio_single_thumbnail();
endif;