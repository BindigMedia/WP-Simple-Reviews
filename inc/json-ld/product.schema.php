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

    if($has_posts === true) {
        ?>
        <script type="application/ld+json">
            {
                "@context": "http:\/\/schema.org",
                "@type": "Product",
                <?php if (!empty($wpsr['product_reviewed_item'])) : ?>
                    "name": "<?php echo $wpsr['product_name']; ?>",
                <?php endif; ?>
                <?php if (!empty($wpsr['product_reviewed_item'])) : ?>
                    "description": "<?php echo $wpsr['product_description']; ?>",
                <?php endif; ?>
                "brand" : {
                    "@type": "Organization",
                <?php if (!empty($wpsr['product_reviewed_item'])) : ?>
                    "name": "<?php echo $wpsr['product_brand']; ?>",
                <?php endif; ?>
                    "url": "<?php echo get_home_url(); ?>"
                },
                <?php if (!empty($wpsr['product_reviewed_item'])) : ?>
                    "image": "<?php echo $wpsr['image']; ?>",
                <?php endif; ?>

                <?php if (!empty($wpsr['product_reviewed_item'])) : ?>
                    "sku": "<?php echo $wpsr['product_sku']; ?>",
                <?php endif; ?>
                "aggregateRating": {
                    "@type": "aggregateRating",
                    "worstRating": 1,
                    "bestRating": 5,

                <?php if (!empty($wpsr['product_reviewed_item'])) : ?>
                    "reviewCount": "<?php echo $amount; ?>",
                <?php endif; ?>
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