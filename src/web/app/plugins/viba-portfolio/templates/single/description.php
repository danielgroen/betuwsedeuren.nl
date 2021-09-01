<?php
/**
 * Viba Portfolio Description.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! get_the_content() ) return; ?>
<div class="viba-portfolio-single-description" itemprop="description">
	<?php the_content(); ?>
</div>