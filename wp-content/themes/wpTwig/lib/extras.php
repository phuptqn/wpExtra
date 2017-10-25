<?php
/**
 * Extra functions
 */

function isLocalhost() {
    $ipList = array(
        '127.0.0.1',
        '::1'
    );

    return in_array($_SERVER['REMOTE_ADDR'], $ipList);
}

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

    $param = isLocalhost() ? rand(100000000, 999999999) : null;

	wp_enqueue_style( 'vendor-style', $url_obj->styleUrl('vendor'), array(), null );
	wp_enqueue_style( 'main-style', $url_obj->styleUrl('style'), array(), $param );
	
	wp_enqueue_script( 'vendor-script', $url_obj->scriptUrl('vendor'), array('jquery'), null, true );
	wp_enqueue_script( 'main-script', $url_obj->scriptUrl('script'), array('jquery'), $param, true );
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

// ACF remove row confirm
add_action('acf/input/admin_footer', function() {
    ?>
    <script type="text/javascript">
        (function ($) {
            $('body').on('click', 'a[data-event="remove-layout"], a[data-event="remove-row"], .acf-repeater-remove-row, .acf-fc-remove, a.delete-field', function (e) {
                return confirm("Are you sure? This is permanent!");
            })
        })(jQuery);
    </script>
    <?php
});


function some_scripts_into_head() {
?>
    <script type="text/javascript">
        var site = {
            url     : '<?php echo rtrim( get_site_url(), '/' ); ?>',
            themeUrl: '<?php echo rtrim( get_template_directory_uri(), '/' ); ?>'
        };
    </script>   
<?php
}
add_action('wp_head', 'some_scripts_into_head');

add_filter('body_class', 'xBodyClasses');
function xBodyClasses($classes) {
    if ( ! is_singular() ) return $classes;

    $xClasses = get_field('body_css_classes');
    if ( $xClasses ) {
        $classes[] = $xClasses;
    }

    return $classes;
}

if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
    function wpex_mce_text_sizes( $initArray ) {
        $string = '';

        for ($i = 5; $i <= 50; $i++) { 
            $string .= $i . 'px ';
        }

        $initArray['fontsize_formats'] = trim($string);

        return $initArray;
    }
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

/**
 * Pagination Class
 * How to use:
 *      Method 1 (basic):
 *          + <?php new RichterPagination(); # Default query # ?>
 *          + <?php new RichterPagination( $yourCustomQuery ); # Custom query # ?>
 *      Method 2 (with wrapper css class):
 *          + <?php new RichterPagination( '', 'your-pagination-class' ); # Default query # ?>
 *          + <?php new RichterPagination( $yourCustomQuery, 'your-pagination-class' ); # Custom query # ?>
 *
 *      Example css:
 *     
        .richter-pagination {
            margin-bottom: 25px;
        }
        .richter-pagination a,
        .richter-pagination span {
            display: inline-block;
            padding: 2px 5px;
            border: solid 1px #a0a0a0;
            min-width: 26px;
            text-align: center;
            color: #676767;
            transition: 0.4s;
            -o-transition: 0.4s;
            -ms-transition: 0.4s;
            -moz-transition: 0.4s;
            -webkit-transition: 0.4s;
        }
        .richter-pagination a:hover {
            border: solid 1px black;
            color: black;
        }
        .richter-pagination a + a,
        .richter-pagination a + span,
        .richter-pagination span + a,
        .richter-pagination span + span {
            margin-left: 10px;
        }
        .richter-pagination .current {
            cursor: default;
            border: solid 1px black;
            color: black;
        }
        .richter-pagination .dots {
            cursor: default;
        }
 */
