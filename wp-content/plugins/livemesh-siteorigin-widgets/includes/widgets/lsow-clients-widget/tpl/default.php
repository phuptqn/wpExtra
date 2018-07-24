<?php
/**
 * @var $clients
 * @var $settings
 */

?>

<?php list($animate_class, $animation_attr) = lsow_get_animation_atts($settings['animation']); ?>

<?php if (!empty($instance['title']))
    echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="lsow-clients lsow-gapless-grid">

    <div class="lsow-grid-container <?php echo lsow_get_grid_classes($settings); ?> ">

        <?php $column_count = 0; ?>

        <?php foreach ($clients as $client): ?>

            <div class="lsow-grid-item lsow-client <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

                <?php echo wp_get_attachment_image($client['image'], 'full', false, array('class' => 'lsow-image full', 'alt' => $client['name'])); ?>

                <div class="lsow-client-name">

                    <?php if (!empty($client['link'])): ?>

                        <a href="<?php echo sow_esc_url($client['link']); ?>"
                           title="<?php echo esc_html($client['name']); ?>"
                           target="_blank"><?php echo esc_html($client['name']); ?></a>

                    <?php else: ?>

                        <?php echo esc_html($client['name']); ?>

                    <?php endif; ?>

                </div>

                <div class="lsow-image-overlay"></div>

            </div>

        <?php

        endforeach;

        ?>

    </div>

</div>