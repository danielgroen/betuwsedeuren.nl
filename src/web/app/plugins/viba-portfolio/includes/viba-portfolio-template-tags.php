<?php
/**
 * Viba Portfolio Template Tags.
 *
 * General template functions.
 *
 * @package 	Viba_Portfolio/Functions/Template_Tags
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exitif accessed directly


if ( ! function_exists( 'viba_portfolio_content' ) ) {
	/**
	 * Output Viba Portfolio content.
	 *
	 * This function is only used in the optional 'viba-portfolio.php' template
	 * which people can add to their themes to add basic Viba Portfolio support
	 * without hooks or modifying core templates.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_content() {

		if ( is_viba_portfolio_single() ) {

			while ( have_posts() ) : the_post();
			
				viba_portfolio_get_template_part( 'content', 'single-viba_portfolio' );
			
			endwhile; // end of the loop.

		} else {

			if ( apply_filters( 'viba_portfolio_show_page_title', true ) ) :
				viba_portfolio_title();
			endif;

			if ( have_posts() ) : ?>
				
				<div <?php 
					/**
					 * viba_portfolio_wrapper_classes filter
					 *
					 * @hooked viba_portfolio_get_wrapper_classes - 10
					 */
					viba_portfolio_get_classes( 'viba_portfolio_wrapper_classes' ); ?> <?php
					/**
					 * viba_portfolio_wrapper_data_attr filter
					 *
					 * @hooked viba_portfolio_get_wrapper_data_attr - 10
					 */
					viba_portfolio_get_data_attr( 'viba_portfolio_wrapper_data_attr' ); ?>>

				<?php 
					/**
					 * viba_portfolio_before_loop hook
					 *
					 * @hooked viba_portfolio_filter - 10
					 */
					do_action( 'viba_portfolio_before_loop' ); 

					
					viba_portfolio_loop_start(); // Outputs the start of a loop. By default this is a opening UL tag
		
					while ( have_posts() ) : the_post();
		
						viba_portfolio_get_template_part( 'content', 'viba_portfolio' );

					endwhile; // end of the loop.
				
					viba_portfolio_loop_end(); // Outputs the end of a loop. By default this is a closing UL tag

					/**
					 * viba_portfolio_after_loop hook
					 *
					 * @hooked viba_portfolio_pagination - 10
					 */
					do_action( 'viba_portfolio_after_loop' ); 
				?>

				</div>

			<?php else :

				viba_portfolio_get_template( 'no-viba-portfolio-items.php' );

			endif;

		}
	}

}

if ( ! function_exists( 'viba_portfolio_the_title' ) ) {
	/**
	 * Get or echo the Title for Main Archive Page, Taxanomies, Single and Search.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	bool $echo If false it returns the title
	 * @return 	string
	 */
	function viba_portfolio_the_title( $echo = true ) {

		$page_title = viba_portfolio_get_the_title();		

		if ( $echo == true ) {
			echo $page_title;
		}
		else {
			return $page_title;
		}
					
	}

}

if ( ! function_exists( 'viba_portfolio_get_the_title' ) ) {
	/**
	 * Get the Title for Main Archive Page, Taxanomies, Single and Search.
	 *
	 * @since 	1.4.1
	 * @access 	public
	 * @return 	string
	 */
	function viba_portfolio_get_the_title() {
		
		if ( is_viba_portfolio_search() ) {
			$page_title = sprintf( viba_portfolio_translate( 'i18n-search', __( 'Search Results: &ldquo;%s&rdquo;', 'viba-portfolio' ) ), get_search_query() );

		} elseif ( is_viba_portfolio_taxonomy() ) {

			$page_title = single_term_title( '', false );

		} elseif ( is_viba_portfolio_page() ) {

		$page_title = post_type_archive_title( '', false );

		} else {
			$page_title = get_the_title();
		}

		return apply_filters( 'viba_portfolio_the_title', $page_title );

	}
}

