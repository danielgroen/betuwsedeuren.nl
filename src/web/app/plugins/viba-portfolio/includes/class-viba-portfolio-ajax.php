<?php
/**
 * Viba Portfolio Ajax.
 *
 * @package 	Viba_Portfolio/Classes
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Ajax' ) ) :

class Viba_Portfolio_Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'wp_ajax_viba_portfolio_open_with_ajax', array( $this, 'open_with_ajax' ) );
		add_action( 'wp_ajax_nopriv_viba_portfolio_open_with_ajax', array( $this, 'open_with_ajax' ) );
		
		add_action( 'wp_ajax_viba_portfolio_load_more', array( $this, 'load_more' ) );
		add_action( 'wp_ajax_nopriv_viba_portfolio_load_more', array( $this, 'load_more' ) );

		add_action( 'wp_ajax_viba_portfolio_likes', array( $this, 'likes' ) );
		add_action( 'wp_ajax_nopriv_viba_portfolio_likes', array( $this, 'likes' ) );

	}

	/**
	 * Retrieve the main query.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	object $wp_the_query
	 */
	static function wp_query() {
		global $wp_the_query;
		return apply_filters( 'viba_portfolio_query_object', $wp_the_query );
	}

	/**
	 * Open single items with ajax.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	array $results
	 */
	public function open_with_ajax() {

		$query_args = array_merge( self::wp_query()->query_vars, array(
			'post_type'	 => viba_portfolio()->post_type,
			'p'          => $_GET['post_id']
		) );

		$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'] = new WP_Query( $query_args );

		$results = array();

		if ( have_posts() ) :

			$results['type'] = 'success';

			ob_start();

			while ( have_posts() ) : the_post();

				viba_portfolio_get_template_part( 'content', 'single-viba_portfolio' );

			endwhile;

			$results['html'] = ob_get_clean();

		else :

			$results['type'] = 'empty';

		endif;

		echo json_encode( apply_filters( 'viba_portfolio_open_with_ajax_data', $results ) );

		die();

	}

	/**
	 * Load more items with ajax.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	array $results
	 */
	public function load_more() {
		
		viba_portfolio_set_selected_style( $_GET['current_style'] );

		$tax = $_GET['tax'];
		$term_id = $_GET['term_id'];
		$archive_page = $_GET['archive_page'];
		$search_query = $_GET['search_query'];

		$default_args = viba_portfolio_get_query_args();

		if ( 'false' != $tax ) {
			$tax_args['tax_query'] = array();
			$tax_args['tax_query'][] = array(
				'taxonomy' => $tax,
				'field'    => 'term_id',
				'terms'    => array( $term_id ),
				'include_children' => true
			);
			$default_args = wp_parse_args( $tax_args, viba_portfolio_get_query_args( false ) );
		}

		if ( 'false' != $archive_page ) {
			$default_args = viba_portfolio_get_query_args( false );
		}

		if ( 'false' != $search_query ) {
			$default_args = wp_parse_args( array( 's' => $search_query ), viba_portfolio_get_query_args( false ) );
		}

		$load_more_args = array(
			'posts_per_page' => $_GET['post_per_page'],
			'offset' 		 => $_GET['offset']
		);

		$query_args = wp_parse_args( $load_more_args, $default_args );
		$viba_query = new WP_Query( $query_args );

		$results = array();

		if ( $viba_query->have_posts() ) :

			$results['type'] = 'success';

			ob_start();

			while ( $viba_query->have_posts() ) : $viba_query->the_post();

				viba_portfolio_get_template_part( 'content', 'viba_portfolio' );

			endwhile;

			$results['html'] = ob_get_clean();

		else :

			$results['type'] = 'empty';

		endif;

		wp_reset_postdata();

		echo json_encode( apply_filters( 'viba_portfolio_load_more_ajax_data', $results ) );

		die;

	}

	/**
	 * Portfolio Likes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	string $likes Number of likes
	 */
	public function likes() {
		
		$post_id = $_GET['post_id'];
		$likes = get_post_meta( $post_id, '_viba_portfolio_likes', true );
		$results = array();

		if( ! $likes ) {
			$likes = '0';
			add_post_meta( $post_id, '_viba_portfolio_likes', $likes, true );
		}

		if( isset( $_COOKIE['viba_portfolio_likes_'. $post_id] ) ) {

			$results['type'] = 'active';

		} elseif ( $_GET['click'] == 'true' ) {

			$results['type'] = 'success';
			
			$likes++;
			update_post_meta( $post_id, '_viba_portfolio_likes', $likes );
			setcookie( 'viba_portfolio_likes_'. $post_id, $post_id, strtotime( '+30 days' ), '/' );
			
		}

		$results['likes'] = $likes;

		echo json_encode( apply_filters( 'viba_portfolio_likes_ajax_data', $results ) );

		die;
	}

}

new Viba_Portfolio_Ajax();

endif;