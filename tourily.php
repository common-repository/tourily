<?php
/*
Plugin Name: Tourily
Author: Tourily, Inc.
Version: 0.0.1
Author URI: http://www.tourily.com
*/


define('TOURILY_PLUGIN_VERSION',        '0.0.1');
define('TOURILY_API_URL',               'http://tours.tourily.com/api/v1');
define('TOURILY_AUTH_OPTION_NAME',      'tourily_auth_token');
define('TOURILY_OPTION_LISTING_PREFIX', 'tourily_prefix_listing');
define('TOURILY_OPTION_TOUR_PREFIX',    'tourily_prefix_tour');
define('TOURILY_OPTION_MAP',            'tourily_address_map');
define('TOURILY_OPTION_LISTING',        'tourily_listing_');
define('TOURILY_OPTION_CITY',           'tourily_results_by_city');
define('TOURILY_OPTION_STATUS',         'tourily_results_by_status');
define('TOURILY_OPTION_PRICE',          'tourily_results_by_price');
define('TOURILY_OPTION_ZIPCODE',        'tourily_results_by_zipcode');
define('TOURILY_OPTION_SUBDIVISION',    'tourily_results_by_subdivision');
define('TOURILY_OPTION_COMMUNITY',      'tourily_results_by_community');


define('TOURILY_DIR', dirname(__FILE__));
require_once(TOURILY_DIR . '/lib/utils.php');
require_once(TOURILY_DIR . '/lib/functions.php');
require_once(TOURILY_DIR . '/lib/listings.php');
require_once(TOURILY_DIR . '/lib/virtual-tours.php');
require_once(TOURILY_DIR . '/lib/xmlrpc.php');
require_once(TOURILY_DIR . '/lib/admin.php');
require_once(TOURILY_DIR . '/lib/widgets/cities-widget.php');
require_once(TOURILY_DIR . '/lib/widgets/communities-widget.php');
require_once(TOURILY_DIR . '/lib/widgets/subdivisions-widget.php');
require_once(TOURILY_DIR . '/lib/widgets/zip-codes-widget.php');
require_once(TOURILY_DIR . '/lib/widgets/prices-widget.php');
require_once(TOURILY_DIR . '/lib/shortcodes.php');


/**
 * Register Wordpress actions.
 */

add_action('init', 'tourily_init');
add_filter('xmlrpc_methods', 'tourily_xmlrpc_methods');


function tourily_init()
{
    if (!is_admin())
    {
        intercept_request(get_option(TOURILY_OPTION_LISTING_PREFIX), listings_dispatch);
        intercept_request(get_option(TOURILY_OPTION_TOUR_PREFIX), virtual_tour_dispatch);
    }
}


function intercept_request($prefix, $fn)
{
    $prefix = '/' . $prefix . '/';
    if (starts_with($_SERVER['REQUEST_URI'], $prefix))
    {
        $fn(remove_prefix($_SERVER['REQUEST_URI'], $prefix));
        exit();
    }
}


function tourily_xmlrpc_methods($methods)
{
    $methods['tourily.getVersion']      = 'tourily_xmlrpc_get_version';
    $methods['tourily.updateListing']   = 'tourily_xmlrpc_update_listing';
    $methods['tourily.removeListing']   = 'tourily_xmlrpc_remove_listing';

    return $methods;
}
