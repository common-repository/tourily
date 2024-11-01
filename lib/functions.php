<?php


function tourily_listing_option_key($listing_id)
{
    return TOURILY_OPTION_LISTING . $listing_id;
}


function tourily_listing_for_path($path)
{
    $mapping = get_option(TOURILY_OPTION_MAP);

    $question_mark_pos = strpos($path, '?');
    if ($question_mark_pos !== false)
    {
        $path_pieces = explode('?', $path);
        $path = $path_pieces[0];
    }

    if (isset($mapping[$path]))
        return get_option(tourily_listing_option_key($mapping[$path]));

    return null;
}


function tourily_results_for_search($type, $query)
{
    $lookup = array(
        'cities' => array('option_name' => TOURILY_OPTION_CITY),
        'communities' => array('option_name' => TOURILY_OPTION_COMMUNITY),
        'subdivisions' => array('option_name' => TOURILY_OPTION_SUBDIVISION),
        'zip_codes' => array('option_name' => TOURILY_OPTION_ZIPCODE),
        'prices' => array('option_name' => TOURILY_OPTION_PRICE)
    );

    if (!isset($lookup[$type]))
        return null;

    $search = $lookup[$type];
    $all_listings = get_option($search['option_name']);

    foreach ($all_listings as $ident => $listings)
    {
        if ($type == 'prices')
        {
            $range = tourily_range_for_price($ident);
            if (tourily_slug_range($range) == $query)
                return $listings;
        }
        else
        {
            if (tourily_slug($ident) == $query)
                return $listings;
        }
    }

    return null;
}


function tourily_range_for_price($price)
{
    if ($price == 0)
        return array(0, 99999);
    else
        return array($price * 100000, (($price + 1) * 100000) - 1);
}


function tourily_format_range($range)
{
    return '$' . number_format($range[0], 0, '', ',') . ' - ' . number_format($range[1], 0, '', ',');
}


function tourily_slug_range($range)
{
    return $range[0] . '-' . $range[1];
}


function tourily_path_for_listing($listing)
{
    // address-city-state-zip
    $components = array(
        $listing->address,
        $listing->city,
        $listing->state,
        $listing->zip_code
    );

    $str = implode(' ', $components);
    $str = ereg_replace("[^A-Za-z0-9 ]", '', $str);

    return str_replace(' ', '-', strtolower($str));
}


function tourily_format_images($image_list)
{
    $images = array();
    foreach ($image_list as $img)
        $images[] = $img;

    return $images;
}


function tourily_slug($str)
{
    return str_replace(' ', '_', strtolower($str));
}


function tourily_get_listings()
{
    global $wpdb;

    // get all listings
    $sql = "SELECT * FROM {$wpdb->prefix}options
            WHERE option_name LIKE 'tourily_listing_%'";

    $raw = $wpdb->get_results($sql);

    $listings = array();

    foreach ($raw as $raw_listing)
        $listings[] = unserialize($raw_listing->option_value);

    return $listings;
}


function tourily_update_widgets()
{
    $listings = tourily_get_listings();

    foreach ($listings as $listing)
    {
        $slug = tourily_path_for_listing($listing);

        // Map URL slugs to listings
        $address_maps[$slug] = $listing->id;

        // Data needed for a search result
        $search_result = array(
            'id' => $listing->id,
            'slug' => $slug,
            'address' => $listing->address,
            'city' => $listing->city,
            'zip_code' => $listing->zip_code,
            'thumbnail' => $listing->thumb_url,
            'description' => $listing->description,
            'price' => $listing->price,
            'community_name' => $listing->community_name,
            'subdivision' => $listing->subdivision,
            'sale_type' => $listing->sale_type,
            'status' => $listing->status
        );

        // Cities
        tourily_update_results($cities, $listing->city, $slug, $search_result);

        // Statuses
        tourily_update_results($statuses, $listing->status, $slug, $search_result);

        // Prices
        $price_int = tourily_extract_price_as_int($listing->price);
        $price_group = (int) ($price_int / 100000);
        tourily_update_results($prices, $price_group, $slug, $search_result);

        // Zip codes
        tourily_update_results($zip_codes, $listing->zip_code, $slug, $search_result);

        // Subdivisions
        tourily_update_results($subdivisions, $listing->subdivision, $slug, $search_result);

        // Communities
        tourily_update_results($communities, $listing->community_name, $slug, $search_result);
    }

    tourily_reset_option(TOURILY_OPTION_MAP,            $address_maps);
    tourily_reset_option(TOURILY_OPTION_CITY,           $cities);
    tourily_reset_option(TOURILY_OPTION_STATUS,         $statuses);
    tourily_reset_option(TOURILY_OPTION_PRICE,          $prices);
    tourily_reset_option(TOURILY_OPTION_ZIPCODE,        $zip_codes);
    tourily_reset_option(TOURILY_OPTION_SUBDIVISION,    $subdivisions);
    tourily_reset_option(TOURILY_OPTION_COMMUNITY,      $communities);
}


function tourily_extract_price_as_int($price)
{
    // Remove cents
    $pieces = explode('.', $price);
    $dollars = $pieces[0];

    // Remove all non-numeric characters
    return ereg_replace('[^0-9]', '', $dollars);
}


function tourily_update_results(&$data_array, $indentifier, $slug, $search_result)
{
    if (!isset($data_array[$indentifier]))
        $data_array[$indentifier] = array();

    $data_array[$indentifier][$slug] = $search_result;
}


function tourily_delete_results()
{
    delete_option(TOURILY_OPTION_CITY);
    delete_option(TOURILY_OPTION_STATUS);
    delete_option(TOURILY_OPTION_PRICE);
    delete_option(TOURILY_OPTION_ZIPCODE);
    delete_option(TOURILY_OPTION_SUBDIVISION);
    delete_option(TOURILY_OPTION_COMMUNITY);
}


function tourily_reset_option($option, $data)
{
    delete_option($option);
    add_option($option, $data, null, 'no');
}


function tourily_update_prefixes($listing_prefix, $tour_prefix)
{
    delete_option(TOURILY_OPTION_LISTING_PREFIX);
    add_option(TOURILY_OPTION_LISTING_PREFIX, str_replace('/', '', $listing_prefix), null, 'yes');

    delete_option(TOURILY_OPTION_TOUR_PREFIX);
    add_option(TOURILY_OPTION_TOUR_PREFIX, str_replace('/', '', $tour_prefix), null, 'yes');
}


function tourily_disconnect()
{
    tourily_reset();
    delete_option(TOURILY_AUTH_OPTION_NAME);
}


function tourily_reset()
{
    global $wpdb;

    $sql = "DELETE FROM {$wpdb->prefix}options
            WHERE option_name LIKE 'tourily_listing_%'";

    $listings = $wpdb->query($sql);

    delete_option(TOURILY_OPTION_MAP);
    delete_option(TOURILY_OPTION_CITY);
    delete_option(TOURILY_OPTION_STATUS);
    delete_option(TOURILY_OPTION_PRICE);
    delete_option(TOURILY_OPTION_ZIPCODE);
    delete_option(TOURILY_OPTION_SUBDIVISION);
    delete_option(TOURILY_OPTION_COMMUNITY);
}
