<?php
/**
 * Single Random Review
 *
 */
function wpsr_loop_reviews($atts, $content = null) {

    // Attributes
    $a = shortcode_atts( array(
        'max_words' => '',
        'items' => -1,
        'photos' => 'false',
        'pagination' => 'false',
    ), $atts );

    // Pagination if is enable
    if ($a['pagination'] == 'true') {
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    } else {
        $paged = '';
    }

    // Get Reviews in Pagination Version and NONE Pagination Version
    if ($a['pagination'] == 'true') {
        $loop_reviews_args = array(
            'post_type' => 'review',
            'posts_per_page' => $a['items'],
            'meta_query' => array(
                array(
                    'key'     => 'review_exclude',
                    'value'   => '1',
                    'compare' => '!=',
                )
            ),
            'paged' => $paged
        );
    } else {
        $loop_reviews_args = array(
            'post_type' => 'review',
            'posts_per_page' => $a['items'],
            'meta_query' => array(
                array(
                    'key'     => 'review_exclude',
                    'value'   => '1',
                    'compare' => '!=',
                )
            )
        );
    }

    $loop_reviews = new WP_Query( $loop_reviews_args );


    $markup = '';

    if ( $loop_reviews->have_posts() ) {
        $markup .= '<div class="wpsr-reviews">';

        /**
         * Loopi
         */
        while ( $loop_reviews->have_posts() ) {
            $loop_reviews->the_post();

            if (!empty($a['max_words'])) {
                $content = wp_trim_words(get_the_content(), $a['max_words']);
            } else {
                $content = get_the_content();
            }

            if ($a['photos'] == 'true') {
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

        /**
         * Pagination
         */
        $args_pagination = array(
            'type' => 'list',
            'base' => add_query_arg('paged', '%#%'),
            'total' => $loop_reviews->max_num_pages,
            'current' => $paged
        );
        if ($a['pagination'] == 'true') {
            $markup .= paginate_links($args_pagination);
        }


        $markup .= '</div>';
    }
    wp_reset_postdata();

    return $markup;

}
add_shortcode('wpsr_reviews', 'wpsr_loop_reviews');