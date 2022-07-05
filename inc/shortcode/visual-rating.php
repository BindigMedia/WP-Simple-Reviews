<?php
/**
 * Visual Rating
 *
 */
function wpsr_visual_rating($atts, $content = null) {

    // Attributes
    $a = shortcode_atts(array(
        'stars' => 'true',
        'label' => 'true',
        'rating_description' => 'true',
        'short_summery' => 'false',
        'summery' => 'true',
        'schema' => 'false',
        'review_link' => 'false',
        'review_button' => 'false'
    ), $atts);

    // Variables
    $visual_rating = '';
    $amount = 0;
    $rating_sum = 0;

    // Get Settings
    $wpsr = get_option('wpsr');
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
        $output .= '<img class="reviews-legal-trigger" style="margin-left: 7px;" src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMi1jMDAwIDc5LjU2NmViYzViNCwgMjAyMi8wNS8wOS0wODoyNTo1NSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjQgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkE4QTRBREZBRkJBMTExRUM5MkZBODUwQkExNDcxNTY5IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkE4QTRBREZCRkJBMTExRUM5MkZBODUwQkExNDcxNTY5Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QThBNEFERjhGQkExMTFFQzkyRkE4NTBCQTE0NzE1NjkiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QThBNEFERjlGQkExMTFFQzkyRkE4NTBCQTE0NzE1NjkiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5bCi7YAAACM0lEQVR42qyWz0tUURTHp2fQxjbRqonQRlP/gtwMZQXBBDNthhYGEaHLzE3LwnVQ6FKRgowgmGqmZtUPKze1dWU6iqA1C6EB29bY98D3wdfLve8peeDD3LnvnnPuO/fcc96hSqWSSZBToASugC5wkvObYB28BVWwETJwODCfBffALdDhed5HLoNJYLu8S6e7JPIoXwVLYDRg3GejDBZBMc3BGHfTKXPvwAjo57wxwA28l3VHwStwOxQi2/lDcbpMw188u14iM+Acf3up+4ihqukb2OE9lf9mdDBg3JXP4CxYkKjMgRPqYELCssy3aTmGekCD9DjPWtRpSLgmYgeWijdk8YjHeIYHmSNlz/Nf1I3lpkUmYp53yIGGwnIkMFb5BD5wbDZL5qAgC15k/l/URsEcnJaJhQNwoBHIRfFpU34cgINNrQjRPhQbMl5JudmxtO2i/QRnpAZ9Dyg+AzvkeYKDrIyb5mBNHOQTHOzQSZrkZbxqr1OXiWsJikkXLROwUY9Yz/9y4hJri09KctGKgTVD4ALHf6weRWwWT2TRY3Dco1zl7lc4duUYmJb/s5ZR8YnfB7857gYvqeBmUS/Pa9Vj/LWEbltrUZz/1y2t5KC+gvN7OFQLyzc53DZtNd2ctfo9Lk5st/NsKqNsMm7DsbrzUXZuunfAm1BPnmKzmGPJNblI0sTCMswPgcSeXGOmTDET0qTNZtXvGk/6qthif34gny3dzmfLGu9Qzak/u+SfAAMAj997bKsIfNMAAAAASUVORK5CYII=" width="16" height="16" />';
        $output .= '<div class="reviews-legal">';
        $output .= __('For data protection legal reasons, we can not guarantee the authenticity of the data (information obligation for ratings).', 'wp-simple-reviews');
        $output .= '</div>';
        if ($a['review_button'] == 'true' AND !empty($wpsr['review_url'])) {
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