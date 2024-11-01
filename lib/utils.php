<?php
/**
 * Utility functions for Tourily WP plugin.
 */

function starts_with($haystack, $needle)
{
    return (strpos($haystack, $needle) === 0) ? true : false;
}


function remove_prefix($uri, $prefix)
{
    return substr($uri, strlen($prefix));
}


function get_remote($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}


function post_remote($url, $data, $username, $password)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

    $data = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($status == 200) ? $data : null;
}


function array_to_object($array)
{
    if (!is_array($array))
        return $array;

    $obj = new stdClass();

    foreach ($array as $k => $v)
        $obj->$k = array_to_object($v);

    return $obj;
}
