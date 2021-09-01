<div id="sidebar">
  <ul>
    <?php
      if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('test-sidebar') ) :
      endif;
    ?>
  </ul>
</div>
