<?php

if ( ! class_exists('TimberSite') && ! is_admin() ) {
	echo 'Please active Timber plugin!'; die;
}

if ( class_exists('TimberSite') ) {
	
	class BootstrapSite extends TimberSite {

		function __construct() {
			
			add_filter( 'timber_context', array( $this, 'add_to_context' ) );
			add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
			add_action( 'init', array( $this, 'register_post_types' ) );
			add_action( 'init', array( $this, 'register_taxonomies' ) );
			add_action( 'init', array( $this, 'register_menus' ) );
			add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
			add_action( 'init', array( $this, 'tsk_acf_utils' ) );

			// Weird thing that is required for custom post type single pages
			flush_rewrite_rules();

			parent::__construct();
		}

		// Note that the following included files only need to contain the taxonomy/CPT/Menu arguments and register_whatever function. They are initialized here.
		function register_post_types() {
			require( 'lib/custom-types.php' );
		}

		function register_taxonomies() {
			require( 'lib/taxonomies.php' );
		}

		function register_menus() {
			require( 'lib/menus.php' );
		}

		function register_sidebars() {
			require( 'lib/widgets.php' );
		}

		function tsk_acf_utils() {
			require( 'lib/acf-utilities.php' );
		}

		// Global Context of Site
		function add_to_context( $context ) {

			$context['menu'] = new TimberMenu();
			$context['site'] = $this;
			// Site-wide Settings
			$context['global'] = get_fields( 'options' );

			return $context;
		}

		function add_to_twig( $twig ){
			/* This is where you can add your own fuctions to twig */
			$twig->addExtension( new Twig_Extension_StringLoader() );

			return $twig;
		}
	}

	new BootstrapSite();

}

// Extras functions
require( 'lib/master-url.php' );
require( 'lib/extras.php' );
