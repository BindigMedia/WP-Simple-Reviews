<?php
/**
 * Rating (in Loop!)
 *
 */
function wpsr_get_single_title() {

    $title = get_the_title();

    return $title;
}
add_shortcode('wpsr_single_title', 'wpsr_get_single_title');