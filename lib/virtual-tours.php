<?php


/**
 * Virtual tour dispatch.
 */

function virtual_tour_dispatch($path)
{
    if ($listing = tourily_listing_for_path($path))
    {
        virtual_tour($path, $listing);
    }
    else
    {
        die('No tour.');
    }
}


/**
 * Show a virtual tour.
 */

function virtual_tour($path, $listing)
{
    $images = tourily_format_images($listing->images);
    include(TOURILY_DIR . '/templates/tour.php');
}
