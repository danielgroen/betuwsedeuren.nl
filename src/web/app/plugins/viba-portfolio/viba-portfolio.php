<?php
/**
 * Plugin Name: Viba Portfolio
 * Plugin URI: http://plugins.apalodi.com/viba-portfolio/
 * Description: Advanced portfolio plugin that helps you showcase your work beatifully.
 * Version: 1.9.1
 * Author: APALODI
 * Author URI: http://apalodi.com
 * Tags: viba portfolio, portfolio, portfolio type, custom post type, images, gallery, video, audio
 *
 * Text Domain: viba-portfolio
 * Domain Path: /languages
 *
 * License: CodeCanyon Licence
 * License URI: https://codecanyon.net/licenses
 *
 * @package		Viba_Portfolio
 * @version 	1.9.1
 * @author 		apalodi
 *
 * 
 * This plugin was inspired by bbPress and WooCommerce.
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio' ) ) :

/**
 * Main Viba_Portfolio Class.
 *
 * @since 	1.0
 */
final class Viba_Portfolio {

	/**
	 * @var 	string
	 */
	public $version = '1.9.1';

	/**
	 * A dummy constructor to prevent Viba Portfolio from being loaded more than once.
	 *
	 * @since 	1.0
	 */
	private function __construct() { /* Do nothing here */ }

