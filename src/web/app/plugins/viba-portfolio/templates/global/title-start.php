<?php
/**
 * Viba Portfolio Title Start Wrappers.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$template = get_option( 'template' );

switch( $template ) {
	case 'twentytwelve' :
	case 'twentythirteen' :
	case 'twentyfourteen' :
	case 'twentyfifteen' :
	case 'twentysixteen' :
		echo '<header class="entry-header">';
		break;
	default :
		break;
}