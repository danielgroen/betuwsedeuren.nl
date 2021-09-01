<?php
/**
 * Viba Portfolio Template Styles CSS.
 *
 * @package 	Viba_Portfolio/Functions/Styles
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get the generated custom CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	string $custom_css
 */
function viba_portfolio_get_custom_css() {
	$generated_css = viba_portfolio_generate_custom_css();
	$custom_css = '';

	foreach ( $generated_css as $style ) {
		foreach ( $style as $css ) {
			if ( is_array( $css ) ) {
				foreach ( $css as $value ) {
					$custom_css .= $value;
				}
			} else {
				$custom_css .= $css;
			} 
		}
	}

	return $custom_css;
}

/**
 * Generate custom styles CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $custom_css
 */
function viba_portfolio_generate_custom_css() {
	global $viba_portfolio_options;

	$styles 	= $viba_portfolio_options['portfolio-style'];
	$custom_css = array();

	foreach ( $styles['styles'] as $slug => $style ) {

		$margins 				= $style['margins'];
		$padding 				= $style['padding'];
		$opacity 				= esc_attr( viba_portfolio_number_to_opacity( $style['overlay-opacity'] ) );
		$animation_duration 	= esc_attr( $style['item-animation-duration'] );
		$overlay_color 			= $style['overlay-color'];
		$info_color 			= $style['informations-color'];
		$spinner_color 			= $style['spinner-color'];
		$filter_color 			= $style['filter-color'];
		$pagination_color 		= $style['pagination-color'];
		$typography 			= $style['typography'];
		$skin_style 			= $style['skin']['style'];
		$style_css 				= esc_attr( $style['custom-css'] );

		$custom_css[$slug]['global'] 			= viba_portfolio_generate_global_css( $slug, $overlay_color, $info_color, $opacity );
		$custom_css[$slug]['animations'] 		= viba_portfolio_generate_animation_css( $slug, $animation_duration );
		$custom_css[$slug]['padding-margins'] 	= viba_portfolio_generate_padding_margin_css( $slug, $padding, $margins );
		$custom_css[$slug]['loader'] 			= viba_portfolio_generate_loader_css( $slug, $spinner_color );

		if ( '1' == $style['filter'] ) {
			$custom_css[$slug]['filter'] 		= viba_portfolio_generate_filter_css( $slug, $filter_color, $info_color );
		}

		if ( '1' == $style['pagination'] ) {
			$custom_css[$slug]['pagination'] 	= viba_portfolio_generate_pagination_css( $slug, $pagination_color, $info_color );
		}

		$custom_css[$slug]['typography'] 		= viba_portfolio_generate_typography_css( $slug, $typography );
		$custom_css[$slug]['styles'] 			= viba_portfolio_generate_styles_css( $slug, $skin_style, $overlay_color, $info_color, $opacity );

		if ( ! empty( $style_css ) ) {
			$custom_css[$slug]['custom'] = "
			/* Custom CSS */ 
			{$style_css}";
		}

	}
    
    return apply_filters( 'viba_portfolio_custom_css', $custom_css );

}

/**
 * Global CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $css
 */
function viba_portfolio_generate_global_css( $slug, $overlay_color, $info_color, $opacity ) {
	$css[] = "
	.vp-style-{$slug} .viba-portfolio-item-inner { color: {$info_color['text']}; background-color: {$info_color['background']}; }
	.vp-style-{$slug} .viba-portfolio-arrow:before { background-color: {$info_color['background']}; }

	.vp-style-{$slug} .viba-portfolio-overlay { background-color: {$overlay_color['background']}; }
	.vp-style-{$slug} .viba-portfolio-cover,
	.vp-style-{$slug} .viba-portfolio-cover-fixed { color: {$overlay_color['text']}; }
		
	.vp-style-{$slug} .vp-slide-overlay .viba-portfolio-overlay,
	.vp-style-{$slug} .vp-overlay-off-hover .viba-portfolio-overlay,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-overlay,
	.vp-style-{$slug} .vp-overlay-on-hover .viba-portfolio-item-inner:hover .viba-portfolio-overlay, 
	.vp-style-{$slug} .vp-slide-overlay .viba-portfolio-item-inner:hover .viba-portfolio-overlay { opacity: {$opacity}; }
	";

	return apply_filters( 'viba_portfolio_global_css', $css, $slug, $overlay_color, $info_color, $opacity );
}

/**
 * Animation CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $css
 */
