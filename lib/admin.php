<?php


if (is_admin())
{
    add_action('admin_menu', 'tourily_admin_menu');

    // Make sure the required options are set
    if (!get_option(TOURILY_OPTION_LISTING_PREFIX))
        add_option(TOURILY_OPTION_LISTING_PREFIX, 'listings', null, 'yes');

    if (!get_option(TOURILY_OPTION_TOUR_PREFIX))
        add_option(TOURILY_OPTION_TOUR_PREFIX, 'virtual-tours', null, 'yes');
}


function tourily_admin_menu()
{
    add_options_page('Tourily Options', 'Tourily', 'manage_options', 'tourily-options', 'tourily_admin_index');
}


function tourily_mce_plugin()
{
    if ( get_user_option('rich_editing') == 'true')
    {
        add_filter('mce_external_plugins', 'tourily_add_mce_plugin');
        add_filter('mce_buttons', 'tourily_mce_button');
    }
}


function tourily_mce_button($buttons)
{
    array_push($buttons, 'separator', 'tourily');
    return $buttons;
}


function tourily_add_mce_plugin($plugin_array)
{
    $plugin_array['tourily'] = plugins_url('/', __FILE__).'../templates/static/editor/mce_plugin.js';
    return $plugin_array;
}

add_action('init', 'tourily_mce_plugin');


function tourily_admin_index()
{
    if (!current_user_can('manage_options'))
        wp_die('You do not have sufficient permissions to access this page.');

    if (isset($_POST['tourily_listings_prefix']))
        tourily_update_prefixes($_POST['tourily_listings_prefix'], $_POST['tourily_tour_prefix']);

    if (isset($_POST['tourily_disconnect']))
        tourily_disconnect();

    if (isset($_POST['tourily_reset']))
        tourily_reset();

    if (isset($_POST['tourily_regenerate']))
        tourily_update_widgets();

    if (get_option(TOURILY_AUTH_OPTION_NAME) === false)
        tourily_admin_connect();
    else
        include(TOURILY_DIR . '/templates/admin-options.php');
}


function tourily_admin_connect()
{
    if (isset($_POST['tourily_email']))
    {
        $data = array(
            'blog_url' => get_option('siteurl'),
            'plugin_version' => TOURILY_PLUGIN_VERSION
        );

        $url = TOURILY_API_URL . '/blogs';
        $r = post_remote($url, $data, $_POST['tourily_email'], $_POST['tourily_password']);

        if ($r == null)
        {
            $bad_login = true;
            include(TOURILY_DIR . '/templates/admin-connect.php');
        }
        else
        {
            add_option(TOURILY_AUTH_OPTION_NAME, str_replace('"', '', $r), null, 'no');
            tourily_admin_index();
        }
    }
    else
    {
        include(TOURILY_DIR . '/templates/admin-connect.php');
    }
}
