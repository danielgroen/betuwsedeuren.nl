<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
  return;
}
?>

<div class="col-md-4">
  <?php


  /**
   * woocommerce_before_shop_loop_item hook.
   *
   * @hooked woocommerce_template_loop_product_link_open - 10
   */
  do_action('woocommerce_before_shop_loop_item');

  /**
   * woocommerce_before_shop_loop_item_title hook.
   *
   * @hooked woocommerce_show_product_loop_sale_flash - 10
   * @hooked woocommerce_template_loop_product_thumbnail - 10
   */
  do_action('woocommerce_before_shop_loop_item_title');
  ?>

  <?php
  /**
   * woocommerce_after_shop_loop_item_title hook.
   *
   * @hooked woocommerce_template_loop_rating - 5
   * @hooked woocommerce_template_loop_price - 10
   */
  do_action('woocommerce_after_shop_loop_item_title'); ?>

  <div class="productTitleOverview">

    <?php
    /**
     * woocommerce_shop_loop_item_title hook.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     */
    do_action('woocommerce_shop_loop_item_title'); ?>

    <div class="korteOmschrijvingProductVlak">

      <?php while (the_flexible_field("downloads")) : ?>

        <?php if (get_row_layout() == "pdf") : ?>

          <a href="<?php the_sub_field("pdf_link"); ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> download folder</a>

        <?php elseif (get_row_layout() == "korte_omschrijving") : ?>

          <?php the_sub_field("korte_omschrijving_gele_vlak") ?>


        <?php endif; ?>


      <?php endwhile; ?>
    </div>
  </div>
</div>