function viba_portfolio_generate_animation_css( $slug, $animation_duration ) {
	$css[] = "
	.vp-style-{$slug}.js-vp-loaded .viba-portfolio-item { -webkit-animation-duration: {$animation_duration}ms; animation-duration: {$animation_duration}ms; }
	.vp-style-{$slug} .vp-layout-carousel .owl-item,
	.vp-style-{$slug} .vp-layout-carousel .owl-item .viba-portfolio-item { -webkit-transition-duration: {$animation_duration}ms; transition-duration: {$animation_duration}ms; }
	";

	return apply_filters( 'viba_portfolio_animation_css', $css, $slug, $animation_duration );
}

/**
 * Padding and Margins CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $css
 */
function viba_portfolio_generate_padding_margin_css( $slug, $padding, $margins ) {
	$css[] = "
	/* mobile portrait */
	.vp-style-{$slug}.viba-portfolio-wrapper { padding: {$padding['mobile-portrait']} }
	.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins { margin: -" . $margins['mobile-portrait'] / 2 . "px; }
	.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins .viba-portfolio-item { padding: " . $margins['mobile-portrait'] / 2 . "px; }

	/* mobile landscape */
	@media screen and ( min-width: 480px ) {
		.vp-style-{$slug}.viba-portfolio-wrapper { padding: {$padding['mobile-landscape']} }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins { margin: -" . $margins['mobile-landscape'] / 2 . "px; }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins .viba-portfolio-item { padding: " . $margins['mobile-landscape'] / 2 . "px; }
	}
	/* tablet portrait */
	@media screen and ( min-width: 768px ) {
		.vp-style-{$slug}.viba-portfolio-wrapper { padding: {$padding['tablet-portrait']} }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins { margin: -" . $margins['tablet-portrait'] / 2 . "px; }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins .viba-portfolio-item { padding: " . $margins['tablet-portrait'] / 2 . "px; }
	}
	/* tablet landscape */
	@media screen and ( min-width: 960px ) {
		.vp-style-{$slug}.viba-portfolio-wrapper { padding: {$padding['tablet-landscape']} }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins { margin: -" . $margins['tablet-landscape'] / 2 . "px; }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins .viba-portfolio-item { padding: " . $margins['tablet-landscape'] / 2 . "px; }
	}
	/* desktop small */
	@media screen and ( min-width: 1124px ) {
		.vp-style-{$slug}.viba-portfolio-wrapper { padding: {$padding['desktop-small']} }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins { margin: -" . $margins['desktop-small'] / 2 . "px; }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins .viba-portfolio-item { padding: " . $margins['desktop-small'] / 2 . "px; }
	}
	/* desktop large */
	@media screen and ( min-width: 1400px ) {
		.vp-style-{$slug}.viba-portfolio-wrapper { padding: {$padding['desktop-large']} }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins { margin: -" . $margins['desktop-large'] / 2 . "px; }
		.vp-style-{$slug}.viba-portfolio-wrapper .viba-portfolio.vp-margins .viba-portfolio-item { padding: " . $margins['desktop-large'] / 2 . "px; }
	}
	";

	return apply_filters( 'viba_portfolio_padding_margin_css', $css, $slug, $padding, $margins );
}


/**
 * Loader CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $css
 */
function viba_portfolio_generate_loader_css( $slug, $spinner_color ) {
	$css[] = "
	.vp-style-{$slug} .vp-loader,
	.vp-style-{$slug} .vp-loader:before,
	.vp-style-{$slug} .vp-loader:after,
	.vp-style-{$slug} .vp-loader div { color: {$spinner_color['text']}; background-color: {$spinner_color['background']}; }
	.vp-style-{$slug} .vp-loader-4:before,
	.vp-style-{$slug} .vp-loader-7:before { background-color: {$spinner_color['text']}; }
	.vp-style-{$slug} .vp-loader-8 { border-bottom: 5px solid {$spinner_color['background']}; border-left: 5px solid {$spinner_color['background']}; }
	";

	return apply_filters( 'viba_portfolio_loader_css', $css, $slug, $spinner_color );
}

/**
 * Filter CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $css
 */
