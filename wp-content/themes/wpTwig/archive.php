<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 *
 * @package    Studio
 * @subpackage Timber
 * @since      Timber 0.1
 */

$context = Timber::get_context();

$context['posts'] = Timber::get_posts();

Timber::render( array( 'pages/archive-' . get_post_type() . '.twig', 'pages/archive.twig', 'pages/index.twig' ), $context );
