<?php

if ( ! class_exists('acf') && ! is_admin() ) {
    echo 'Please active ACF plugin!'; die;
}

add_action( 'init', 'master_init' );
function master_init() {
	require( 'lib/custom-types.php' );
	require( 'lib/taxonomies.php' );
	require( 'lib/menus.php' );
	require( 'lib/acf-utilities.php' );
}

add_action( 'widgets_init', 'master_widgets_init' );
function master_widgets_init() {
	require( 'lib/widgets.php' );
}

// Extras functions
require( 'lib/master-url.php' );
require( 'lib/extras.php' );