function viba_portfolio_generate_filter_css( $slug, $filter_color, $info_color ) {
	$css[] = "
	.vp-style-{$slug} .viba-portfolio-filter li a:hover, 
	.vp-style-{$slug} .viba-portfolio-filter li a.selected,
	.vp-style-{$slug} .vp-filter-slide-in .vp-filter-button:hover { background-color: {$filter_color['background']}; border-color: {$filter_color['background']}; color: {$filter_color['text']}; }
	.vp-style-{$slug} .vp-filter-dropdown ul li a:hover,
	.vp-style-{$slug} .vp-filter-dropdown ul li a.selected { background:none; color: {$filter_color['background']}; }
	";

	return apply_filters( 'viba_portfolio_filter_css', $css, $slug, $filter_color, $info_color );
}

/**
 * Pagination CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $css
 */
function viba_portfolio_generate_pagination_css( $slug, $pagination_color, $info_color ) {
	$css[] = "
	.vp-style-{$slug} .vp-pagination-numbers ul.page-numbers a.page-numbers:hover,
	.vp-style-{$slug} .vp-pagination-numbers ul.page-numbers .page-numbers.current,
	.vp-style-{$slug} .vp-pagination-arrow a:hover,
	.vp-style-{$slug} .vp-load-more:hover { background-color: {$pagination_color['background']}; border-color: {$pagination_color['background']}; color: {$pagination_color['text']}; }
	";

	return apply_filters( 'viba_portfolio_pagination_css', $css, $slug, $pagination_color, $info_color );
}

/**
 * Typography CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $css
 */
function viba_portfolio_generate_typography_css( $slug, $typography ) {

	$title = "font-size:{$typography['title']['font-size']}; line-height:{$typography['title']['line-height']}; text-transform:{$typography['title']['text-transform']};";
	if ( isset( $typography['title']['default'] ) && "''" != $typography['title']['family'] ) {
		if ( '1' != $typography['title']['default'] ) {
			$title = $title." font-family: {$typography['title']['family']}; font-weight:{$typography['title']['font-weight']};";
		}
	}
	if ( isset( $typography['title']['italic'] ) ) {
		if ( '1' == $typography['title']['italic'] ) {
			$title = $title." font-style:italic;";
		}
	}

	$buttons = "font-size:{$typography['buttons']['font-size']}; line-height:{$typography['buttons']['line-height']}; text-transform:{$typography['buttons']['text-transform']};";
	if ( isset( $typography['buttons']['default'] ) && "''" != $typography['buttons']['family'] ) {
		if ( '1' != $typography['buttons']['default'] ) {
			$buttons = $buttons." font-family: {$typography['buttons']['family']}; font-weight:{$typography['buttons']['font-weight']};";
		}
	}
	if ( isset( $typography['buttons']['italic'] ) ) {
		if ( '1' == $typography['buttons']['italic'] ) {
			$buttons = $buttons." font-style:italic;";
		}
	}

	$likes = "font-size:{$typography['likes']['font-size']}; line-height:{$typography['likes']['line-height']}; text-transform:{$typography['likes']['text-transform']};";
	if ( isset( $typography['likes']['default'] ) && "''" != $typography['likes']['family'] ) {
		if ( '1' != $typography['likes']['default'] ) {
			$likes = $likes." font-family: {$typography['likes']['family']}; font-weight:{$typography['likes']['font-weight']};";
		}
	}
	if ( isset( $typography['likes']['italic'] ) ) {
		if ( '1' == $typography['likes']['italic'] ) {
			$likes = $likes." font-style:italic;";
		}
	}

	$categories = "font-size:{$typography['categories']['font-size']}; line-height:{$typography['categories']['line-height']}; text-transform:{$typography['categories']['text-transform']};";
	if ( isset( $typography['categories']['default'] ) && "''" != $typography['categories']['family'] ) {
		if ( '1' != $typography['categories']['default'] ) {
			$categories = $categories." font-family: {$typography['categories']['family']}; font-weight:{$typography['categories']['font-weight']};";
		}
	}
	if ( isset( $typography['categories']['italic'] ) ) {
		if ( '1' == $typography['categories']['italic'] ) {
			$categories = $categories." font-style:italic;";
		}
	}

	$desc = "font-size:{$typography['desc']['font-size']}; line-height:{$typography['desc']['line-height']}; text-transform:{$typography['desc']['text-transform']};";
	if ( isset( $typography['desc']['default'] ) && "''" != $typography['desc']['family'] ) {
		if ( '1' != $typography['desc']['default'] ) {
			$desc = $desc." font-family: {$typography['desc']['family']}; font-weight:{$typography['desc']['font-weight']};";
		}
	}
	if ( isset( $typography['desc']['italic'] ) ) {
		if ( '1' == $typography['desc']['italic'] ) {
			$desc = $desc." font-style:italic;";
		}
	}

	$filter = "font-size:{$typography['filter']['font-size']}; line-height:{$typography['filter']['line-height']}; text-transform:{$typography['filter']['text-transform']};";
	if ( isset( $typography['filter']['default'] ) && "''" != $typography['filter']['family'] ) {
		if ( '1' != $typography['filter']['default'] ) {
			$filter = $filter." font-family: {$typography['filter']['family']}; font-weight:{$typography['filter']['font-weight']};";
		}
	}
	if ( isset( $typography['filter']['italic'] ) ) {
		if ( '1' == $typography['filter']['italic'] ) {
			$filter = $filter." font-style:italic;";
		}
	}

	$pagination = "font-size:{$typography['pagination']['font-size']}; line-height:{$typography['pagination']['line-height']}; text-transform:{$typography['pagination']['text-transform']};";
	if ( isset( $typography['pagination']['default'] ) && "''" != $typography['pagination']['family'] ) {
		if ( '1' != $typography['pagination']['default'] ) {
			$pagination = $pagination." font-family: {$typography['pagination']['family']}; font-weight:{$typography['pagination']['font-weight']};";
		}
	}
	if ( isset( $typography['pagination']['italic'] ) ) {
		if ( '1' == $typography['pagination']['italic'] ) {
			$pagination = $pagination." font-style:italic;";
		}
	}

	$css[] = "
	.vp-style-{$slug} .viba-portfolio .viba-portfolio-title { {$title} }
	.vp-style-{$slug} .viba-portfolio .viba-portfolio-item-button { {$buttons} }
	.vp-style-{$slug} .viba-portfolio .viba-portfolio-likes { {$likes} }
	.vp-style-{$slug} .viba-portfolio .viba-portfolio-categories { {$categories} }
	.vp-style-{$slug} .viba-portfolio .viba-portfolio-short-description p { {$desc} }
	.vp-style-{$slug} .viba-portfolio-filter a,
	.vp-style-{$slug} .viba-portfolio-filter .vp-filter-button { {$filter} }
	.vp-style-{$slug} .viba-portfolio-pagination ul.page-numbers .page-numbers,
	.vp-style-{$slug} .viba-portfolio-pagination .vp-pagination-arrow-desc,
	.vp-style-{$slug} .viba-portfolio-pagination .vp-load-more { {$pagination} }
	";

	return apply_filters( 'viba_portfolio_typography_css' , $css, $slug, $typography );
}

