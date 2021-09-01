<?php
/**
 * The Template for displaying portfolio items in a category. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/viba-potfolio/taxonomy-viba_portfolio_category.php
 *
 * @package 	Viba_Portfolio/Templates
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

viba_portfolio_get_template( 'archive-viba_portfolio.php' );