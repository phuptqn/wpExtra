<?php

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