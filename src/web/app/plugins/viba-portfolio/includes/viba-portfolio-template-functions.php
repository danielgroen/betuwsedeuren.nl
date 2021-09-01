<?php
/**
 * Viba Portfolio Template Functions.
 *
 * General template functions.
 *
 * @package 	Viba_Portfolio/Functions/Template
 * @since 	   	1.0
 * @author 		apalodi
 */

if ( ! function_exists( 'viba_portfolio_generator_tag' ) ) {
	/**
	 * Output generator tag to aid debugging.
	 *
	 * @since 	1.0
	 * @access 	public
     * @param   string $gen The HTML markup output to wp_head().
     * @param   string $type The type of generator. Accepts 'html', 'xhtml', 'atom', 'rss2', 'rdf', 'comment', 'export'.
	 * @return 	string $gen
	 */
    function viba_portfolio_generator_tag( $gen, $type ) {
        switch ( $type ) {
            case 'html':
                $gen .= "\n" . '<meta name="generator" content="Viba Portfolio ' . esc_attr( viba_portfolio()->version ) . '">';
                break;
            case 'xhtml':
                $gen .= "\n" . '<meta name="generator" content="Viba Portfolio ' . esc_attr( viba_portfolio()->version ) . '" />';
                break;
        }
        return $gen;
    }
}

if ( ! function_exists( 'viba_portfolio_image_meta' ) ) {
	/**
	 * Get the image caption and link.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	int $id - Image id
	 * @return 	string - Image meta, caption and link
	 */
	function viba_portfolio_image_meta( $id ) {
		$image 		= get_post( $id );
		$image_url 	= wp_get_attachment_url( $image->ID );
		$caption 	= $image->post_excerpt != '' ? '<span class="viba-portfolio-media-caption">'.$image->post_excerpt.'</span>' : null;
		$link_tag	= apply_filters( 'viba_portfolio_media_link_html', sprintf( '<a href="%s" class="viba-portfolio-media-link" title="%s"></a>', $image_url, $image->post_excerpt ) );

		return $caption . $link_tag;

	}
}

if ( ! function_exists( 'viba_portfolio_get_body_classes' ) ) {
	/**
	 * Remove and add body classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */
	function viba_portfolio_get_body_classes( $classes ) {
		global $viba_portfolio_options;
		
		$classes[] = $viba_portfolio_options['ajax-likes-count'] == '1' ? 'viba-portfolio-ajax-likes' : '';
		$post_format = get_post_format();

		if ( is_viba_portfolio() ) {

			$post_type = viba_portfolio()->post_type;

			$remove_classes = array(
				'single-'.$post_type.'', 
				'tax-'.$post_type.'_category', 
				'tax-'.$post_type.'_tag', 
				'post-type-archive-'.$post_type.'',
				'single-format-standard',
				'single-format-gallery',
				'single-format-video',
				'single-format-audio',
				'single-format-link',
			);

			// remove classes
			$classes = array_diff( $classes, apply_filters( 'viba_portfolio_remove_body_classes', $remove_classes ) );

			if ( is_viba_portfolio_search() ) {
				$classes[] = 'viba-portfolio-search';
			}
			if ( is_viba_portfolio_page() ) {
				$classes[] = 'viba-portfolio-page';
			}
			if ( is_viba_portfolio_archive() ) {
				$classes[] = 'viba-portfolio-archive';
			}
			if ( is_viba_portfolio_taxonomy() ) {
				$classes[] = 'viba-portfolio-taxonomy';
			}
			if ( is_viba_portfolio_category() ) {
				$classes[] = 'viba-portfolio-category';
			}
			if ( is_viba_portfolio_tag() ) {
				$classes[] = 'viba-portfolio-tag';
			}
			if ( is_viba_portfolio_single() ) {
				$classes[] = 'single-viba-portfolio';

				// post format
				if ( $post_format && ! is_wp_error( $post_format ) ) {
					$classes[] = 'vp-single-format-' . sanitize_html_class( $post_format );
				} else {
					$classes[] = 'vp-single-format-standard';
				}

			}

		}

		return array_values( array_filter( $classes ) );
	}	
}

if ( ! function_exists( 'viba_portfolio_get_post_classes' ) ) {
	/**
	 * Remove default generated post classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */
	function viba_portfolio_get_post_classes( $classes ) {

		$post_type = viba_portfolio()->post_type;

		if ( $post_type == get_post_type() && ! is_admin() ) {
			
			$remove_classes = array(
				$post_type,
				'type-'.$post_type.'',
				'has-post-thumbnail',
				'format-standard',
				'format-gallery',
				'format-video',
				'format-audio',
				'format-link',
			);

			// remove classes
			$classes = array_diff( $classes, apply_filters( 'viba_portfolio_remove_post_classes', $remove_classes ) );

		}

		return array_values( array_filter( $classes ) );

	}
}

