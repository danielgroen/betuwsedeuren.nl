<?php
/**
 * Viba Portoflio Conditional Functions.
 *
 * Functions for determining on what page we are and is some option enabled.
 *
 * @package 	Viba_Portfolio/Functions/
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns true when viewing pages that have portfolios.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio() {
	return ( is_viba_portfolio_page() || is_viba_portfolio_archive() || is_viba_portfolio_single() || is_viba_portfolio_search() ) ? true : false;
}

/**
 * Returns true when viewing the main archive page.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_page() {
	return ( is_post_type_archive( viba_portfolio()->post_type ) && ! is_search() ) ? true : false;
}

/**
 * Returns true when viewing a single portfolio.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_single() {
	return is_singular( array( viba_portfolio()->post_type ) );
}

/**
 * Returns true when viewing the search page.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_search() {
	return ( is_post_type_archive( viba_portfolio()->post_type ) && is_search() ) ? true : false;
}

/**
 * Returns true when viewing the archive pages.
 *
 * TODO: when we add date archives add the conditional
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_archive() {
	return ( is_viba_portfolio_taxonomy() ) ? true : false;
}

/**
 * Returns true when viewing a taxonomy archive.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_taxonomy() {
	return is_tax( get_object_taxonomies( viba_portfolio()->post_type ) );
}

/**
 * Returns true when viewing a category archive.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $term (default: '') The term slug you are checking for. Leave blank to return true on any.
 * @return 	bool
 */
function is_viba_portfolio_category( $term = '' ) {
	return is_tax( viba_portfolio()->category_taxonomy, $term );
}

/**
 * Returns true when viewing a tag archive.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $term (default: '') The term slug you are checking for. Leave blank to return true on any.
 * @return 	bool
 */
function is_viba_portfolio_tag( $term = '' ) {
	return is_tax( viba_portfolio()->tag_taxonomy, $term );
}

/**
 * Returns true when shortcode is active on page.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_shortcode_active() {
	global $post;
	return ( $post ) ? has_shortcode( $post->post_content, 'viba_portfolio' ) : false;
}

/**
 * Returns true when the style is created.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_style_available( $style ) {
	global $viba_portfolio_options;	
	return array_key_exists( $style, $viba_portfolio_options['portfolio-style']['styles'] ) ? true : false;
}

/**
 * Returns true when the load all scripts is enabled.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_loading_all_scripts() {
	global $viba_portfolio_options;	
	return ( '1' == $viba_portfolio_options['load-all-scripts'] ) ? true : false;
}

/*==========================================================
=========================================================*/

/**
 * Returns true when the archives are enabled.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_archive_enabled() {
	global $viba_portfolio_options;
	$has_archive = isset( $viba_portfolio_options['has-archive'] ) ? $viba_portfolio_options['has-archive'] : false;
	return ( '1' == $has_archive ) ? true : false;
}

/**
 * Returns true when multi sizes option is enabled.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_multi_size_enabled() {
	global $viba_portfolio_options;
	return ( '1' == $viba_portfolio_options['multi-sizes'] ) ? true : false;
}

/**
 * Returns true when the desired layout is selected. When on single portolios
 * it's checking the related items layout.
 * Available options are grid, multi-size-grid and carousel.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $layout - Layout to query
 * @return 	bool
 */
function is_viba_portfolio_layout( $layout ) {

	$saved_layout = viba_portfolio_get_style_option( 'layout' );

	if ( is_viba_portfolio_single() ) {
		$saved_layout = viba_portfolio_get_related_layout();
	}

	return ( 'vp-layout-' . $layout == $saved_layout ) ? true : false;
}

/**
 * Returns true when the desired effect is selected.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_overlay() {
	$hover_effect = viba_portfolio_get_style_option( 'hover-effect' );
	return ( '1' == $hover_effect['overlay']['vp-overlay'] ) ? true : false;
}

/**
 * Returns true when the desired visibility is selected.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $visibility - Effect to query
 * @return 	bool
 */
function is_viba_portfolio_overlay_visible( $visibility ) {
	return ( 'vp-overlay-' . $visibility == viba_portfolio_get_style_option( 'overlay-visibility' ) ) ? true : false;
}

/**
 * Returns true when the desired effect is selected.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $effect - Effect to query
 * @return 	bool
 */
