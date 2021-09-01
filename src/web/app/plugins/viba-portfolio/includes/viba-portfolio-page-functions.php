<?php
/**
 * Viba Portfolio Page Functions.
 *
 * Functions related to pages and menus.
 *
 * @package 	Viba_Portfolio/Functions/Page
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Handle redirects before content is output - hooked into template_redirect.
 * When default permalinks are enabled, redirect portfolio archive page to post type archive url.
 *
 * @since 	1.0
 * @access 	public
 */
function viba_portfolio_template_redirect() {
	if ( ! empty( $_GET['page_id'] ) && '' === get_option( 'permalink_structure' ) && $_GET['page_id'] == viba_portfolio_get_archive_page() ) {
		wp_safe_redirect( get_post_type_archive_link( viba_portfolio()->post_type ) );
		exit;
	}
}
add_action( 'template_redirect', 'viba_portfolio_template_redirect' );

/**
 * Change the archives title to whatever is the user selected page name.
 *
 * @since 	1.0
 * @access 	public
 */
function viba_portfolio_archives_title( $title, $post_type ) {

	if ( is_viba_portfolio_page() && viba_portfolio_get_archive_page() ) {
		$title = get_post( viba_portfolio_get_archive_page() );
		return $title->post_title;
	}
	else {
        return $title;
	}

}
add_filter( 'post_type_archive_title', 'viba_portfolio_archives_title', 10, 2 );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $title Default title text for current view.
 * @param 	string $sep Optional separator.
 * @return 	string $title Filtered title.
 */
function viba_portfolio_wp_title( $title, $sep ) {

	if ( viba_portfolio_get_archive_page() ) {

		$archive_title = get_post( viba_portfolio_get_archive_page() )->post_title;

		if ( is_viba_portfolio_taxonomy() ) {
			$title = apply_filters( 'viba_portfolio_taxonomy_wp_title', single_term_title( '', false ) . ' ' . $sep . ' ' . $archive_title . ' ' . $sep . ' ', $sep, $archive_title );
		}

		if ( is_viba_portfolio_single() ) {
			$title = apply_filters( 'viba_portfolio_single_wp_title', get_the_title() . ' ' . $sep . ' ' . $archive_title . ' ' . $sep . ' ', $sep, $archive_title );
		}
	}

	return $title;

}
add_filter( 'wp_title', 'viba_portfolio_wp_title', 10, 2 );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view. For WP 4.4+
 *
 * @since 	1.7.2
 * @access 	public
 * @param 	array $title Default title text for current view.
 * @return 	array $title Filtered title.
 */
function viba_portfolio_document_title_parts( $title ) {

	$sep = apply_filters( 'document_title_separator', '-' );

	if ( ( is_viba_portfolio_single() || is_viba_portfolio_taxonomy() ) && viba_portfolio_get_archive_page() ) {
		$archive_title = get_post( viba_portfolio_get_archive_page() )->post_title;
		$title['title'] = $title['title'] . ' ' . $sep . ' ' . $archive_title;
	}

	return $title;

}
add_filter( 'document_title_parts', 'viba_portfolio_document_title_parts', 10 );

/**
 * Fix active class in nav for archives page.
 *
 * @since 	1.0
 * @access 	public
 * @param 	array $menu_items
 * @param 	array $args
 * @return 	array $$menu_items
 */
function viba_portfolio_nav_menu_item_classes( $menu_items, $args ) {

	if ( is_viba_portfolio() && viba_portfolio_get_archive_page() ) {
	
		$archive_page = (int) viba_portfolio_get_archive_page();
		$page_for_posts = (int) get_option( 'page_for_posts' );

		foreach ( (array) $menu_items as $key => $menu_item ) {

			$classes = (array) $menu_item->classes;

			// Unset active class for blog page
			if ( $page_for_posts == $menu_item->object_id ) {
				$menu_items[$key]->current = false;
				
				if ( in_array( 'current_page_parent', $classes ) )
					unset( $classes[ array_search('current_page_parent', $classes) ] );
				
				if ( in_array( 'current-menu-item', $classes ) )
					unset( $classes[ array_search('current-menu-item', $classes) ] );

			// Set active state if this is the page link
			} elseif ( is_viba_portfolio_page() && $archive_page == $menu_item->object_id && $menu_item->type != 'taxonomy' ) {
				$menu_items[$key]->current = true;
				$classes[] = 'current-menu-item';

			// Set parent state if this is a single
			} elseif ( is_viba_portfolio_single() && $archive_page == $menu_item->object_id && $menu_item->type != 'taxonomy' ) {
				$classes[] = 'current-menu-parent current-menu-ancestor';
			}

			$menu_items[$key]->classes = array_unique( $classes );

		}

	}

	return $menu_items;

}
add_filter( 'wp_nav_menu_objects',  'viba_portfolio_nav_menu_item_classes', 10, 2 );

