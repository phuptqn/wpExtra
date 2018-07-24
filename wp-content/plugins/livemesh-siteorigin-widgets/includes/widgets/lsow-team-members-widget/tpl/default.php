<?php
/**
 * @var $style
 * @var $settings
 * @var $team_members
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $item_style = ''; ?>

<?php $container_style = 'lsow-container'; ?>

<?php if ($style == 'style1'): ?>

    <?php $item_style = 'lsow-grid-item'; ?>

    <?php $container_style = 'lsow-grid-container ' . lsow_get_grid_classes($settings); ?>

<?php endif; ?>

<div class="lsow-team-members lsow-<?php echo $style; ?> <?php echo $container_style; ?>">

    <?php foreach ($team_members as $team_member): ?>

        <div class="<?php echo $item_style; ?> lsow-team-member-wrapper">

            <?php list($animate_class, $animation_attr) = lsow_get_animation_atts($team_member['animation']); ?>

            <div class="lsow-team-member <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

                <div class="lsow-image-wrapper">

                    <?php echo wp_get_attachment_image($team_member['image'], $settings['image_size'], false, array('class' => 'lsow-image')); ?>

                    <?php if ($style == 'style1'): ?>

                        <?php include 'social-profile.php'; ?>

                    <?php endif; ?>

                </div>

                <div class="lsow-team-member-text">

                    <h3 class="lsow-title"><?php echo esc_html($team_member['name']) ?></h3>

                    <div class="lsow-team-member-position">

                        <?php echo do_shortcode($team_member['position']) ?>

                    </div>

                    <div class="lsow-team-member-details">

                        <?php echo do_shortcode($team_member['details']) ?>

                    </div>

                    <?php if ($style == 'style2'): ?>

                        <?php include 'social-profile.php'; ?>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <?php

    endforeach;

    ?>

</div>