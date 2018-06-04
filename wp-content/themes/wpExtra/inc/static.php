<?php

function isLocalHost() {
  $ipList = array(
    '127.0.0.1',
    '::1'
  );

  return in_array($_SERVER['REMOTE_ADDR'], $ipList);
}

function isUsedPageBuilder($currentPost = '') {
  if ( ! $currentPost ) {
    global $post;
    $currentPost = $post;
  }

  return ( strpos($currentPost->post_content, '"panel-layout"') !== FALSE );
}

// @length unit: Character
function getStrippedExcerpt( $content, $length = 250 ) {
  $return = wp_strip_all_tags($content, true);
  if ( $return && strlen($return) > $length ) {
    $return = substr( $return, 0, strpos($return, ' ', $length) );
  }

  return $return;
}

// Allows SVG files to be added to Media Uploader
function masterMimeTypes( $mimes ) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'masterMimeTypes' );

function previewSvgMediaImage($response, $attachment, $meta) {
  
  if ( $response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement') )
  {
    try {

      $path = get_attached_file($attachment->ID);
      if ( @file_exists($path) ) {
        $svg    = new SimpleXMLElement(@file_get_contents($path));
        $src    = $response['url'];
        $width  = (int) $svg['width'];
        $height = (int) $svg['height'];

        // media gallery
        $response['image'] = compact( 'src', 'width', 'height' );
        $response['thumb'] = compact( 'src', 'width', 'height' );

        // media single
        $response['sizes']['full'] = array(
          'height'        => $height,
          'width'         => $width,
          'url'           => $src,
          'orientation'   => $height > $width ? 'portrait' : 'landscape'
        );
      }

    } catch(Exception $e) {}

  }

  return $response;
}
add_filter('wp_prepare_attachment_for_js', 'previewSvgMediaImage', 10, 3);

function masterTextSizes( $initArray ) {
  $string = '';

  for ($i = 5; $i <= 50; $i++) { 
    $string .= $i . 'px ';
  }

  $initArray['fontsize_formats'] = trim($string);

  return $initArray;
}
add_filter( 'tiny_mce_before_init', 'masterTextSizes' );

/**
 * Enqueue scripts and styles.
 */
function masterScripts() {

  if ( is_singular() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );

  $urlObj = new assetUrl();
  $param  = isLocalHost() ? rand(100000000, 999999999) : null;
  $useMin = true;

  wp_enqueue_style( 'vendor-style', $urlObj->styleUrl('vendor', $useMin), array(), null );
  wp_enqueue_style( 'main-style', $urlObj->styleUrl('style', $useMin), array(), $param );

  wp_enqueue_script( 'vendor-script', $urlObj->scriptUrl('vendor', $useMin), array('jquery'), null, true );
  wp_enqueue_script( 'main-script', $urlObj->scriptUrl('script', $useMin), array('jquery'), $param, true );
}
add_action( 'wp_enqueue_scripts', 'masterScripts' );