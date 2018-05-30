<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>

  <?php get_template_part( 'template-parts/head-html' ) ?>

</head>

  <body ontouchstart="" <?php body_class() ?>>

    <?php the_field('code_after_body_opening', 'option') ?>
    
    <div id="wrapper">

      <header>
        <?php _e('Header', 'wpextra') ?>
      </header>