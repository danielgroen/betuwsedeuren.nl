<?php
/**
 * Registers post types and taxonomies.
 *
 * @package		Viba_Portfolio/Classes
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Post_Type' ) ) :

class Viba_Portfolio_Post_Type {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ), 10 );
		add_action( 'init', array( $this, 'register_post_type_taxonomies' ), 10 );
	}

	/**
	 * Setup the post type for portfolios.
	 *
	 * @since 	1.0
	 * @access 	public 
	 */
	public function register_post_type() {

		$has_archive = false;
		$rewrite = false;

		if ( is_viba_portfolio_archive_enabled() ) {
			$has_archive = viba_portfolio_get_archive_page() ? get_page_uri( viba_portfolio_get_archive_page() ) : false;
		}

		if ( viba_portfolio_get_permalinks_base() ) {
			$rewrite = array( 'slug' => untrailingslashit( viba_portfolio_get_permalinks_base() ), 'with_front' => false, 'feeds' => true );
		} elseif ( $has_archive ) {
			$rewrite = array( 'slug' => untrailingslashit( $has_archive ), 'with_front' => false, 'feeds' => true );
		}

		$portfolio_labels = apply_filters( 'viba_portfolio_post_type_labels', 
			array(
				'name' 					=> __( 'Viba Portfolios', 'viba-portfolio' ),
				'singular_name' 		=> _x( 'Viba Portfolio', 'Singular Name', 'viba-portfolio' ),
				'menu_name'				=> _x( 'Viba Portfolio', 'Menu Name', 'viba-portfolio' ),
				'all_items'				=> __( 'All Portfolio Items', 'viba-portfolio' ),
				'name_admin_bar' 		=> _x( 'Viba Portfolio', 'Admin bar add new', 'viba-portfolio'),
				'add_new' 				=> __( 'Add New Portfolio', 'viba-portfolio' ),
				'add_new_item' 			=> __( 'Add New Portfolio', 'viba-portfolio' ),
				'edit' 					=> __( 'Edit', 'viba-portfolio' ),
				'edit_item' 			=> __( 'Edit Portfolio', 'viba-portfolio' ),
				'new_item' 				=> __( 'New Portfolio', 'viba-portfolio' ),
				'view' 					=> __( 'View Portfolio', 'viba-portfolio' ),
				'view_item' 			=> __( 'View Portfolio', 'viba-portfolio' ),
				'search_items' 			=> __( 'Search Portfolios', 'viba-portfolio' ),
				'not_found' 			=> __( 'No Portfolios found', 'viba-portfolio' ),
				'not_found_in_trash' 	=> __( 'No Portfolios found in trash', 'viba-portfolio' )
			)
		);

		$portfolio_args = apply_filters( 'viba_portfolio_post_type_args',
			array(
				'labels'				=> $portfolio_labels,
				'public' 				=> true,
				'show_ui' 				=> true,
				'capability_type' 		=> viba_portfolio()->post_type,
				'map_meta_cap'			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,	
				'query_var' 			=> true,
				'supports' 				=> array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
				'has_archive' 			=> $has_archive,
				'rewrite' 				=> $rewrite,
				'show_in_nav_menus' 	=> true,
				'menu_position' 		=> apply_filters( 'viba_portfolio_menu_position', 20 ),
				'menu_icon'				=> apply_filters( 'viba_portfolio_menu_icon', 'dashicons-portfolio' )
			), 
			$portfolio_labels, 
			$has_archive, 
			$rewrite
		);

		register_post_type(	viba_portfolio()->post_type, $portfolio_args );
	}

	/**
	 * Setup the post type taxonomies.
	 *
	 * @since 	1.0
	 * @access 	public 
	 */
	public function register_post_type_taxonomies() {


		// Category taxonomy
		$category_taxonomy_labels = apply_filters( 'viba_portfolio_category_taxonomy_labels', 
			array(
				'name' 							=> __( 'Viba Portfolio Categories', 'viba-portfolio' ),
				'singular_name' 				=> __( 'Viba Portfolio Category', 'viba-portfolio' ),
				'search_items' 					=> __( 'Search Portfolio Categories', 'viba-portfolio' ),
				'popular_items'					=> __( 'Popular Portfolio Categories', 'viba-portfolio' ),
				'all_items' 					=> __( 'All Portfolio Categories', 'viba-portfolio' ),
				'parent_item' 					=> __( 'Parent Portfolio Category', 'viba-portfolio' ),
				'parent_item_colon' 			=> __( 'Parent Portfolio Category:', 'viba-portfolio' ),
				'edit_item' 					=> __( 'Edit Portfolio Category', 'viba-portfolio' ),
				'update_item' 					=> __( 'Update Portfolio Category', 'viba-portfolio' ),
				'add_new_item' 					=> __( 'Add New Portfolio Category', 'viba-portfolio' ),
				'new_item_name' 				=> __( 'New Portfolio Category Name', 'viba-portfolio' ),
				'separate_items_with_commas' 	=> __( 'Separate portfolio categories with commas', 'viba-portfolio' ),
				'add_or_remove_items' 			=> __( 'Add or remove portfolio categories', 'viba-portfolio' ),
				'choose_from_most_used' 		=> __( 'Choose from the most used portfolio categories', 'viba-portfolio' ),
				'menu_name' 					=> __( 'Portfolio Categories', 'viba-portfolio' )
			)
		);
		
		$category_taxonomy_args = apply_filters( 'viba_portfolio_category_taxonomy_args',
			array(
				'labels' 			=> $category_taxonomy_labels,
				'public' 			=> is_viba_portfolio_archive_enabled(),
				'hierarchical' 		=> true,
				'query_var' 		=> true,
				'show_ui' 			=> true,
				'show_admin_column' => true,
				'capabilities'		=> array(
					'manage_terms' 		=> 'manage_'.viba_portfolio()->post_type.'_terms',
					'edit_terms' 		=> 'edit_'.viba_portfolio()->post_type.'_terms',
					'delete_terms' 		=> 'delete_'.viba_portfolio()->post_type.'_terms',
					'assign_terms' 		=> 'assign_'.viba_portfolio()->post_type.'_terms',
				),
				'rewrite' 			=> viba_portfolio_get_category_base() && is_viba_portfolio_archive_enabled() ? array( 'slug' => untrailingslashit( viba_portfolio_get_category_base() ), 'with_front' => false, 'hierarchical' => true ) : false
			),
			$category_taxonomy_labels
		);
		
		register_taxonomy( viba_portfolio()->category_taxonomy, viba_portfolio()->post_type, $category_taxonomy_args );


		// Tag taxonomy
		$tag_taxonomy_labels = apply_filters( 'viba_portfolio_tag_taxonomy_labels', 
			array(
				'name' 							=> __( 'Viba Portfolio Tags', 'viba-portfolio' ),
				'singular_name' 				=> __( 'Viba Portfolio Tag', 'viba-portfolio' ),
				'search_items' 					=> __( 'Search Portfolio Tags', 'viba-portfolio' ),
				'popular_items' 				=> __( 'Popular Portfolio Tags', 'viba-portfolio' ),
				'all_items' 					=> __( 'All Portfolio Tags', 'viba-portfolio' ),
				'edit_item' 					=> __( 'Edit Portfolio Tag', 'viba-portfolio' ),
				'update_item' 					=> __( 'Update Portfolio Tag', 'viba-portfolio' ),
				'add_new_item' 					=> __( 'Add New Portfolio Tag', 'viba-portfolio' ),
				'new_item_name' 				=> __( 'New Portfolio Tag Name', 'viba-portfolio' ),
				'separate_items_with_commas' 	=> __( 'Separate portfolio tags with commas', 'viba-portfolio' ),
				'add_or_remove_items' 			=> __( 'Add or remove portfolio tags', 'viba-portfolio' ),
				'choose_from_most_used' 		=> __( 'Choose from the most used portfolio tags', 'viba-portfolio' ),
				'menu_name' 					=> __( 'Portfolio Tags', 'viba-portfolio' )
			)
		);

		$tag_taxonomy_args = apply_filters( 'viba_portfolio_tag_taxonomy_args',
			array(
				'labels'			=> $tag_taxonomy_labels,	
				'public' 			=> is_viba_portfolio_archive_enabled(),
				'show_admin_column' => true,
				'query_var' 		=> true,
				'show_ui' 			=> true,
				'capabilities'		=> array(
					'manage_terms' 		=> 'manage_'.viba_portfolio()->post_type.'_terms',
					'edit_terms' 		=> 'edit_'.viba_portfolio()->post_type.'_terms',
					'delete_terms' 		=> 'delete_'.viba_portfolio()->post_type.'_terms',
					'assign_terms' 		=> 'assign_'.viba_portfolio()->post_type.'_terms',
				),
				'rewrite' => viba_portfolio_get_tag_base() && is_viba_portfolio_archive_enabled() ? array( 'slug' => untrailingslashit( viba_portfolio_get_tag_base() ), 'with_front' => false ) : false
			),
			$tag_taxonomy_labels
		);

		register_taxonomy( viba_portfolio()->tag_taxonomy, viba_portfolio()->post_type, $tag_taxonomy_args );

	}

}

new Viba_Portfolio_Post_Type();

endif;