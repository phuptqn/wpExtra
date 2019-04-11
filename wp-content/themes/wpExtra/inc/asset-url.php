<?php

class assetUrl
{
  public function scriptUrl($name, $useMin = false)
  {
    $path = 'dist/bundles/' . $name . '.js';

    if ($useMin === true) {
      $path = 'dist/min/'. $name . '.min.js';
    }

    return get_stylesheet_directory_uri() . '/' . $path;
  }

  public function styleUrl($name, $useMin = false)
  {
    $path = 'dist/bundles/' . $name . '.css';

    if ($useMin === true) {
      $path = 'dist/min/' . $name . '.min.css';
    }

    return get_stylesheet_directory_uri() . '/' . $path;
  }
}