	/**
	 * A dummy magic method to prevent Viba Portfolio from being cloned.
	 *
	 * @since 	1.0
	 */
	public function __clone() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'viba-portfolio' ), '1.0' ); }

	/**
	 * A dummy magic method to prevent Viba Portfolio from being unserialized.
	 *
	 * @since 	1.0
	 */
	public function __wakeup() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'viba-portfolio' ), '1.0' ); }

	/**
	 * Main Viba Portfolio Instance.
	 *
	 * Insures that only one instance of Viba Portfolio exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @see 	viba_portfolio()
	 * @return 	object $instance The one true Viba Portfolio
	 */
	public static function instance() {

		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run the setup if it haven't been ran previously
		if ( null === $instance ) {
			$instance = new Viba_Portfolio;
			$instance->setup_globals();
			$instance->includes();
			$instance->setup_plugin();
		}

		// Always return the instance
		return $instance;
	}

	/**
	 * Set some smart defaults to class variables. Allow some of them to be
	 * filtered to allow for early overriding.
	 *
	 * @since 	1.0
	 * @access 	private
	 */
	public function setup_globals() {

		$this->debug 				= apply_filters( 'viba_portfolio_debug', false );
		$this->file 				= __FILE__;

		// Setup post type and taxonomy names
		$this->post_type 			= apply_filters( 'viba_portfolio_post_type', 			'viba_portfolio' );
		$this->category_taxonomy	= apply_filters( 'viba_portfolio_category_taxonomy', 	'viba_portfolio_category' );
		$this->tag_taxonomy			= apply_filters( 'viba_portfolio_tag_taxonomy', 		'viba_portfolio_tag' );

		// Setup some base path and URL information
		$this->basename     		= apply_filters( 'viba_portfolio_plugin_basename',  	plugin_basename( $this->file ) );
		$this->plugin_dir_path   	= apply_filters( 'viba_portfolio_plugin_dir_path',  	plugin_dir_path( $this->file ) );
		$this->plugin_dir_url   	= apply_filters( 'viba_portfolio_plugin_dir_url',   	plugin_dir_url ( $this->file ) );

		// Languages
		$this->lang_dir_path     	= apply_filters( 'viba_portfolio_lang_dir_path',  		trailingslashit( $this->plugin_dir_path . 'languages' ) );
		$this->lang_dir_rel_path   	= apply_filters( 'viba_portfolio_lang_dir_rel_path',	trailingslashit( dirname( $this->basename ). '/languages' ) );

		// Admin
		$this->admin_dir_path 		= apply_filters( 'viba_portfolio_admin_dir_path', 		trailingslashit( $this->plugin_dir_path . 'includes/admin' ) );
		$this->admin_dir_url 		= apply_filters( 'viba_portfolio_admin_dir_url', 		trailingslashit( $this->plugin_dir_url . 'includes/admin' ) );

		// Templates
		$this->template_dir_path 	= apply_filters( 'viba_portfolio_template_dir_path',    trailingslashit( $this->plugin_dir_path . 'templates' ) );
		$this->template_dir_url 	= apply_filters( 'viba_portfolio_template_dir_url',     trailingslashit( $this->plugin_dir_url . 'templates' ) );

		// Custom template folder
		$this->custom_template_dir_path = apply_filters( 'viba_portfolio_custom_template_dir_path', trailingslashit( 'viba-portfolio' ) );

		$this->ajax_url = admin_url( 'admin-ajax.php', 'relative' );

	}	

	/**
	 * Include required files.
	 *
	 * @since 	1.0
	 * @access 	private
	 */
	private function includes() {
		
		// plugin classes
		include_once( 'includes/class-viba-portfolio-post-type.php' 		);	// Registers post type and taxonomies
		include_once( 'includes/class-viba-portfolio-template-loader.php' 	);	// Template Loader
		include_once( 'includes/class-viba-portfolio-frontend-scripts.php' 	);	// Frontend styles and scripts
		include_once( 'includes/class-viba-portfolio-shortcode.php'			); 	// Shortcode
		include_once( 'includes/class-viba-portfolio-ajax.php' 				); 	// Ajax

        if ( is_admin() ) {
		  include_once( 'includes/admin/class-viba-portfolio-admin.php' 	); 	// Main Admin Class
        }

		// plugin functions
		include_once( 'includes/viba-portfolio-core-functions.php' 			); 	// General core functions available on both the front-end and admin
		include_once( 'includes/viba-portfolio-helper-functions.php' 		); 	// General helper functions
		include_once( 'includes/viba-portfolio-get-option-functions.php' 	); 	// Functions for getting options
		include_once( 'includes/viba-portfolio-page-functions.php' 			); 	// Functions related to pages and menus
		include_once( 'includes/viba-portfolio-styles-functions.php'		);	// Template Styles Functions
		include_once( 'includes/viba-portfolio-template-hooks.php' 			);	// Action and filter hooks used for functions and templates
        include_once( 'includes/viba-portfolio-template-styles.php'         );  // Template styles.
		include_once( 'includes/viba-portfolio-conditional-functions.php' 	);	// Functions for determining on what page we are and is some option enabled

		// widgets
		include_once( 'includes/widgets/class-viba-portfolio-widget.php' 			);
		include_once( 'includes/widgets/class-viba-portfolio-widget-cloud.php' 		);
		include_once( 'includes/widgets/class-viba-portfolio-widget-filter.php' 	);
		include_once( 'includes/widgets/class-viba-portfolio-widget-searchform.php' );

		// other plugins support
		include_once( 'includes/supported-plugins/visual-composer/visual-composer.php' );
		include_once( 'includes/supported-plugins/wp-seo/wp-seo.php' );
		//include_once( 'includes/supported-plugins/wpml/wpml.php' );

	}

	/**
	 * Function used to init template functions and tags. This makes them pluggable by plugins and themes.
	 *
	 * @since 	1.6.1
	 * @access 	public
	 */
	public function include_template_functions() {
		include_once( 'includes/viba-portfolio-template-functions.php' 		); 	// General template functions
		include_once( 'includes/viba-portfolio-template-tags.php' 			); 	// General template tags
	}

	/**
	 * Setup the plugin globals, hooks, actions and include plugin files.
	 *
	 * @since 	1.0
	 * @access 	private
	 */
	private function setup_plugin() {

		// Register activation, deactivation and uninstall hook.
		register_activation_hook(   $this->file, array( $this, 'activation'   ) );
		register_deactivation_hook( $this->file, array( $this, 'deactivation' ) );
		register_uninstall_hook( $this->file, array( 'Viba_Portfolio', 'uninstall' ) );

		do_action( 'viba_portfolio_before_init' );

		add_action( 'current_screen', 	 array( $this, 'setup_post_formats' ) );
		add_action( 'after_setup_theme', array( $this, 'styles_theme_support' ) );
		add_action( 'after_setup_theme', array( $this, 'setup_thumbnail_sizes' ) );
		add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );

		add_action( 'init', array( $this, 'setup_globals' 	), 0 ); 	// necessary for apply_filters to work
		add_action( 'init', array( $this, 'load_textdomain' ), 0 ); 	// themes have time to filter textdomain

		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		
		// Loaded action
		do_action( 'viba_portfolio_loaded' );

	}

	/**
	 * Register widgets.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function register_widgets() {

		register_widget( 'Viba_Portfolio_Widget' );
		register_widget( 'Viba_Portfolio_Widget_Filter' );

		if ( is_viba_portfolio_archive_enabled() ) {
			register_widget( 'Viba_Portfolio_Widget_Cloud' );
			register_widget( 'Viba_Portfolio_Widget_Searchform' );
		}
		
	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function activation() {

        do_action( 'viba_portfolio_before_activation' );

		$this->create_roles();

		add_option( 'viba_portfolio_options_version', $this->version );
		add_option( 'viba_portfolio_needs_update', 0 );

		do_action( 'viba_portfolio_activated' );
		flush_rewrite_rules();

	}

	/**
	 * Method that runs only when the plugin is deactivated.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function deactivation() {

		$options = get_option( 'viba_portfolio_options' );

		if ( is_multisite() && '1' == $options['delete-data-on-deactivation'] ) {

			$this->remove_roles();
			$this->delete_data( $this->post_type );
			$this->delete_upload_subdir();

		}

		do_action( 'viba_portfolio_deactivated' );
		flush_rewrite_rules();

	}

	/**
	 * Method that runs only when the plugin is uninstalled.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function uninstall() {

		$viba 	 = viba_portfolio();
		$options = get_option( 'viba_portfolio_options' );

		$viba->remove_roles();

		if ( '1' == $options['delete-data'] ) {
		
			// we can re-register custom taxonomies to be deleted
			do_action( 'viba_portfolio_before_delete_data', $viba->post_type );

			// We need to re-register taxonomies because when the plugin is deactivated it can't get them
			register_taxonomy( $viba->category_taxonomy, $viba->post_type );
			register_taxonomy( $viba->tag_taxonomy, $viba->post_type );

			$viba->delete_data( $viba->post_type );
			$viba->delete_upload_subdir();

		}
		
		do_action( 'viba_portfolio_uninstall' );

	}

	/**
	 * Delete all plugin data.
	 *
	 * @since 	1.0
	 * @access 	private
	 * @param 	string $post_type Post type
	 */
	private function delete_data( $post_type ) {

		$items 		= get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1 ) );
		$taxonomies = get_object_taxonomies( $post_type );
		$terms 		= get_terms( $taxonomies );

		foreach( $items as $item ) {
			/**
			 * wp_delete_post won't delete post formats relationships because 
			 * get_object_taxonomies() isn't returning post_formats as
			 * a taxonomy for custom post types
			 */
			wp_delete_object_term_relationships( $item->ID, 'post_format' );
			wp_delete_post( $item->ID, true );
		}

		foreach ( $terms as $term ) {
			wp_delete_term( $term->term_id, $term->taxonomy );
		}

		delete_option( 'viba_portfolio_options' );
		delete_option( 'viba_portfolio_options-transients' );
		delete_option( 'viba_portfolio_options_version' );
		delete_option( 'viba_portfolio_needs_update' );
		delete_option( 'viba_portfolio_category_children' );

		do_action( 'viba_portfolio_data_deleted' );

	}

	/**
	 * Delete viba-portfolio dir inside wp upload dir with custom css file.
	 *
	 * @since 	 1.0
	 * @access 	private
	 */
	private function delete_upload_subdir() {

		$access_type = get_filesystem_method();
		
		if ( $access_type === 'direct' ) {

			/* we can now safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
			$creds = request_filesystem_credentials( site_url() . '/wp-admin/', '', false, false, array() );

			/* initialize the API */
			if ( ! WP_Filesystem( $creds ) ) {
				/* any problems and we exit */
				return false;
			}	

			global $wp_filesystem;
			/* do our file manipulations below */

			$upload_dir = wp_upload_dir(); 
			$filename = $upload_dir['basedir'] . '/viba-portfolio/custom-styles.css';

			if ( $wp_filesystem->is_dir( $upload_dir['basedir'] . '/viba-portfolio/' ) ) {
				
				/* directory exist, so let's delete it with the custom css inside */
				if ( $wp_filesystem->is_file( $filename ) ) {
					$wp_filesystem->delete( $filename );
				}

				$wp_filesystem->rmdir( $upload_dir['basedir'] . '/viba-portfolio/' );
			}

		}

	}

	/**
	 * Load the translation file for current language. Checks the default WordPress
	 * languages folder first, and then the languages folder inside the plugin folder.
	 * This way when if user creates translations outside the plugin folder those 
	 * translations will be used as default.
	 *
	 * Note that custom translation files inside the plugin folder
	 * will be removed on updates. If you're creating custom
	 * translation files, please use the global language folder.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function load_textdomain() {

		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'viba_portfolio_locale', get_locale(), 'viba-portfolio' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'viba-portfolio', $locale );
		$mofile_global = WP_LANG_DIR . '/viba-portfolio/' . $mofile;

		// 1. Look in global /wp-content/languages/viba-portfolio/ folder
		load_textdomain( 'viba-portfolio', $mofile_global );

		/* 
		 * 2. Look in local /wp-content/plugins/viba-portfolio/languages/ folder
		 * 3. If 2. is empty look in global /wp-content/languages/plugins/
		 *
		**/
		load_plugin_textdomain( 'viba-portfolio', false, $this->lang_dir_rel_path );
		
	}

	/**
	 * Get all available styles and add them as a theme support.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function styles_theme_support() {

		$template_styles = viba_portfolio_get_template_styles();
		$theme_support = array();

		foreach ( $template_styles as $key => $type ) {
			foreach ( $type['styles'] as $style ) {
				$theme_support[] = $key.'/'.$style['id'];
			}
			
		}

		$theme_support = array_values( array_unique( $theme_support ) );

		add_theme_support( 'viba-portfolio-styles', apply_filters( 'viba_portfolio_styles_theme_support', $theme_support ) );

	}

	/**
	 * Add Post Format Support.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	string $current_screen Current screen neccessary for getting post type
	 */
	public function setup_post_formats( $current_screen ) {

		// this overrides themes support for post formats
		if ( $this->post_type == $current_screen->post_type ) {
			add_theme_support( 'post-formats', apply_filters( 'viba_portfolio_post_formats', array( 'gallery', 'video', 'audio', 'link' ) ) );
		}
		
	}

	/**
	 * Add thumbnail support and add custom image sizes.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function setup_thumbnail_sizes() {

		// Post Thumbnail Support
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
			remove_post_type_support( 'post', 'thumbnail' );
		}

		// Get Image Sizes
		$thumbnail 	= viba_portfolio_get_image_size( 'thumbnail' );
		$single		= viba_portfolio_get_image_size( 'single' );
		$big	 	= viba_portfolio_get_image_size( 'big' );
		$landscape	= viba_portfolio_get_image_size( 'landscape' );
		$portrait	= viba_portfolio_get_image_size( 'portrait' );

		// Add Image Sizes
		if ( false != $thumbnail && false != $single ) {
			add_image_size( 'viba_portfolio_thumbnail', $thumbnail['width'], $thumbnail['height'], $thumbnail['crop'] );
			add_image_size( 'viba_portfolio_single', $single['width'], $single['height'], $single['crop'] );
		}

		if ( false != $big && false != $landscape && false != $portrait ) {
			add_image_size( 'viba_portfolio_big', $big['width'], $big['height'], $big['crop'] );
			add_image_size( 'viba_portfolio_landscape', $landscape['width'], $landscape['height'], $landscape['crop'] );
			add_image_size( 'viba_portfolio_portrait', $portrait['width'], $portrait['height'], $portrait['crop'] );
		}

	}

	/**
	 * Create roles and capabilities.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function create_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {

			// Viba Portfolio Manager role
			add_role( 'viba_portfolio_manager', _x( 'Viba Portfolio Manager', 'WordPress User Role', 'viba-portfolio' ), array(
				'read'                   => true,
				'read_private_pages'     => true,
				'read_private_posts'     => true,
				'edit_users'             => true,
				'edit_posts'             => true,
				'edit_pages'             => true,
				'edit_published_posts'   => true,
				'edit_published_pages'   => true,
				'edit_private_pages'     => true,
				'edit_private_posts'     => true,
				'edit_others_posts'      => true,
				'edit_others_pages'      => true,
				'publish_posts'          => true,
				'publish_pages'          => true,
				'delete_posts'           => true,
				'delete_pages'           => true,
				'delete_private_pages'   => true,
				'delete_private_posts'   => true,
				'delete_published_pages' => true,
				'delete_published_posts' => true,
				'delete_others_posts'    => true,
				'delete_others_pages'    => true,
				'manage_categories'      => true,
				'manage_links'           => true,
				'moderate_comments'      => true,
				'unfiltered_html'        => true,
				'upload_files'           => true,
				'export'                 => true,
				'import'                 => true,
				'list_users'             => true
			) );

			$capabilities = $this->get_core_capabilities();

			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'viba_portfolio_manager', $cap );
					$wp_roles->add_cap( 'administrator', $cap );
				}
			}
		}
	}

	/**
	 * Get capabilities - these are assigned to Admin and Viba Portfolio Manager during installation or reset.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	array $capabilities
	 */
	public function get_core_capabilities() {
		
		$capabilities = array();
		$capabilities['core'] = array( 'manage_viba_portfolio' );
		$capability_type = viba_portfolio()->post_type;

		$capabilities[ $capability_type ] = array(
			// Post type
			"edit_{$capability_type}",
			"read_{$capability_type}",
			"delete_{$capability_type}",
			"edit_{$capability_type}s",
			"edit_others_{$capability_type}s",
			"publish_{$capability_type}s",
			"read_private_{$capability_type}s",
			"delete_{$capability_type}s",
			"delete_private_{$capability_type}s",
			"delete_published_{$capability_type}s",
			"delete_others_{$capability_type}s",
			"edit_private_{$capability_type}s",
			"edit_published_{$capability_type}s",

			// Terms
			"manage_{$capability_type}_terms",
			"edit_{$capability_type}_terms",
			"delete_{$capability_type}_terms",
			"assign_{$capability_type}_terms"
		);

		return $capabilities;
	}

	/**
	 * Remove roles.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function remove_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {

			$capabilities = $this->get_core_capabilities();

			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->remove_cap( 'viba_portfolio_manager', $cap );
					$wp_roles->remove_cap( 'administrator', $cap );
				}
			}

			remove_role( 'viba_portfolio_manager' );
		}
	}

}

/**
 * The main function responsible for returning the one true Viba Portfolio Instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $portfolio = viba_portfolio(); ?>
 *
 * @since 	1.0
 * @return 	object The one true Viba_Portfolio Instance
 */
function viba_portfolio() {
	return Viba_Portfolio::instance();
}

/**
 * Hook Viba Portfolio early onto the 'plugins_loaded' action.
 *
 * This gives all other plugins the chance to load before Viba Portfolio, to get their
 * actions, filters, and overrides setup without Viba Portfolio being in the way.
 */
if ( defined( 'VIBA_PORTFOLIO_LATE_LOAD' ) ) {
	add_action( 'plugins_loaded', 'viba_portfolio', (int) VIBA_PORTFOLIO_LATE_LOAD );
} else {
	viba_portfolio();
}

endif;