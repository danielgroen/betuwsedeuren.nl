<div class="container">

  <div class="row">

      <div class="col-md-12">
          <h1><?php the_title(); ?></h1>
      </div>

  </div>

  <div class="row">
    <?php while(the_flexible_field("standaard_pagina_elementen")): ?>

      <?php if(get_row_layout() == "tekst_volledige_breedte"): ?>
        <div class="FullText col-md-12">
          <?php the_sub_field("tekst"); ?>
        </div>
      <?php endif; ?>

    <?php endwhile; ?>

  </div>

  <div class="row">

    <div class="col-md-5 normalePageContent">
      <?php the_content(); ?>
    </div>

    <div class="col-md-6 col-md-offset-1">

      <?php
          $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'referenties' );
          echo ('<img src="' . $thumbnail[0] . '" class="img-responsive">');
      ?>
      <?php if($thumbnail != "") { ?>
        <div class="geleVlakStandaardPagina"></div>
      <?php } ?>

      <?php if(is_page( 868 )) { ?>
        <div class="geleVlakContactPagina"></div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2459.6892822665154!2d5.584026216173477!3d51.93962087970849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c654f8579b4ff1%3A0xab0a9e570426f6c5!2sBetuwse+Deuren+BV!5e0!3m2!1snl!2snl!4v1506590928775" width="100%" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
      <?php } ?>

    </div>

  </div>

</div>
