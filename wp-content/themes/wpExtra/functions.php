<?php

require( 'inc/config.php' );

add_action( 'init', 'masterInit' );
function masterInit() {
	require( 'inc/posttypes.php' );
	require( 'inc/taxonomies.php' );
	require( 'inc/menus.php' );
	require( 'inc/acf.php' );
}

add_action( 'widgets_init', 'masterWidgetsInit' );
function masterWidgetsInit() {
	require( 'inc/widgets.php' );
}

// Extras functions
require( 'inc/static.php' );
require( 'inc/clean-up.php' );
require( 'inc/asset-url.php' );
require( 'inc/pagination.php' );
require( 'inc/extras.php' );
