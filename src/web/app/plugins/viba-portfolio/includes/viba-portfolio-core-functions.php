<?php
/**
 * Viba Portfolio Core Functions.
 *
 * General core functions available on both the front-end and admin.
 *
 * @package 	Viba_Portfolio/Functions/Core
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get template part.
 *
 * @since 	1.0
 * @access 	public
 * @param 	mixed $slug
 * @param 	string $name (default: '')
 */
function viba_portfolio_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/viba-portfolio/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", viba_portfolio()->custom_template_dir_path . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( viba_portfolio()->template_dir_path . "{$slug}-{$name}.php" ) ) {
		$template = viba_portfolio()->template_dir_path . "{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/viba-portfolio/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", viba_portfolio()->custom_template_dir_path . "{$slug}.php" ) );
	}

	// Allow 3rd party plugin filter template file from their plugin
	$template = apply_filters( 'viba_portfolio_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Get style template.
 *
 * First look in your yourtheme/viba-portfolio/styles folder. Then look for specific style template in plugin folder.
 * If there is no specific template, load the default one.
 *
 * @since 	1.0
 * @access 	public
 * @param 	array $skin
 */
function viba_portfolio_get_style_template( $skin ) {

	$type = $skin['type'];
	$style = $skin['style'];

	// look in your yourtheme/viba-portfolio/styles folder
	$template = locate_template( array( 
		viba_portfolio()->custom_template_dir_path . "styles/{$type}/{$style}.php",
		viba_portfolio()->custom_template_dir_path . "styles/{$type}/default.php",
		viba_portfolio()->custom_template_dir_path . "styles/default.php"
	));

	// look for specific style template in plugin folder
	if ( ! $template ) {
		if ( file_exists( viba_portfolio()->template_dir_path . "styles/{$type}/{$style}.php" ) ) {
			$template = viba_portfolio()->template_dir_path . "styles/{$type}/{$style}.php";
		} elseif ( file_exists( viba_portfolio()->template_dir_path . "styles/{$type}/default.php" ) ) {
			$template = viba_portfolio()->template_dir_path . "styles/{$type}/default.php";
		} else {
			$template = viba_portfolio()->template_dir_path . "styles/default.php";
		}
	}

	// Allow 3rd party plugin filter template file from their plugin
	$template = apply_filters( 'viba_portfolio_style_template', $template, $type, $style );

	if ( $template ) {
		load_template( $template, false );
	}


}

/**
 * Get other templates passing attributes and including the file.
 *
 * @since 	1.0
 * @access 	public
 * @param 	mixed $template_name
 * @param 	array $args (default: array())
 * @param 	string $template_dir_path (default: '')
 * @param 	string $default_path (default: '')
 */
function viba_portfolio_get_template( $template_name, $args = array(), $template_dir_path = '', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	$located = viba_portfolio_locate_template( $template_name, $template_dir_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '1.0' );
		return;
	}

	do_action( 'viba_portfolio_before_template_part', $template_name, $template_dir_path, $located, $args );

	include( $located );

	do_action( 'viba_portfolio_after_template_part', $template_name, $template_dir_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_dir_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @since 	1.0
 * @access 	public
 * @param 	mixed $template_name
 * @param 	string $template_dir_path (default: '')
 * @param 	string $default_path (default: '')
 * @return 	string
 */
function viba_portfolio_locate_template( $template_name, $template_dir_path = '', $default_path = '' ) {
	if ( ! $template_dir_path ) {
		$template_dir_path = viba_portfolio()->custom_template_dir_path;
	}

	if ( ! $default_path ) {
		$default_path = viba_portfolio()->template_dir_path;
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_dir_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	return apply_filters( 'viba_portfolio_locate_template', $template, $template_name, $template_dir_path );
}

/**
 * Get the classes for various elements.
 *
 * It needs to be called like this: viba_portfolio_get_classes( 'viba_portfolio_container_classes' )
 * where viba_portfolio_container_classes is an applied filter which is used to insert classes
 *
 * function viba_portfolio_get_container_classes( $classes ) {
 *
 *		$classes[] = 'viba-portfolio';
 *		return $classes;
 *	}
 * add_filter('viba_portfolio_container_classes', 'viba_portfolio_get_container_classes', 10 );
 *
 * By changing viba_portfolio_container_classes to something else you create new filter for inserting
 * classes somewhere else. Example viba_portfolio_get_classes( 'viba_portfolio_title_classes' )
 *
 *
 * To add classes without filter use it like this
 * 		1.string 	viba_portfolio_get_classes( 'viba_portfolio_title_classes', true, 'class1 class2 class3' )
 *		2.string 	viba_portfolio_get_classes( 'viba_portfolio_title_classes', true, 'class1, class2, class3', ',' )
 *		3.array  	viba_portfolio_get_classes( 'viba_portfolio_title_classes', true, array( 'class1', 'class2', 'class3' ) )
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $filter Name of the custom filter
 * @param 	bool $echo If false it will return the value
 * @param 	string|array $classes One or more classes to add to the class list
 * @param 	string $delimiter If we enter classes as string set what delimiter is being used between classes
 * @return 	string Html class tag with classes
 */
function viba_portfolio_get_classes( $filter, $echo = true, $classes = array(), $delimiter = ' ' ) {
	if ( is_string( $classes ) ) {
		$classes = explode( $delimiter, $classes );
	}

	$classes = array_unique( apply_filters( $filter, $classes ) );
	
	// Separates classes with a single space
	if ( $echo ) {
		echo 'class="' . join(' ', $classes ) . '"';
	} else {
		return 'class="' . join(' ', $classes ) . '"';
	}
	
}

/**
 * Get the data attributs for various elements.
 *
 * To add classes without filter use it like this
 * 		1.string 	viba_portfolio_get_data_attr( 'viba_portfolio_get_load_more_data_attr', true, 'data1="example1" data2="example2" data3="example3"' )
 *		2.string 	viba_portfolio_get_data_attr( 'viba_portfolio_get_load_more_data_attr', true, 'data1="example1", data2="example2", data3="example3"', ',' )
 *		3.array  	viba_portfolio_get_data_attr( 'viba_portfolio_get_load_more_data_attr', true, array( 'data1' => 'example1', 'data2' => 'example2', 'data3 => 'example3' ) )
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $filter Name of the custom filter
 * @param 	bool $echo If false it will return the value
 * @param 	string|array $data One or more data attr to add to the list
 * @param 	string $delimiter If we enter data attr as string set what delimiter is being used between
 * @return 	string Html class tag with data
 */
function viba_portfolio_get_data_attr( $filter, $echo = true, $data = array(), $delimiter = ' ' ) {
	if ( is_string( $data ) ) {
		$data = explode( $delimiter, $data );
	}
	$data_attr = array();

	$data = apply_filters( $filter, $data );

	foreach ( $data as $key => $value ) {
		$data_attr[] = 'data-' . $key . '="' . $value . '"';
	}

	if ( $echo == true ) {
		echo implode( ' ', $data_attr );
	} else {
		return implode( ' ', $data_attr );
	}

}

/**
 * Get the tag attributs for various elements.
 *
 * To add classes without filter use it like this
 *		- viba_portfolio_get_tag_attr( 'viba_portfolio_link_tag_attr', true, array( 'class' => array( 'viba-portfolio-item-icon', 'vp-link-icon' ), 'href' => 'http://example.com', 'target => '_blank') )
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $filter Name of the custom filter
 * @param 	bool $echo If false it will return the value
 * @param 	string|array $data One or more tag attr to add to the list
 * @return 	string Html class tag with tag
 */
function viba_portfolio_get_tag_attr( $filter, $echo = true, $data = array() ) {
	
	$tags = $attr = array();
	$data = apply_filters( $filter, $data );

	foreach ( $data as $tag => $value ) {
		if ( is_array( $value ) ) {
			$attr[$tag] = implode(' ', $value );
		} else {
			$attr[$tag] = $value;
		}
	}

	foreach ( $attr as $tag => $value ) {
		$tags[] = $tag .'="'.$value.'"';
	}

	if ( $echo == true ) {
		echo implode( ' ', $tags );
	} else {
		return implode( ' ', $tags );
	}

}

/**
 * Get the inline styles for various elements.
 *
 * To add inline styles without filter use it like this
 * 		1.string 	viba_portfolio_inline_styles( 'viba_portfolio_overlay_inline_styles', true, 'background="#000" color="#fff" opacity="0.8"' )
 *		2.string 	viba_portfolio_inline_styles( 'viba_portfolio_overlay_inline_styles', true, 'background="#000", color="#fff", opacity="0.8"', ',' )
 *		3.array  	viba_portfolio_inline_styles( 'viba_portfolio_overlay_inline_styles', true, array( 'background' => '#000', 'color' => '#fff', 'opacity => '0.8') )
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $filter Name of the custom filter
 * @param 	bool $echo If false it will return the value
 * @param 	string|array $data One or more data to add to the list
 * @param 	string $delimiter If we enter data as string set what delimiter is being used between data
 * @return 	string Html style tag with data
 */
function viba_portfolio_inline_styles( $filter, $echo = true, $data = array(), $delimiter = ' ' ) {
	if ( is_string( $data ) ) {
		$data = explode( $delimiter, $data );
	}

	$styles = array();
	$data = apply_filters( $filter, $data );

	foreach ( $data as $key => $value ) {
		$styles[] = $key.':' . $value;
	}

	if ( empty( $styles ) ) return;

	if ( $echo ) {
		echo ' style="' . join(';', $styles ) . '"';
	} else {
		return ' style="' . join(';', $styles ) . '"';
	}

}

/**
 * Get paged value for pagination.
 *
 * Looking for get_query_var('paged') and get_query_var('page') in case shortcode is used
 * on static front page which has problems returning the right paged number.
 *
 * @since 	1.0
 * @access 	public
 * @return 	int $paged Current page number
 */
function viba_portfolio_get_paged() {
	if ( get_query_var('paged') ) { 
	    $paged = get_query_var('paged');
	} else if ( get_query_var('page') ) {
	    $paged = get_query_var('page');
	} else {
	    $paged = 1;
	}
	return $paged;
}

/**
 * Get maximum number of pages for pagination.
 *
 * @since 	1.0
 * @access 	public
 * @return 	int $max_num_pages Maximum number of pages
 */
function viba_portfolio_get_max_num_pages() {
	global $viba_portfolio_options, $wp_query;

	if ( is_viba_portfolio_page() || is_viba_portfolio_archive() ) {
		$max_num_pages = $wp_query->max_num_pages;
	} else {
		$max_num_pages = $viba_portfolio_options['max-num-pages'];
	}
	
	return $max_num_pages;
}

/**
 * Get portfolio terms.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string|array $taxonomy The taxonomy to retrive terms from.đ
 * @param 	string $key_data What kind of data to get into array keys (term_id, name, slug, term_group, term_taxonomy_id, description, parent, count)
 * @param 	string $data What kind of data to get (term_id, name, slug, term_group, term_taxonomy_id, description, parent, count)
 * @return 	array $viba_terms - Array of portfolio terms
 */
function viba_portfolio_get_terms( $taxonomy = '', $args = array(), $key_data ='slug', $data = 'name' ) {
	$viba_terms = array();
    $args['taxonomy'] = $taxonomy;
	$terms = get_terms( $args );
    foreach ( $terms as $term ) {
    	$viba_terms[ $term->$key_data ] = $term->$data;
    }
    return $viba_terms;
}

/**
 * Get the terms as a list with specified format.
 *
 * @since 	1.0
 * @access 	public
 * @param 	int $id Post ID.
 * @param 	string $taxonomy Taxonomy name
 * @param 	string $before Optional. Before list
 * @param 	string $sep Optional. Separate items using this
 * @param 	string $after Optional. After list
 * @param 	bool $links Optional. Return the terms as links or spans
 * @return 	string|bool|WP_Error A list of terms on success, false if there are no terms, WP_Error on failure
 */
function viba_portfolio_get_the_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '', $links = false ) {
	$terms = get_the_terms( $id, $taxonomy );
	
	if ( is_wp_error( $terms ) )
		return $terms;
	
	if ( empty( $terms ) )
		return false;
	
	foreach ( $terms as $term ) {

		$link = get_term_link( $term, $taxonomy );
		if ( is_wp_error( $link ) )
			return $link;

		if ( apply_filters( 'viba_portfolio_term_links', $links ) ) {
			$term_list[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';
		} else {
			$term_list[] = '<span>' . $term->name . '</span>';
		}
		
	}
	
	/**
	 * Filter the term links for a given taxonomy. 
	 * $taxonomy, refers to the taxonomy slug.
	 */
	$term_list = apply_filters( 'viba_portfolio_term_list_'.$taxonomy, $term_list );
	
	return $before . join( $sep, $term_list ) . $after;
	
}

/**
 * Get related portfolio items. If the item has no categories return false before starting the query.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $data - What data do we want, array of ids or number
 * @return 	array|int $related - Related ids or number
 */
function viba_portfolio_get_related_items( $data = 'id' ) {
    
    $terms_array = $related = array();

    // Get terms
    $taxonomy = apply_filters( 'viba_portfolio_related_taxanomy', viba_portfolio()->category_taxonomy );
	$terms = wp_get_post_terms( get_the_ID(), $taxonomy );
	foreach ( $terms as $term ) {
		$terms_array[] = $term->term_id;
	}

	if ( empty( $terms_array ) ) {
		return false;
	}

	$query_args = array(
		'posts_per_page' => -1,
		'post_type'=> viba_portfolio()->post_type,
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'terms' => $terms_array,
				'field' => 'id'
			)
		),
		'suppress_filters' => false,
		'post__not_in'	=> array( get_the_ID() ),
	);

	$posts = get_posts( $query_args ); 

	foreach ( $posts as $post ) {
		$related[] = $post->ID;
	}

	if ( $data == 'number' ) {
		return sizeof( $related );
	} else {
		return $related;
	}
	
}

/**
 * Get the all years portfolio items were created. Used for year dropdown query option.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $years - All years
 */
function viba_portfolio_get_all_years() {
    
    $years = array();

	$query_args = array(
		'posts_per_page' => -1,
		'post_type'=> viba_portfolio()->post_type,
	);

	$posts_array = get_posts( $query_args ); 

	foreach ( $posts_array as $post ) {
		$years[] = get_the_date( 'Y', $post->ID );
	}

	return array_unique( $years );
	
}

/**
 * Get the total number of quiered portfolios.
 *
 * @since 	1.3.0
 * @access 	public
 * @return 	int $number - Number of portfolio items
 */
function viba_portfolio_get_number_of_queried_items() {
    global $wp_query;

    if ( is_viba_portfolio_page() || is_viba_portfolio_search() ) {

    	return $wp_query->found_posts;

   	} elseif ( is_viba_portfolio_taxonomy() ) {

   		return $wp_query->queried_object->count;

   	} else {

	    $query_args = viba_portfolio_get_query_args();
	    $all_items = array(
			'posts_per_page' => -1
		);
		$query = wp_parse_args( $all_items, $query_args );
		$posts_array = get_posts( $query ); 

		return count( $posts_array );
	}
}

/**
 * Get the query args.
 *
 * @since 	1.0
 * @access 	public
 * @param 	bool $advanced_query - If true use advanced query options
 * @return 	array $args - Query args
 */
function viba_portfolio_get_query_args( $advanced_query = true ) {
    
    $args 			= array();
    $orderby 		= viba_portfolio_get_query_option( 'orderby' );
    $year 			= viba_portfolio_get_query_option( 'year' );
    $monthnum 		= viba_portfolio_get_query_option( 'monthnum' );
    $author 		= viba_portfolio_get_query_option( 'author' );
    $category 		= viba_portfolio_get_query_option( 'category' );
    $tag 			= viba_portfolio_get_query_option( 'tag' );
    $format 		= viba_portfolio_get_query_option( 'format' );
    $post_status 	= array( 'publish' );
	
	if ( current_user_can( 'read_private_viba_portfolios' ) ) {
		array_push( $post_status, 'private' );
	}

    $args['post_type'] 		= viba_portfolio()->post_type;
    $args['posts_per_page'] = viba_portfolio_get_style_option( 'number' );
    $args['paged'] 			= viba_portfolio_get_paged();
    $args['order'] 			= viba_portfolio_get_query_option( 'order' );
    $args['orderby'] 		= $orderby;
	$args['post_status'] 	= $post_status;
	
    if ( 'meta_value_num' == $orderby ) {
    	$args['meta_key'] = '_viba_portfolio_likes';
    	$args['orderby']  = 'meta_value_num title';
    }

    if ( is_viba_portfolio_pagination( 'vp-pagination-load-more' ) ) {
    	$args['paged'] = 0;
    }

    if ( $advanced_query ) {

	    if ( ! empty( $year ) ) {
	    	$args['year'] = $year;
		 }

	    if ( ! empty( $monthnum ) ) {
	    	$args['date_query'] = array();

		    if ( ! empty( $monthnum ) ) {
		    	foreach ( $monthnum as $key => $value) {
		    		$args['date_query'][]['month'] = $value;
		    	}
		    }

		    if ( sizeof( $args['date_query'] ) > 1 ) {
		    	$args['date_query']['relation'] = 'OR';
		    }
		}

	    if ( ! empty( $category ) || ! empty( $tag ) || ! empty( $format ) ) {
	    	$args['tax_query'] = array();

	    	if ( ! empty( $category ) ) {
	    		$args['tax_query'][] = array(
					'taxonomy' => viba_portfolio()->category_taxonomy,
					'field'    => 'term_id',
					'terms'    => $category,
					'include_children' => ( viba_portfolio_get_query_option( 'exclude-sub-category' ) == '1' ) ? false : true
				);
	    	}

	    	if ( ! empty( $tag ) ) {
	    		$args['tax_query'][] = array(
					'taxonomy' => viba_portfolio()->tag_taxonomy,
					'field'    => 'term_id',
					'terms'    => $tag
				);
	    	}

	    	if ( ! empty( $format ) ) {
	    		$args['tax_query'][] = array(
					'taxonomy' =>'post_format',
					'field'    => 'slug',
					'terms'    => $format
				);
	    	}

	    	if ( sizeof( $args['tax_query'] ) > 1 ) {
	    		$args['tax_query']['relation'] = viba_portfolio_get_query_option( 'relation' );
	    	}
	    }
	}

	return apply_filters( 'viba_portfolio_query_args', $args );
	
}


/**
 * Get the filter terms.
 *
 * @since 	1.0
 * @access 	public
 * @return 	array $terms - Filter terms
 */
function viba_portfolio_get_filter_terms() {

    $taxonomy 	= viba_portfolio_get_filter_taxonomy();
    $terms 		= viba_portfolio_get_terms( $taxonomy );

    if ( viba_portfolio()->category_taxonomy == $taxonomy ) {
    	$filter_option = viba_portfolio_get_query_option( 'category' );
    }
    if ( viba_portfolio()->tag_taxonomy == $taxonomy ) {
    	$filter_option = viba_portfolio_get_query_option( 'tag' );
    }

    if ( ! empty( $filter_option ) && ! is_viba_portfolio_page() ) {

    	// reset the terms array
    	$terms = array();
    	$temp_terms[] = get_terms( $taxonomy, array( 'include' => $filter_option ) );

    	foreach ( $temp_terms[0] as $term ) {
	    	$terms[ $term->slug ] = $term->name;
	    }

    	if ( '1' != viba_portfolio_get_query_option( 'exclude-sub-category' ) && viba_portfolio()->category_taxonomy == $taxonomy ) {
    		foreach ( $filter_option as $key => $id ) {
    			$temp_terms[] = get_terms( $taxonomy, array( 'child_of' => $id ) );
    			foreach ( $temp_terms[1] as $term ) {
			    	$terms[ $term->slug ] = $term->name;
			    }
    		}
    	}

	}

	return apply_filters( 'viba_portfolio_filter_terms', $terms );

}

/**
 * Translate the text.
 *
 * If the Internationalization is enabled use the text from gettext function.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $option - Option id for text
 * @param 	string $text - Text in gettext function
 * @param 	bool $echo - Echo the text or return it
 * @return 	string $text - Text
 */
function viba_portfolio_translate( $option, $text, $echo = false ) {
	global $viba_portfolio_options;

	$i18n = $viba_portfolio_options['i18n'];

	if ( '1' != $i18n && isset( $viba_portfolio_options[$option] ) ) {
		$text = esc_attr( $viba_portfolio_options[$option] );
	}

	if ( $echo ) {
		echo $text;
	} else {
		return $text;
	}
	
}

/**
 * Get the query url for share icons.
 *
 * @since 	1.0
 * @access 	public
 * @param 	string $social - What social url to build
 * @param 	bool $echo - Echo the text or return it
 * @return 	string $url - Url query
 */
function viba_portfolio_share_link( $social, $echo = true ) {

	$url 		= '';
	$post 		= get_post( get_the_ID() ); // used to get the raw title, get_the_title() returns the title with filters
	$permalink 	= rawurlencode( get_the_permalink() );
	$title 		= rawurlencode( $post->post_title ); 
	
	switch ( $social ) {
		case 'facebook':
			$url = add_query_arg( 
				array(
					'u' => $permalink,
				),
				'https://www.facebook.com/sharer/sharer.php'
			);
			break;
		case 'twitter':
			$url = add_query_arg( 
				array(
					'url' => $permalink,
					'text' => $title
				),
				'https://twitter.com/intent/tweet'
			);
			break;
		case 'google-plus':
			$url = add_query_arg( 
				array(
					'url' => $permalink
				),
				'https://plus.google.com/share'
			);
			break;
		case 'pinterest':
			$url = add_query_arg( 
				array(
					'url' => $permalink,
					'description' => $title
				),
				'https://pinterest.com/pin/create/button'
			);
			break;
		case 'tumblr':
			$url = add_query_arg( 
				array(
					'url' => $permalink,
					'name' => $title
				),
				'https://www.tumblr.com/share/link'
			);
			break;
		case 'linkedin':
			$url = add_query_arg( 
				array(
					'mini' => 'true',
					'url' => $permalink,
					'title' => $title
				),
				'//www.linkedin.com/shareArticle'
			);
			break;
		case 'reddit':
			$url = add_query_arg( 
				array(
					'url' => $permalink,
					'title' => $title
				),
				'//www.reddit.com/submit'
			);
			break;
		case 'vk':
			$url = add_query_arg( 
				array(
					'url' => $permalink,
					'title' => $title
				),
				'http://vk.com/share.php'
			);
			break;
		case 'mail':
			$url = add_query_arg( 
				array(
					'subject' => $title,
					'body' => $permalink
				),
				'mailto:'
			);
			break;
		
		default:
			break;
	}

	$url = esc_url( apply_filters( 'viba_portfolio_share_link_' . $social, $url ) );

	if ( $echo ) {
		echo $url;
	} else {
		return $url;
	}
	
}