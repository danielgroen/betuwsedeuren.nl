<?php
/**
 * Viba Portfolio Get Options.
 *
 * General functions for getting options.
 *
 * @package 	Viba_Portfolio/Functions/Options
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*=================================================================
 *
 * 1. GENERAL OPTIONS
 * 2. OPTIONS FOR SINGLE PORTFOLIO ITEMS
 * 3. STYLE OPTIONS
 * 4. QUERY OPTIONS
 * 
 ================================================================*/

/*=================================================================
 *
 * 1. GENERAL OPTIONS
 * 
 ================================================================*/
/**
 * Create a global variable with all the options.
 *
 * @since   1.8.0
 * @access  public
 */
function viba_portfolio_create_theme_options_global() {
    if ( false === ( $options = get_transient( 'viba_portfolio_options' ) ) ) {
        if ( false !== ( $options = get_option( 'viba_portfolio_options' ) ) ) {
            set_transient( 'viba_portfolio_options', $options );
        }
    }
    $GLOBALS['viba_portfolio_options'] = $options;
}
add_action( 'after_setup_theme', 'viba_portfolio_create_theme_options_global' );

/**
 * Delete the options transients.
 *
 * @since   1.8.0
 * @access  public
 */
function viba_portfolio_delete_options_transients() {
    delete_transient( 'viba_portfolio_options' );
}

/**
 * Get Archive Page.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	int/bool Archive page id
 */
function viba_portfolio_get_archive_page() {
	global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_archive_page', ( is_viba_portfolio_archive_enabled() && ! empty( $viba_portfolio_options['archive-page'] ) ) ? esc_attr( $viba_portfolio_options['archive-page'] ): false );
}

/**
 * Get permalinks Base.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string/bool Permalink Base
 */
function viba_portfolio_get_permalinks_base() {
	global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_permalinks_base', ! empty( $viba_portfolio_options['permalinks-base'] ) ? esc_attr( $viba_portfolio_options['permalinks-base'] ) : false );
}

/**
 * Get Category Base.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string/bool Category Base
 */
function viba_portfolio_get_category_base() {
	global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_category_base', ! empty( $viba_portfolio_options['category-base'] ) ? esc_attr( $viba_portfolio_options['category-base'] ) : false );
}

/**
 * Get Tag Base.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string/bool Tag Base
 */
function viba_portfolio_get_tag_base() {
	global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_tag_base', ! empty( $viba_portfolio_options['tag-base'] ) ? esc_attr( $viba_portfolio_options['tag-base'] ) : false );
}

 /**
 * Get the image size.
 *
 * @since 	1.0
 * @access 	public 
 * @param 	string $image_size
 * @return 	array
 */
function viba_portfolio_get_image_size( $image_size ) {
	global $viba_portfolio_options;

	if ( isset( $viba_portfolio_options['image-size-' . $image_size . ''] ) ) {

		if ( in_array( $image_size, array( 'big', 'landscape', 'portrait' ) ) && ! is_viba_portfolio_multi_size_enabled() ) {
			
			$size = false;

		} else {

			$size = $viba_portfolio_options['image-size-' . $image_size . ''];
			$size['crop'] = isset( $size['crop'] ) ? $size['crop'] : 0;

		}

	} else {

		$size = false;

	}

	return apply_filters( 'viba_portfolio_get_image_size_' . $image_size, $size );
}

/*=================================================================
 *
 * 2. OPTIONS FROM SINGLE PORTFOLIO ITEMS
 * 
 ================================================================*/

/**
 * Get overlay color. If the multi color option is enabled return the color 
 * from single items.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	array $color Array with keys background and text with color values
 */
function viba_portfolio_get_overlay_color() {
    $color = viba_portfolio_get_style_option( 'overlay-color' );

	if ( is_viba_portfolio_multi_color() ) {
		$color = get_post_meta( get_the_ID(), '_viba_portfolio_color', true );
	}

	return apply_filters( 'viba_portfolio_overlay_color', $color );
}

/**
 * Get related portfolio items number.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string $number
 */
function viba_portfolio_get_related_number() {
    global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_related_number', $viba_portfolio_options['related-number'] );
}

/**
 * Get related portfolio items layout.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string $layout
 */
function viba_portfolio_get_related_layout() {
    global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_related_layout', $viba_portfolio_options['related-layout'] );
}

/**
 * Get related portfolio items columns.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string $columns
 */
function viba_portfolio_get_related_columns() {
    global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_related_columns', $viba_portfolio_options['related-columns'] );
}