if ( ! class_exists('RichterPagination') ) {

    class RichterPagination
    {

        public $richterQuery;
        public $richterCssClass;
        public $richterType;
        public $richterRange;
        public $richterEcho;

        /**
         * Constructor
         */
        function __construct($richterQuery = '', $richterCssClass = 'richter-pagination', $richterEcho = true, $richterType = 'long', $richterRange = 3) {
            $this->richterQuery     = $richterQuery;
            $this->richterCssClass  = $richterCssClass;
            $this->richterType      = $richterType;
            $this->richterRange     = $richterRange;
            $this->richterEcho      = $richterEcho;

            if ( $this->richterEcho ) {
                echo $this->getMainRichterPagination();
            }
        }

        /**
         * Pagination Link
         */
        function getRichterPaginationLink($href, $text, $classes = '') {
            return '<a href="' . $href . '" class="' . $classes . '">' . $text . '</a>';
        }

        /**
         * Pagination Current
         */
        function getRichterPaginationCurrent($text) {
            return '<span class="current">' . $text . '</span>';
        }

        function getMainRichterPagination() {

            $paged = get_query_var('paged') ? get_query_var('paged') : ( get_query_var('page') ? get_query_var('page') : 1 );

            if ( $this->richterQuery === '' ) {
                global $wp_query;
                $pages = $wp_query->max_num_pages;
            } else {
                $pages = $this->richterQuery->max_num_pages;
            }

            if ( ! $pages || $pages == 1 ) return '';
         
            $html = '<div class="' . $this->richterCssClass . '">';

            if ($this->richterType == 'long') {

                $dots_left = 0;
                $dots_right = 0;

                $html .= ($paged >= 2) ? $this->getRichterPaginationLink( get_pagenum_link($paged - 1), '&#171;', 'arrow arrow-left' ) : '';

                for ($i = 1; $i <= $pages; $i++) {

                    $output = ( $paged == $i ) ? $this->getRichterPaginationCurrent($i) : $this->getRichterPaginationLink( get_pagenum_link($i), $i );

                    if ($i <= 2 || $i >= $pages - 1) {
                        $html .= $output;
                    } else {
                        if ($paged == $i) {
                            if ($i == 3) {
                                $html .= $this->getRichterPaginationCurrent($i);
                                $html .= ($i + 1 != $pages - 1) ? $this->getRichterPaginationLink( get_pagenum_link($i + 1), $i + 1 ) : '';
                            } elseif ($i == $pages - 2) {
                                $html .= $this->getRichterPaginationLink( get_pagenum_link($i - 1), $i - 1 ) . $this->getRichterPaginationCurrent($i);
                            } else {
                                $html .= $this->getRichterPaginationLink( get_pagenum_link($i - 1), $i - 1 ) . $this->getRichterPaginationCurrent($i) . $this->getRichterPaginationLink( get_pagenum_link($i + 1), $i + 1 );
                            }
                        } else {
                            if ( abs($i - $paged) >= 3 ) {
                                if ($i < $paged) {
                                    if (!$dots_left) {
                                        $html .= '<span class="dots">...</span>';
                                        $dots_left = 1;
                                    }
                                } else {
                                    if (!$dots_right) {
                                        $html .= '<span class="dots">...</span>';
                                        $dots_right = 1;
                                    }
                                }
                            } elseif ( ($i == 3 && $paged != 1 && $paged != 4) || ($i == $pages - 2 && $paged != $pages && $paged != $pages - 3) ) {
                                $html .= $this->getRichterPaginationLink( get_pagenum_link($i), $i );
                            }
                            
                        }
                    }

                }

                $html .= ($paged <= $pages - 1) ? $this->getRichterPaginationLink( get_pagenum_link($paged + 1), '&#187;', 'arrow arrow-right' ) : '';

            } elseif ($this->richterType == 'short') {
                
                for ($i = 1; $i <= $pages; $i++) {
                    if ( !($i >= $paged + $this->richterRange + 1 || $i <= $paged - $this->richterRange - 1) ) {
                        $html .= ( $paged == $i ) ? $this->getRichterPaginationCurrent($i) : $this->getRichterPaginationLink( get_pagenum_link($i), $i );
                    }
                }

            } else {
                $html .= __('Invalid Richter Pagination Parameters.');
            }

            $html .= '</div>';

            return $html;
        }
    }
}