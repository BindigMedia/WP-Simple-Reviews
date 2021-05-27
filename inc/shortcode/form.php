<?php
function review_form_shortcode($atts) {

    /**
     * Get Data
     *
     */
    $wpsr = get_option('wpsr');

    /**
     * Registration Data
     *
     */
    $rating = 0;
    $rating_title = '';
    $rating_content = '';
    $company = '';
    $first_name = '';
    $last_name = '';
    $email = '';
    $phone = '';

    /**
     * Submit Form
     *
     */
    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['insert_post'])) {

        /**
         * Error
         *
         */
        $error = array();


        /**
         * Invoice Data
         *
         */

        // Check "Rating Value"
        if (!empty($_POST['rating_value'])) {
            $rating = $_POST['rating_value'];
        } else {
            $error[] = __('Please select a rating', 'wp-simple-reviews');
        }

        // Check "Rating Title"
        if (!empty($_POST['rating_title'])) {
            $rating_title = $_POST['rating_title'];
        } else {
            $error[] = __('Please enter your rating title', 'wp-simple-reviews');
        }

        // Check "Rating Content"
        if (!empty($_POST['rating_content'])) {
            $rating_content = $_POST['rating_content'];
        } else {
            $error[] = __('Please enter your rating content', 'wp-simple-reviews');
        }

        // Check "Company"
        if (!empty($_POST['company'])) {
            $company = $_POST['company'];
        }

        // Check "First name"
        if (!empty($_POST['first_name'])) {
            $first_name = $_POST['first_name'];
        } else {
            $error[] = __('Please enter your first name', 'wp-simple-reviews');
        }

        // Check "Last name"
        if (!empty($_POST['last_name'])) {
            $last_name = $_POST['last_name'];
        } else {
            $error[] = __('Please enter your last name', 'wp-simple-reviews');
        }

        // Check "eMail"
        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $error[] = __('Please enter your email', 'wp-simple-reviews');
        }

        // Check "Phone"
        if (!empty($_POST['phone'])) {
            $phone = $_POST['phone'];
        }


        /**
         * Save post & Redirect after saved post
         *
         */
        if(empty($error)) {
            // Assign data to post
            $new_post = array(
                'post_title' => $rating_title,
                'post_content' => $rating_content,
                'post_status' => 'draft',
                'post_type' => 'review',
                'meta_input' => array(

                    // Data
                    'review_rating' => $rating,
                    'review_company' => $company,
                    'review_first_name' => $first_name,
                    'review_last_name' => $last_name,
                    'review_email' => $email,
                    'review_phone' => $phone,
               ),
           );

            // Save Post
            $pid = wp_insert_post($new_post);

            // Redirect
            if (is_user_logged_in()) {
                $redirect_url = '#review-successfully';
            } else {
                $redirect_url = $wpsr['thank_you_url'];
            }
            echo '<script>window.location = "'. $redirect_url .'"</script>';

        }


        /**
         * eMails & Update Order ID
         *
         */
        if(empty($error)) {

            wp_mail(
                'pt@bindig-media.de', // eMail Address
                __('New review on '. get_home_url(), 'wp-simple-reviews'), // Subject
                'Es hat sich ein neuer Nutzer registriert.<br />'. $first_name .' '. $last_name .' ('. $company .')<br />Tel.:'. $phone .'<br />E-Mail: '. $email,
                array('Reply-To: '. $first_name .' '. $last_name .' <'. $email .'>')
           );

        }
    }



    /**
     * Shortcode
     *
     */
    $a = shortcode_atts(array(
        'id' => '',
        'term' => false,
   ), $atts);



    /**
     * Form
     *
     */
    ob_start();
    ?>

    <?php
    // Error
    if(!empty($error)) {
        echo '<div class="registration-error">';
        echo '<ul>';
        foreach($error as $e) {
            echo '<li>'. $e .'</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    ?>
    <!-- Form -->
    <form id="wpsr-form" class="wpsr-form" name="rating" method="post" action="">
        <div class="starrr"></div>
        <input type="hidden" id="rating_value" name="rating_value" value="<?php echo $rating_value; ?>" placeholder="<?php echo _x('Rating*', 'Review Form', 'wp-simple-reviews'); ?>" />
        <input type="text" id="company" name="company" value="<?php echo $company; ?>" placeholder="<?php echo _x('Company', 'Review Form', 'wp-simple-reviews'); ?>" />
        <div class="wpsr-fullname">
            <div class="wpsr-first-name-holder">
                <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" placeholder="<?php echo _x('First name*', 'Review Form', 'wp-simple-reviews'); ?>" />
            </div>
            <div class="wpsr-last-name-holder">
                <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" placeholder="<?php echo _x('Last name*', 'Review Form', 'wp-simple-reviews'); ?>" />
            </div>
        </div>
        <div class="wpsr-contact">
            <div class="wpsr-phone-holder">
                <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="<?php echo _x('Phone', 'Review Form', 'wp-simple-reviews'); ?>" />
            </div>
            <div class="wpsr-email-holder">
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo _x('eMail*', 'Review Form', 'wp-simple-reviews'); ?>" />
            </div>
        </div>
        <input type="text" id="rating_title" name="rating_title" value="<?php echo $rating_title; ?>" placeholder="<?php echo _x('Rating Title*', 'Review Form', 'wp-simple-reviews'); ?>" />
        <textarea id="rating_content" name="rating_content" placeholder="<?php echo _x('Rating Content*', 'Review Form', 'wp-simple-reviews'); ?>"><?php echo $rating_content; ?></textarea>


        <!-- Terms -->
        <div class="wpsr-terms">
            <?php printf(_x('With my rating I accept the <a href="%s" title="Data Privacy Policy" target="_blank">Data Privacy Policy</a>.', 'Review Form', 'wp-simple-reviews'), esc_url(get_permalink(get_option('wp_page_for_privacy_policy')))); ?>
        </div>

        <!-- Submit Button -->
        <div class="wpsr-review-button">
            <input id="order-submit" type="submit" value="<?php _e('Submit Rating', 'wp-simple-reviews'); ?>" />
        </div>
        <input type="hidden" name="insert_post" value="post" />
    </form>

    <?php
    return ob_get_clean();
}

add_shortcode('wpsr_form', 'review_form_shortcode');