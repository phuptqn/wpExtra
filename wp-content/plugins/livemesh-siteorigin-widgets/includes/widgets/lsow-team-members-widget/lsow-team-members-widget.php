<?php

/*
Widget Name: Team Members
Description: Display a list of your team members optionally in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LSOW_Team_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lsow-team-members',
            __('Team Members', 'livemesh-so-widgets'),
            array(
                'description' => __('Create team members to display in a column grid.', 'livemesh-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => LSOW_PLUGIN_HELP_URL. '#team-members'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'livemesh-so-widgets'),
                ),

                'style' => array(
                    'type' => 'select',
                    'label' => __('Choose Style', 'livemesh-so-widgets'),
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('style')
                    ),
                    'default' => 'style1',
                    'options' => array(
                        'style1' => __('Style 1', 'livemesh-so-widgets'),
                        'style2' => __('Style 2', 'livemesh-so-widgets'),
                    )
                ),

                'team-members' => array(
                    'type' => 'repeater',
                    'label' => __('Team Members', 'livemesh-so-widgets'),
                    'item_name' => __('Team Member', 'livemesh-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='team-members-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'livemesh-so-widgets'),
                            'description' => __('Name of the team member.', 'livemesh-so-widgets'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Team member image.', 'livemesh-so-widgets'),
                        ),

                        'position' => array(
                            'type' => 'text',
                            'label' => __('Position', 'livemesh-so-widgets'),
                            'description' => __('Specify the position/title of the team member.', 'livemesh-so-widgets'),
                        ),

                        'details' => array(
                            'type' => 'textarea',
                            'label' => __('Short details', 'livemesh-so-widgets'),
                            'description' => __('Provide a short writeup for the team member', 'livemesh-so-widgets'),
                        ),


                        'social_profile' => array(
                            'type' => 'section',
                            'label' => __('Social profile', 'livemesh-so-widgets'),
                            'fields' => array(
                                'email_address' => array(
                                    'type' => 'text',
                                    'label' => __('Email Address', 'livemesh-so-widgets'),
                                    'description' => __('Enter the email address of the team member.', 'livemesh-so-widgets'),
                                ),

                                'facebook' => array(
                                    'type' => 'text',
                                    'label' => __('Facebook Page URL', 'livemesh-so-widgets'),
                                    'description' => __('URL of the Facebook page of the team member.', 'livemesh-so-widgets'),
                                ),

                                'twitter' => array(
                                    'type' => 'text',
                                    'label' => __('Twitter Profile URL', 'livemesh-so-widgets'),
                                    'description' => __('URL of the Twitter page of the team member.', 'livemesh-so-widgets'),
                                ),

                                'linkedin' => array(
                                    'type' => 'text',
                                    'label' => __('LinkedIn Page URL', 'livemesh-so-widgets'),
                                    'description' => __('URL of the LinkedIn profile of the team member.', 'livemesh-so-widgets'),
                                ),

                                'pinterest' => array(
                                    'type' => 'text',
                                    'label' => __('Pinterest Page URL', 'livemesh-so-widgets'),
                                    'description' => __('URL of the Pinterest page for the team member.', 'livemesh-so-widgets'),
                                ),

                                'dribbble' => array(
                                    'type' => 'text',
                                    'label' => __('Dribbble Profile URL', 'livemesh-so-widgets'),
                                    'description' => __('URL of the Dribbble profile of the team member.', 'livemesh-so-widgets'),
                                ),

                                'google_plus' => array(
                                    'type' => 'text',
                                    'label' => __('GooglePlus Page URL', 'livemesh-so-widgets'),
                                    'description' => __('URL of the Google Plus page of the team member.', 'livemesh-so-widgets'),
                                ),

                                'instagram' => array(
                                    'type' => 'text',
                                    'label' => __('Instagram Page URL', 'livemesh-so-widgets'),
                                    'description' => __('URL of the Instagram feed for the team member.', 'livemesh-so-widgets'),
                                ),

                            )
                        ),

                        'animation' => array(
                            'type' => 'select',
                            'label' => __('Choose Animation Type', 'livemesh-so-widgets'),
                            'default' => 'none',
                            'options' => lsow_get_animation_options(),
                        ),

                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'livemesh-so-widgets'),
                    'fields' => array(


                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Team Members per row', 'livemesh-so-widgets'),
                            'state_handler' => array(
                                'style[style1]' => array('show'),
                                'style[style2]' => array('hide'),
                            ),
                            'min' => 1,
                            'max' => 6,
                            'integer' => true,
                            'default' => 3
                        ),

                        'per_line_tablet' => array(
                            'type' => 'slider',
                            'label' => __('Team Members per row in Tablet Resolution', 'livemesh-so-widgets'),
                            'state_handler' => array(
                                'style[style1]' => array('show'),
                                'style[style2]' => array('hide'),
                            ),
                            'min' => 1,
                            'max' => 6,
                            'integer' => true,
                            'default' => 2
                        ),

                        'per_line_mobile' => array(
                            'type' => 'slider',
                            'label' => __('Team Members per row in Mobile Resolution', 'livemesh-so-widgets'),
                            'state_handler' => array(
                                'style[style1]' => array('show'),
                                'style[style2]' => array('hide'),
                            ),
                            'min' => 1,
                            'max' => 4,
                            'integer' => true,
                            'default' => 1
                        ),

                        'image_size'    => array(
                            'type'          => 'image-size',
                            'label'         => __( 'Image Size', 'livemesh-so-widgets' ),
                            'default'       => 'large',
                        ),
                    )
                ),
            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'lsow-team-members',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_style_name($instance) {
        if ($instance['style'] == 'style2')
            return false; // no stylesheet required for style 2 template
        return $instance['style'];
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'team_members' => !empty($instance['team-members']) ? $instance['team-members'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('lsow-team-members', __FILE__, 'LSOW_Team_Widget');