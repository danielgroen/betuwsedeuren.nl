<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<div class="container">
	<div class="wrap">
			<?php if ( have_posts() ) : ?>
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyseventeen' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<?php else : ?>
				<h1 class="page-title"><?php _e( 'Nothing Found', 'twentyseventeen' ); ?></h1>
			<?php endif; ?>

			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<?php
						if (have_posts()) : // Results Found ?>
							<?php while (have_posts()) : the_post(); ?>
								<div class="row">
									<article <?php post_class(); ?>>
											<div class="col-md-12">
												<h3 class="zoekenTitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
											</div>
											<div class="entry col-md-10">
													<p><?php echo wp_trim_words( get_the_excerpt(), 130, 'LEES MEER' ); ?></p>
											</div>
											<div class="col-md-2">
												<a href="<?php the_permalink() ?>" class="btn btn-default zoekLeesMeer">Lees meer</a>
											</div>
									</article>
								</div>
								<hr />

							<?php endwhile; ?>

							<ul class="pager">
									<li><?php next_posts_link('<i class="icon-chevron-left"></i>&nbsp; Older Results') ?></li>
									<li><?php previous_posts_link('Newer Results &nbsp;<i class="icon-chevron-right"></i>') ?></li>
							</ul>

					<?php else : // No Results ?>

					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen' ); ?></p>
					<?php
					get_search_form();

				endif;
				?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .wrap -->

</div>

<?php get_footer();
