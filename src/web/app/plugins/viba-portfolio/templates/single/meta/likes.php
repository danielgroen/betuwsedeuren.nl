<?php
/**
 * Viba Portfolio Meta Likes.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_meta( 'likes' ) ) {
	viba_portfolio_likes();
}