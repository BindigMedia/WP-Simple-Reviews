<?php
/**
 * Single Random Review
 *
 */
function wpsr_single_random_review($atts, $content = null) {

    // Attributes
    $a = shortcode_atts(array(
        'max_words' => '',
        'photo' => 'false',
        'simple' => 'false',
   ), $atts);

    // Get Reviews
    $single_random_review_args = array(
        'post_type' => 'review',
        'posts_per_page' => 1,
        'orderby' => 'rand',
        'meta_query' => array(
            array(
                'key'     => 'review_exclude',
                'value'   => '1',
                'compare' => '<',
           )
       )
   );
    $single_random_review = new WP_Query($single_random_review_args);

    $markup = '';

    if ($single_random_review->have_posts()) {
        while ($single_random_review->have_posts()) {
            $single_random_review->the_post();

            if (!empty($a['max_words'])) {
                $content = wp_trim_words(get_the_content(), $a['max_words']);
            } else {
                $content = get_the_content();
            }

            if ($a['simple'] == 'true') {
                $markup .= '<blockquote class="wpsr-single-review">';
                $markup .= '<div class="wpsr-content">'. $content .'</div>';
                $markup .= '</blockquote>';
            } else {
                if ($a['photo'] == 'true') {
                    $markup .= '<blockquote class="wpsr-single-review">';
                    $markup .= '<div class="flexbox">';
                    $markup .= '<div class="left">';
                    if (has_post_thumbnail()) {
                        $markup .= '<img class="wpsr-photo" src="'. get_the_post_thumbnail_url() .'" alt="'. do_shortcode('[wpsr_single_full_name]') .'" />';
                    } else {
                        $initials = '';
                        if (get_post_meta(get_the_ID(), 'review_first_name', true) AND get_post_meta(get_the_ID(), 'review_last_name', true)) {
                            $initials = get_post_meta(get_the_ID(), 'review_first_name', true)[0] . get_post_meta(get_the_ID(), 'review_last_name', true)[0];
                        } else {
                            $initials = get_post_meta(get_the_ID(), 'review_first_name', true)[0];
                        }
                        $markup .= '<div class="wpsr-initials">'. $initials .'</div>';
                    }
                    $markup .= '</div>';
                    $markup .= '<div class="right">';
                    $markup .= '<div class="wpsr-title"><strong>'. get_the_title() .'</strong> <span class="wpsr-date">'. get_the_date() .'</span></div>';
                    $markup .= '<div class="wpsr-rating">'. do_shortcode('[wpsr_single_visual_rating]') .'</div>';
                    $markup .= '<div class="wpsr-content">'. $content .'</div>';
                    $markup .= '<div class="wpsr-name">';
                    $markup .= do_shortcode('[wpsr_single_full_name]');
                    if (get_post_meta(get_the_ID(), 'review_company', true)) {
                        $markup .= '<span class="wpsr-company">('. do_shortcode('[wpsr_single_review_company]') .')</span>';
                    }
                    $markup .= '</div>';
                    $markup .= '</div>';
                    $markup .= '</blockquote>';
                } else {
                    $markup .= '<blockquote class="wpsr-single-review">';
                    $markup .= '<div class="wpsr-title"><strong>'. get_the_title() .'</strong> <span class="wpsr-date">'. get_the_date() .'</span></div>';
                    $markup .= '<div class="wpsr-rating">'. do_shortcode('[wpsr_single_visual_rating]') .'</div>';
                    $markup .= '<div class="wpsr-content">'. $content .'</div>';
                    $markup .= '<div class="wpsr-name">';
                    $markup .= do_shortcode('[wpsr_single_full_name]');
                    if (get_post_meta(get_the_ID(), 'review_company', true)) {
                        $markup .= '<span class="wpsr-company">('. do_shortcode('[wpsr_single_review_company]') .')</span>';
                    }
                    $markup .= '</div>';
                    $markup .= '</blockquote>';
                }
            }
        }
    }
    wp_reset_postdata();

    return $markup;

}
add_shortcode('wpsr_single_random_review', 'wpsr_single_random_review');