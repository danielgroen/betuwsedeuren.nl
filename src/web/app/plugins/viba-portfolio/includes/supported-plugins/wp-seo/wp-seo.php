<?php
/**
 * Fix for WordPress SEO.
 *
 * @package 	Viba_Portfolio/Functions/Supported_Plugins
 * @since 	    1.0
 * @author 		apalodi
 */

/**
 * Hooked into wpseo_ hook already, so no need for function_exist.
 *
 * @since 	1.0
 * @access 	public
 * @return 	string
 */
function viba_portfolio_wpseo_metadesc() {
	return WPSEO_Meta::get_value( 'metadesc', viba_portfolio_get_archive_page() );
}

/**
 * Hooked into wpseo_ hook already, so no need for function_exist.
 *
 * @since 	1.0
 * @access 	public
 * @return 	string
 */
function viba_portfolio_wpseo_metakey() {
	return WPSEO_Meta::get_value( 'metakey', viba_portfolio_get_archive_page() );
}