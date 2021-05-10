<?php
/**
 * Rating Bar
 *
 */
function wpsr_rating_bar() {

    $aggregated_reviews = '<div class="wpsr-rating-bar">';
    $aggregated_reviews .= '<div class="wpsr-wrapper">';
    $aggregated_reviews .= '<div class="flexbox">';
    $aggregated_reviews .= '<div class="left">'. do_shortcode('[wpsr_visual_rating review_link="true" review_button="true"]') .'</div>';
    $aggregated_reviews .= '<div class="middle">'. do_shortcode('[wpsr_single_random_review max_words="10" simple="true"]') .'</div>';
    $aggregated_reviews .= '<div class="right">'. do_shortcode('[wpsr_address]') .'</div>';
    $aggregated_reviews .= '</div>';
    $aggregated_reviews .= '</div>';
    $aggregated_reviews .= '</div>';

    return $aggregated_reviews;
}
add_shortcode('wpsr_rating_bar', 'wpsr_rating_bar');