<?php

function someScriptsIntoHead() {
  ?>
  <script type="text/javascript">
    var site = {
      url     : '<?php echo rtrim( get_site_url(), '/' ); ?>',
      themeUrl: '<?php echo rtrim( get_template_directory_uri(), '/' ); ?>'
    };
  </script>   
  <?php
}
add_action('wp_head', 'someScriptsIntoHead');

add_filter('body_class', 'xBodyClasses');
function xBodyClasses($classes) {
  if ( ! is_singular() ) return $classes;

  $xClasses = get_field('body_css_classes');
  if ( $xClasses ) {
    $classes[] = $xClasses;
  }

  return $classes;
}

function masterSetup() {

  load_theme_textdomain( 'wpextra', get_template_directory() . '/languages' );

  add_theme_support( 'title-tag' );
  add_theme_support( 'menus' );
  add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
  add_post_type_support( 'page', 'excerpt' );

  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption'
  ) );
}
add_action( 'after_setup_theme', 'masterSetup' );