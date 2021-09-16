  </section>
  </main>

  <div class="external-links">
    <div class="grid">
      <h5 class="block-title">Externe links</h5>
      <div class="article-wrapper">
        <?php
        $repeater = get_option('options_repeater');
        if ($repeater) {
          $repeater_bare = (int)$repeater;

          for ($i = 0; $i < $repeater_bare; $i++) : ?>
            <?php
            $url = get_option('options_repeater_' . $i . '_url');
            $image = get_option('options_repeater_' . $i . '_image');
            $title = get_option('options_repeater_' . $i . '_title');
            $summary = get_option('options_repeater_' . $i . '_summary');

            if ($image) :
              $image_src = wp_get_attachment_image_src($image, 'large')[0];
            ?>

              <a href="<?php $url; ?>" target="_blank" class="external-links__article">
                <img class="external-links__article__image" src="<?php echo $image_src; ?>" alt="external image">
                <?php
                ?>
                <div class="external-links__article__wrapper">
                  <span class="external-links__article__title"><?php echo $title; ?></span>
                  <p class="external-links__article__summary"><?php echo $summary; ?></p>
                </div>
              </a>
        <?php endif;
          endfor;
        }
        ?>
      </div>
    </div>
  </div>

  <footer class="footer">

    <div class="container">

      <div class="row footer-tekst">

        <div class="col-md-3 col-xs-6">
          <?php
          if (is_active_sidebar('footer-sidebar-1')) {
            dynamic_sidebar('footer-sidebar-1');
          }
          ?>

        </div>

        <div class="col-md-3 col-xs-6">
          <?php
          if (is_active_sidebar('footer-sidebar-2')) {
            dynamic_sidebar('footer-sidebar-2');
          }
          ?>
        </div>

        <div class="col-md-3 col-xs-6">
          <?php
          if (is_active_sidebar('footer-sidebar-3')) {
            dynamic_sidebar('footer-sidebar-3');
          }
          ?>

        </div>

        <div class="col-md-3 col-xs-6">
          <?php
          if (is_active_sidebar('footer-sidebar-4')) {
            dynamic_sidebar('footer-sidebar-4');
          }
          ?>
        </div>

        <div class="col-md-3 col-xs-6">
          <?php
          if (is_active_sidebar('footer-sidebar-5')) {
            dynamic_sidebar('footer-sidebar-5');
          }
          ?>
        </div>

      </div>
    </div>
    <div class="container-fluid">
      <div class="fullImgFooter"></div>
    </div>
    <div class="menu-box-bg"></div>
    <div class="modal fade modal-search" id="modal-search" role="dialog" aria-labelledby="modalsearch">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h3 class="modal-title text-center" id="myModalLabel">Doorzoek de website</h3>
          </div>
          <form role="search" method="get" action="<?php echo home_url('/'); ?>">
            <div class="modal-body">
              <input type="search" class="form-control" placeholder="Zoeken" value="<?php echo wp_specialchars($s, 1); ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>">
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-default" value="<?php echo esc_attr_x('Zoeken', 'submit button') ?>" />
            </div>
          </form>
        </div>
      </div>
    </div>

  </footer>

  <script>
    window.addEventListener('load', function(event) {
      if (location.pathname.includes('contact-route')) {
        const offerChoise = document.getElementById("label_2_21_1");

        if (location.search === '?q=offer' && offerChoise) {
          offerChoise.click()
        }
      }
    });
  </script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <?php wp_footer(); ?>
  </body>

  </html>