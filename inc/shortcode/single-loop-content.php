<?php
/**
 * Content (in Loop!)
 *
 */
function wpsr_get_single_content($atts, $content = null) {

    // Attributes
    $a = shortcode_atts( array(
        'excerpt' => 'false'
    ), $atts );

    // Get Content
    if($a['excerpt'] == 'true') {
        $content = get_the_excerpt();
    } else {
        $content = get_the_content();
    }

    if (!empty($a['max_words'])) {
        $content = wp_trim_words($content, $a['max_words']);
    }

    return $content;
}
add_shortcode('wpsr_single_content', 'wpsr_get_single_content');