/**
 * Skin style custom CSS.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $styles
 */
function viba_portfolio_generate_styles_css( $slug, $skin_style, $overlay_color, $info_color, $opacity ) {

	$styles['vp-helium'] = "
	/* Helium */
	.vp-style-{$slug} .viba-portfolio-helium-overlay { background-color: {$overlay_color['background']} }
	.vp-style-{$slug} .viba-portfolio-helium-overlay { opacity: {$opacity}; }
		";

	$styles['vp-carbon'] = "
	/* Carbon */
	.vp-style-{$slug} .vp-carbon .viba-portfolio-overlay:after { background-color: {$info_color['background']}; }
	.vp-style-{$slug} .vp-carbon .viba-portfolio-cover-content { color: {$info_color['text']}; }
		";

	$styles['vp-beryllium'] = "
	/* Beryllium */
	.vp-style-{$slug} .vp-beryllium.vp-visible-on-hover .viba-portfolio-item-inner { box-shadow: 0 0 0 0 {$info_color['background']}; }
	.vp-style-{$slug} .vp-beryllium.vp-visible-on-hover .viba-portfolio-item-inner:hover { box-shadow: 0 0 0 10px {$info_color['background']}; }
		";

	$styles['vp-nitrogen'] = "
	/* Nitrogen */
	.vp-style-{$slug} .vp-nitrogen .viba-portfolio-item-inner { box-shadow: 0 0 0 0 {$info_color['background']}; }
	.vp-style-{$slug} .vp-nitrogen .viba-portfolio-item-inner:hover { background-color: {$info_color['background']} !important; box-shadow: 0 0 0 20px {$info_color['background']}; }
		";

	$styles['vp-neon'] = "
	/* Neon */
	.vp-style-{$slug} .viba-portfolio-neon-content { background-color: {$overlay_color['background']}; color: {$overlay_color['text']}; }
	.vp-style-{$slug} .vp-visible-on-hover .viba-portfolio-item-inner .viba-portfolio-neon-content,
	.vp-style-{$slug} .vp-overlay-on-hover .viba-portfolio-item-inner:hover .viba-portfolio-neon-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-item-inner:hover .viba-portfolio-neon-content { background-color: {$info_color['background']} !important; color: {$info_color['text']} !important; }
		";

	$styles['vp-sodium'] = "
	/* Sodium */
	.vp-style-{$slug} .viba-portfolio-sodium-content { background-color: {$info_color['background']}; color: {$info_color['text']}; }
	.vp-style-{$slug} .vp-visible-on-hover .viba-portfolio-item-inner .viba-portfolio-sodium-content,
	.vp-style-{$slug} .vp-overlay-on-hover .viba-portfolio-item-inner:hover .viba-portfolio-sodium-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-item-inner:hover .viba-portfolio-sodium-content { background-color: {$info_color['background']} !important; color: {$info_color['text']} !important; }
		";

	$styles['vp-aluminium'] = "
	/* Aluminium */
	.vp-style-{$slug} .viba-portfolio-aluminium-content { background-color: {$overlay_color['background']}; color: {$overlay_color['text']}; }
	.vp-style-{$slug} .vp-overlay-off-hover .viba-portfolio-aluminium-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-aluminium-content { background-color: {$info_color['background']}; color: {$info_color['text']}; }
	.vp-style-{$slug} .vp-overlay-on-hover .viba-portfolio-item-inner:hover .viba-portfolio-aluminium-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-item-inner:hover .viba-portfolio-aluminium-content { background-color: {$info_color['background']} !important; color: {$info_color['text']} !important; }
		";

	$styles['vp-silicon'] = "
	/* Silicon */
	.vp-style-{$slug} .viba-portfolio-silicon-content { background-color: {$overlay_color['background']}; color: {$overlay_color['text']}; }
	.vp-style-{$slug} .vp-overlay-off-hover .viba-portfolio-silicon-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-silicon-content { background-color: {$info_color['background']}; color: {$info_color['text']}; }
	.vp-style-{$slug} .vp-overlay-on-hover .viba-portfolio-item-inner:hover .viba-portfolio-silicon-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-item-inner:hover .viba-portfolio-silicon-content { background-color: {$info_color['background']} !important; color: {$info_color['text']} !important; }
		";

	$styles['vp-phosphorus'] = "
	/* Phosphorus */
	.vp-style-{$slug} .viba-portfolio-phosphorus-overlay { color: {$info_color['background']}; box-shadow: inset 0 0 0 0 {$info_color['background']};  }
	.vp-style-{$slug} .viba-portfolio-item-inner:hover .viba-portfolio-phosphorus-overlay { box-shadow: inset 0 0 0 10px {$info_color['background']}; }
		";

	$styles['vp-sulfur'] = "
	/* Sulfur */
	.vp-style-{$slug} .viba-portfolio-sulfur-left { background-color: {$overlay_color['background']}; color: {$overlay_color['text']}; }
	.vp-style-{$slug} .vp-overlay-off-hover .viba-portfolio-sulfur-left,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-sulfur-left { background-color: {$info_color['background']}; color: {$info_color['text']}; }
	.vp-style-{$slug} .vp-overlay-on-hover .viba-portfolio-item-inner:hover .viba-portfolio-sulfur-left,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-item-inner:hover .viba-portfolio-sulfur-left { background-color: {$info_color['background']} !important; color: {$info_color['text']} !important; }
		";

	$styles['vp-argon'] = "
	/* Argon */
	.vp-style-{$slug} .viba-portfolio-argon-content { background-color: {$overlay_color['background']}; color: {$overlay_color['text']}; }
	.vp-style-{$slug} .vp-overlay-off-hover .viba-portfolio-argon-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-argon-content { background-color: {$info_color['background']}; color: {$info_color['text']}; }
	.vp-style-{$slug} .vp-overlay-on-hover .viba-portfolio-item-inner:hover .viba-portfolio-argon-content,
	.vp-style-{$slug} .vp-overlay-visible .viba-portfolio-item-inner:hover .viba-portfolio-argon-content { background-color: {$info_color['background']} !important; color: {$info_color['text']} !important; }
		";

	$styles = apply_filters( 'viba_portfolio_styles_css', $styles, $slug, $overlay_color, $info_color, $opacity );

	if ( isset( $styles[$skin_style] ) ) {
		return $styles[$skin_style];
	}

}