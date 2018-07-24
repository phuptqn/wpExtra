<?php
/**
 * @var $settings
 * @var $testimonials
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="lsow-testimonials lsow-grid-container <?php echo lsow_get_grid_classes($settings); ?>">

    <?php foreach ($testimonials as $testimonial) : ?>

        <?php list($animate_class, $animation_attr) = lsow_get_animation_atts($testimonial['animation']); ?>

        <div class="lsow-grid-item lsow-testimonial <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

            <div class="lsow-testimonial-text">
                <?php echo wp_kses_post($testimonial['text']) ?>
            </div>

            <div class="lsow-testimonial-user">

                <div class="lsow-image-wrapper">
                    <?php echo wp_get_attachment_image($testimonial['image'], 'thumbnail', false, array('class' => 'lsow-image full')); ?>
                </div>

                <div class="lsow-text">
                    <h4 class="lsow-author-name"><?php echo esc_html($testimonial['name']) ?></h4>
                    <div class="lsow-author-credentials"><?php echo wp_kses_post($testimonial['credentials']); ?></div>
                </div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>