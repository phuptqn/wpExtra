<?php
/*
Plugin Name:  Master SMTP Mail 
Plugin URI:   https://www.phupt.com/
Description:  Configure PHPMailer.
Version:      1.0.0
Author:       Phú PT
Author URI:   https://www.phupt.com/
License:      MIT License
*/

define('MAIL_USER', 'smtp@mailserver.hdint.net');

add_action( 'phpmailer_init', 'mail_configure_phpmailer', 1 );
add_filter( 'wp_mail_from', 'mail_configure_default_mail_from', 1 );

function mail_configure_phpmailer( $phpmailer ) {
    call_user_func([$phpmailer, 'isSMTP']);

    $phpmailer->Host = 'rpcluster02.reliabledns.org';
    $phpmailer->Username = MAIL_USER;
    $phpmailer->Password = 'HDint15#';
    $phpmailer->Port = 465;

    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = 'ssl';
}

function mail_configure_default_mail_from( $phpmailer ) {
    return MAIL_USER;
}
