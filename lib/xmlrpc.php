<?php


function tourily_xmlrpc_auth($args)
{
    global $wp_xmlrpc_server;
    $wp_xmlrpc_server->escape($args);

    $token = (is_array($args)) ? $args[0] : $args;
    $saved_token = get_option(TOURILY_AUTH_OPTION_NAME);

    if ($token !== $saved_token)
        return 'Authentication failed.';

    return null;
}


function tourily_xmlrpc_get_version($args)
{
    if ($error = tourily_xmlrpc_auth($args))
        return $error;

    return TOURILY_PLUGIN_VERSION;
}


function tourily_xmlrpc_update_listing($args)
{
    if ($error = tourily_xmlrpc_auth($args))
        return $error;

    if (isset($args[1]) && isset($args[2]))
    {
        $listing_key = tourily_listing_option_key($args[1]);
        $listing = array_to_object($args[2]);

        delete_option($listing_key);
        add_option($listing_key, $listing, null, 'no');

        $listing_path = tourily_path_for_listing($listing);
        tourily_update_widgets();

        return array(
            'listing' => '/listings/' . $listing_path,
            'tour' => '/virtual-tours/' . $listing_path
        );
    }

    return 'ERROR';
}


function tourily_xmlrpc_remove_listing($args)
{
    if ($error = tourily_xmlrpc_auth($args))
        return $error;

    if (isset($args[1]))
        delete_option(tourily_listing_option_key($args[1]));

    delete_option(tourily_listing_key(69));
    return 'OK';
}
