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

    if($has_posts === true AND
        !empty($wpsr['product_item_reviewed']) AND
        !empty($wpsr['product_sku']) AND
        !empty($wpsr['image']) AND
        !empty($wpsr['product_brand']) AND
        !empty($wpsr['product_description']) AND
        !empty($wpsr['product_name'])
    ) {
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
                "gtin": "<?php echo $wpsr['product_sku']; ?>",
                "review": {
                    "@type": "Review",
                    "reviewRating": {
                      "@type": "Rating",
                      "ratingValue": "<?php echo $rating_result; ?>",
                      "bestRating": "5"
                    },
                    "author": {
                      "@type": "Person",
                      "name": "Paul C."
                    }
                },
                "aggregateRating": {
                    "@type": "aggregateRating",
                    "worstRating": 1,
                    "bestRating": 5,
                    "reviewCount": "<?php echo $amount; ?>",
                    "ratingValue": "<?php echo $rating_result; ?>",
                    "itemReviewed": {
                        "@type": "Thing",
                        "name": "<?php echo $wpsr['product_item_reviewed']; ?>"
                    }
                },
                "offers": {
                    "@type": "Offer",
                    "url": "<?php echo get_home_url(); ?>",
                    "priceCurrency": "EUR",
                    "price": "79.99",
                    "priceValidUntil": "<?php echo date('Y-m-d', strtotime('Dec 31')); ?>",
                    "itemCondition": "https://schema.org/UsedCondition",
                    "availability": "https://schema.org/InStock"
                }
            }
        </script>
        <?php
    }

}
add_action('wp_head', 'add_schema_to_head', 10);