function is_viba_portfolio_image_effect( $effect ) {
	$hover_effect = viba_portfolio_get_style_option( 'hover-effect' );
	return ( '1' == $hover_effect['image'][$effect] ) ? true : false;
}

/**
 * Returns true when the info is set to show. Use without parametar to see
 * if any info is selected.
 *
 * Available options are: zoom-button, link-button, title, categories, description, likes.
 *
 * You can use it as string or array
 *		1. returns true if any of the options in array is selected
 *			- is_viba_portfolio_info( array( 'likes', 'title', 'categories', 'description' )
 *
 *	 	2. returns true if the option is selected
 * 			- is_viba_portfolio_info( 'zoom-button' )
 *
 * 		3. returns true if any option is selected
 * 			- is_viba_portfolio_info()
 *
 * @since 	1.0
 * @access 	public
 * @param 	array|string $info - What info do you want test
 * @return 	bool
 */
function is_viba_portfolio_info( $info = false ) {
	$viba_portfolio_info = viba_portfolio_get_style_option( 'informations' );

	if ( $info ) {
		if ( is_array( $info ) ) {
			foreach ( $info as $key => $value ) {
				$new_info_array[] = $viba_portfolio_info[ $value ];
			}
			return ( in_array( '1', $new_info_array ) ) ? true : false;
		} else { 
			return ( $viba_portfolio_info[ $info ] == '1' ) ? true : false;
		}
	} else {
		return ( in_array( '1', $viba_portfolio_info ) ) ? true : false;
	}
}

/**
 * Returns true when informations arrow is set.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_informations_arrow() {
	return ( '1' == viba_portfolio_get_style_option( 'informations-arrow' ) ) ? true : false;
}

/**
 * Returns true when filter is enabled.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_filter() {
	return ( '1' == viba_portfolio_get_style_option( 'filter' ) ) ? true : false;
}

/**
 * Returns true when pagination is enabled and when there are more pages.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $type Pagination type
 * @return 	bool
 */
function is_viba_portfolio_pagination( $type = false ) {

	if ( $type ) {
		return ( $type == viba_portfolio_get_style_option( 'pagination-type' ) ) ? true : false;
	} else {
		return ( '1' == viba_portfolio_get_style_option( 'pagination' ) && viba_portfolio_get_max_num_pages() > 1 ) ? true : false;
	}

}

/**
 * Returns true when the ajax is enabled.
 * First it checks on what page we are, if we are
 * on the archive page then it uses value from default style.
 * If we are not on archive page that means we are using shortcode.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_ajax() {
	global $viba_portfolio_options;
	$ajax_fix = $viba_portfolio_options['ajax-fix'];

	if ( '1' == $ajax_fix ) {
		return true;
	} else {
		$is_ajax = ( '1' == viba_portfolio_get_style_option( 'ajax' ) ) ? true : false;
		return apply_filters( 'is_viba_portfolio_ajax', ( is_viba_portfolio_page() || is_viba_portfolio_archive() || is_viba_portfolio_search() ) ? $is_ajax : is_viba_portfolio_shortcode_ajax() );
	}
}

/**
 * Returns true when the the active shortcode is using ajax. 
 * If the page has more shortcodes only one needs to use ajax
 * and this function will return true.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_shortcode_ajax() {
	global $post, $viba_portfolio_options;

	$slugs = $ajax = array();
	$styles = $viba_portfolio_options['portfolio-style']['styles'];

	if ( ! $post )
		return false;

	preg_match_all( '(\[viba_portfolio.*?])', $post->post_content, $matches, PREG_SET_ORDER );

	if ( empty( $matches ) )
		return false;

	foreach ( $matches as $shortcode ) {
		preg_match( '/"([^"]*)"/', $shortcode[0], $slug );
		if ( ! empty( $slug ) ) {
			$slugs[] = $slug[1];
		} else {
			$slugs[] = 'default';
		}
	}

	foreach ( $styles as $slug => $style ) {
		if ( in_array( $slug, $slugs ) && '1' == $style['ajax'] ) {
			$ajax[] = '1';
		}
	}

	return ( empty( $ajax ) ) ? false : true;

}

/**
 * Returns true when multi color option is enabled.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_multi_color() {
	return ( '1' == viba_portfolio_get_style_option( 'multi-color' ) ) ? true : false;
}

/**
 * Returns true when the gallery type is selected.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_gallery_type() {
	return ( $type == viba_portfolio_get_gallery_type() ) ? true : false;
}

/**
 * Returns true when the gallery type is selected.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_audio_thumbnail() {
	global $viba_portfolio_options;
	return ( '1' == $viba_portfolio_options['audio-thumbnail'] ) ? true : false;
}

/**
 * Returns true when the meta is set to show. Use without parametar to see
 * if any meta is selected.
 *
 * Available options are: data, client, categories, tags, project-link, likes, share
 *
 * You can use it as string or array
 *		1. returns true if any of the options in array is selected
 *			- is_viba_portfolio_meta( array( 'likes', 'client', 'categories', 'tags' )
 *
 *	 	2. returns true if the option is selected
 * 			- is_viba_portfolio_meta( 'date' )
 *
 * 		3. returns true if any option is selected
 * 			- is_viba_portfolio_meta()
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $meta - What meta do you want test
 * @return 	bool
 */