if ( ! function_exists( 'viba_portfolio_get_wrapper_classes' ) ) {
	/**
	 * Portfolio item wrapper classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */	
	function viba_portfolio_get_wrapper_classes( $classes ) {

		$size = viba_portfolio_get_style_option( 'size' );

		$classes[] = 'viba-portfolio-wrapper';
		$classes[] = 'vp-style-'.viba_portfolio_get_selected_style();
		$classes[] = 'vp-size-default' != $size ? $size : '';

		return array_values( array_filter( $classes ) );
	}
}

if ( ! function_exists( 'viba_portfolio_get_container_classes' ) ) {
	/**
	 * Portfolio item container classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */	
	function viba_portfolio_get_container_classes( $classes ) {

		$template_skin 					 = viba_portfolio_get_template_skin();

		$layout 						 = viba_portfolio_get_style_option( 'layout' );
		$columns 						 = viba_portfolio_get_style_option( 'columns' );
		$margins					 	 = viba_portfolio_get_style_option( 'margins' );
		$hover_effect					 = viba_portfolio_get_style_option( 'hover-effect' );
		$overlay_visibility				 = viba_portfolio_get_style_option( 'overlay-visibility' );
		$informations_horizontal_align 	 = viba_portfolio_get_style_option( 'horizontal-align' );
		$cover_horizontal_align 	 	 = viba_portfolio_get_style_option( 'cover-horizontal-align' );
		$informations_vertical_align 	 = viba_portfolio_get_style_option( 'vertical-align' );
		$informations_arrow 			 = viba_portfolio_get_style_option( 'arrow-indicator' );
		$animations 					 = viba_portfolio_get_style_option( 'animation' );
		$multi_color 					 = viba_portfolio_get_style_option( 'multi-color' );
		$item_animation 				 = viba_portfolio_get_style_option( 'item-animation' );

		if ( is_viba_portfolio_single() ) {
			$layout = viba_portfolio_get_related_layout();
		}

		$classes[] = 'viba-portfolio';
		$classes[] = implode(' ', $template_skin );
		$classes[] = $layout;

		if ( is_viba_portfolio_layout( 'grid' ) || is_viba_portfolio_layout( 'multi-size-grid' ) ) {
			$classes[] = 'vp-isotope';
		}


		$classes[] = 'vp-col-mp-' . $columns['mobile-portrait'];
		$classes[] = 'vp-col-ml-' . $columns['mobile-landscape'];
		$classes[] = 'vp-col-tp-' . $columns['tablet-portrait'];
		$classes[] = 'vp-col-tl-' . $columns['tablet-landscape'];
		$classes[] = 'vp-col-ds-' . $columns['desktop-small'];
		$classes[] = 'vp-col-dl-' . $columns['desktop-large'];
		$classes[] = $item_animation;
		
		$classes[] = $margins != '0' ? 'vp-margins' : '';

		$classes[] = viba_portfolio_implode_array_keys( $hover_effect['overlay'], '1', 'vp-overlay' );
		$classes[] = $hover_effect['image'] != 'none' ? $hover_effect['image'] : '';

		$classes[] = $multi_color == '1' ? 'vp-multi-color' : '';

		if ( is_viba_portfolio_overlay() ) {
			$classes[] = $overlay_visibility;
		}

		$classes[] = $animations != 'none' ? $animations : '';
		
		if ( is_viba_portfolio_info() ) {

			$classes[] = $informations_horizontal_align;
			$classes[] = $cover_horizontal_align;
			$classes[] = $informations_vertical_align;
			$classes[] = $informations_arrow == '1' ? 'vp-arrow' : '';

		}


		if ( ! is_viba_portfolio_single() ) {

			if ( '1' == viba_portfolio_get_style_option( 'ajax' ) ) {
				$classes[] = 'vp-ajax';
				$classes[] = viba_portfolio_get_style_option( 'ajax-type' );
			}

		}

		return array_values( array_filter( $classes ) );
	}
}

