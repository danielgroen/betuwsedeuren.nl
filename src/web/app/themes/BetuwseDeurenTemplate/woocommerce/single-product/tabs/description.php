<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) ) );

?>

<div class="row description">
	<div class="col-md-8 gray-background">


		<?php
		  global $product;
		  $koostis = $product->get_categories();
		  echo "<div><strong>Categorie: </strong>" . $koostis . " </div>";
	  ?>

		<?php
		  global $product;
		  $koostis = $product->get_attribute( 'pa_bouwjaar' );
		  echo "<div><strong>Bouwjaar: </strong>" . $koostis . " </div>";
	  ?>

		<?php
		  global $product;
		  $koostis = $product->get_attribute( 'pa_merk' );
		  echo "<div><strong>Merk: </strong>" . $koostis . " </div>";
	  ?>

		<?php
		  global $product;
		  $koostis = $product->get_attribute( 'pa_conditie' );
		  echo "<div><strong>Conditie: </strong>" . $koostis . " </div>";
	  ?>
	</br>

		<?php the_content(); ?>
	</div>
</div>
