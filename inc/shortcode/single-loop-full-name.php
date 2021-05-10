<?php
/**
 * Address
 *
 */
function wpsr_get_single_full_name() {

    $fullname = '';

    // Get full name
    if (get_post_meta(get_the_ID(), 'review_first_name', true) OR get_post_meta(get_the_ID(), 'review_last_name', true)) {
        $fullname = get_post_meta(get_the_ID(), 'review_first_name', true) .' '. get_post_meta(get_the_ID(), 'review_last_name', true);
    }

    return $fullname;
}
add_shortcode('wpsr_single_full_name', 'wpsr_get_single_full_name');