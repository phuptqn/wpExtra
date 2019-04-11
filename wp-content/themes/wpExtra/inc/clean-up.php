<?php

function masterCleanup() {

  // Remove Really Simple Discovery
  remove_action ('wp_head', 'rsd_link');

  // Remove WordPress version number generator tag
  remove_action('wp_head', 'wp_generator');

  // Remove Windows Live Writer
  remove_action( 'wp_head', 'wlwmanifest_link');

  // Remove shortlink
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

  // Remove Emojis
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );

  // Remove REST API Links
  remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
  remove_action('template_redirect', 'rest_output_link_header', 11, 0);

  // Remove oEmbed
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
  remove_action( 'wp_head', 'wp_oembed_add_host_js' );
  remove_action('rest_api_init', 'wp_oembed_register_route');
  remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

  // Remove Automatic Feed Links
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);

  // Remove Relational Links (prev/next post)
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
add_action('after_setup_theme', 'masterCleanup');

function noCacheParam($src) {
  if (strpos($src, '?ver=')) {
    $src = remove_query_arg( 'ver', $src );
  }

  $param = isset($_GET['clearcache']) ? rand(100000000, 999999999) : '';
  if ($param) {
    $src = add_query_arg('nochache', $param, $src);
  }

  return $src;
}
add_filter( 'style_loader_src', 'noCacheParam', 1000 );
add_filter( 'script_loader_src', 'noCacheParam', 1000 );

// Remove slick scripts from Livemesh post carousel widget
// Because the theme already included
function wpa54064_inspect_scripts() {
  if ( ! is_admin() ) {
    wp_deregister_script( 'lsow-slick-carousel' );
    wp_deregister_style( 'lsow-slick' ); 
    wp_dequeue_script( 'lsow-slick-carousel' );
    wp_dequeue_style( 'lsow-slick' );
  }
}
add_action( 'wp_print_styles', 'wpa54064_inspect_scripts', 11 );
add_action( 'get_footer', 'wpa54064_inspect_scripts', 11 );