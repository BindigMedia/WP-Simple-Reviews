<?php

class WPSR_Review_Detail{

    private $postTypes = array(
        'review'
    );


    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'wpsr_add_meta_boxes' ) );
        add_action( 'admin_footer', array( $this, 'admin_footer' ) );
        add_action( 'save_post', array( $this, 'wpsr_save_fields' ) );

    }


    public function wpsr_add_meta_boxes() {
        foreach ( $this->postTypes as $postType ) {
            add_meta_box(
                'details',
                __( 'Details', 'wp-simple-reviews' ),
                array( $this, 'wpsr_details_callback' ),
                $postType,
                'advanced',
                'default'
            );
        }
    }


    public function wpsr_details_callback($post){
        wp_nonce_field( 'details_data', 'details_none' );
        $review_exclude = get_post_meta( $post->ID, 'review_exclude', true );
        ?>
        <div class="geo-meta-data">
            <label for="review_rating"><?php _e('Rating', 'wp-simple-reviews'); ?></label>
            <input class="box-input" id="review_rating" name="review_rating" value="<?php echo get_post_meta( $post->ID, 'review_rating', true ); ?>" />
            <div>
                <label for="review_exclude"><?php _e('Exclude Review from visible showing? (0/1)', 'wp-simple-reviews'); ?></label><br />
                <select name="review_exclude">
                    <option value="0" <?php echo ($review_exclude == 0) ? 'selected' : ''; ?>><?php _e('No', 'wp-simple-reviews'); ?></option>
                    <option value="1" <?php echo ($review_exclude == 1) ? 'selected' : ''; ?>><?php _e('Yes', 'wp-simple-reviews'); ?></option>
                </select>
            </div>
            <label for="review_company"><?php _e('Company', 'wp-simple-reviews'); ?></label>
            <input class="box-input" id="review_company" name="review_company" value="<?php echo get_post_meta( $post->ID, 'review_company', true ); ?>" />
            <label for="review_first_name"><?php _e('First name', 'wp-simple-reviews'); ?></label>
            <input class="box-input" id="review_first_name" name="review_first_name" value="<?php echo get_post_meta( $post->ID, 'review_first_name', true ); ?>" />
            <label for="review_last_name"><?php _e('Last name', 'wp-simple-reviews'); ?></label>
            <input class="box-input" id="review_last_name" name="review_last_name" value="<?php echo get_post_meta( $post->ID, 'review_last_name', true ); ?>" />
            <label for="review_email"><?php _e('eMail', 'wp-simple-reviews'); ?></label>
            <input class="box-input" id="review_email" name="review_email" value="<?php echo get_post_meta( $post->ID, 'review_email', true ); ?>" />
            <label for="review_phone"><?php _e('Phone', 'wp-simple-reviews'); ?></label>
            <input class="box-input" id="review_phone" name="review_phone" value="<?php echo get_post_meta( $post->ID, 'review_phone', true ); ?>" />
        </div>
        <?php
    }


    public function wpsr_save_fields( $post_id ) {
        if ( ! isset( $_POST['details_none'] ) )
            return $post_id;

        $nonce = $_POST['details_none'];
        if ( !wp_verify_nonce( $nonce, 'details_data' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        // Update metafields
        if ( isset( $_POST['review_exclude'] ) )
            update_post_meta( $post_id, 'review_exclude', esc_attr( $_POST['review_exclude'] ) );
        if ( isset( $_POST['review_company'] ) )
            update_post_meta( $post_id, 'review_company', esc_attr( $_POST['review_company'] ) );
        if ( isset( $_POST['review_first_name'] ) )
            update_post_meta( $post_id, 'review_first_name', esc_attr( $_POST['review_first_name'] ) );
        if ( isset( $_POST['review_last_name'] ) )
            update_post_meta( $post_id, 'review_last_name', esc_attr( $_POST['review_last_name'] ) );
        if ( isset( $_POST['review_rating'] ) )
            update_post_meta( $post_id, 'review_rating', esc_attr( $_POST['review_rating'] ) );
        if ( isset( $_POST['review_email'] ) )
            update_post_meta( $post_id, 'review_email', esc_attr( $_POST['review_email'] ) );
        if ( isset( $_POST['review_phone'] ) )
            update_post_meta( $post_id, 'review_phone', esc_attr( $_POST['review_phone'] ) );
    }


    public function admin_footer() {
        ?>
        <style>
            .box-input {width: 100%; margin: 3px 0 5px 0; padding: 5px 10px; margin-bottom: 5px; border-radius: 4px; border: 1px solid #666;}
            .input-label { margin-bottom: 5px; display: block }
        </style>
        <?php
    }

}
new WPSR_Review_Detail;