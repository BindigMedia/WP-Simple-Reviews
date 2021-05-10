<?php
/**
 * Rating Box
 *
 */
function wpsr_rating_box($atts, $content = null) {

    // Attributes
    $a = shortcode_atts( array(
        'review' => 'false',
        'address' => 'true',
        'review_link' => 'true'
    ), $atts );

    $wpsr = get_option( 'wpsr' );

    $aggregated_reviews = '<div class="wpsr-review-box">';
    $aggregated_reviews .= '<div class="wpsr-label-rating">'. do_shortcode('[wpsr_visual_rating summery="false" review_link="false" review_button="false" label="true" stars="false" short_summery="false"]') .'</div>';
    $aggregated_reviews .= '<div class="wpsr-star-rating">'. do_shortcode('[wpsr_visual_rating summery="false" review_link="false" review_button="false" label="false" stars="true" short_summery="true"]') .'</div>';
    if ($a['review'] == 'true') {
        $aggregated_reviews .= '<div class="wpsr-review">'. do_shortcode('[wpsr_single_random_review max_words="10"]') .'</div>';
    }
    if ($a['address'] == 'true') {
        $aggregated_reviews .= do_shortcode('[wpsr_address]');
    }
    if ($a['review_link'] == 'true') {
        $aggregated_reviews .= '<div class="wpsr-review-now"><a href="'. $wpsr['review_url'] .'" title="'. __('Review Now', 'wp-simple-reviews') .'">'. __('Review Now', 'wp-simple-reviews') .'</a></div>';
    } else {
        $aggregated_reviews .= '<div class="wpsr-review-now">'. __('Review Now', 'wp-simple-reviews') .'</div>';
    }
    $aggregated_reviews .= '</div>';

    return $aggregated_reviews;
}
add_shortcode('wpsr_rating_box', 'wpsr_rating_box');