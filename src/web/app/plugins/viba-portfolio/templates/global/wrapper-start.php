<?php
/**
 * Viba Portfolio Content Start Wrappers.
 *
 * @package 	Viba_Portfolio/Templates/Global
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$template = get_option( 'template' );

switch( $template ) {
	case 'twentytwelve' :
		echo '<div id="primary" class="site-content vp-twentytwelve">';
		echo '<div id="content" role="main">';
		echo '<article class="hentry">';
		echo '<div class="entry-content">';
		break;
	case 'twentythirteen' :
		echo '<div id="primary" class="content-area vp-twentythirteen">';
		echo '<div id="content" class="site-content" role="main">';
		echo '<article class="hentry">';
		echo '<div class="entry-content">';
		break;
	case 'twentyfourteen' :
		echo '<div id="main-content" class="main-content vp-twentyfourteen">';
		echo '<div id="primary" class="content-area">';
		echo '<div id="content" class="site-content" role="main">';
		echo '<article class="hentry">';
		echo '<div class="entry-content">';
		break;
	case 'twentyfifteen' :
		echo '<div id="primary" class="content-area vp-twentyfifteen">';
		echo '<main id="main" class="site-main" role="main">';
		echo '<article class="hentry">';
		echo '<div class="entry-content">';
		break;
	case 'twentysixteen' :
		echo '<div id="primary" class="content-area vp-twentysixteen">';
		echo '<main id="main" class="site-main" role="main">';
		echo '<article class="hentry">';
		echo '<div class="entry-content">';
		break;
	default :
		echo '<div id="container" class="container"><div id="content" class="content site-content" role="main">';
		break;
}