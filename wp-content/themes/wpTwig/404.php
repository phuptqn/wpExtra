<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 *
 * @package    Studio
 * @subpackage Timber
 * @since      Timber 0.1
 */

$context = Timber::get_context();
Timber::render( 'pages/404.twig', $context );
