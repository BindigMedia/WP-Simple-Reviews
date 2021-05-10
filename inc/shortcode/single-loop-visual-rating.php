<?php
/**
 * Rating (in Loop!)
 *
 */
function wpsr_get_single_visual_rating() {

    // Get Single Loop Rating
    if (get_post_meta(get_the_ID(), 'review_rating', true)) {
        $rating = get_post_meta(get_the_ID(), 'review_rating', true);

        if ($rating >= 4.5) {
            $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i>';
        } elseif ($rating >= 3.5) {
            $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i>';
        } elseif ($rating >= 2.5) {
            $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
        } elseif ($rating >= 1.5) {
            $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
        } elseif ($rating >= 0.5) {
            $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
        } else {
            $rating_stars = '<i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
        }
    }

    return $rating_stars;
}
add_shortcode('wpsr_single_visual_rating', 'wpsr_get_single_visual_rating');