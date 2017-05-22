<?php
/**
 * The Template for displaying all single posts
 *
 *
 * @package    Studio
 * @subpackage Timber
 * @since      Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

Timber::render( array( 'pages/single-' . $post->ID . '.twig', 'pages/single-' . $post->post_type . '.twig', 'pages/single.twig' ), $context );
