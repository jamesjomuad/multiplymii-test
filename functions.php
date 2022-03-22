<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

require 'vendor/autoload.php';

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')) :
    add_filter('locale_stylesheet_uri', function ($uri) {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    });
endif;

if (!function_exists('child_theme_configurator_css')) :
    add_action('wp_enqueue_scripts', function () {
        wp_enqueue_style('chld_thm_cfg_child', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('twentytwentytwo-style', 'twentytwentytwo-style'));
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', '', '5.1.3');

        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', [], '5.1.3', true);
    }, 10);
endif;

add_action('init', function () {
    register_nav_menus(
        array(
            'primary-menu' => __('Primary Menu'),
            'secondary-menu' => __('Secondary Menu')
        )
    );
});

// END ENQUEUE PARENT ACTION


#
#   Functions
#
function axcelerate_config()
{
    return include('config.php');
}

function axcelerate_query($url)
{
    $config = axcelerate_config();

    $headers = [
        'headers' => array(
            'wstoken' => $config['ws_token'],
            'apitoken' => $config['api_token']
        )
    ];

    $response = wp_remote_get(
        'https://stg.axcelerate.com/api/' . $url,
        $headers
    );

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);

    $data = json_decode($body);

    return $data;
}

function axcelerate_certificate($enrolID)
{
    return axcelerate_query('contact/enrolment/certificate?enrolID='.$enrolID);
}

function axcelerate_students()
{
    $data = axcelerate_query('contacts');

    return $data;
}

function axcelerate_student($id)
{
    $data = axcelerate_query('contact/'.$id);

    return $data;
}