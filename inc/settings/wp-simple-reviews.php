<?php
class WPSimpleReviewsSettings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'WP Simple Reviews',
            'WP Simple Reviews',
            'manage_options',
            'wp-simple-reviews',
            array($this, 'create_admin_page')
       );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('wpsr');
        ?>
        <div class="wrap">
            <h1><?php _e('WP Simple Reviews', 'wp-simple-reviews'); ?></h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('wpsr_option_group');
                do_settings_sections('wp-simple-reviews');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'wpsr_option_group', // Option group
            'wpsr', // Option name
            array($this, 'sanitize') // Sanitize
       );

        add_settings_section(
            'setting_section_id', // ID
            'WP Simple Reviews', // Title
            array($this, 'print_section_info'), // Callback
            'wp-simple-reviews' // Page
       );

        add_settings_field(
            'type', // ID
            __('Type', 'wp-simple-reviews'), // Title
            array($this, 'type_callback'), // Callback
            'wp-simple-reviews', // Page
            'setting_section_id' // Section
       );

        add_settings_field(
            'company', // ID
            __('Company', 'wp-simple-reviews'), // Title
            array($this, 'company_callback'), // Callback
            'wp-simple-reviews', // Page
            'setting_section_id' // Section
       );

        add_settings_field(
            'street',
            __('Street', 'wp-simple-reviews'), // Title
            array($this, 'street_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'zipcode',
            __('Zipcode', 'wp-simple-reviews'), // Title
            array($this, 'zipcode_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'city',
            __('City', 'wp-simple-reviews'), // Title
            array($this, 'city_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'state',
            __('State', 'wp-simple-reviews'), // Title
            array($this, 'state_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'country',
            __('Country e.g. DE', 'wp-simple-reviews'), // Title
            array($this, 'country_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'image',
            __('Image URL', 'wp-simple-reviews'), // Title
            array($this, 'image_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'phone',
            __('Phone', 'wp-simple-reviews'), // Title
            array($this, 'phone_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'email',
            __('eMail', 'wp-simple-reviews'), // Title
            array($this, 'email_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'pricerange_from',
            __('Pricerange from', 'wp-simple-reviews'), // Title
            array($this, 'pricerange_from_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'pricerange_to',
            __('Pricerange to', 'wp-simple-reviews'), // Title
            array($this, 'pricerange_to_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'review_url',
            __('Review URL', 'wp-simple-reviews'), // Title
            array($this, 'review_url_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'thank_you_url',
            __('Thank You Page URL', 'wp-simple-reviews'), // Title
            array($this, 'thank_you_url_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'product_name',
            __('Product Specific: Product Name', 'wp-simple-reviews'), // Title
            array($this, 'product_name_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'product_description',
            __('Product Specific: Product Description', 'wp-simple-reviews'), // Title
            array($this, 'product_description_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'product_brand',
            __('Product Specific: Product Brand', 'wp-simple-reviews'), // Title
            array($this, 'product_name_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'product_sku',
            __('Product Specific: Product SKU', 'wp-simple-reviews'), // Title
            array($this, 'product_sku_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

        add_settings_field(
            'product_item_reviewed',
            __('Product Specific: Product Item Reviewed', 'wp-simple-reviews'), // Title
            array($this, 'product_item_reviewed_callback'),
            'wp-simple-reviews',
            'setting_section_id'
       );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();
        if(isset($input['type']))
            $new_input['type'] = sanitize_text_field($input['type']);

        if(isset($input['company']))
            $new_input['company'] = sanitize_text_field($input['company']);

        if(isset($input['street']))
            $new_input['street'] = sanitize_text_field($input['street']);

        if(isset($input['zipcode']))
            $new_input['zipcode'] = sanitize_text_field($input['zipcode']);

        if(isset($input['city']))
            $new_input['city'] = sanitize_text_field($input['city']);

        if(isset($input['state']))
            $new_input['state'] = sanitize_text_field($input['state']);

        if(isset($input['country']))
            $new_input['country'] = sanitize_text_field($input['country']);

        if(isset($input['image']))
            $new_input['image'] = sanitize_text_field($input['image']);

        if(isset($input['phone']))
            $new_input['phone'] = sanitize_text_field($input['phone']);

        if(isset($input['email']))
            $new_input['email'] = sanitize_text_field($input['email']);

        if(isset($input['pricerange_from']))
            $new_input['pricerange_from'] = sanitize_text_field($input['pricerange_from']);

        if(isset($input['pricerange_to']))
            $new_input['pricerange_to'] = sanitize_text_field($input['pricerange_to']);

        if(isset($input['review_url']))
            $new_input['review_url'] = sanitize_text_field($input['review_url']);

        if(isset($input['thank_you_url']))
            $new_input['thank_you_url'] = sanitize_text_field($input['thank_you_url']);

        // Product specific data
        if(isset($input['product_name']))
            $new_input['product_name'] = sanitize_text_field($input['product_name']);

        if(isset($input['product_description']))
            $new_input['product_description'] = sanitize_text_field($input['product_description']);

        if(isset($input['product_brand']))
            $new_input['product_brand'] = sanitize_text_field($input['product_brand']);

        if(isset($input['product_sku']))
            $new_input['product_sku'] = sanitize_text_field($input['product_sku']);

        if(isset($input['product_item_reviewed']))
            $new_input['product_item_reviewed'] = sanitize_text_field($input['product_item_reviewed']);

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */

    /**
     * Type
     */
    public function type_callback()
    {
        printf(
            '<input type="text" id="type" name="wpsr[type]" value="%s" placeholder="'. __('1=Org, 2=Product', 'wp-simple-reviews') .'" />',
            isset($this->options['type']) ? esc_attr($this->options['type']) : ''
       );
    }

    /**
     * Company
     */
    public function company_callback()
    {
        printf(
            '<input type="text" id="company" name="wpsr[company]" value="%s" />',
            isset($this->options['company']) ? esc_attr($this->options['company']) : ''
       );
    }

    /**
     * Street
     */
    public function street_callback()
    {
        printf(
            '<input type="text" id="street" name="wpsr[street]" value="%s" />',
            isset($this->options['street']) ? esc_attr($this->options['street']) : ''
       );
    }

    /**
     * Zipcode
     */
    public function zipcode_callback()
    {
        printf(
            '<input type="text" id="zipcode" name="wpsr[zipcode]" value="%s" />',
            isset($this->options['zipcode']) ? esc_attr($this->options['zipcode']) : ''
       );
    }


    /**
     * City
     */
    public function city_callback()
    {
        printf(
            '<input type="text" id="city" name="wpsr[city]" value="%s" />',
            isset($this->options['city']) ? esc_attr($this->options['city']) : ''
       );
    }

    /**
     * State
     */
    public function state_callback()
    {
        printf(
            '<input type="text" id="state" name="wpsr[state]" value="%s" />',
            isset($this->options['state']) ? esc_attr($this->options['state']) : ''
       );
    }

    /**
     * Country
     */
    public function country_callback()
    {
        printf(
            '<input type="text" id="country" name="wpsr[country]" value="%s" />',
            isset($this->options['country']) ? esc_attr($this->options['country']) : ''
       );
    }

    /**
     * Image
     */
    public function image_callback()
    {
        printf(
            '<input type="text" id="image" name="wpsr[image]" value="%s" />',
            isset($this->options['image']) ? esc_attr($this->options['image']) : ''
       );
    }


    /**
     * Phone
     */
    public function phone_callback()
    {
        printf(
            '<input type="text" id="phone" name="wpsr[phone]" value="%s" />',
            isset($this->options['phone']) ? esc_attr($this->options['phone']) : ''
       );
    }


    /**
     * Image
     */
    public function email_callback()
    {
        printf(
            '<input type="email" id="email" name="wpsr[email]" value="%s" />',
            isset($this->options['email']) ? esc_attr($this->options['email']) : ''
       );
    }

    /**
     * Pricerange from
     */
    public function pricerange_from_callback()
    {
        printf(
            '<input type="text" id="pricerange_from" name="wpsr[pricerange_from]" value="%s" />',
            isset($this->options['pricerange_from']) ? esc_attr($this->options['pricerange_from']) : ''
       );
    }

    /**
     * Pricerange to
     */
    public function pricerange_to_callback()
    {
        printf(
            '<input type="text" id="pricerange_to" name="wpsr[pricerange_to]" value="%s" />',
            isset($this->options['pricerange_to']) ? esc_attr($this->options['pricerange_to']) : ''
       );
    }

    /**
     * Review URL
     */
    public function review_url_callback()
    {
        printf(
            '<input type="text" id="review_url" name="wpsr[review_url]" value="%s" />',
            isset($this->options['review_url']) ? esc_attr($this->options['review_url']) : ''
       );
    }

    /**
     * Thank You Page URL
     */
    public function thank_you_url_callback()
    {
        printf(
            '<input type="text" id="thank_you_url" name="wpsr[thank_you_url]" value="%s" />',
            isset($this->options['thank_you_url']) ? esc_attr($this->options['thank_you_url']) : ''
       );
    }

    /**
     * Product Specific: Product Name
     */
    public function product_name_callback()
    {
        printf(
            '<input type="text" id="product_name" name="wpsr[product_name]" value="%s" />',
            isset($this->options['product_name']) ? esc_attr($this->options['product_name']) : ''
       );
    }

    /**
     * Product Specific: Product Description
     */
    public function product_description_callback()
    {
        printf(
            '<input type="text" id="product_description" name="wpsr[product_description]" value="%s" />',
            isset($this->options['product_description']) ? esc_attr($this->options['product_description']) : ''
       );
    }

    /**
     * Product Specific: Product Brand
     */
    public function product_brand_callback()
    {
        printf(
            '<input type="text" id="product_brand" name="wpsr[product_brand]" value="%s" />',
            isset($this->options['product_brand']) ? esc_attr($this->options['product_brand']) : ''
       );
    }

    /**
     * Product Specific: Product SKU
     */
    public function product_sku_callback()
    {
        printf(
            '<input type="text" id="product_sku" name="wpsr[product_sku]" value="%s" />',
            isset($this->options['product_sku']) ? esc_attr($this->options['product_sku']) : ''
       );
    }

    /**
     * Product Specific: Product Item Reviewd
     */
    public function product_item_reviewed_callback()
    {
        printf(
            '<input type="text" id="product_item_reviewed" name="wpsr[product_item_reviewed]" value="%s" />',
            isset($this->options['product_item_reviewed']) ? esc_attr($this->options['product_item_reviewed']) : ''
       );
    }
}

if(is_admin())
    $my_settings_page = new WPSimpleReviewsSettings();