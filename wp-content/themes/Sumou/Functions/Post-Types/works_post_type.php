<?php
//******************** Post Type: Works ********************//

if ( ! function_exists( 'sumou_register_works_post_type' ) ) {
    function sumou_register_works_post_type() {
        register_post_type( 'works', array(
            'labels'          => array(
                'name'               => 'Works',
                'singular_name'      => 'Work',
                'add_new'            => 'Add Work',
                'add_new_item'       => 'Add New Work',
                'edit_item'          => 'Edit Work',
                'new_item'           => 'New Work',
                'view_item'          => 'View Work',
                'view_items'         => 'View Works',
                'search_items'       => 'Search Works',
                'not_found'          => 'No works found',
                'not_found_in_trash' => 'No works found in Trash',
                'all_items'          => 'All Works',
                'archives'           => 'Works Archive',
                'menu_name'          => 'Works',
            ),
            'public'          => true,
            'has_archive'     => true,
            'rewrite'         => array( 'slug' => 'works', 'with_front' => false ),
            'menu_icon'       => 'dashicons-portfolio',
            'menu_position'   => 22,
            'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
            'show_in_rest'    => true,
            'hierarchical'    => false,
            'capability_type' => 'post',
        ) );
    }
}
add_action( 'init', 'sumou_register_works_post_type' );

// Refresh permalinks once when the theme is activated so /works/ works.
if ( ! function_exists( 'sumou_works_flush_rewrites' ) ) {
    function sumou_works_flush_rewrites() {
        sumou_register_works_post_type();
        flush_rewrite_rules();
    }
}
add_action( 'after_switch_theme', 'sumou_works_flush_rewrites' );

//******************** ACF Fields: Works ********************//

