<?php
/**
 * Template Name: Home Page
 *
 * */

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

Timber::render( array( 'pages/home.twig', 'pages/page.twig' ), $context );