/**
 * Add active class in wp_list_pages for archive page.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $pages
 * @return 	string $pages
 */
function viba_portfolio_list_pages( $pages ) {

    if ( is_viba_portfolio() && viba_portfolio_get_archive_page() ) {

        $pages = str_replace( 'current_page_parent', '', $pages ); // remove current_page_parent class from any item
        $viba_portfolio_arhive_page = 'page-item-' . viba_portfolio_get_archive_page();

        if ( is_viba_portfolio_page() || is_viba_portfolio_archive() ) :
        	$pages = str_replace( $viba_portfolio_arhive_page, $viba_portfolio_arhive_page . ' current_page_item', $pages ); // add current_page_item class to archive page
    	elseif ( is_viba_portfolio_single() ) :
    		$pages = str_replace( $viba_portfolio_arhive_page, $viba_portfolio_arhive_page . ' current_page_parent current_page_ancestor', $pages ); 
    	endif;

    }

    return $pages;

}
add_filter( 'wp_list_pages', 'viba_portfolio_list_pages' );

/**
 * Filter post_type_link to allow viba_portfolio_cat in the permalinks.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $permalink The existing permalink URL.
 * @param 	object $post
 * @return 	string
 */
function viba_portfolio_post_type_link( $permalink, $post ) {
    
    // Abort if post is not a product
    if ( viba_portfolio()->post_type !== $post->post_type )
    	return $permalink;

    // Abort early if the placeholder rewrite tag isn't in the generated URL
    if ( false === strpos( $permalink, '%' ) )
    	return $permalink;

    // Get the custom taxonomy terms in use by this post
    $terms = get_the_terms( $post->ID, viba_portfolio()->category_taxonomy );

    if ( empty( $terms ) ) {
    	// If no terms are assigned to this post, use a string instead (can't leave the placeholder there)
        $viba_portfolio_cat = _x( 'uncategorized', 'Category Slug', 'viba-portfolio' );
    } else {
    	// Replace the placeholder rewrite tag with the first term's slug
        $first_term = array_shift( $terms );
        $viba_portfolio_cat = $first_term->slug;
    }

    $find = array(
    	'%year%',
    	'%monthnum%',
    	'%day%',
    	'%hour%',
    	'%minute%',
    	'%second%',
    	'%post_id%',
    	'%category%',
    	'%'.viba_portfolio()->category_taxonomy.'%'
    );

    $replace = array(
    	date_i18n( 'Y', strtotime( $post->post_date ) ),
    	date_i18n( 'm', strtotime( $post->post_date ) ),
    	date_i18n( 'd', strtotime( $post->post_date ) ),
    	date_i18n( 'H', strtotime( $post->post_date ) ),
    	date_i18n( 'i', strtotime( $post->post_date ) ),
    	date_i18n( 's', strtotime( $post->post_date ) ),
    	$post->ID,
    	$viba_portfolio_cat,
    	$viba_portfolio_cat
    );

    $replace = array_map( 'sanitize_title', $replace );

    $permalink = str_replace( $find, $replace, $permalink );

    return $permalink;
}
add_filter( 'post_type_link', 'viba_portfolio_post_type_link', 10, 2 );

/**
 * Add use_verbose_page_rules to wp_rewrite object if the archive page is enabled.
 *
 * @since 	1.7.2
 * @access 	public
 */
function viba_portfolio_use_verbose_page_rules() {
	if ( is_viba_portfolio_page() ) {
		$GLOBALS['wp_rewrite']->use_verbose_page_rules = true;
	}
}
add_action( 'init', 'viba_portfolio_use_verbose_page_rules', 10 );

/**
 * Various rewrite rule fixes.
 *
 * @since 	1.7.2
 * @access 	public
 * @param 	array $rules
 * @return 	array $rules
 */
function viba_portfolio_fix_rewrite_rules( $rules ) {
	global $wp_rewrite;

	// If there is a main archive page we need to enable verbose rewrite rules or sub pages will 404.
	if ( is_viba_portfolio_page() ) {
		$page_rewrite_rules = $wp_rewrite->page_rewrite_rules();
		$rules              = array_merge( $page_rewrite_rules, $rules );
	}

	return $rules;
}
add_filter( 'rewrite_rules_array', 'viba_portfolio_fix_rewrite_rules', 10 );

