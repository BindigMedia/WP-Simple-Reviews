<?php

/**
 * Add JSON-LD for Aggregated Reviews
 *
 */
function add_schema_to_head() {

    // Get Address
    $wpsr = get_option('wpsr');
    $has_posts = false;

    // Variables
    $amount = 0;
    $rating_sum = 0;

    // Get Reviews
    $reviews_args = array(
        'post_type' => 'review',
        'posts_per_page' => -1
    );
    $reviews_query = new WP_Query($reviews_args);

    if($reviews_query->have_posts()) {
        while ($reviews_query->have_posts()) {
            $reviews_query->the_post();
            $amount++;
            $rating_sum += intval(get_post_meta(get_the_ID(), 'review_rating', true));
        }
        $has_posts = true;
    }
    wp_reset_postdata();

    // Calculation
    $rating_result = $rating_sum / $amount;

    if($has_posts === true AND !empty($wpsr['product_name']) AND !empty($wpsr['product_description']) AND !empty($wpsr['product_brand']) AND !empty($wpsr['image']) AND !empty($wpsr['product_sku'])) {
        ?>
        <script type="application/ld+json">
            {
                "@context": "http:\/\/schema.org",
                "@type": "Product",
                "name": "<?php echo $wpsr['product_name']; ?>",
                "description": "<?php echo $wpsr['product_description']; ?>",
                "brand" : {
                    "@type": "Organization",
                    "name": "<?php echo $wpsr['product_brand']; ?>",
                    "url": "<?php echo get_home_url(); ?>"
                },
                "image": "<?php echo $wpsr['image']; ?>",
                "sku": "<?php echo $wpsr['product_sku']; ?>",
                "aggregateRating": {
                    "@type": "aggregateRating",
                    "worstRating": 1,
                    "bestRating": 5,
                    "reviewCount": "<?php echo $amount; ?>",
                    "ratingValue": "<?php echo $rating_result; ?>",
                    "itemReviewed": {
                        "@type": "Thing",
                        <?php if (!empty($wpsr['product_reviewed_item'])) : ?>
                        "name": "<?php echo $wpsr['product_reviewed_item']; ?>"
                        <?php endif; ?>
                    }
                }
            }
        </script>
        <?php
    }

}
add_action('wp_head', 'add_schema_to_head', 10);