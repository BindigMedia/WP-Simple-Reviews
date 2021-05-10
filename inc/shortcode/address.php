<?php
/**
 * Address
 *
 */
function wpsr_get_address($atts, $content = null) {

    // Attributes
    $a = shortcode_atts( array(
        'schema' => 'false'
    ), $atts );

    // Get Settings Array
    $wpsr = get_option( 'wpsr' );

    // Build Address
    if($a['schema'] == 'true') {
        $address = '<address class="wpsr-address item vcard">';
        $address .= '<div class="hcard">';
        if (!empty($wpsr['company']) AND $wpsr['type'] == 1) {
            $address .= '<div class="company fn org">'. $wpsr['company'] .'</div>';
        } elseif (!empty($wpsr['company'])) {
            $address .= '<div class="company fn">'. $wpsr['company'] .'</div>';
        }
        if (!empty($wpsr['street']) AND !empty($wpsr['zipcode']) AND !empty($wpsr['city'])) {
            $address .= '<div class="address adr">';
            $address .= '<span class="street street-address">'. $wpsr['street'] .'</span>, <span class="zipcode postcode">'. $wpsr['zipcode'] .'</span> <span class="city locality">'. $wpsr['city'] .'</span>';
            $address .= '</div>';
        }
        if (!empty($wpsr['image'])) {
            $address .= '<img src="'. $wpsr['image'] .'" class="photo" data-no-lazy="1" style="display: none;" />';
        }
        if (!empty($wpsr['phone'])) {
            $address .= '<div class="tel">'. $wpsr['phone'] .'</div>';
        }
        $address .= '</div>';
        $address .= '</address>';
    } else {
        $address = '<address class="wpsr-address">';
        if (!empty($wpsr['company'])) {
            $address .= '<div class="company">'. $wpsr['company'] .'</div>';
        }
        if (!empty($wpsr['street']) AND !empty($wpsr['zipcode']) AND !empty($wpsr['city'])) {
            $address .= '<div class="address">';
            $address .= '<span class="street">'. $wpsr['street'] .'</span>, <span class="zipcode">'. $wpsr['zipcode'] .'</span> <span class="city">'. $wpsr['city'] .'</span>';
            $address .= '</div>';
        }
        if (!empty($wpsr['phone'])) {
            $address .= '<div class="tel">'. $wpsr['phone'] .'</div>';
        }
        $address .= '</address>';
    }

    return $address;
}
add_shortcode('wpsr_address', 'wpsr_get_address');