if ( ! function_exists( 'viba_portfolio_get_item_classes' ) ) {
	/**
	 * Portfolio item classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */
	function viba_portfolio_get_item_classes( $classes ) {
		
		$post_type = viba_portfolio()->post_type;

		if ( viba_portfolio()->post_type == get_post_type() ) {

			$post_format = get_post_format();
			$filter_by = get_object_taxonomies( $post_type );
			$terms = wp_get_post_terms( get_the_ID(), $filter_by );

			$classes[] = 'vp-item-' . get_the_ID();
			$classes[] = 'viba-portfolio-item';

			// classes for single item
			if ( is_viba_portfolio_single() ) {
				$classes[] = viba_portfolio_get_single_layout();
				if ( ! is_viba_portfolio_meta() ) {
					$classes[] = 'vp-no-meta';
				}
				if ( ! get_the_content() ) {
					$classes[] = 'vp-no-content';
				}
			} 

			// image sizes
			if ( is_viba_portfolio_layout( 'multi-size-grid' ) ) {
				switch ( viba_portfolio_get_thumbnail_size() ) {
					case 'viba_portfolio_big':
						$classes[] = 'viba-portfolio-item-big';
						break;
					case 'viba_portfolio_landscape':
						$classes[] = 'viba-portfolio-item-landscape';
						break;
					case 'viba_portfolio_portrait':
						$classes[] = 'viba-portfolio-item-portrait';
						break;
					default:
						$classes[] = 'viba-portfolio-item-default';
						break;
				}
			}

			// post format
			if ( $post_format && ! is_wp_error( $post_format ) ) {
				$classes[] = 'vp-format-' . sanitize_html_class( $post_format );
			} else {
				$classes[] = 'vp-format-standard';
			}

			// add terms
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$classes[] = 'vp-term-' . $term->slug;
				}
			}

		}

		return array_values( array_filter( $classes ) );
	}	
}

if ( ! function_exists( 'viba_portfolio_get_item_inner_classes' ) ) {
	/**
	 * Portfolio item inner classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */	
	function viba_portfolio_get_item_inner_classes( $classes ) {

		$classes[] = 'viba-portfolio-item-inner';
		
		return array_values( array_filter( $classes ) );

	}
}

if ( ! function_exists( 'viba_portfolio_get_filter_classes' ) ) {
	/**
	 * Portfolio filter classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */	
	function viba_portfolio_get_filter_classes( $classes ) {

		$filter_type = viba_portfolio_get_style_option( 'filter-type' );

		$classes[] = 'viba-portfolio-filter';
		$classes[] = $filter_type;
		
		return array_values( array_filter( $classes ) );
	}
}

if ( ! function_exists( 'viba_portfolio_get_pagination_classes' ) ) {
	/**
	 * Portfolio pagination classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */	
	function viba_portfolio_get_pagination_classes( $classes ) {

		$pagination_type = viba_portfolio_get_style_option( 'pagination-type' );
		$load_more_count = viba_portfolio_get_style_option( 'load-more-count' );

		$classes[] = 'viba-portfolio-pagination';
		$classes[] = $pagination_type;

		if ( 'vp-pagination-load-more' == $pagination_type && '1' == $load_more_count ) {
			$classes[] = 'vp-load-more-count';
		}
		
		return array_values( array_filter( $classes ) );
	}
}

if ( ! function_exists( 'viba_portfolio_get_gallery_classes' ) ) {
	/**
	 * Portfolio galley classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */	
	function viba_portfolio_get_gallery_classes( $classes ) {

		$gallery_type = viba_portfolio_get_gallery_type();

		$classes[] = 'viba-portfolio-gallery';
		$classes[] = 'viba-portfolio-gallery-' .$gallery_type;
		
		return array_values( array_filter( $classes ) );
	}
}

if ( ! function_exists( 'viba_portfolio_get_likes_classes' ) ) {
	/**
	 * Portfolio likes classes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $classes
	 * @return 	array $classes
	 */	
	function viba_portfolio_get_likes_classes( $classes ) {

		$classes[] = 'viba-portfolio-likes';

		if( isset( $_COOKIE['viba_portfolio_likes_'. get_the_ID()] ) ) {
			$classes[] = 'active';
		}
		
		return array_values( array_filter( $classes ) );
	}
}

if ( ! function_exists( 'viba_portfolio_get_link_tag_attr' ) ) {
	/**
	 * Portfolio link tag attributes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $attr
	 * @return 	array $attr
	 */	
	function viba_portfolio_get_link_tag_attr( $attr ) {
		
		$format = get_post_format( get_the_ID() );

		$attr['class'][] = 'viba-portfolio-link';

		if ( 'link' == $format ) {

			$link =  get_post_meta( get_the_ID(), '_viba_portfolio_link', true );
			$url = is_array( $link ) ? $link['url'] : $link;

			$attr['class'][] = 'vp-ext-link';

			if ( '' != $url ) {
				$attr['href'] = esc_url( $url );
			}

			if ( isset( $link['target'] ) ) {
				$attr['target'] = '_blank';
			}
			
		} else {

			$attr['href'] = get_the_permalink();
			$attr['data-id'] = get_the_ID();
			$attr['data-path'] = wp_make_link_relative( get_the_permalink() );

		}
		
		return $attr;

	}
}

