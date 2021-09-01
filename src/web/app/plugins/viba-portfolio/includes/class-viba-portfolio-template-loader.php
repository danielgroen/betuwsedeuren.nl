<?php
/**
 * Template Loader.
 *
 * @package		Viba_Portfolio/Classes
 * @since		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Template_Loader' ) ) :

class Viba_Portfolio_Template_Loader {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'template_include', array( $this, 'template_loader' ) );
	}

	/**
	 * Load a template.
	 *
	 * Handles template usage so that we can use our own templates instead of the themes.
	 *
	 * Templates are in the 'templates' folder. Viba Portfolio looks for theme
	 * overrides in /themes/viba-portfolio/ by default
	 *
	 * For beginners, it also looks for a viba-portfolio.php template first. If the user adds
	 * this to the theme (containing a viba_portfolio_content() inside) this will be used for all templates.
	 *
	 * @param 	mixed $template
	 * @return 	string
	 */
	public function template_loader( $template ) {

		$find = array( 'viba-portfolio.php' );
		$file = '';

		if ( is_viba_portfolio_search() ) {

			$file 	= 'search-viba_portfolio.php';
			$find[] = $file;
			$find[] = viba_portfolio()->custom_template_dir_path . $file;
		
		} elseif ( is_viba_portfolio_single() ) {

			$file 	= 'single-viba_portfolio.php';
			$find[] = $file;
			$find[] = viba_portfolio()->custom_template_dir_path . $file;

		} elseif ( is_viba_portfolio_taxonomy() ) {

			$term = get_queried_object();

			$file 		= 'taxonomy-' . $term->taxonomy . '.php';
			$find[] 	= 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= viba_portfolio()->custom_template_dir_path . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= $file;
			$find[] 	= viba_portfolio()->custom_template_dir_path . $file;

		} elseif ( is_viba_portfolio_page() ) {

			$file 	= 'archive-viba_portfolio.php';
			$find[] = $file;
			$find[] = viba_portfolio()->custom_template_dir_path . $file;

		}

		if ( $file ) {
			$template = locate_template( $find );
			if ( ! $template ) $template = viba_portfolio()->template_dir_path . $file;
		}

		return $template;

	}

}

new Viba_Portfolio_Template_Loader();

endif;