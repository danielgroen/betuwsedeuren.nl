<?php


/**
 * side menu
 */
add_action('admin_menu', function () {
  add_options_page('Stage file proxy', 'Stage file proxy', 'manage_options', 'stage-file-proxy', 'render_SFP_settings_page');
});


function render_SFP_settings_page()
{
?>
  <h2>Example Plugin Settings</h2>
  <form action="options.php" method="post">
    <?php
    settings_fields('custom_file_proxy_options');
    do_settings_sections('cfp_plugin'); ?>
    <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>" />
  </form>
<?php
}


function cfp_register_settings()
{
  register_setting('custom_file_proxy_options', 'custom_file_proxy_options');
  add_settings_section('form_settings', false, 'cfp_plugin_section_text', 'cfp_plugin');

  add_settings_field('cfp_plugin_setting_production_cname', 'Production CNAME', 'cfp_plugin_setting_production_cname', 'cfp_plugin', 'form_settings');
}
add_action('admin_init', 'cfp_register_settings');




function cfp_plugin_section_text()
{
  echo '<p>Enter the production URL of which you want to proxy the images from</p>';
}

function cfp_plugin_setting_production_cname()
{
  $options = get_option('custom_file_proxy_options');
  if (isset($options['production_cname'])) {
    echo "<input id='cfp_plugin_setting_production_cname' name='custom_file_proxy_options[production_cname]' type='text' value='" . esc_attr($options['production_cname']) . "' />";
  } else {
    echo "<input id='cfp_plugin_setting_production_cname' name='custom_file_proxy_options[production_cname]' type='text' value='' />";
  }
}
