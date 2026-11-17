<?php
//******************** Post Type: Services ********************//

if ( ! function_exists( 'sumou_register_services_post_type' ) ) {
    function sumou_register_services_post_type() {
        register_post_type( 'services', array(
            'labels'          => array(
                'name'               => 'Services',
                'singular_name'      => 'Service',
                'add_new'            => 'Add Service',
                'add_new_item'       => 'Add New Service',
                'edit_item'          => 'Edit Service',
                'new_item'           => 'New Service',
                'view_item'          => 'View Service',
                'view_items'         => 'View Services',
                'search_items'       => 'Search Services',
                'not_found'          => 'No services found',
                'not_found_in_trash' => 'No services found in Trash',
                'all_items'          => 'All Services',
                'archives'           => 'Services Archive',
                'menu_name'          => 'Services',
            ),
            'public'          => true,
            'has_archive'     => true,
            'rewrite'         => array( 'slug' => 'services', 'with_front' => false ),
            'menu_icon'       => 'dashicons-admin-tools',
            'menu_position'   => 21,
            'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
            'show_in_rest'    => true,
            'hierarchical'    => false,
            'capability_type' => 'post',
        ) );
    }
}
add_action( 'init', 'sumou_register_services_post_type' );

// Refresh permalinks once when the theme is activated so /services/ works.
if ( ! function_exists( 'sumou_services_flush_rewrites' ) ) {
    function sumou_services_flush_rewrites() {
        sumou_register_services_post_type();
        flush_rewrite_rules();
    }
}
add_action( 'after_switch_theme', 'sumou_services_flush_rewrites' );

//******************** ACF Fields: Services ********************//

if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_services_fields',
        'title'    => 'Service Details',
        'fields'   => array(
            array(
                'key'   => 'field_service_tab_card',
                'label' => 'Card',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_service_card_background',
                'label'         => 'Card Background Image',
                'name'          => 'service_card_background',
                'type'          => 'image',
                'instructions'  => 'The image revealed behind the card on hover. Separate from the Featured Image (which is only shown on the single service page). Leave empty for no hover background.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'mime_types'    => 'jpg, jpeg, png, webp',
            ),
            array(
                'key'           => 'field_service_icon',
                'label'         => 'Service Icon Image',
                'name'          => 'service_icon',
                'type'          => 'image',
                'instructions'  => 'Shown on the service card and the single service page. Leave empty to hide the icon.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'mime_types'    => 'jpg, jpeg, png, webp, svg',
            ),
            array(
                'key'          => 'field_service_summary',
                'label'        => 'Short Summary',
                'name'         => 'service_summary',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => 'Shown on the card and under the single page title. Falls back to the post excerpt when empty.',
            ),
            array(
                'key'           => 'field_service_accent',
                'label'         => 'Card Accent',
                'name'          => 'service_accent',
                'type'          => 'select',
                'choices'       => array(
                    'gold' => 'Gold',
                    'cyan' => 'Cyan',
                ),
                'default_value' => 'gold',
            ),
            array(
                'key'          => 'field_service_features',
                'label'        => 'Card Features',
                'name'         => 'service_features',
                'type'         => 'repeater',
                'instructions' => 'The short checklist shown on the card and the single page. Empty rows are not shown.',
                'layout'       => 'table',
                'button_label' => 'Add Feature',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_service_feature_text',
                        'label' => 'Feature',
                        'name'  => 'text',
                        'type'  => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'services',
                ),
            ),
        ),
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ) );
}

//******************** Helpers ********************//

if ( ! function_exists( 'sumou_service_image_url' ) ) {
    /**
     * Resolve an ACF image value (array, attachment ID or URL) to a URL.
     */
    function sumou_service_image_url( $image, $size = 'full' ) {
        if ( is_array( $image ) ) {
            return $image['url'] ?? '';
        }
        if ( is_numeric( $image ) ) {
            return wp_get_attachment_image_url( $image, $size );
        }
        return is_string( $image ) ? $image : '';
    }
}

if ( ! function_exists( 'sumou_get_service_icon_url' ) ) {
    function sumou_get_service_icon_url( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        if ( ! $post_id || ! function_exists( 'get_field' ) ) {
            return '';
        }
        return sumou_service_image_url( get_field( 'service_icon', $post_id ) );
    }
}

if ( ! function_exists( 'sumou_get_service_card_background_url' ) ) {
    /**
     * Hover background of the service card — its own image field, not the Featured Image.
     */
    function sumou_get_service_card_background_url( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        if ( ! $post_id || ! function_exists( 'get_field' ) ) {
            return '';
        }
        return sumou_service_image_url( get_field( 'service_card_background', $post_id ) );
    }
}

if ( ! function_exists( 'sumou_get_service_summary' ) ) {
    function sumou_get_service_summary( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        if ( ! $post_id ) {
            return '';
        }

        $summary = function_exists( 'get_field' ) ? get_field( 'service_summary', $post_id ) : '';
        if ( ! $summary ) {
            $summary = get_the_excerpt( $post_id );
        }

        return trim( wp_strip_all_tags( (string) $summary ) );
    }
}

if ( ! function_exists( 'sumou_get_service_features' ) ) {
    function sumou_get_service_features( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        if ( ! $post_id || ! function_exists( 'get_field' ) ) {
            return array();
        }

        $rows = get_field( 'service_features', $post_id );
        if ( ! is_array( $rows ) ) {
            return array();
        }

        $features = array();
        foreach ( $rows as $row ) {
            $text = is_array( $row ) ? ( $row['text'] ?? '' ) : $row;
            if ( is_string( $text ) && trim( $text ) !== '' ) {
                $features[] = trim( $text );
            }
        }

        return $features;
    }
}

if ( ! function_exists( 'sumou_get_service_accent' ) ) {
    /**
     * Tailwind class sets for the two card accents.
     */
    function sumou_get_service_accent( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        $accent  = ( $post_id && function_exists( 'get_field' ) ) ? get_field( 'service_accent', $post_id ) : 'gold';

        $map = array(
            'gold' => array(
                'icon_box'    => 'bg-amber-500/10 border-amber-500/30',
                'icon_color'  => 'text-brand-gold',
                'hover_title' => 'group-hover:text-brand-gold',
                'link'        => 'text-brand-goldLight group-hover:text-white',
                'check'       => 'text-brand-gold',
            ),
            'cyan' => array(
                'icon_box'    => 'bg-cyan-500/10 border-cyan-500/30',
                'icon_color'  => 'text-cyan-400',
                'hover_title' => 'group-hover:text-cyan-300',
                'link'        => 'text-cyan-300 group-hover:text-white',
                'check'       => 'text-cyan-400',
            ),
        );

        return $map[ $accent ] ?? $map['gold'];
    }
}