if ( ! function_exists( 'viba_portfolio_get_zoom_button_tag_attr' ) ) {
	/**
	 * Portfolio zoom button tag attributes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $attr
	 * @return 	array $attr
	 */	
	function viba_portfolio_get_zoom_button_tag_attr( $attr ) {

		$attr['href'] = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
		
		return $attr;

	}
}

if ( ! function_exists( 'viba_portfolio_get_wrapper_data_attr' ) ) {
	/**
	 * Portfolio wrapper data attr.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $data
	 * @return 	array $data
	 */	
	function viba_portfolio_get_wrapper_data_attr( $data ) {

		$data['style'] = viba_portfolio_get_selected_style();

		return $data;

	}
}

if ( ! function_exists( 'viba_portfolio_get_container_data_attr' ) ) {
	/**
	 * Portfolio container data attr.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $data
	 * @return 	array $data
	 */	
	function viba_portfolio_get_container_data_attr( $data ) {
		global $viba_portfolio_options;

		$columns 			= viba_portfolio_get_style_option( 'columns' );
		$related_columns 	= $viba_portfolio_options['related-columns'];
		$item_animation 	= viba_portfolio_get_style_option( 'item-animation' );

		$data['col-mp'] = $columns['mobile-portrait'];
		$data['col-ml'] = $columns['mobile-landscape'];
		$data['col-tp'] = $columns['tablet-portrait'];
		$data['col-tl'] = $columns['tablet-landscape'];
		$data['col-ds'] = $columns['desktop-small'];
		$data['col-dl'] = $columns['desktop-large'];

		if ( is_viba_portfolio_single() ) {
			$data['col-mp'] = $related_columns['mobile-portrait'];
			$data['col-ml'] = $related_columns['mobile-landscape'];
			$data['col-tp'] = $related_columns['tablet-portrait'];
			$data['col-tl'] = $related_columns['tablet-landscape'];
			$data['col-ds'] = $related_columns['desktop-small'];
			$data['col-dl'] = $related_columns['desktop-large'];
		}

		switch ( $item_animation ) {
			case 'vp-items-fade':
				$data['isotope-hidden-style'] = 'none';
				break;
			case 'vp-items-scale':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) scale(0.4)';
				break;
			case 'vp-items-rotate':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotate3d(0,0,1,180deg)';
				break;
			case 'vp-items-rotate-down-left':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotate3d(0,0,1,45deg)';
				break;
			case 'vp-items-rotate-down-right':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotate3d(0,0,1,-45deg)';
				break;
			case 'vp-items-rotate-up-left':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotate3d(0,0,1,-45deg)';
				break;
			case 'vp-items-rotate-up-right':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotate3d(0,0,1,45deg)';
				break;
			case 'vp-items-slide-top':
				$data['isotope-hidden-style'] = 'translate3d(0,-100%,0)';
				break;
			case 'vp-items-slide-right':
				$data['isotope-hidden-style'] = 'translate3d(100%,0,0)';
				break;
			case 'vp-items-slide-bottom':
				$data['isotope-hidden-style'] = 'translate3d(0,100%,0)';
				break;
			case 'vp-items-slide-left':
				$data['isotope-hidden-style'] = 'translate3d(-100%,0,0)';
				break;
			case 'vp-items-vertical-flip':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotateX(180deg)';
				break;
			case 'vp-items-horizontal-flip':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotateY(180deg)';
				break;
			case 'vp-items-vertical-flipbook':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotateX(90deg)';
				break;
			case 'vp-items-horizontal-flipbook':
				$data['isotope-hidden-style'] = 'translate3d(0,0,0) rotateY(-90deg)';
				break;
				default:
				$data['isotope-hidden-style'] = 'none';
				break;
		}

		$data['isotope-visible-style'] = 'translate3d(0,0,0) rotate(0deg) scale3d(1,1,1)';
		$data['transition-duration'] =viba_portfolio_get_style_option( 'item-animation-duration' );
		$data['spinner'] = viba_portfolio_get_style_option( 'spinner' );

		if ( is_viba_portfolio_ajax() ) {

			$ajax_width = viba_portfolio_get_style_option( 'ajax-width' );
			$ajax_width = $ajax_width == '0' ? 'auto' : $ajax_width;

			$data['ajax-width'] = $ajax_width;
			$data['ajax-offset'] = viba_portfolio_get_style_option( 'ajax-offset' );
			$data['ajax-animation'] = viba_portfolio_get_style_option( 'ajax-modal-animation' );

		}

		return $data;

	}
}

