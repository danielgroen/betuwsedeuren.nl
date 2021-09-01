<?php
/**
 * Viba Portfolio Export.
 *
 * This is mostly copied from WordPress Export Administration API.
 *
 * @package 	Viba_Portfolio/Admin/Classes
 * @since 	    1.0
 * @author 		apalodi
 */

if ( ! class_exists( 'Viba_Portfolio_Export' ) ) :

class Viba_Portfolio_Export {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'wp_ajax_viba_portfolio_export', array( $this, 'export' ) );
		
	}

	/**
	 * Get the all post and images ids that will be exported.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	array $export_ids Post, images, videos and audio ids that will be exported
	 */
	public function get_export_ids() {

		$posts = get_posts( array( 'post_type' => viba_portfolio()->post_type, 'posts_per_page' => -1 ) );

		if ( empty( $posts ) ) 
			return;

		$export_ids = $post_ids = $thumbnail_ids = $gallery_ids = $video_ids = $audio_ids = $attachment_ids = array();

		foreach ( $posts as $post ) {

			$post_ids[] 		= $post->ID;
			$thumbnail_ids[] 	= get_post_thumbnail_id( $post->ID );
			$gallery_images		= get_post_meta( $post->ID, '_viba_portfolio_gallery', true );
			$videos				= get_post_meta( $post->ID, '_viba_portfolio_video', true );
			$audios				= get_post_meta( $post->ID, '_viba_portfolio_audio', true );

			if ( ! empty( $gallery_images ) ) {
				foreach ( $gallery_images as $id ) {
					$gallery_ids[] = $id;
				}
			}

			if ( ! empty( $videos['hosted'] ) ) {
				foreach ( $videos['hosted'] as $id ) {
					$video_ids[] = $id;
				}
			}

			if ( ! empty( $audios['hosted'] ) ) {
				foreach ( $audios['hosted'] as $id ) {
					$audio_ids[] = $id;
				}
			}

			$attachments_args = array(
				'posts_per_page'   	=> -1,
				'post_status' 		=> 'any',
				'post_type' 		=> 'attachment',
				'post_parent'      	=> $post->ID,
				'exclude'     		=> get_post_thumbnail_id()
			);

			$attachments = get_posts( $attachments_args );

			foreach ( $attachments as $attachment ) {
				$attachment_ids[] = $attachment->ID;
			}

		}

		$export_ids = array_merge( $post_ids, $thumbnail_ids, $gallery_ids, $video_ids, $audio_ids, $attachment_ids );
		$export_ids = array_filter( array_values( array_unique( $export_ids ) ) );
		
		return $export_ids;
		
	}

	/**
	 * Wrap given string in XML CDATA tag.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	string $str String to wrap in XML CDATA tag.
	 * @return 	string
	 */
	public function wxr_cdata( $str ) {
		if ( seems_utf8( $str ) == false )
			$str = utf8_encode( $str );

		// $str = ent2ncr(esc_html($str));
		$str = '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $str ) . ']]>';

		return $str;
	}

	/**
	 * Return the URL of the site
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	string Site URL.
	 */
	public function wxr_site_url() {
		// Multisite: the base URL.
		if ( is_multisite() )
			return network_home_url();
		// WordPress (single site): the blog URL.
		else
			return get_bloginfo_rss( 'url' );
	}

	/**
	 * Output list of authors with posts
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function wxr_authors_list() {
		global $wpdb;

		$post_ids = $this->get_export_ids();

		if ( !empty( $post_ids ) ) {
			$post_ids = array_map( 'absint', $post_ids );
			$and = 'AND ID IN ( ' . implode( ', ', $post_ids ) . ')';
		} else {
			$and = '';
		}

		$authors = array();
		$results = $wpdb->get_results( "SELECT DISTINCT post_author FROM $wpdb->posts WHERE post_status != 'auto-draft' $and" );
		foreach ( (array) $results as $result )
			$authors[] = get_userdata( $result->post_author );

		$authors = array_filter( $authors );

		foreach ( $authors as $author ) {
			echo "\t<wp:author>\n";
			echo "\t\t<wp:author_id>" . $author->ID . "</wp:author_id>\n";
			echo "\t\t<wp:author_login>" . $author->user_login . "</wp:author_login>\n";
			echo "\t\t<wp:author_email>" . $author->user_email . "</wp:author_email>\n";
			echo "\t\t<wp:author_display_name>" . $this->wxr_cdata( $author->display_name ) . "</wp:author_display_name>\n";
			echo "\t\t<wp:author_first_name>" . $this->wxr_cdata( $author->user_firstname ) . "</wp:author_first_name>\n";
			echo "\t\t<wp:author_last_name>" . $this->wxr_cdata( $author->user_lastname ) . "</wp:author_last_name>\n";
			echo "\t</wp:author>\n";
		}
	}

	/**
	 * Output a term name XML tag from a given term object
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	object $term Term Object
	 * @return 	string Term name XML tag
	 */
	public function wxr_term_name( $term ) {
		if ( empty( $term->name ) )
			return;

		echo "\t\t<wp:term_name>" . $this->wxr_cdata( $term->name ) . "</wp:term_name>\n";
	}

	/**
	 * Output a term description XML tag from a given term object
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	object $term Term Object
	 * @return 	string Term description XML tag
	 */
	public function wxr_term_description( $term ) {
		if ( empty( $term->description ) )
			return;

		echo "\t\t<wp:term_description>" . $this->wxr_cdata( $term->description ) . "</wp:term_description>\n";
	}

	/**
	 * Output all Viba Portfolio terms, in XML tag format.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	string Taxonomy terms in xml format
	 */
	public function wxr_all_terms() {

		$taxonomies = get_object_taxonomies( viba_portfolio()->post_type );
		if ( empty( $taxonomies ) )
			return;

		$custom_terms = (array) get_terms( $taxonomies );

		// Put terms in order with no child going before its parent.
		while ( $t = array_shift( $custom_terms ) ) {
			if ( $t->parent == 0 || isset( $terms[$t->parent] ) )
				$terms[$t->term_id] = $t;
			else
				$custom_terms[] = $t;
		}

		foreach ( (array) $terms as $term ) {
			$term->parent = $term->parent ? $terms[$term->parent]->slug : '';
			echo "\t<wp:term>\n";
			echo "\t\t<wp:term_id>{$term->term_id}</wp:term_id>\n";
			echo "\t\t<wp:term_taxonomy>{$term->taxonomy}</wp:term_taxonomy>\n";
			echo "\t\t<wp:term_slug>{$term->slug}</wp:term_slug>\n";
			echo "\t\t<wp:term_parent>{$term->parent}</wp:term_parent>\n";
			$this->wxr_term_name( $term );
			$this->wxr_term_description( $term );
			echo "\t</wp:term>\n";
		}

	}

	/**
	 * Output list of taxonomy terms, in XML tag format, associated with a post.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	object $post 
	 * @return 	string Taxonomy terms in xml format
	 */
	public function wxr_post_taxonomy( $post ) {

		$taxonomies = get_object_taxonomies( $post->post_type );

		if ( empty( $taxonomies ) ) 
			return;

		if ( viba_portfolio()->post_type == $post->post_type ) {
			$taxonomies = wp_parse_args( array( 'post_format' ), $taxonomies );
		}

		$terms = wp_get_object_terms( $post->ID, $taxonomies );

		foreach ( (array) $terms as $term ) {
			echo "\t\t<category domain=\"{$term->taxonomy}\" nicename=\"{$term->slug}\">" . $this->wxr_cdata( $term->name ) . "</category>\n";
		}
	}

	/**
	 * Output all items for export in XML tag.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	void
	 */
	public function wxr_all_items() {
		global $wpdb, $post;

		$post_ids = $this->get_export_ids();

		if ( ! $post_ids ) 
			return;

		foreach ( $post_ids as $id ) {
			
			$post 		= get_post( $id );
			$is_sticky 	= is_sticky( $post->ID ) ? 1 : 0;
			$postmeta 	= $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE post_id = %d", $post->ID ) ); 

			setup_postdata( $post );
		?>
	<item>
		<title><?php echo apply_filters( 'the_title_rss', $post->post_title ); ?></title>
		<link><?php the_permalink_rss() ?></link>
		<pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true ), false ); ?></pubDate>
		<dc:creator><?php echo $this->wxr_cdata( get_the_author_meta( 'login' ) ); ?></dc:creator>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>
		<description></description>
		<content:encoded><?php
			/**
			 * Filter the post content used for WXR exports.
			 *
			 * @since 1.0
			 * @param string $post_content Content of the current post.
			 */
			echo $this->wxr_cdata( apply_filters( 'the_content_export', $post->post_content ) );
		?></content:encoded>
		<excerpt:encoded><?php
			/**
			 * Filter the post excerpt used for WXR exports.
			 *
			 * @since 1.0
			 * @param string $post_excerpt Excerpt for the current post.
			 */
			echo $this->wxr_cdata( apply_filters( 'the_excerpt_export', $post->post_excerpt ) );
		?></excerpt:encoded>
		<wp:post_id><?php echo $post->ID; ?></wp:post_id>
		<wp:post_date><?php echo $post->post_date; ?></wp:post_date>
		<wp:post_date_gmt><?php echo $post->post_date_gmt; ?></wp:post_date_gmt>
		<wp:comment_status><?php echo $post->comment_status; ?></wp:comment_status>
		<wp:ping_status><?php echo $post->ping_status; ?></wp:ping_status>
		<wp:post_name><?php echo $post->post_name; ?></wp:post_name>
		<wp:status><?php echo $post->post_status; ?></wp:status>
		<wp:post_parent><?php echo $post->post_parent; ?></wp:post_parent>
		<wp:menu_order><?php echo $post->menu_order; ?></wp:menu_order>
		<wp:post_type><?php echo $post->post_type; ?></wp:post_type>
		<wp:post_password><?php echo $post->post_password; ?></wp:post_password>
		<wp:is_sticky><?php echo $is_sticky; ?></wp:is_sticky>
