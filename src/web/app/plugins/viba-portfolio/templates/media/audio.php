<?php
/**
 * Viba Portfolio Audio.
 *
 * @package 	Viba_Portfolio/Templates/Media
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="viba-portfolio-audio">
	<?php 
		if ( is_viba_portfolio_audio_thumbnail() ) {
			viba_portfolio_single_thumbnail();
		} 
		
		if ( viba_portfolio_get_audio() ) {
			foreach ( viba_portfolio_get_audio() as $audio ) {
				echo '<div class="viba-portfolio-audio-item">';
				echo apply_filters( 'the_content', $audio );
				echo '</div>';
			}
		}
	?>
</div>