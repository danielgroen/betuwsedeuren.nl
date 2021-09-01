<?php
/**
 * Viba Portfolio Template Styles
 *
 * Template Styles
 *
 * @package 	Viba_Portfolio/Functions/
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get template styles.
 *
 * Options for template styles.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $template_styles
 */
function viba_portfolio_get_template_styles() {

	$plugin_dir_url = viba_portfolio()->plugin_dir_url;

	$template_styles = array(
		/*===================================================================
			ALWAYS VISIBLE
		*==================================================================*/
		'vp-always-visible' => array(
			'title' => __( 'Always Visible', 'viba-portfolio' ),
			'styles' => array(
				array(
					'title' => __( 'Hydrogen', 'viba-portfolio' ),
					'id' => 'vp-hydrogen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-hydrogen.jpg'
				),
				array(
					'title' => __( 'Helium', 'viba-portfolio' ),
					'id' => 'vp-helium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-helium.jpg'
				),
				array(
					'title' => __( 'Lithium', 'viba-portfolio' ),
					'id' => 'vp-lithium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-lithium.jpg'
				),
				array(
					'title' => __( 'Beryllium', 'viba-portfolio' ),
					'id' => 'vp-beryllium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-beryllium.jpg'
				),
				array(
					'title' => __( 'Boron', 'viba-portfolio' ),
					'id' => 'vp-boron',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-boron.jpg'
				),
				array(
					'title' => __( 'Carbon', 'viba-portfolio' ),
					'id' => 'vp-carbon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-carbon.jpg'
				),
				array(
					'title' => __( 'Nitrogen', 'viba-portfolio' ),
					'id' => 'vp-nitrogen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-nitrogen.jpg'
				),
				array(
					'title' => __( 'Oxygen', 'viba-portfolio' ),
					'id' => 'vp-oxygen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-oxygen.jpg'
				),
				array(
					'title' => __( 'Fluorine', 'viba-portfolio' ),
					'id' => 'vp-fluorine',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-fluorine.jpg'
				),
				array(
					'title' => __( 'Neon', 'viba-portfolio' ),
					'id' => 'vp-neon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-neon.jpg'
				),
				array(
					'title' => __( 'Sodium', 'viba-portfolio' ),
					'id' => 'vp-sodium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-sodium.jpg'
				),
				array(
					'title' => __( 'Magnesium', 'viba-portfolio' ),
					'id' => 'vp-magnesium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-magnesium.jpg'
				),
				array(
					'title' => __( 'Aluminium', 'viba-portfolio' ),
					'id' => 'vp-aluminium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-aluminium.jpg'
				),
				array(
					'title' => __( 'Silicon', 'viba-portfolio' ),
					'id' => 'vp-silicon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-silicon.jpg'
				),
				array(
					'title' => __( 'Phosphorus', 'viba-portfolio' ),
					'id' => 'vp-phosphorus',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-phosphorus.jpg'
				),
				array(
					'title' => __( 'Sulfur', 'viba-portfolio' ),
					'id' => 'vp-sulfur',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-sulfur.jpg'
				),
				array(
					'title' => __( 'Chlorine', 'viba-portfolio' ),
					'id' => 'vp-chlorine',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-chlorine.jpg'
				),
				array(
					'title' => __( 'Argon', 'viba-portfolio' ),
					'id' => 'vp-argon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-argon.jpg'
				),
				array(
					'title' => __( 'Potassium', 'viba-portfolio' ),
					'id' => 'vp-potassium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-potassium.jpg'
				),
				array(
					'title' => __( 'Calcium', 'viba-portfolio' ),
					'id' => 'vp-calcium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/av/av-calcium.jpg'
				),
			)
		),
		/*===================================================================
			SEMI VISIBLE
		*==================================================================*/
		'vp-semi-visible' => array(
			'title' => __( 'Semi Visible', 'viba-portfolio' ),
			'styles' => array(
				array(
					'title' => __( 'Hydrogen', 'viba-portfolio' ),
					'id' => 'vp-hydrogen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-hydrogen.jpg'
				),
				array(
					'title' => __( 'Helium', 'viba-portfolio' ),
					'id' => 'vp-helium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-helium.jpg'
				),
				array(
					'title' => __( 'Lithium', 'viba-portfolio' ),
					'id' => 'vp-lithium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-lithium.jpg'
				),
				array(
					'title' => __( 'Beryllium', 'viba-portfolio' ),
					'id' => 'vp-beryllium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-beryllium.jpg'
				),
				array(
					'title' => __( 'Boron', 'viba-portfolio' ),
					'id' => 'vp-boron',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-boron.jpg'
				),
				array(
					'title' => __( 'Carbon', 'viba-portfolio' ),
					'id' => 'vp-carbon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-carbon.jpg'
				),
				array(
					'title' => __( 'Nitrogen', 'viba-portfolio' ),
					'id' => 'vp-nitrogen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-nitrogen.jpg'
				),
				array(
					'title' => __( 'Oxygen', 'viba-portfolio' ),
					'id' => 'vp-oxygen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-oxygen.jpg'
				),
				array(
					'title' => __( 'Fluorine', 'viba-portfolio' ),
					'id' => 'vp-fluorine',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-fluorine.jpg'
				),
				array(
					'title' => __( 'Neon', 'viba-portfolio' ),
					'id' => 'vp-neon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-neon.jpg'
				),
				array(
					'title' => __( 'Sodium', 'viba-portfolio' ),
					'id' => 'vp-sodium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-sodium.jpg'
				),
				array(
					'title' => __( 'Magnesium', 'viba-portfolio' ),
					'id' => 'vp-magnesium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-magnesium.jpg'
				),
				array(
					'title' => __( 'Aluminium', 'viba-portfolio' ),
					'id' => 'vp-aluminium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-aluminium.jpg'
				),
				array(
					'title' => __( 'Silicon', 'viba-portfolio' ),
					'id' => 'vp-silicon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-silicon.jpg'
				),
				array(
					'title' => __( 'Phosphorus', 'viba-portfolio' ),
					'id' => 'vp-phosphorus',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-phosphorus.jpg'
				),
				array(
					'title' => __( 'Sulfur', 'viba-portfolio' ),
					'id' => 'vp-sulfur',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-sulfur.jpg'
				),
				array(
					'title' => __( 'Chlorine', 'viba-portfolio' ),
					'id' => 'vp-chlorine',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-chlorine.jpg'
				),
				array(
					'title' => __( 'Argon', 'viba-portfolio' ),
					'id' => 'vp-argon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-argon.jpg'
				),
				array(
					'title' => __( 'Potassium', 'viba-portfolio' ),
					'id' => 'vp-potassium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-potassium.jpg'
				),
				array(
					'title' => __( 'Calcium', 'viba-portfolio' ),
					'id' => 'vp-calcium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/sv/sv-calcium.jpg'
				),
			)
		),
		/*===================================================================
			VISIBLE ON HOVER
		*==================================================================*/
		'vp-visible-on-hover' => array(
			'title' => __( 'Visible on Hover', 'viba-portfolio' ),
			'styles' => array(
				array(
					'title' => __( 'Hydrogen', 'viba-portfolio' ),
					'id' => 'vp-hydrogen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-hydrogen.jpg'
				),
				array(
					'title' => __( 'Helium', 'viba-portfolio' ),
					'id' => 'vp-helium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-helium.jpg'
				),
				array(
					'title' => __( 'Lithium', 'viba-portfolio' ),
					'id' => 'vp-lithium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-lithium.jpg'
				),
				array(
					'title' => __( 'Beryllium', 'viba-portfolio' ),
					'id' => 'vp-beryllium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-beryllium.jpg'
				),
				array(
					'title' => __( 'Boron', 'viba-portfolio' ),
					'id' => 'vp-boron',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-boron.jpg'
				),
				array(
					'title' => __( 'Carbon', 'viba-portfolio' ),
					'id' => 'vp-carbon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-carbon.jpg'
				),
				array(
					'title' => __( 'Nitrogen', 'viba-portfolio' ),
					'id' => 'vp-nitrogen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-nitrogen.jpg'
				),
				array(
					'title' => __( 'Oxygen', 'viba-portfolio' ),
					'id' => 'vp-oxygen',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-oxygen.jpg'
				),
				array(
					'title' => __( 'Fluorine', 'viba-portfolio' ),
					'id' => 'vp-fluorine',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-fluorine.jpg'
				),
				array(
					'title' => __( 'Neon', 'viba-portfolio' ),
					'id' => 'vp-neon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-neon.jpg'
				),
				array(
					'title' => __( 'Sodium', 'viba-portfolio' ),
					'id' => 'vp-sodium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-sodium.jpg'
				),
				array(
					'title' => __( 'Magnesium', 'viba-portfolio' ),
					'id' => 'vp-magnesium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-magnesium.jpg'
				),
				array(
					'title' => __( 'Aluminium', 'viba-portfolio' ),
					'id' => 'vp-aluminium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-aluminium.jpg'
				),
				array(
					'title' => __( 'Silicon', 'viba-portfolio' ),
					'id' => 'vp-silicon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-silicon.jpg'
				),
				array(
					'title' => __( 'Phosphorus', 'viba-portfolio' ),
					'id' => 'vp-phosphorus',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-phosphorus.jpg'
				),
				array(
					'title' => __( 'Sulfur', 'viba-portfolio' ),
					'id' => 'vp-sulfur',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-sulfur.jpg'
				),
				array(
					'title' => __( 'Chlorine', 'viba-portfolio' ),
					'id' => 'vp-chlorine',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-chlorine.jpg'
				),
				array(
					'title' => __( 'Argon', 'viba-portfolio' ),
					'id' => 'vp-argon',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-argon.jpg'
				),
				array(
					'title' => __( 'Potassium', 'viba-portfolio' ),
					'id' => 'vp-potassium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-potassium.jpg'
				),
				array(
					'title' => __( 'Calcium', 'viba-portfolio' ),
					'id' => 'vp-calcium',
					'img' => $plugin_dir_url .'includes/admin/assets/img/styles/vh/vh-calcium.jpg'
				),
			)
		),
		
	);

	return apply_filters( 'viba_portfolio_template_styles', $template_styles );
}