<?php	if ( $post->post_type == 'attachment' ) : ?>
		<wp:attachment_url><?php echo wp_get_attachment_url( $post->ID ); ?></wp:attachment_url>
<?php 	endif; ?>
<?php 	$this->wxr_post_taxonomy( $post ); ?>
<?php	foreach ( $postmeta as $meta ) : ?>
		<wp:postmeta>
			<wp:meta_key><?php echo $meta->meta_key; ?></wp:meta_key>
			<wp:meta_value><?php echo $this->wxr_cdata( $meta->meta_value ); ?></wp:meta_value>
		</wp:postmeta>
<?php 	endforeach; ?>
	</item>
<?php 
		}

		wp_reset_postdata();

	}

	/**
	 * Export portfolio items.
	 * Generates the WXR export file for download.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @return 	void
	 */
	public function export() {

		check_ajax_referer( 'viba-portfolio-export-nonce', 'nonce' );

		/**
		 * Version number for the export format.
		 *
		 * Bump this when something changes that might affect compatibility.
		 *
		 * @since 1.0
		 */
		define( 'WXR_VERSION', '1.2' );

		$sitename = sanitize_key( get_bloginfo( 'name' ) );
		if ( ! empty($sitename) ) $sitename .= '-';
		$filename = $sitename . 'viba-portfolio-' . date( 'Y-m-d' ) . '.xml';

		header( 'Content-Description: File Transfer' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );

		echo '<?xml version="1.0" encoding="' . get_bloginfo( 'charset' ) . "\" ?>\n";

		?>
<!-- This is a WordPress eXtended RSS file generated by Viba Portfolio as an export of your portfolios. -->
<!-- You may use this file to transfer your portfolios from one site to another. -->
<!-- This file is not intended to serve as a complete backup of your portfolios. -->

<!-- To import this information into a WordPress site follow these steps: -->
<!-- 1. Log in to that site as an administrator. -->
<!-- 2. Go to Tools: Import in the WordPress admin panel. -->
<!-- 3. Install the "WordPress" importer from the list. -->
<!-- 4. Activate & Run Importer. -->
<!-- 5. Upload this file using the form provided on that page. -->
<!-- 6. You will first be asked to map the authors in this export file to users -->
<!--    on the site. For each author, you may choose to map to an -->
<!--    existing user on the site or to create a new user. -->
<!-- 7. WordPress will then import your portfolios. -->

<?php the_generator( 'export' ); ?>
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/<?php echo WXR_VERSION; ?>/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/<?php echo WXR_VERSION; ?>/"
>

<channel>
	<title><?php bloginfo_rss( 'name' ); ?></title>
	<link><?php bloginfo_rss( 'url' ); ?></link>
	<description><?php bloginfo_rss( 'description' ); ?></description>
	<pubDate><?php echo date( 'D, d M Y H:i:s +0000' ); ?></pubDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<wp:wxr_version><?php echo WXR_VERSION; ?></wp:wxr_version>
	<wp:base_site_url><?php echo $this->wxr_site_url(); ?></wp:base_site_url>
	<wp:base_blog_url><?php bloginfo_rss( 'url' ); ?></wp:base_blog_url>

<?php $this->wxr_authors_list(); ?>

<?php $this->wxr_all_terms(); ?>

	<?php
	/** This action is documented in wp-includes/feed-rss2.php */
	do_action( 'rss2_head' );
	?>

<?php $this->wxr_all_items(); ?>

</channel>
</rss><?php die;
	} // end function export()

}

new Viba_Portfolio_Export();

endif;