<?php
/**
 * @var $piecharts
 * @var $settings
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php

$bar_color = ' data-bar-color="' . esc_attr($settings['bar_color']) . '"';
$track_color = ' data-track-color="' . esc_attr($settings['track_color']) . '"';

?>

<div class="lsow-piecharts lsow-grid-container <?php echo lsow_get_grid_classes($settings); ?>">

    <?php foreach ($piecharts as $piechart): ?>

        <div class="lsow-grid-item lsow-piechart">

            <div class="lsow-percentage" <?php echo $bar_color; ?> <?php echo $track_color; ?>
                 data-percent="<?php echo round($piechart['percentage']); ?>">

                <span><?php echo round($piechart['percentage']); ?><sup>%</sup></span>

            </div>

            <div class="lsow-label"><?php echo esc_html($piechart['stats_title']); ?></div>

        </div>

    <?php

    endforeach;

    ?>

</div>