if ( ! function_exists( 'viba_portfolio_password_form' ) ) {
	/**
	 * Output the password form.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_password_form() {
		echo get_the_password_form();
	}
}

if ( ! function_exists( 'viba_portfolio_searchform' ) ) {
	/**
	 * Output the searcform.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_searchform() {
		viba_portfolio_get_template( 'global/searchform.php' );
	}
}

/*========================================================
	GLOBAL TAGS
 =======================================================*/

if ( ! function_exists( 'viba_portfolio_content_wrapper' ) ) {
	/**
	 * Output the start of the page wrapper.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_content_wrapper() {
		viba_portfolio_get_template( 'global/wrapper-start.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_content_wrapper_end' ) ) {
	/**
	 * Output the end of the page wrapper.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_content_wrapper_end() {
		viba_portfolio_get_template( 'global/wrapper-end.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_title_wrapper' ) ) {
	/**
	 * Output the start of the title wrapper.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_title_wrapper() {
		viba_portfolio_get_template( 'global/title-start.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_title_wrapper_end' ) ) {
	/**
	 * Output the end of the title wrapper.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_title_wrapper_end() {
		viba_portfolio_get_template( 'global/title-end.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_title' ) ) {
	/**
	 * Get the title template.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_title() {
		viba_portfolio_get_template( 'global/title.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_likes' ) ) {
	/**
	 * Get the likes template.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_likes() {
		viba_portfolio_get_template( 'global/likes.php' );
	}
}


if ( ! function_exists('viba_portfolio_filter' ) ) {
	/**
	 *	Output the portfolio filter.
	 *
	 * @since 	1.0
	 * @access 	public
	 */	
	function viba_portfolio_filter() {
		viba_portfolio_get_template( 'global/filter.php' );
	}
}

if ( ! function_exists('viba_portfolio_filter_list' ) ) {
	/**
	 *	Output the portfolio filter list.
	 *
	 * @since 	1.0
	 * @access 	public
	 */	
	function viba_portfolio_filter_list() {
		viba_portfolio_get_template( 'global/filter-list.php' );
	}
}

if ( ! function_exists('viba_portfolio_pagination' ) ) {
	/**
	 *	Output the portfolio pagination.
	 *
	 * @since 	1.0
	 * @access 	public
	 */	
	function viba_portfolio_pagination() {
		viba_portfolio_get_template( 'global/pagination.php' );
	}
}

/*========================================================
	PORTFOLIO ITEMS
 =======================================================*/

if ( ! function_exists( 'viba_portfolio_loop_start' ) ) {
	/**
	 * Output the start of a loop. By default this is a UL tag
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_loop_start() {
		viba_portfolio_get_template( 'loop/loop-start.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_loop_end' ) ) {
	/**
	 * Output the end of a loop. By default this is a UL tag
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_loop_end() {
		viba_portfolio_get_template( 'loop/loop-end.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_item_media' ) ) {
	/**
	 * Output the media.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_item_media() {
		viba_portfolio_get_template( 'loop/item-media.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_item_overlay' ) ) {
	/**
	 * Output the overlay.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_item_overlay() {
		viba_portfolio_get_template( 'loop/item-overlay.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_item_buttons' ) ) {
	/**
	 * Output the zoom and link button.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_item_buttons() {
		viba_portfolio_get_template( 'loop/item-buttons.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_item_title' ) ) {
	/**
	 * Output the item title.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_item_title() {
		viba_portfolio_get_template( 'loop/item-title.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_item_categories' ) ) {
	/**
	 * Output the categories.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_item_categories() {
		viba_portfolio_get_template( 'loop/item-categories.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_item_description' ) ) {
	/**
	 * Output the short description.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_item_description() {
		viba_portfolio_get_template( 'loop/item-description.php' );
	}
}

/*========================================================
	PORTFOLIO SINGLE
 =======================================================*/

if ( ! function_exists( 'viba_portfolio_media' ) ) {
	/**
	 * Output the single media.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_media() {
		viba_portfolio_get_template( 'single/media.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_thumbnail' ) ) {
	/**
	 * Output the single thumbnail.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_thumbnail() {
		viba_portfolio_get_template( 'media/thumbnail.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_gallery' ) ) {
	/**
	 * Output the single gallery.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_gallery() {
		viba_portfolio_get_template( 'media/gallery.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_video' ) ) {
	/**
	 * Output the single video.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_video() {
		viba_portfolio_get_template( 'media/video.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_audio' ) ) {
	/**
	 * Output the single audio.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_audio() {
		viba_portfolio_get_template( 'media/audio.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_description' ) ) {
	/**
	 * Output the single content.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_description() {
		viba_portfolio_get_template( 'single/description.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_pagination' ) ) {
	/**
	 * Output the single pagination.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_pagination() {
		viba_portfolio_get_template( 'single/pagination.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_related' ) ) {
	/**
	 * Output the related items.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_related() {
		viba_portfolio_get_template( 'single/related.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta' ) ) {
	/**
	 * Output the single meta informations.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta() {
		viba_portfolio_get_template( 'single/meta.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta_date' ) ) {
	/**
	 * Output the single meta date.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta_date() {
		viba_portfolio_get_template( 'single/meta/date.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta_client' ) ) {
	/**
	 * Output the single meta client.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta_client() {
		viba_portfolio_get_template( 'single/meta/client.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta_categories' ) ) {
	/**
	 * Output the single meta categories.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta_categories() {
		viba_portfolio_get_template( 'single/meta/categories.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta_tags' ) ) {
	/**
	 * Output the single meta tags.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta_tags() {
		viba_portfolio_get_template( 'single/meta/tags.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta_project_link' ) ) {
	/**
	 * Output the single meta project link.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta_project_link() {
		viba_portfolio_get_template( 'single/meta/project-link.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta_likes' ) ) {
	/**
	 * Output the single meta likes.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta_likes() {
		viba_portfolio_get_template( 'single/meta/likes.php' );
	}
}

if ( ! function_exists( 'viba_portfolio_single_meta_share' ) ) {
	/**
	 * Output the single meta share buttons.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_single_meta_share() {
		viba_portfolio_get_template( 'single/meta/share.php' );
	}
}

/*========================================================
	WIDGETS
 =======================================================*/
 if ( ! function_exists( 'viba_portfolio_widget' ) ) {
	/**
	 * Output the widget content.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	function viba_portfolio_widget() {
		viba_portfolio_get_template( 'widgets/viba-portfolio.php' );
	}
}