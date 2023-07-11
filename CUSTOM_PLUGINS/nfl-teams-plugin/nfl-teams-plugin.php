<?php
/**
 * Plugin Name: NFL Teams
 * Description: Fetches NFL teams from an API and displays them in a table.
 * Version: 1.0.0
 * Author: Joshua Solomon
*/

function fetch_nfl_teams() {
    $api_url = 'http://delivery.chalk247.com/team_list/NFL.JSON?api_key=74db8efa2a6db279393b433d97c2bc843f8e32b0';
    $response = wp_remote_get($api_url);
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return false;
    }

    return $data['results']['data']['team'];
}

add_action('init', 'fetch_nfl_teams');