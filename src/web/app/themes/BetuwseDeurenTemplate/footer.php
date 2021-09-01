  </section> <!-- Einde van content section -->

</main> <!-- Einde van pagina content -->

<footer>

  <div class="container">

    <div class="row footer-tekst">

      <div class="col-md-2 col-xs-6">
        <?php
          if(is_active_sidebar('footer-sidebar-1')){
          dynamic_sidebar('footer-sidebar-1');
          }
        ?>

      </div>

      <div class="col-md-2 col-xs-6">
        <?php
          if(is_active_sidebar('footer-sidebar-2')){
          dynamic_sidebar('footer-sidebar-2');
          }
        ?>
      </div>

      <div class="col-md-3 col-md-offset-2 col-xs-6">
        <?php
          if(is_active_sidebar('footer-sidebar-3')){
          dynamic_sidebar('footer-sidebar-3');
          }
        ?>

      </div>

      <div class="col-md-3 col-xs-6">
        <?php
          if(is_active_sidebar('footer-sidebar-4')){
          dynamic_sidebar('footer-sidebar-4');
          }
        ?>
      </div>

      <div class="col-md-2 col-md-offset-1 col-xs-6">
        <?php
          if(is_active_sidebar('footer-sidebar-5')){
          dynamic_sidebar('footer-sidebar-5');
          }
        ?>
      </div>

    </div>

    <div class="row footer-link">
      <?php if (is_front_page()) { ?>
        Ontworpen en ontwikkeld door: <a href="https://vaneckoosterink.com" target="_blank">van Eck Oosterink Communicatieregisseurs</a>
      <?php } ?>
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
        <form role="search" method="get"  action="<?php echo home_url( '/' ); ?>">
          <div class="modal-body">
            <input type="search" class="form-control" placeholder="Zoeken"  value="<?php echo wp_specialchars($s, 1); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="<?php echo esc_attr_x( 'Zoeken', 'submit button' ) ?>" />
          </div>
        </form>
      </div>
    </div>
  </div>

</footer>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php wp_footer(); ?>
</body>
</html>
