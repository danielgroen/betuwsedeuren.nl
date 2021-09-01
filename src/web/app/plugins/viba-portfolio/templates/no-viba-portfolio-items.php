<?php
/**
 * Displayed when no portfolios are found.
 *
 * Override this template by copying it to yourtheme/viba-portfolio/no-viba-portfolio-items.php
 *
 * @package 	Viba_Portfolio/Templates
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_viba_portfolio_search() ) : ?>

	<p><?php viba_portfolio_translate( 'i18n-search-not-found', __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'viba-portfolio' ), true ); ?></p>
	<?php viba_portfolio_searchform(); ?>

<?php else : ?>

	<p class="viba-portfolio-notice-info"><?php viba_portfolio_translate( 'i18n-no-items', __( 'No portfolio items were found.', 'viba-portfolio' ), true ); ?></p>

<?php endif; ?>