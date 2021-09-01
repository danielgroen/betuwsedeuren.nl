<?php
/**
 * Viba Portfolio Enqueue Frontend Styles and Scripts.
 *
 * @package 	Viba_Portfolio/Classes
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Frontend_Scripts' ) ) :

class Viba_Portfolio_Frontend_Scripts {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'localize_scripts' ), 30 );
		add_action( 'wp_head', array( __CLASS__, 'head_scripts' ), 0 );
		add_action( 'wp_head', array( __CLASS__, 'custom_css' ) );
	}

	/**
	 * Add styles CSS to head.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public static function custom_css() {

		if ( ! wp_style_is( 'viba-portfolio-custom', 'enqueued' ) && ( is_viba_portfolio_loading_all_scripts() || is_viba_portfolio() || is_viba_portfolio_shortcode_active() ) ) {
			echo '
			<style type="text/css">' . viba_portfolio_get_custom_css() . '
			</style>';
		}

	}

	/**
	 * Add class vp-js to html if javascript is enabled.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public static function head_scripts() {
		echo "<script>document.documentElement.classList ? document.documentElement.classList.add('vp-js') : document.documentElement.className += ' vp-js';</script>\n";
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public static function enqueue_scripts() {
		global $viba_portfolio_options;

		$assets_url		 	= viba_portfolio()->plugin_dir_url . 'assets/';
		$plugin_version		= viba_portfolio()->version;
		$upload_dir 		= wp_upload_dir(); 
		$scripts_position 	= $viba_portfolio_options['scripts-position'] == 'footer' ? true : false;
		$gfonts 			= $viba_portfolio_options['gfonts'];
		$fonts 				= ! empty( $gfonts ) ? '//fonts.googleapis.com/css?family=' . esc_attr( $gfonts ) : null;

		// Register CSS
		wp_register_style( 'viba-portfolio-gfonts', 	$fonts, 										'', $plugin_version );
		wp_register_style( 'magnific-popup', 			$assets_url . 'css/vendor/magnific-popup.css', 	'', $plugin_version ); 
		wp_register_style( 'viba-portfolio', 			$assets_url . 'css/viba-portfolio.css', 		'', $plugin_version ); 
		wp_register_style( 'viba-portfolio-single', 	$assets_url . 'css/viba-portfolio-single.css', 	'', $plugin_version ); 
		wp_register_style( 'viba-portfolio-styles', 	$assets_url . 'css/viba-portfolio-styles.css', 	'', $plugin_version ); 
		wp_register_style( 'viba-portfolio-widgets', 	$assets_url . 'css/viba-portfolio-widgets.css', '', $plugin_version ); 

		if ( file_exists( $upload_dir['basedir'] . '/viba-portfolio/custom-styles.css' ) ) {
			$custom_css_url = set_url_scheme( $upload_dir['baseurl'] . '/viba-portfolio/custom-styles.css' );
			wp_register_style( 'viba-portfolio-custom', $custom_css_url, '', $plugin_version );
		}

		// Register JS
		wp_register_script( 'magnific-popup', 			$assets_url . 'js/vendor/jquery.magnific-popup.min.js', array( 'jquery' ), '0.9.9',			$scripts_position );
		wp_register_script( 'viba-portfolio-plugins', 	$assets_url . 'js/plugins.min.js', 						array( 'jquery' ), $plugin_version, $scripts_position );
		wp_register_script( 'viba-portfolio', 			$assets_url . 'js/main.js', 							array( 'jquery' ), $plugin_version, $scripts_position );

		/* 
		 * Enqueue scripts
		 * 
		 * Only Enqueue Scripts when Viba Portfolio is active on page or if the option load all scripts is enabled.
		 * Only Enqueue Media Scripts on single pages or if is ajax enabled or if the option load all scripts is enabled.
		**/
		if ( is_viba_portfolio_loading_all_scripts() || is_viba_portfolio() || is_viba_portfolio_shortcode_active() ) {
			
			wp_enqueue_style( 'viba-portfolio-gfonts' );
			wp_enqueue_style( 'magnific-popup' );
			wp_enqueue_style( 'viba-portfolio' );
			wp_enqueue_style( 'viba-portfolio-styles' );

			wp_enqueue_script( 'magnific-popup' );
			wp_enqueue_script( 'viba-portfolio-plugins' );
			wp_enqueue_script( 'viba-portfolio' );
			
			if ( is_viba_portfolio_loading_all_scripts() || is_viba_portfolio_ajax() || is_viba_portfolio_single() ) {

				wp_enqueue_style( 'viba-portfolio-single' );

				if ( viba_portfolio_format_exists( 'audio' ) || viba_portfolio_format_exists( 'video' ) ) {
					wp_enqueue_style( 'wp-mediaelement' );
					wp_enqueue_script( 'wp-mediaelement' );
				}

				if ( viba_portfolio_playlist_exists( 'audio' ) ) {
					wp_playlist_scripts( 'audio' );
				}
				
				if ( viba_portfolio_playlist_exists( 'video' ) ) {
					wp_playlist_scripts( 'video' );
				}

			}

			wp_enqueue_style( 'viba-portfolio-custom' );

		}

		if ( is_viba_portfolio_loading_all_scripts() || is_active_widget( false, false, 'viba_portfolio_widget', true ) || is_active_widget( false, false, 'viba_portfolio_widget_filter', true ) ) {
			wp_enqueue_style( 'viba-portfolio-widgets' );
		}

	}

	/**
	 * Localize scripts.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public static function localize_scripts() {

		wp_localize_script(
		 	'viba-portfolio',
		 	'viba_portfolio_ajax',
		 	array(
		 		'ajax_url' 		=> viba_portfolio()->ajax_url,
		 		'previous' 		=> viba_portfolio_translate( 'i18n-ajax-prev', __( 'Previous', 'viba-portfolio' ) ),
		 		'next' 			=> viba_portfolio_translate( 'i18n-ajax-next', __( 'Next', 'viba-portfolio' ) ),
		 		'close' 		=> viba_portfolio_translate( 'i18n-ajax-close', __( 'Close', 'viba-portfolio' ) )
		 	)
		 );
	}

}

new Viba_Portfolio_Frontend_Scripts();

endif;