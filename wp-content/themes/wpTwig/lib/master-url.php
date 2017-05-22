<?php

/**
 * The Url Twig Extension class.
 *
 * @author Patrick Douglas <pdouglas@engrain.com>
 * @author Patrik Vormittag <pvormittag@engrain.com>
 */
class Master_Url
{
    /**
     * Creates a script URL with either a minified or non-minified version
     * depending on whether or not your are debugging.
     *
     * @param string $name The name of the file you'd like to load
     *
     * @return string A script URL with the appropiate file
     */
    public function scriptUrl($name, $useMin = false)
    {
        $path = 'assets/bundles/' . $name . '.js';

        if ($useMin === true) {
            $path = 'assets/min/'.$name.'.min.js';
        }

        // Use `get_stylesheet_directory_uri` as this function resolves the URI
        // for child themes in addition to the root theme.
        // https://developer.wordpress.org/reference/functions/get_stylesheet_directory_uri/#comment-1798

        return get_stylesheet_directory_uri() . '/' . $path;
    }

    /**
     * Creates a style URL with either a minified or non-minified version
     * depending on whether or not your are debugging.
     *
     * @param string $name The name of the file you'd like to load
     *
     * @return string A style URL with the appropiate file
     */
    public function styleUrl($name, $useMin = false)
    {
        $path = 'assets/bundles/' . $name . '.css';

        if ($useMin === true) {
            $path = 'assets/min/' . $name . '.min.css';
        }

        // Use `get_stylesheet_directory_uri` as this function resolves the URI
        // for child themes in addition to the root theme.
        // https://developer.wordpress.org/reference/functions/get_stylesheet_directory_uri/#comment-1798

        return get_stylesheet_directory_uri() . '/' . $path;
    }
}
