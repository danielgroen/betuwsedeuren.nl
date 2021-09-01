<?php
/**
 * Fix for WPML main archive page slug.
 *
 * @package 	Viba_Portfolio/Functions/Supported_Plugins
 * @since 		1.0
 * @author 		apalodi
 */

remove_filter( 'option_rewrite_rules', array( 'WPML_Slug_Translation', 'rewrite_rules_filter' ), 1, 1 ); //remove filter from WPML and use WCML filter first
add_filter( 'option_rewrite_rules', 'viba_portfolio_wpml_archive', 4, 1 ) ; // high priority

/**
 * Add new rewrite rules for main archive page.
 *
 * @since 	1.0
 * @access 	public
 * @return 	string
 */
function viba_portfolio_wpml_archive( $value ) {
	global $sitepress, $sitepress_settings;
	
	if ( ! empty( $sitepress_settings['posts_slug_translation']['on'] ) ) {
		add_filter( 'option_rewrite_rules', array( 'WPML_Slug_Translation', 'rewrite_rules_filter' ), 1, 1 );
	}

	if ( viba_portfolio_get_archive_page() ) {

		$current_shop_id = viba_portfolio_get_archive_page();
		$default_shop_id = apply_filters( 'translate_object_id', $current_shop_id, 'page', true, $sitepress->get_default_language() );

		if ( is_null( get_post( $current_shop_id ) ) || is_null( get_post( $default_shop_id ) ) )
			return $value;

		$current_slug = get_post( $current_shop_id )->post_name;
		$default_slug = get_post( $default_shop_id )->post_name;

		print_r( $sitepress->get_default_language() );
		print_r( $current_shop_id );
		print_r( $default_shop_id );

		print_r( $current_slug );
		print_r( $default_slug );

		if( $current_slug != $default_slug ) {
			$buff_value = array();
			foreach ( (array) $value as $k => $v ) {
				if ( $current_slug != $default_slug && preg_match( '#^[^/]*/?' . $default_slug . '/page/#', $k ) ) {
					$k = preg_replace( '#^([^/]*)(/?)' . $default_slug . '/#',  '$1$2' . $current_slug . '/' , $k );
				}
				$buff_value[$k] = $v;
			}

			$value = $buff_value;
			unset( $buff_value );
		}
	}

	return $value;
}