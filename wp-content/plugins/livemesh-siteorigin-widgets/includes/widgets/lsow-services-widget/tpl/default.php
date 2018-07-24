<?php
/**
 * @var $settings
 * @var $style
 * @var $icon_type
 * @var $services
 */

if (!empty($settings['target']))
    $target = 'target="_blank"';
else
    $target = '';

?>

<?php if (!empty($instance['title']))
    echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $id = 'id="' . $this->id . '"'; ?>

<div <?php echo $id; ?> class="lsow-services lsow-<?php echo $style; ?> lsow-grid-container <?php echo lsow_get_grid_classes($settings); ?>">

    <?php foreach ($services as $service): ?>

        <?php list($animate_class, $animation_attr) = lsow_get_animation_atts($service['animation']); ?>

        <?php $service_url = sow_esc_url($service['href']); ?>

        <div class="lsow-grid-item lsow-service-wrapper">

            <div class="lsow-service <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

                <?php if ($icon_type == 'icon_image') : ?>

                    <?php if (empty($service_url)) : ?>

                        <div class="lsow-image-wrapper">

                            <?php echo wp_get_attachment_image($service['icon_image'], 'full', false, array('class' => 'lsow-image full')); ?>

                        </div>

                    <?php else : ?>

                        <a class="lsow-image-wrapper" href="<?php echo $service_url; ?>" <?php echo $target; ?>>

                            <?php echo wp_get_attachment_image($service['icon_image'], 'full', false, array('class' => 'lsow-image full')); ?>

                        </a>

                    <?php endif; ?>

                <?php else : ?>

                    <?php if (empty($service_url)) : ?>

                        <div class="lsow-icon-wrapper">

                            <?php echo siteorigin_widget_get_icon($service['icon']); ?>

                        </div>

                    <?php else : ?>

                        <a class="lsow-icon-wrapper" href="<?php echo $service_url; ?>" <?php echo $target; ?>>

                            <?php echo siteorigin_widget_get_icon($service['icon']); ?>

                        </a>

                    <?php endif; ?>

                <?php endif; ?>

                <div class="lsow-service-text">

                    <?php if (empty($service_url)) : ?>

                        <h3 class="lsow-title"><?php echo esc_html($service['title']) ?></h3>

                    <?php else : ?>

                        <a class="lsow-title-link" href="<?php echo $service_url; ?>" <?php echo $target; ?>>

                            <h3 class="lsow-title"><?php echo esc_html($service['title']) ?></h3>

                        </a>

                    <?php endif; ?>

                    <div class="lsow-service-details"><?php echo wp_kses_post($service['excerpt']) ?></div>

                </div>

            </div>

        </div>

        <?php

    endforeach;

    ?>

</div>