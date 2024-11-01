<?php


function tourily_shortcode($atts)
{
    $default_atts = array(
        'price_min' => 0,
        'price_max' => 999999999,
        'status' => 'all',
        'zip_code' => 'all',
        'city' => 'all',
        'subdivision' => 'all',
        'community' => 'all'
    );

    extract(shortcode_atts($default_atts, $atts));

    $price_min = tourily_extract_price_as_int($price_min);
    $price_max = tourily_extract_price_as_int($price_max);

    $result_html = '<link rel="stylesheet" href="' . plugins_url('/', __FILE__) . '../templates/static/stylesheets/search-results.css">';
    $all_listings = tourily_get_listings();

    foreach ($all_listings as $listing)
    {
        $price_dollars = tourily_extract_price_as_int($listing->price);

        if ($price_dollars < $price_min || $price_dollars > $price_max)
            continue;

        if ($status != 'all' && $listing->status != $status)
            continue;

        if ($zip_code != 'all' && $listing->zip_code != $zip_code)
            continue;

        if ($city != 'all' && $listing->city != $city)
            continue;

        if ($subdivision != 'all' && $listing->subdivision != $subdivision)
            continue;

        if ($community != 'all' && $listing->community_name != $community)
            continue;

        $slug = tourily_path_for_listing($listing);

        ob_start();
        include(TOURILY_DIR . '/templates/shortcode-result.php');
        $result_html .= ob_get_contents();
        ob_end_clean();
    }

    return $result_html;
}


add_shortcode('tourily', 'tourily_shortcode');