function is_viba_portfolio_meta( $meta = false ) {
	global $viba_portfolio_options;
	$viba_portfolio_meta = $viba_portfolio_options['single-meta'];

	if ( $meta ) {
		if ( is_array( $meta ) ) {
			foreach ( $meta as $key => $value ) {
				$new_meta_array[] = $viba_portfolio_meta[ $value ];
			}
			return ( in_array( '1', $new_meta_array ) ) ? true : false;
		} else { 
			return ( $viba_portfolio_meta[ $meta ] == '1' ) ? true : false;
		}
	} else {
		return ( in_array( '1', $viba_portfolio_meta ) ) ? true : false;
	}

}

/**
 * Returns true when the share icon is set to show. Use without parametar to see
 * if any share icon is selected.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $share - What share do you want test
 * @return 	bool
 */
function is_viba_portfolio_share( $share = false ) {
	global $viba_portfolio_options;
	$viba_portfolio_share = $viba_portfolio_options['single-share'];

	if ( $share ) {
		return ( $viba_portfolio_share[ $share ] == '1' ) ? true : false;
	} else {
		return ( in_array( '1', $viba_portfolio_share ) ) ? true : false;
	}
}

/**
 * Returns true when there are related items to show.
 *
 * @since 	1.0
 * @access 	public
 * @return 	bool
 */
function is_viba_portfolio_related() {
	global $viba_portfolio_options;
	return ( 0 != viba_portfolio_get_related_items( 'number' ) && '1' == $viba_portfolio_options['related-items'] ) ? true : false;
}

/**
 * Returns true when the desired related items layout is selected.
 * Available options are grid, multi-size-grid and carousel.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $layout - Layout to query
 * @return 	bool
 */
function is_viba_portfolio_related_layout( $layout ) {
	return ( 'vp-layout-' . $layout == viba_portfolio_get_related_layout() ) ? true : false;
}


/*==========================================================
=========================================================*/


/**
 * Returns true if there are items with a desired post format.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $format - Format to check
 * @return 	bool
 */
function viba_portfolio_format_exists( $format ) {

	$query_args = array(
		'posts_per_page' => -1,
		'post_type'=> viba_portfolio()->post_type,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'terms' => 'post-format-' . $format,
				'field' => 'slug'
			)
		)
	);

	$posts_array = get_posts( $query_args ); 

	return sizeof( $posts_array ) > 0 ? true : false;

}

/**
 * Returns true if there is a audio or video post format with playlist.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $format - Format to check, video or audio
 * @return 	bool
 */
function viba_portfolio_playlist_exists( $format ) {

	$playlist = array();
	$query_args = array(
		'posts_per_page' => -1,
		'post_type'=> viba_portfolio()->post_type,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'terms' => 'post-format-'.$format,
				'field' => 'slug'
			)
		)
	);

	$posts_array = get_posts( $query_args ); 

	foreach ( $posts_array as $post ) {

		if ( 'audio' == $format ) :
			if ( array_key_exists( 'playlist', viba_portfolio_get_audio( $post->ID ) ) ) :
				$playlist[] = 'playlist';
			endif;
		else:
			if ( array_key_exists( 'playlist', viba_portfolio_get_video( $post->ID ) ) ) :
				$playlist[] = 'playlist';
			endif;
		endif;
		
	}

	return in_array( 'playlist', $playlist ) ? true : false;

}