/**
 * Get the thumbnail size.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string $thumbnail_size
 */
function viba_portfolio_get_thumbnail_size() {

	$thumbnail_size = 'viba_portfolio_thumbnail';
	
	if ( is_viba_portfolio_multi_size_enabled() && is_viba_portfolio_layout( 'multi-size-grid' ) ) {
		$thumbnail_size = get_post_meta( get_the_ID(), '_viba_portfolio_image_size', true );
	}

	return apply_filters( 'viba_portfolio_thumbnail_size', $thumbnail_size );
}

/**
 * Get the layout for single portfolio items.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string layout
 */
function viba_portfolio_get_single_layout() {
    global $viba_portfolio_options;
	$layout = $viba_portfolio_options['single-layout'];
	$meta_layout = get_post_meta( get_the_ID(), '_viba_portfolio_layout', true );

	if ( $meta_layout != 'default' ) {
		$layout = $meta_layout;
	}
	
	return apply_filters( 'viba_portfolio_single_layout', $layout );
}

/**
 * Get the short description.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string description
 */
function viba_portfolio_get_short_description() {
	return apply_filters( 'viba_portfolio_short_description', get_post_meta( get_the_ID(), '_viba_portfolio_excerpt', true ) );
}

/**
 * Get Gallery Type.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string $gallery_type gallery type
 */
function viba_portfolio_get_gallery_type() {
	global $viba_portfolio_options;

	$gallery_type 		= $viba_portfolio_options [ 'gallery-type' ];
	$gallery_type_meta  = get_post_meta( get_the_ID(), '_viba_portfolio_gallery_type', true );

	if ( $gallery_type_meta != 'default' ) {
		$gallery_type = $gallery_type_meta;
	}

	return apply_filters( 'viba_portfolio_gallery_type', $gallery_type );
}

/**
 * Get the gallery images.
 *
 * @since 	1.0
 * @access 	public 
 * @param 	int $post_id - Optional post ID to get the gallery images
 * @return 	array gallery images
 */
function viba_portfolio_get_gallery_images( $post_id = false ) {

	if ( false === $post_id ) {
		$post_id = get_the_ID();
	}

    return apply_filters( 'viba_portfolio_gallery_images', get_post_meta( $post_id, '_viba_portfolio_gallery', true ) );

}

/**
 * Get the video files.
 *
 * @since 	1.0
 * @access 	public 
 * @param 	int $post_id - Optional post ID to get the video
 * @return 	array|bool $videos
 */
function viba_portfolio_get_video( $post_id = false ) {
	
	if ( false === $post_id ) {
		$post_id = get_the_ID();
	}

	$video = get_post_meta( $post_id, '_viba_portfolio_video', true );
	$videos = array();

	if ( ! empty( $video['hosted'] ) && count( $video['hosted'] ) > 1 ) {
		$videos['playlist'] = '[playlist type="video" ids="'.implode( ',', $video['hosted'] ) .'"]';
	} else {
		$videos[] = isset( $video['hosted'][0] ) ? wp_get_attachment_url( $video['hosted'][0] ) : false;
	}

	if ( ! empty( $video['external'] ) ) {
		foreach ($video['external'] as $key => $value) {
			$videos[] = $value;
		}
		
	}

	$videos = apply_filters( 'viba_portfolio_video', $videos );

	if ( ! empty( $videos ) ) {
		return array_filter( $videos );
	} else {
		return false;
	}

}

/**
 * Get the audio files-
 *
 * @since 	1.0
 * @access 	public 
 * @param 	int $post_id - Optional post ID to get the audio
 * @return 	array|bool $audio_files
 */
function viba_portfolio_get_audio( $post_id = false ) {

	if ( false === $post_id ) {
		$post_id = get_the_ID();
	}
	
	$audio = get_post_meta( $post_id, '_viba_portfolio_audio', true );
	$audio_files = array();

	if ( ! empty( $audio['hosted'] ) && count( $audio['hosted'] ) > 1 ) {
		$audio_files['playlist'] = '[playlist ids="' . implode( ',', $audio['hosted'] ) . '"]';
	} else {
		$audio_files[] = isset( $audio['hosted'][0] ) ? wp_get_attachment_url( $audio['hosted'][0] ) : false;
	}

	if ( ! empty( $audio['external'] ) ) {
		foreach ($audio['external'] as $key => $value) {
			$audio_files[] = $value;
		}
		
	}

	$audio_files = apply_filters( 'viba_portfolio_audio', $audio_files );

	if ( ! empty( $audio_files ) ) {
		return array_filter( $audio_files );
	} else {
		return false;
	}

}

