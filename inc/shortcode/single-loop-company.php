<?php
/**
 * Company (in Loop!)
 *
 */
function wpsr_get_single_review_company() {

    // Get full name
    if (get_post_meta(get_the_ID(), 'review_company', true)) {
        $company = get_post_meta(get_the_ID(), 'review_company', true);
    }

    return $company;
}
add_shortcode('wpsr_single_review_company', 'wpsr_get_single_review_company');