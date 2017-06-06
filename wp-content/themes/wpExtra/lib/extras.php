<?php
/**
 * Extra functions
 */

// Allows SVG files to be added to Media Uploader
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/* Execute PHP code in widget */
function php_text($text) {
	if (strpos($text, '<' . '?') !== false) {
		ob_start();
		eval('?' . '>' . $text);
		$text = ob_get_contents();
		ob_end_clean();
	}
	return $text;
}
add_filter('widget_text', 'php_text', 99);

// Do shortcode in widget
add_filter('widget_text', 'do_shortcode');

/**
 * Theme setup
 * @return void
 */
function master_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
}
add_action( 'after_setup_theme', 'master_setup' );

/**
 * Enqueue scripts and styles.
 */
function master_scripts() {

	$url_obj = new Master_Url();

	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_style( 'vendor-style', $url_obj->styleUrl('vendor'), array(), null );
	wp_enqueue_style( 'main-style', $url_obj->styleUrl('style'), array(), null );
	
	wp_enqueue_script( 'vendor-script', $url_obj->scriptUrl('vendor'), array('jquery'), null, true );
	wp_enqueue_script( 'main-script', $url_obj->scriptUrl('script'), array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'master_scripts' );

// @length unit: Character
function get_stripped_excerpt( $content, $length = 250 ) {
    $return = wp_strip_all_tags($content, true);
    if ( $return && strlen($return) > $length ) {
        $return = substr( $return, 0, strpos($return, ' ', $length) );
    }

    return $return;
}

/**
 * Pagination function
 */
function get_pagination_link($href, $text, $classes = '') {
    return '<a href="' . $href . '" class="pa-item ' . $classes . '">' . $text . '</a>';
}

function get_pagination_current($text) {
    return '<span class="pa-item pa-current">' . $text . '</span>';
}

/**
 * Get pagination
 * @param  string  $type  long or short
 * @param  string  $pages max_num_pages (total of pages)
 * @param  string  $paged current page
 * @param  integer $range how many items to show at the same time
 * @return pagination html
 */
function pagination($type = 'long', $pages = '', $paged = '', $range = 3) {
 
    if ( ! $paged ) {
        $paged = get_query_var('paged');
        $paged = $paged ? $paged : 1;
    }

    if ( ! $pages ) {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
    }

    if ( !$pages || $pages == 1 ) return '';
 
    $html = '';

    if ($type == 'long') {

        $dots_left = 0;
        $dots_right = 0;

        $html .= ($paged >= 2) ? get_pagination_link( get_pagenum_link($paged - 1), '&#171;', 'pa-control pa-left' ) : '';

        for ($i = 1; $i <= $pages; $i++) {

            $output = ( $paged == $i ) ? get_pagination_current($i) : get_pagination_link( get_pagenum_link($i), $i );

            if ($i <= 2 || $i >= $pages - 1) {
                $html .= $output;
            } else {
                if ($paged == $i) {
                    if ($i == 3) {
                        $html .= get_pagination_current($i) . get_pagination_link( get_pagenum_link($i + 1), $i + 1 );
                    } elseif ($i == $pages - 2) {
                        $html .= get_pagination_link( get_pagenum_link($i - 1), $i - 1 ) . get_pagination_current($i);
                    } else {
                        $html .= get_pagination_link( get_pagenum_link($i - 1), $i - 1 ) . get_pagination_current($i) . get_pagination_link( get_pagenum_link($i + 1), $i + 1 );
                    }
                } else {
                    if ( abs($i - $paged) >= 3 ) {
                        if ($i < $paged) {
                            if (!$dots_left) {
                                $html .= '<span class="pa-item pa-dots">...</span>';
                                $dots_left = 1;
                            }
                        } else {
                            if (!$dots_right) {
                                $html .= '<span class="pa-item pa-dots">...</span>';
                                $dots_right = 1;
                            }
                        }
                    } elseif ( ($i == 3 && $paged != 1 && $paged != 4) || ($i == $pages - 2 && $paged != $pages && $paged != $pages - 3) ) {
                        $html .= get_pagination_link( get_pagenum_link($i), $i );
                    }
                    
                }
            }

        }

        $html .= ($paged <= $pages - 1) ? get_pagination_link( get_pagenum_link($paged + 1), '&#187;', 'pa-control pa-right' ) : '';

    } elseif ($type == 'short') {
        
        for ($i = 1; $i <= $pages; $i++) {
            if ( !($i >= $paged + $range + 1 || $i <= $paged - $range - 1) ) {
                $html .= ( $paged == $i ) ? get_pagination_current($i) : get_pagination_link( get_pagenum_link($i), $i );
            }
        }

    } else {
        $html .= 'Invalid pagination function parameters.';
    }

    return $html;
}
