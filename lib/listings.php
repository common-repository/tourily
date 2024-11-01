<?php


/**
 * Listings dispatch.
 */

function listings_dispatch($path)
{
    if (strpos($path, '/') !== false)
    {
        $path_pieces = explode('/', $path);
        search_results_view($path_pieces[0], $path_pieces[1]);
    }
    else if ($listing = tourily_listing_for_path($path))
    {
        listing_view($path, $listing);
    }
    else
    {
        die('No Listing.');
    }
}


function listing_view($path, $listing)
{
    $images = tourily_format_images($listing->images);
    include(TOURILY_DIR . '/templates/listing.php');
}


function search_results_view($type, $query)
{
    $results = tourily_results_for_search($type, $query);

    if ($results == null)
        die('No results');

    include(TOURILY_DIR . '/templates/search.php');
}