if ( ! function_exists( 'viba_portfolio_get_link_data_attr' ) ) {
	/**
	 * Link data attribute.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $data
	 * @return 	array $data
	 */	
	function viba_portfolio_get_link_data_attr( $data ) {

		$data['id'] = get_the_ID();
		
		return $data;

	}
}

if ( ! function_exists( 'viba_portfolio_get_load_more_data_attr' ) ) {
	/**
	 * Portfolio load more button data attributes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $data
	 * @return 	array $data
	 */	
	function viba_portfolio_get_load_more_data_attr( $data ) {

		$offset = viba_portfolio_get_style_option( 'number' );
		$post_per_page = viba_portfolio_get_style_option( 'load-more-number' );
		
		$data['offset'] = $offset;
		$data['post-per-page'] = $post_per_page;
		$data['count-posts'] = viba_portfolio_get_number_of_queried_items();

		if ( is_viba_portfolio_taxonomy() ) {
			$tax = get_queried_object();
			$data['tax'] = $tax->taxonomy;
			$data['term-id'] = $tax->term_id;
		}

		if ( is_viba_portfolio_page() ) {
			$data['archive-page'] = 'true';
		}

		if ( is_viba_portfolio_search() ) {
			$data['search-query'] = get_search_query();
		}
		
		return $data;

	}
}

if ( ! function_exists( 'viba_portfolio_get_single_media_data_attr' ) ) {
	/**
	 * Single media data attribute.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $data
	 * @return 	array $data
	 */	
	function viba_portfolio_get_single_media_data_attr( $data ) {

		$data['spinner'] = viba_portfolio_get_style_option( 'spinner' );
		
		return $data;

	}
}

if ( ! function_exists( 'viba_portfolio_get_overlay_inline_styles' ) ) {
	/**
	 * Inline style for overlay.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $style
	 * @return 	array $style
	 */	
	function viba_portfolio_get_overlay_inline_styles( $style ) {

		if ( is_viba_portfolio_multi_color() ) {
			$overlay_color = viba_portfolio_get_overlay_color();

			$style['background'] = $overlay_color['background'];

		}
			
		return $style;

	}
}

if ( ! function_exists( 'viba_portfolio_get_cover_content_inline_styles' ) ) {
	/**
	 * Inline style for cover.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $style
	 * @return 	array $style
	 */	
	function viba_portfolio_get_cover_content_inline_styles( $style ) {

		if ( is_viba_portfolio_multi_color() ) {
			
			$template_skin = viba_portfolio_get_template_skin();
			$overlay_color = viba_portfolio_get_overlay_color();
			$info_color = viba_portfolio_get_style_option( 'informations-color' );

			$style['color'] = $overlay_color['text'];

			if ( 'vp-carbon' == $template_skin['style'] ) {
				$style['color'] = $info_color['text'];
			}

		}
		
		
		return $style;

	}
}

if ( ! function_exists( 'viba_portfolio_get_content_inline_styles' ) ) {
	/**
	 * Inline style for content.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $style
	 * @return 	array $style
	 */	
	function viba_portfolio_get_content_inline_styles( $style ) {

		if ( is_viba_portfolio_multi_color() ) {

			$template_skin = viba_portfolio_get_template_skin();
			$overlay_color = viba_portfolio_get_overlay_color();
			$info_color = viba_portfolio_get_style_option( 'informations-color' );

			$style['color'] = $overlay_color['text'];
			$style['background'] = $overlay_color['background'];

			if ( 'vp-neon' == $template_skin['style'] || 'vp-aluminium' == $template_skin['style'] || 'vp-silbutton' == $template_skin['style'] || 'vp-sulfur' == $template_skin['style'] || 'vp-argon' == $template_skin['style'] ) {
				if ( is_viba_portfolio_overlay() ) {
					if ( ! is_viba_portfolio_overlay_visible( 'on-hover' ) ) {
						$style['color'] = $info_color['text'];
						$style['background'] = $info_color['background'];
					}
				}
			}

			if ( 'vp-sodium' == $template_skin['style'] ) {
				if ( 'vp-visible-on-hover' == $template_skin['type'] ) {
					if ( is_viba_portfolio_overlay() ) {
						if ( ! is_viba_portfolio_overlay_visible( 'on-hover' ) ) {
							$style['color'] = $info_color['text'];
							$style['background'] = $info_color['background'];
						}
					}
				} else {
					$style['color'] = $info_color['text'];
					$style['background'] = $info_color['background'];
				}
			}
			
		}
		
		return $style;

	}
}