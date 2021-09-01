<?php
/**
 * Extend Visual Composer by adding our shortcode
 *
 * @package 	Viba_Portfolio/Functions/Supported_Plugins
 * @since 	    1.0
 * @author 		apalodi
 */

/**
 * Fix for Visual Composer Shortcodes not Rendering with Ajax.
 *
 * @since 	1.7.3
 * @access 	public
 */
function viba_portfolio_ajax_fix_for_visual_composer() {

	if ( class_exists( 'Vc_Manager' ) && is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		WPBMap::addAllMappedShortcodes();
		add_filter( 'the_content', array( 'Vc_Base', 'fixPContent' ), 11 );
	}

}
add_action( 'viba_portfolio_before_single', 'viba_portfolio_ajax_fix_for_visual_composer' );

/**
 * Add Viba Portfolio to Visual Composer.
 *
 * @since 	1.0
 * @access 	public
 */
function viba_portfolio_extend_visual_composer() {
	global $viba_portfolio_options;	
		
	$temp_styles = isset( $viba_portfolio_options['portfolio-style']['styles'] ) ? $viba_portfolio_options['portfolio-style']['styles'] : array();		
	$styles = array();

	if ( ! empty( $temp_styles ) && is_array( $temp_styles ) ) {
		foreach ( $temp_styles as $slug => $style ) {
			$styles[$style['title']] = $slug;
		}
	}
		
	vc_map( array(
		'name' => _x( 'Viba Portfolio', 'Visual Composer Title', 'viba-portfolio' ),
		'description' => _x( 'Advanced portfolio to showcase your work beatifully', 'Visual Composer Description', 'viba-portfolio' ),
		'base' => 'viba_portfolio',
		'category' => _x( 'Content', 'Visual Composer Category', 'viba-portfolio' ),	
		'class' => '',
		'controls' => 'full',
		'icon'		=> 'icon-wpb-viba-portfolio',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => _x( 'Viba Portfolio', 'Visual Composer Shortcode Heading', 'viba-portfolio' ),
				'param_name' => 'slug',
				'value' => $styles,
				'description' => _x( 'Select portfolio', 'Visual Composer Shortcode Description', 'viba-portfolio' ),
				'admin_label' => true
			)
		)
	));

}
add_action( 'vc_before_init', 'viba_portfolio_extend_visual_composer' );