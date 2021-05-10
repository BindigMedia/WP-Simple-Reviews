<?php

/**
 * Add JSON-LD for Aggregated Reviews
 *
 */
function add_localbusiness_schema_to_head() {

    // Get Address
    $wpsr = get_option( 'wpsr' );

    if($wpsr['type'] == 2) {
        // Variables
        $amount = 0;
        $rating_sum = 0;

        // Get Reviews
        $reviews_args = array(
            'post_type' => 'review',
            'posts_per_page' => -1
        );
        $reviews_query = new WP_Query( $reviews_args );

        if ( $reviews_query->have_posts() ) {
            while ( $reviews_query->have_posts() ) {
                $reviews_query->the_post();
                $amount++;
                $rating_sum += intval(get_post_meta(get_the_ID(), 'review_rating', true));
            }
        }
        wp_reset_postdata();

        // Calculation
        $rating_result = $rating_sum / $amount;

        ?>
        <script type="application/ld+json">
            {
                "@context": "http:\/\/schema.org",
                "@type": "LocalBusiness",
                "name": "<?php echo $wpsr['company']; ?>",
                "address" : {
                    "@type": "PostalAddress",
                    "streetAddress": "<?php echo $wpsr['street']; ?>",
                    "addressLocality": "<?php echo $wpsr['city']; ?>",
                    "addressRegion": "<?php echo $wpsr['state']; ?>",
                    "postalCode": "<?php echo $wpsr['zipcode']; ?>",
                    "addressCountry": "<?php echo $wpsr['country']; ?>"
                },
                "image": "<?php echo $wpsr['image']; ?>",
                "telephone": "<?php echo $wpsr['phone']; ?>",
                "email": "<?php echo $wpsr['email']; ?>",
                "aggregateRating": {
                    "@type": "aggregateRating",
                    "worstRating": 1,
                    "bestRating": 5,
                    "reviewCount": "<?php echo $amount; ?>",
                    "ratingValue": "<?php echo $rating_result; ?>"
                }
            }
        </script>
        <?php
    }
}
add_action( 'wp_head', 'add_localbusiness_schema_to_head', 10 );