/**
 * Get the likes.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	int Number of likes
 */
function viba_portfolio_get_likes() {
	return (int) get_post_meta( get_the_ID(), '_viba_portfolio_likes', true );
}

/*=================================================================
 *
 * 3. STYLES OPTIONS
 * 
 ================================================================*/

/**
 * Get Selected Style.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string Selected Style
 */
function viba_portfolio_get_selected_style() {
	global $viba_portfolio_options;
	return apply_filters( 'viba_portfolio_selected_style', $viba_portfolio_options['portfolio-style']['selected-style'] );
}

/**
 * Set Selected Style.
 *
 * @since 	1.0
 * @access 	public 
 * @param 	string $slug Style slug
 * @return 	void
 */
function viba_portfolio_set_selected_style( $slug ) {
	global $viba_portfolio_options;
	$viba_portfolio_options['portfolio-style']['selected-style'] = $slug;
}


/**
 * Get the style option.
 *
 * To get the option value use it like this i.e. viba_portfolio_get_style_option( 'margins' ).
 *
 * Function is filtered with viba_portfolio_style_option_$option i.e. viba_portfolio_style_option_margins.
 *
 * @since 	1.0
 * @access 	public 
 * @param 	string $options Option id
 * @return 	mixed Option value
 */
function viba_portfolio_get_style_option( $option ) {
	global $viba_portfolio_options;

	$selected_style = viba_portfolio_get_selected_style();
	$style_option 	= $viba_portfolio_options['portfolio-style']['styles'][$selected_style][$option];
	$filter 		= strtr( $option, array( '-' => '_' ) );

	return apply_filters( 'viba_portfolio_style_option_'.$filter, $style_option );
}

/**
 * Get template skin.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	array Skin
 */
function viba_portfolio_get_template_skin() {

	$skin = viba_portfolio_get_style_option( 'skin' );
	$type = $skin['type'];
	$style = $skin['style'];
	$theme_support = get_theme_support( 'viba-portfolio-styles' );

	if ( is_array( $theme_support ) ) {
		// Preferred implementation, where theme provides an array of options
		if ( isset( $theme_support[0] ) && is_array( $theme_support[0] ) ) {
			if ( ! in_array( $type.'/'.$style, $theme_support[0] ) ) {
				$type = 'vp-always-visible';
				$style = 'vp-hydrogen';
			}
		}
	}
	$template_skin = array(
		'type' => $type,
		'style' => $style
	);

	return apply_filters( 'viba_portfolio_template_skin', $template_skin );
}

/*=================================================================
 *
 * 4. QUERY OPTIONS
 * 
 ================================================================*/

/**
 * Get the query options.
 *
 * To get the option value use it like this i.e. viba_portfolio_get_query_option( 'category' ).
 *
 * Function is filtered with viba_portfolio_query_option_$option i.e. viba_portfolio_query_option_category.
 *
 * @since 	1.0
 * @access 	public 
 * @param 	string $options Option id
 * @return 	mixed Option value
 */
function viba_portfolio_get_query_option( $option ) {
	global $viba_portfolio_options;

	$selected_style = viba_portfolio_get_selected_style();
	$query 			= '';
	$filter 		= strtr( $option, array( '-' => '_' ) );

	if ( isset( $viba_portfolio_options['portfolio-style']['styles'][$selected_style]['query'][$option] ) ) {
		$query 	= $viba_portfolio_options['portfolio-style']['styles'][$selected_style]['query'][$option];
	}
	
	return apply_filters( 'viba_portfolio_query_option_'.$filter, $query );
}

/**
 * Get the taxonomy used for filter list.
 *
 * @since 	1.0
 * @access 	public 
 * @return 	string $taxonomy Filter taxonomy
 */
function viba_portfolio_get_filter_taxonomy() {
	$filter = viba_portfolio_get_style_option( 'filter-data' );

	switch ( $filter ) {
		case 'category':
			$taxonomy = viba_portfolio()->category_taxonomy;
			break;
		case 'tag':
			$taxonomy = viba_portfolio()->tag_taxonomy;
			break;
		default:
			$taxonomy = viba_portfolio()->category_taxonomy;
			break;
	}

	return apply_filters( 'viba_portfolio_filter_taxonomy', $taxonomy );

}