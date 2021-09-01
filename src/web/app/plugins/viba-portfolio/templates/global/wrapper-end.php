<?php
/**
 * Viba Portfolio Content End Wrappers.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$template = get_option( 'template' );

switch( $template ) {
	case 'twentytwelve' :
		echo '</div><!-- .entry-content -->';
		echo '</article></div><!-- #content -->';
		echo '</div><!-- #primary -->';
		get_sidebar();
		break;
	case 'twentythirteen' :
		echo '</div><!-- .entry-content -->';
		echo '</article>';
		echo '</div><!-- #content -->';
		echo '</div><!-- #primary -->';
		get_sidebar();
		break;
	case 'twentyfourteen' :
		echo '</div><!-- .entry-content -->';
		echo '</article>';
		echo '</div><!-- #content -->';
		echo '</div><!-- #primary -->';
		get_sidebar( 'content' );
		echo '</div><!-- #main-content -->';
		get_sidebar();
		break;
	case 'twentyfifteen' :
		echo '</div><!-- .entry-content -->';
		echo '</article><!-- #post-## -->';
		echo '</main><!-- .site-main -->';
		echo '</div><!-- .content-area -->';
		break;
	case 'twentysixteen' :
		echo '</div><!-- .entry-content -->';
		echo '</article><!-- #post-## -->';
		echo '</main><!-- .site-main -->';
		echo '</div><!-- .content-area -->';
		get_sidebar(); 
		break;
	default :
		echo '</div></div>';
		break;
}