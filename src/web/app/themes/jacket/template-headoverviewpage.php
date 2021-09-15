<?php /* Template Name: Hoofd pagina voor categorieën template	*/ ?>

<?php get_header(); ?>

<div class="container">
  <div class="row">
    <div class="col-sm-12 standaard">
      <h1 class="block-title"><?php the_title(); ?></h1>
    </div>
    <div class="row">
      <div class="col-md-12">

        <?php while (the_flexible_field("home_page_elementen")) : ?>
          <?php //////////// #1. Categorie voor homepagina //////////
          ?>
          <?php if (get_row_layout() == "categorie") :
            $categories = get_sub_field("selecteer_categorie");
          ?>
            <?php
            foreach ($categories as $category) {

              if ($term = get_term_by('id', $category, 'product_cat')) {

                if (is_page_template('template-headoverviewpage.php')) {
                  global $wp_query;
                  // Haalt de query objecten op
                  $cat = $wp_query->get_queried_object();
                  // Pakt de thumbnail d.m.v. category id
                  $thumbnail_id = get_woocommerce_term_meta($category, 'thumbnail_id', true);
                  // Haalt de afbeelding op en zet het in een variable.
                  $image = wp_get_attachment_image($thumbnail_id, 'onze-acties', "", ["class" => "img-responsive homeCategory"]);
                }

            ?>
                <a href="/product-categorie/<?php echo $term->slug; ?>">
                  <div class="col-md-4 col-xs-6 homeCategoryItem">
                    <?php echo $image; ?>
                    <div class="undertitleHome">
                      <?php

                      echo "<h1 class='block-title'>" . $term->name . "</h1>";

                      ?>
                    </div>
                  </div>
                </a>
            <?php
              }
            }
            ?>
          <?php endif; ?>

          <? php // $countloop++ 
          ?>
        <?php endwhile; ?>

      </div>

    </div>

    <div class="row">
      <div class="col-md-12">

        <?php
        if (have_posts()) : while (have_posts()) : the_post();
            get_template_part('content', get_post_format());
          endwhile;
        endif;
        ?>

      </div>
    </div>

  </div>
</div> <!-- /.container -->

<?php get_footer(); ?>