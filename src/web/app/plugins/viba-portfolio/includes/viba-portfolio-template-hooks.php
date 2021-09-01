<?php
/**
 * Viba Portfolio Template Hooks.
 *
 * Action/filter hooks used for Viba Portfolio functions/templates
 *
 * @package 	Viba_Portfolio/Hooks/Template
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** 
 * WP Header.
 *
 * @see  viba_portfolio_generator_tag()
 */
add_action( 'get_the_generator_html', 'viba_portfolio_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'viba_portfolio_generator_tag', 10, 2 );

/**
 * Content Wrappers.
 *
 * @see viba_portfolio_content_wrapper()
 * @see viba_portfolio_content_wrapper_end()
 * @see viba_portfolio_title_wrapper()
 * @see viba_portfolio_title_wrapper_end()
 */
add_action( 'viba_portfolio_before_main_content', 'viba_portfolio_content_wrapper', 10 );
add_action( 'viba_portfolio_after_main_content', 'viba_portfolio_content_wrapper_end', 10 );
add_action( 'viba_portfolio_before_title', 'viba_portfolio_title_wrapper', 10 );
add_action( 'viba_portfolio_after_title', 'viba_portfolio_title_wrapper_end', 10 );

/**
 * Viba Portfolio Filter.
 *
 * @see viba_portfolio_filter()
 */
add_action( 'viba_portfolio_before_loop', 'viba_portfolio_filter', 10 );

/**
 * Viba Portfolio Pagination.
 *
 * @see viba_portfolio_pagination()
 */
add_action( 'viba_portfolio_after_loop', 'viba_portfolio_pagination', 10 );

/**
 * Viba Portfolio Single.
 *
 * @see viba_portfolio_title()
 * @see viba_portfolio_single_media()
 * @see viba_portfolio_single_description()
 * @see viba_portfolio_single_meta()
 * @see viba_portfolio_single_pagination()
 * @see viba_portfolio_related()
 */
add_action( 'viba_portfolio_before_single_content', 'viba_portfolio_title', 10 );
add_action( 'viba_portfolio_before_single_content', 'viba_portfolio_single_media', 20 );

add_action( 'viba_portfolio_single_content', 'viba_portfolio_single_description', 10 );
add_action( 'viba_portfolio_single_content', 'viba_portfolio_single_meta', 20 );

add_action( 'viba_portfolio_after_single_content', 'viba_portfolio_single_pagination', 10 );
add_action( 'viba_portfolio_after_single_content', 'viba_portfolio_related', 20 );

add_action( 'viba_portfolio_before_password_required', 'viba_portfolio_title', 10 );
add_action( 'viba_portfolio_password_required', 'viba_portfolio_password_form', 10 );

/**
 * Viba Portfolio Single Meta.
 *
 * @see viba_portfolio_single_meta_date()
 * @see viba_portfolio_single_meta_client()
 * @see viba_portfolio_single_meta_categories()
 * @see viba_portfolio_single_meta_tags()
 * @see viba_portfolio_single_meta_project_link()
 * @see viba_portfolio_single_meta_likes()
 * @see viba_portfolio_single_meta_share()
 */
add_action( 'viba_portfolio_single_meta', 'viba_portfolio_single_meta_date', 10 );
add_action( 'viba_portfolio_single_meta', 'viba_portfolio_single_meta_client', 20 );
add_action( 'viba_portfolio_single_meta', 'viba_portfolio_single_meta_categories', 30 );
add_action( 'viba_portfolio_single_meta', 'viba_portfolio_single_meta_tags', 40 );
add_action( 'viba_portfolio_single_meta', 'viba_portfolio_single_meta_project_link', 50 );
add_action( 'viba_portfolio_single_meta', 'viba_portfolio_single_meta_likes', 60 );
add_action( 'viba_portfolio_single_meta', 'viba_portfolio_single_meta_share', 70 );

/**
 * Viba Portfolio Custom Classes.
 *
 * @see viba_portfolio_get_body_classes()
 * @see viba_portfolio_get_wrapper_classes()
 * @see viba_portfolio_get_container_classes()
 * @see viba_portfolio_get_post_classes()
 * @see viba_portfolio_get_item_classes()
 * @see viba_portfolio_get_item_inner_classes()
 * @see viba_portfolio_get_filter_classes()
 * @see viba_portfolio_get_pagination_classes()
 * @see viba_portfolio_get_likes_classes()
 * @see viba_portfolio_get_gallery_classes()
 */
add_filter( 'body_class', 'viba_portfolio_get_body_classes', 10 );
add_filter( 'viba_portfolio_wrapper_classes', 'viba_portfolio_get_wrapper_classes', 10 );
add_filter( 'viba_portfolio_container_classes', 'viba_portfolio_get_container_classes', 10 );

add_filter( 'post_class', 'viba_portfolio_get_post_classes', 20 );
add_filter( 'viba_portfolio_item_classes', 'viba_portfolio_get_item_classes', 10 );
add_filter( 'viba_portfolio_item_inner_classes', 'viba_portfolio_get_item_inner_classes', 10 );

add_filter( 'viba_portfolio_filter_classes', 'viba_portfolio_get_filter_classes', 10 );
add_filter( 'viba_portfolio_pagination_classes', 'viba_portfolio_get_pagination_classes', 10 );
add_filter( 'viba_portfolio_likes_classes', 'viba_portfolio_get_likes_classes', 10 );

add_filter( 'viba_portfolio_gallery_classes', 'viba_portfolio_get_gallery_classes', 10 );

/**
 * Viba Portfolio Tag Attributes.
 *
 * @see viba_portfolio_get_link_tag_attr()
 * @see viba_portfolio_get_zoom_button_tag_attr()
 */
add_filter( 'viba_portfolio_link_tag_attr', 'viba_portfolio_get_link_tag_attr', 10 );
add_filter( 'viba_portfolio_zoom_button_tag_attr', 'viba_portfolio_get_zoom_button_tag_attr', 10 );

/**
 * Viba Portfolio Data Attributes.
 *
 * @see viba_portfolio_get_wrapper_data_attr()
 * @see viba_portfolio_get_container_data_attr()
 * @see viba_portfolio_get_single_media_data_attr()
 * @see viba_portfolio_get_load_more_data_attr()
 */
add_filter( 'viba_portfolio_wrapper_data_attr', 'viba_portfolio_get_wrapper_data_attr', 10 );
add_filter( 'viba_portfolio_container_data_attr', 'viba_portfolio_get_container_data_attr', 10 );
add_filter( 'viba_portfolio_single_media_data_attr', 'viba_portfolio_get_single_media_data_attr', 10 );
add_filter( 'viba_portfolio_load_more_data_attr', 'viba_portfolio_get_load_more_data_attr', 10 );

/**
 * Viba Portfolio Inline Styles.
 *
 * @see viba_portfolio_get_overlay_inline_styles()
 * @see viba_portfolio_get_cover_content_inline_styles()
 * @see viba_portfolio_get_content_inline_styles()
 */
add_action( 'viba_portfolio_overlay_inline_styles', 'viba_portfolio_get_overlay_inline_styles', 10 );
add_action( 'viba_portfolio_cover_content_inline_styles', 'viba_portfolio_get_cover_content_inline_styles', 10 );
add_action( 'viba_portfolio_content_inline_styles', 'viba_portfolio_get_content_inline_styles', 10 );