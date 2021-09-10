<?php

namespace Jacket\classes;

class Functions
{
  static function getIcon($icon)
  {
    return require(get_stylesheet_directory() . '/icons/' . $icon . '.svg');
  }

  static function getImage($image, $mime = '.png')
  {
    echo get_template_directory_uri() . '/images/' . $image . $mime;
  }

  static function pretify($url)
  {
    return str_replace(' ', '-', strtolower($url));
  }
}