if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_works_fields',
        'title'    => 'Work Details',
        'fields'   => array(
            array(
                'key'   => 'field_work_tab_card',
                'label' => 'Card',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_work_category',
                'label'         => 'Category',
                'name'          => 'work_category',
                'type'          => 'select',
                'instructions'  => 'Selects the archive filter chip, the card accent and the card badge fallback.',
                'choices'       => array(
                    'platforms' => 'Websites & Interactive Platforms',
                    'mobile'    => 'Mobile Apps (iOS & Android)',
                    'ecommerce' => 'Luxury E-Commerce',
                    'marketing' => 'Marketing & Business Growth',
                    'seo'       => 'Search Engine Ranking (SEO)',
                ),
                'default_value' => 'platforms',
                'allow_null'    => 0,
            ),
            array(
                'key'          => 'field_work_badge',
                'label'        => 'Card Badge',
                'name'         => 'work_badge',
                'type'         => 'text',
                'instructions' => 'The pill above the card title. Falls back to the category label when empty.',
            ),
            array(
                'key'          => 'field_work_sector',
                'label'        => 'Sector',
                'name'         => 'work_sector',
                'type'         => 'text',
                'instructions' => 'The industry label shown over the card image. Leave empty to hide it.',
            ),
            array(
                'key'          => 'field_work_metric',
                'label'        => 'Headline Metric',
                'name'         => 'work_metric',
                'type'         => 'text',
                'instructions' => 'The result shown over the card image and in the single page results panel.',
            ),
            array(
                'key'          => 'field_work_result',
                'label'        => 'Card Footer Result',
                'name'         => 'work_result',
                'type'         => 'text',
                'instructions' => 'The metric shown in the card footer. Leave empty to hide it.',
            ),
            array(
                'key'          => 'field_work_tagline',
                'label'        => 'Showcase Tagline',
                'name'         => 'work_tagline',
                'type'         => 'text',
                'instructions' => 'The one-line subtitle on the home page showcase card. Leave empty to hide it.',
            ),
            array(
                'key'          => 'field_work_summary',
                'label'        => 'Short Summary',
                'name'         => 'work_summary',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => 'Shown on the cards and under the single page title. Falls back to the post excerpt when empty.',
            ),
            array(
                'key'          => 'field_work_technologies',
                'label'        => 'Technologies',
                'name'         => 'work_technologies',
                'type'         => 'repeater',
                'instructions' => 'The technology tags shown on the card and the single page. Empty rows are not shown.',
                'layout'       => 'table',
                'button_label' => 'Add Technology',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_work_technology_label',
                        'label' => 'Technology',
                        'name'  => 'label',
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
                    'value'    => 'works',
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

if ( ! function_exists( 'sumou_get_work_categories' ) ) {
    /**
     * The archive filter categories, in the order the filter chips render.
     */
    function sumou_get_work_categories() {
        return array(
            'platforms' => array(
                'label'  => 'مواقع ومنصات تفاعلية',
                'accent' => array(
                    'badge'  => 'text-sky-300 border-sky-400/30',
                    'metric' => 'bg-sky-400/20 text-sky-300 border-sky-400/30',
                    'link'   => 'text-sky-300 hover:text-sky-200',
                ),
            ),
            'mobile'    => array(
                'label'  => 'تطبيقات الجوال (iOS & Android)',
                'accent' => array(
                    'badge'  => 'text-amber-300 border-amber-400/30',
                    'metric' => 'bg-amber-400/20 text-amber-300 border-amber-400/30',
                    'link'   => 'text-amber-300 hover:text-amber-200',
                ),
            ),
            'ecommerce' => array(
                'label'  => 'متاجر إلكترونية فاخرة',
                'accent' => array(
                    'badge'  => 'text-amber-300 border-amber-400/30',
                    'metric' => 'bg-amber-400/20 text-amber-300 border-amber-400/30',
                    'link'   => 'text-amber-300 hover:text-amber-200',
                ),
            ),
            'marketing' => array(
                'label'  => 'حملات تسويقية وتطوير أعمال',
                'accent' => array(
                    'badge'  => 'text-emerald-300 border-emerald-400/30',
                    'metric' => 'bg-emerald-400/20 text-emerald-300 border-emerald-400/30',
                    'link'   => 'text-emerald-300 hover:text-emerald-200',
                ),
            ),
            'seo'       => array(
                'label'  => 'تصدر محركات البحث (SEO)',
                'accent' => array(
                    'badge'  => 'text-amber-300 border-amber-400/30',
                    'metric' => 'bg-amber-400/20 text-amber-300 border-amber-400/30',
                    'link'   => 'text-amber-300 hover:text-amber-200',
                ),
            ),
        );
    }
}

if ( ! function_exists( 'sumou_get_work_field' ) ) {
    function sumou_get_work_field( $name, $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        if ( ! $post_id || ! function_exists( 'get_field' ) ) {
            return '';
        }

        return get_field( $name, $post_id );
    }
}

if ( ! function_exists( 'sumou_get_work_category' ) ) {
    function sumou_get_work_category( $post_id = null ) {
        $category   = sumou_get_work_field( 'work_category', $post_id );
        $categories = sumou_get_work_categories();

        return is_string( $category ) && isset( $categories[ $category ] ) ? $category : '';
    }
}

if ( ! function_exists( 'sumou_get_work_category_label' ) ) {
    function sumou_get_work_category_label( $post_id = null ) {
        $category = sumou_get_work_category( $post_id );
        if ( '' === $category ) {
            return '';
        }

        $categories = sumou_get_work_categories();

        return $categories[ $category ]['label'];
    }
}

if ( ! function_exists( 'sumou_get_work_accent' ) ) {
    /**
     * Tailwind class sets for the category accents, or null when no valid category is set.
     */
    function sumou_get_work_accent( $post_id = null ) {
        $category = sumou_get_work_category( $post_id );
        if ( '' === $category ) {
            return null;
        }

        $categories = sumou_get_work_categories();

        return $categories[ $category ]['accent'];
    }
}

if ( ! function_exists( 'sumou_get_work_badge' ) ) {
    function sumou_get_work_badge( $post_id = null ) {
        $badge = sumou_get_work_field( 'work_badge', $post_id );
        if ( is_string( $badge ) && trim( $badge ) !== '' ) {
            return trim( $badge );
        }

        return sumou_get_work_category_label( $post_id );
    }
}

if ( ! function_exists( 'sumou_get_work_sector' ) ) {
    function sumou_get_work_sector( $post_id = null ) {
        return trim( (string) sumou_get_work_field( 'work_sector', $post_id ) );
    }
}

if ( ! function_exists( 'sumou_get_work_metric' ) ) {
    function sumou_get_work_metric( $post_id = null ) {
        return trim( (string) sumou_get_work_field( 'work_metric', $post_id ) );
    }
}

if ( ! function_exists( 'sumou_get_work_result' ) ) {
    function sumou_get_work_result( $post_id = null ) {
        return trim( (string) sumou_get_work_field( 'work_result', $post_id ) );
    }
}

if ( ! function_exists( 'sumou_get_work_tagline' ) ) {
    function sumou_get_work_tagline( $post_id = null ) {
        return trim( (string) sumou_get_work_field( 'work_tagline', $post_id ) );
    }
}

if ( ! function_exists( 'sumou_get_work_summary' ) ) {
    function sumou_get_work_summary( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        if ( ! $post_id ) {
            return '';
        }

        $summary = sumou_get_work_field( 'work_summary', $post_id );
        if ( ! is_string( $summary ) || trim( $summary ) === '' ) {
            $summary = get_the_excerpt( $post_id );
        }

        return trim( wp_strip_all_tags( (string) $summary ) );
    }
}

if ( ! function_exists( 'sumou_get_work_technologies' ) ) {
    function sumou_get_work_technologies( $post_id = null ) {
        $rows = sumou_get_work_field( 'work_technologies', $post_id );
        if ( ! is_array( $rows ) ) {
            return array();
        }

        $technologies = array();
        foreach ( $rows as $row ) {
            $label = is_array( $row ) ? ( $row['label'] ?? '' ) : $row;
            if ( is_string( $label ) && trim( $label ) !== '' ) {
                $technologies[] = trim( $label );
            }
        }

        return $technologies;
    }
}
