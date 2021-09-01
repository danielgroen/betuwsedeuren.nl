<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="container">
	<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div class="row">
	<div class="col-md-12 contentContainer">

	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>

	</div><!-- .summary -->

	<div class="upperContentProduct">
		<?php the_content(); ?>
	</div>

	<?php do_action( 'woocommerce_after_single_product' ); ?>

	<div class="col-md-5 leftContent no-padding">
		<?php while(the_flexible_field("product_elementen")): ?>

			<?php if(get_row_layout() == "tweede_omschrijving"): ?>

				<?php the_sub_field("omschrijving_naast_afbeelding"); ?>

			<?php endif; ?>

		<?php endwhile; ?>
	</div>

	<div class="col-md-7">

		<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php
				/**
				 * woocommerce_before_single_product_summary hook.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
			?>

			<div class="productTitlePage">

				<?php
				/**
				 * woocommerce_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
				do_action( 'woocommerce_shop_loop_item_title' ); ?>

				<div class="korteOmschrijvingProductVlak">

				<?php while(the_flexible_field("downloads")): ?>

				 	<?php if(get_row_layout() == "pdf"): ?>

						<a href="<?php the_sub_field("pdf_link"); ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> download folder</a>

					<?php elseif(get_row_layout() == "korte_omschrijving"): ?>

						<?php the_sub_field("korte_omschrijving_gele_vlak") ?>

					<?php endif; ?>

				<?php endwhile; ?>
				</div>

			</div>

		</div><!-- #product-<?php the_ID(); ?> -->

	</div>

</div>

</div>
