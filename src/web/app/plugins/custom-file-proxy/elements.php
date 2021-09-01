<?php
/*
	Plugin Name: Stage File Proxy
	Plugin URI: https://codefield.nl/
	Description: Get only the files you need from your production environment. Don't ever run this in production!
	Version: 1.00
	Author: Daniel Groen
	Author URI: https://www.codefield.nl/
  Text Domain: codechief
*/
define('SFPPATH',   plugin_dir_path(__FILE__));
define('SFPURL',    plugin_dir_url(__FILE__));
define('SFPBASE',    plugin_basename(__FILE__));

/**
 * Plugin Settings Page
 */
add_filter('plugin_action_links_' . SFPBASE, 'add_action_links');
function add_action_links($actions)
{
  $mylinks = array(
    '<a href="' . admin_url('options-general.php?page=stage-file-proxy') . '">Settings</a>',
  );
  $actions = array_merge($actions, $mylinks);
  return $actions;
}


include_once(SFPPATH . 'src/options-page.php');
include_once(SFPPATH . 'src/image-replacement.php');

