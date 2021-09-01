<?php
/*
    Plugin Name: Jacket Security Plugin
    Description: A WordPress Must-Use plugin to improve security.
    Version: 0.1
    Author: Jacket
    Author URI: https://jacket.io
    License: GPL v3
    Text Domain: mu-plugin-security
    Domain Path: /languages/
*/

/**
 * Disable author URL's.
 *
 * This prefends users from fishing for usernames.
 * eg. http://somesite.ext/?author=1 becomes
 *     http://somesite.ext/author/itsusername
 *
 */
add_action('template_redirect', function () {
  if (is_author()) {
    wp_redirect(home_url());
  }
});

/**
 * Fixes: WordPress File Delete to Code Execution issue
 *
 * More info:
 * https://blog.ripstech.com/2018/wordpress-file-delete-to-code-execution/ *
 */
add_filter('wp_update_attachment_metadata', function ($data) {
  if (isset($data['thumb'])) {
    $data['thumb'] = basename($data['thumb']);
  }

  return $data;
});

/**
 * Removes defaults users endpoints.
 */
add_filter('rest_endpoints', function ($endpoints) {
  if (isset($endpoints['/wp/v2/users']))
    unset($endpoints['/wp/v2/users']);

  if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)']))
    unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);

  return $endpoints;
});

/**
 * Disable xmlrpc
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Add security measures for .htaccess
 *
 * These rules are applied after each deployment, using:
 * - wp rewrite flush
 *
 * https://developer.wordpress.org/cli/commands/rewrite/flush/
 * Any changes in the script below will have immediate effect
 * after a deployment, so be careful with this one!
 *
 */
add_filter('mod_rewrite_rules', function ($rules) {
  $insert_before_wp_defaults = [
    '<IfModule mod_rewrite.c>',
    '  RewriteEngine On',
    '  RewriteBase /',
    '  RewriteRule \.(?:psd|log|cmd|exe|bat|c?sh)$ - [NC,F]',
    '  RewriteRule (?:readme|license|changelog|-config|-sample)\.(?:php|md|txt|html?) - [R=404,NC,L]',
    '</IfModule>',
  ];

  $insert_before_wp_defaults = implode("\n", $insert_before_wp_defaults) . "\n\n";

  return $insert_before_wp_defaults . $rules;
});
