<?php
/**
 * Visual Rating
 *
 */
function wpsr_visual_rating($atts, $content = null) {

    // Attributes
    $a = shortcode_atts( array(
        'stars' => 'true',
        'label' => 'true',
        'rating_description' => 'true',
        'short_summery' => 'false',
        'summery' => 'true',
        'schema' => 'false',
        'review_link' => 'false',
        'review_button' => 'false'
    ), $atts );

    // Variables
    $visual_rating = '';
    $amount = 0;
    $rating_sum = 0;

    // Get Settings
    $wpsr = get_option( 'wpsr' );
    $review_url = $wpsr['review_url'];

    $reviews = get_posts(array(
        'post_type' => 'review',
        'post_status' => 'publish',
        'numberposts' => -1
    ));
    foreach ($reviews as $review) {
        $amount++;
        $rating_sum += floatval(get_post_meta($review->ID, 'review_rating', true));
    }

    // Calculation
    $rating_result = $rating_sum / $amount;

    // Visual Rating
    if ($rating_result >= 4.5) {
        $raiting_label = __('Very Good', 'wp-simple-reviews');
        $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i>';
    } elseif ($rating_result >= 3.5) {
        $raiting_label = __('Good', 'wp-simple-reviews');
        $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i>';
    } elseif ($rating_result >= 2.5) {
        $raiting_label = __('Okay', 'wp-simple-reviews');
        $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
    } elseif ($rating_result >= 1.5) {
        $raiting_label = __('Not so good', 'wp-simple-reviews');
        $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
    } elseif ($rating_result >= 0.5) {
        $raiting_label = __('Bad', 'wp-simple-reviews');
        $rating_stars = '<i class="wpsr-icon-star"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
    } else {
        $raiting_label = __('Not rated yet', 'wp-simple-reviews');
        $rating_stars = '<i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i><i class="wpsr-icon-star gray"></i>';
    }

    $output = '<div class="wpsr-visual-rating">';

    // Top => Rating Visual + Label
    $output .= '<div class="top">';

    if ($a['label'] == 'true' AND $a['stars'] == 'true') {
        $output .= '<div class="flexbox">';
        $output .= '<div class="left">'. $rating_stars .'</div>';
        $output .= '<div class="right">'. $raiting_label .'</div>';
        $output .= '</div>';
    } elseif ($a['label'] == 'false' AND $a['stars'] == 'true') {
        $output .= $rating_stars;
    } elseif ($a['label'] == 'true' AND $a['stars'] == 'false') {
        $output .= $raiting_label;
    }
    $output .= '</div>';

    // Bottom => Summery Rating
    if ($a['summery'] == 'true' AND $a['review_link'] == 'true' AND !empty($wpsr['review_url'])) {
        $output .= '<div class="bottom">';
        $output .= sprintf(__('<span class="rating">%s</span> out of <span class="best">5</span> in <span class="votes">%s</span> <a href="%s" title="Show Reviews">reviews</a>', 'wp-simple-reviews'), number_format($rating_result, 1), $amount, $review_url);
        if ( $a['review_button'] == 'true' AND !empty($wpsr['review_url']) ) {
            $output .= '<div class="wpsr-review-us"><a href="'. $wpsr['review_url'] .'">'. __('Review us', 'wp-simple-reviews') .'</a></div>';
        }
        $output .= '</div>';
    } elseif ($a['summery'] == 'true') {
        $output .= '<div class="bottom">';
        $output .= sprintf(__('<span class="rating">%s</span> out of <span class="best">5</span> in <span class="votes">%s</span> reviews', 'wp-simple-reviews'), number_format($rating_result, 1), $amount);
        $output .= '</div>';
    } elseif ($a['short_summery'] == 'true') {
        $output .= sprintf(__('<span class="rating">%s</span> <span class="votes">(%s reviews)</span>', 'wp-simple-reviews'), number_format($rating_result, 1), $amount);
    }

    $output .= '</div>';

    return $output;
}
add_shortcode('wpsr_visual_rating', 'wpsr_visual_rating');