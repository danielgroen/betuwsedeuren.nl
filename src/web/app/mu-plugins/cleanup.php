<?php

/**
 * Plugin Name:  Wordpress cleanup
 * Plugin URI:   https://github.com/roots/bedrock/
 * Description:  Cleanup not used scripts
 * Version:      1.0.0
 * Author:       Daniel
 * Author URI:   https://jacket.nl/
 * License:      MIT License
 */

/**
 * Remove jquery migrate
 **/
function cedaro_dequeue_jquery_migrate($scripts)
{
  if (!is_admin() && !empty($scripts->registered['jquery'])) {
    $jquery_dependencies = $scripts->registered['jquery']->deps;
    $scripts->registered['jquery']->deps = array_diff($jquery_dependencies, array('jquery-migrate'));
  }
}
add_action('wp_default_scripts', 'cedaro_dequeue_jquery_migrate');


/**
 * Remove Emoji's
 **/
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Remove wp-embed
 * Remove Gutenberg blocks
 **/
add_action('wp_enqueue_scripts', function () {
  wp_deregister_script('wp-embed');
  wp_dequeue_style('wp-block-library');
});



// Adapted from https://gist.github.com/toscho/1584783
// lazyload all js
add_filter('clean_url', function ($url) {
  if (!is_admin()) {
    if (strpos($url, '.js') === FALSE) {
      return $url;
    }
    return "$url' defer='defer'";
  } else {
    return "$url";
  }
}, 11, 1);