/**
 * Hook into pre_get_posts to customize the archive page default query.
 *
 * @since 	1.0
 * @access 	public
 * @param 	object $vp_query query object
 */
function viba_portfolio_pre_get_posts( $vp_query ) {
	global $wp_rewrite;

	/**
	 * If it's the main query ( we don't want to run twice the same query = more speed ).
	 * We are setting the custom options by getting in the query before running.
	 * @see http://codex.wordpress.org/Function_Reference/is_main_query
	 **/
	if ( is_admin() || ! $vp_query->is_main_query() )
		return;

	// Fix for verbose page rules
	if ( viba_portfolio_get_archive_page() && $wp_rewrite->use_verbose_page_rules && $vp_query->queried_object_id == viba_portfolio_get_archive_page() ) {
		$vp_query->set( 'post_type', viba_portfolio()->post_type );
		$vp_query->set( 'page', '' );
		$vp_query->set( 'pagename', '' );

		// Fix conditional Functions
		$vp_query->is_archive           = true;
		$vp_query->is_post_type_archive = true;
		$vp_query->is_singular          = false;
		$vp_query->is_page              = false;
	}

	// Check if the portfolio archive page is set for static front page
	if ( viba_portfolio_get_archive_page() && $vp_query->is_page() && 'page' == get_option( 'show_on_front' ) && $vp_query->get( 'page_id' ) == viba_portfolio_get_archive_page() ) {

		global $wp_post_types;
		
		$vp_query->set( 'post_type', viba_portfolio()->post_type );
		$vp_query->set( 'page_id', '' );

		if ( isset( $vp_query->query['paged'] ) )
			$vp_query->set( 'paged', $vp_query->query['paged'] );
		
		$vp_page = get_post( viba_portfolio_get_archive_page() );

		$wp_post_types[ viba_portfolio()->post_type ]->ID 			= $vp_page->ID;
		$wp_post_types[ viba_portfolio()->post_type ]->post_title 	= $vp_page->post_title;
		$wp_post_types[ viba_portfolio()->post_type ]->post_name 	= $vp_page->post_name;
		$wp_post_types[ viba_portfolio()->post_type ]->post_type    = $vp_page->post_type;
		$wp_post_types[ viba_portfolio()->post_type ]->ancestors    = get_ancestors( $vp_page->ID, $vp_page->post_type );
		
		// Fix conditional Functions like is_front_page
		$vp_query->is_singular 			= false;
		$vp_query->is_post_type_archive = true;
		$vp_query->is_archive 			= true;
		$vp_query->is_page 				= true;

		// Fix WP SEO
		if ( class_exists( 'WPSEO_Meta' ) ) {
			add_filter( 'wpseo_metadesc', 'viba_portfolio_wpseo_metadesc' );
			add_filter( 'wpseo_metakey', 'viba_portfolio_wpseo_metakey' );
		}

	}

	if ( $vp_query->is_post_type_archive( viba_portfolio()->post_type ) || $vp_query->is_tax( get_object_taxonomies( viba_portfolio()->post_type ) ) ) {

		$orderby = viba_portfolio_get_query_option( 'orderby' );

		$vp_query->set( 'posts_per_page', viba_portfolio_get_style_option( 'number' ) );
		$vp_query->set( 'order', viba_portfolio_get_query_option( 'order' ) );
		$vp_query->set( 'orderby', $orderby );

		if ( 'meta_value_num' == $orderby ) {
	    	$vp_query->set( 'meta_key', '_viba_portfolio_likes' );
    	}

		if ( is_viba_portfolio_pagination( 'vp-pagination-load-more' ) ) {
			$vp_query->set( 'paged', '0' );
			$vp_query->set( 'offset', '0' );
		}

	}

	// remove the pre_get_posts hook
	viba_portfolio_remove_pre_get_posts();

}
add_filter( 'pre_get_posts', 'viba_portfolio_pre_get_posts' );

/**
 * Remove the pre_get_posts filter.
 *
 * @since 	1.0
 * @access 	public
 */
function viba_portfolio_remove_pre_get_posts() {
	remove_filter( 'pre_get_posts', 'viba_portfolio_pre_get_posts' );
}

/**
 * Add new option max-num-pages to global options array.
 * We need to add this for pagination to work.
 *
 * @since 	1.0
 * @access 	public
 */
function viba_portfolio_add_max_num_pages() {
	global $viba_portfolio_options, $wp_query;

	$viba_portfolio_options['max-num-pages'] = $wp_query->max_num_pages;
}
add_action( 'pre_get_posts', 'viba_portfolio_add_max_num_pages' );