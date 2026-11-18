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

//******************** Taxonomy: Work Categories ********************//

if ( ! function_exists( 'sumou_register_work_category_taxonomy' ) ) {
    function sumou_register_work_category_taxonomy() {
        register_taxonomy( 'work_category', array( 'works' ), array(
            'labels'            => array(
                'name'              => 'Work Categories',
                'singular_name'     => 'Work Category',
                'search_items'      => 'Search Work Categories',
                'all_items'         => 'All Work Categories',
                'parent_item'       => 'Parent Work Category',
                'parent_item_colon' => 'Parent Work Category:',
                'edit_item'         => 'Edit Work Category',
                'update_item'       => 'Update Work Category',
                'add_new_item'      => 'Add New Work Category',
                'new_item_name'     => 'New Work Category Name',
                'menu_name'         => 'Work Categories',
            ),
            'public'            => true,
            'publicly_queryable' => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => false,
            'query_var'         => 'work_category',
        ) );
    }
}
add_action( 'init', 'sumou_register_work_category_taxonomy', 11 );

if ( ! function_exists( 'sumou_default_work_categories' ) ) {
    /**
     * The categories the archive filter chips are designed around, in render order.
     */
    function sumou_default_work_categories() {
        return array(
            'platforms' => 'مواقع ومنصات تفاعلية',
            'mobile'    => 'تطبيقات الجوال (iOS & Android)',
            'ecommerce' => 'متاجر إلكترونية فاخرة',
            'marketing' => 'حملات تسويقية وتطوير أعمال',
            'seo'       => 'تصدر محركات البحث (SEO)',
        );
    }
}

if ( ! function_exists( 'sumou_seed_work_categories' ) ) {
    function sumou_seed_work_categories() {
        foreach ( sumou_default_work_categories() as $slug => $name ) {
            if ( ! term_exists( $slug, 'work_category' ) ) {
                wp_insert_term( $name, 'work_category', array( 'slug' => $slug ) );
            }
        }
    }
}

if ( ! function_exists( 'sumou_seed_work_categories_once' ) ) {
    /**
     * Theme updates do not fire after_switch_theme, so the design categories are
     * seeded on the first request that runs this version of the theme.
     */
    function sumou_seed_work_categories_once() {
        if ( '1' === get_option( 'sumou_work_categories_seeded' ) ) {
            return;
        }

        sumou_seed_work_categories();
        update_option( 'sumou_work_categories_seeded', '1' );
    }
}
add_action( 'init', 'sumou_seed_work_categories_once', 12 );

// Refresh permalinks and create the design categories once on activation.
if ( ! function_exists( 'sumou_works_flush_rewrites' ) ) {
    function sumou_works_flush_rewrites() {
        sumou_register_works_post_type();
        sumou_register_work_category_taxonomy();
        sumou_seed_work_categories_once();
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
                'key'          => 'field_work_badge',
                'label'        => 'Card Badge',
                'name'         => 'work_badge',
                'type'         => 'text',
                'instructions' => 'The pill above the card title. Falls back to the work category name when empty.',
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
                'key'          => 'field_work_project_url',
                'label'        => 'Project URL',
                'name'         => 'work_project_url',
                'type'         => 'url',
                'instructions' => 'The live project link the "View Project" button opens in a new tab. Leave empty to hide the button.',
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

if ( ! function_exists( 'sumou_get_work_terms' ) ) {
    function sumou_get_work_terms( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        if ( ! $post_id ) {
            return array();
        }

        $terms = get_the_terms( $post_id, 'work_category' );

        return is_array( $terms ) ? $terms : array();
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
    /**
     * Slug of the first assigned category — the one the design accents and filters.
     */
    function sumou_get_work_category( $post_id = null ) {
        $terms = sumou_get_work_terms( $post_id );

        return $terms ? $terms[0]->slug : '';
    }
}

if ( ! function_exists( 'sumou_get_work_category_label' ) ) {
    function sumou_get_work_category_label( $post_id = null ) {
        $terms = sumou_get_work_terms( $post_id );

        return $terms ? $terms[0]->name : '';
    }
}

if ( ! function_exists( 'sumou_get_work_accents' ) ) {
    /**
     * Tailwind class sets for the design categories, keyed by taxonomy slug.
     */
    function sumou_get_work_accents() {
        return array(
            'platforms' => array(
                'badge'  => 'text-sky-300 border-sky-400/30',
                'metric' => 'bg-sky-400/20 text-sky-300 border-sky-400/30',
                'link'   => 'text-sky-300 hover:text-sky-200',
            ),
            'mobile'    => array(
                'badge'  => 'text-amber-300 border-amber-400/30',
                'metric' => 'bg-amber-400/20 text-amber-300 border-amber-400/30',
                'link'   => 'text-amber-300 hover:text-amber-200',
            ),
            'ecommerce' => array(
                'badge'  => 'text-amber-300 border-amber-400/30',
                'metric' => 'bg-amber-400/20 text-amber-300 border-amber-400/30',
                'link'   => 'text-amber-300 hover:text-amber-200',
            ),
            'marketing' => array(
                'badge'  => 'text-emerald-300 border-emerald-400/30',
                'metric' => 'bg-emerald-400/20 text-emerald-300 border-emerald-400/30',
                'link'   => 'text-emerald-300 hover:text-emerald-200',
            ),
            'seo'       => array(
                'badge'  => 'text-amber-300 border-amber-400/30',
                'metric' => 'bg-amber-400/20 text-amber-300 border-amber-400/30',
                'link'   => 'text-amber-300 hover:text-amber-200',
            ),
        );
    }
}

if ( ! function_exists( 'sumou_get_work_accent' ) ) {
    /**
     * Tailwind class sets for the primary category, or null when the category
     * is missing or is a term the design has no accent for.
     */
    function sumou_get_work_accent( $post_id = null ) {
        $accents  = sumou_get_work_accents();
        $category = sumou_get_work_category( $post_id );

        return $accents[ $category ] ?? null;
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

if ( ! function_exists( 'sumou_get_work_project_url' ) ) {
    function sumou_get_work_project_url( $post_id = null ) {
        return trim( (string) sumou_get_work_field( 'work_project_url', $post_id ) );
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

//******************** Archive filter ********************//

if ( ! function_exists( 'sumou_get_work_filter_terms' ) ) {
    /**
     * Categories that currently have works, in the order the chips render.
     */
    function sumou_get_work_filter_terms() {
        $terms = get_terms( array(
            'taxonomy'   => 'work_category',
            'hide_empty' => true,
            'orderby'    => 'term_id',
            'order'      => 'ASC',
        ) );

        return is_array( $terms ) ? $terms : array();
    }
}

if ( ! function_exists( 'sumou_get_work_filter_slug' ) ) {
    function sumou_get_work_filter_slug() {
        if ( ! isset( $_GET['work_category'] ) ) {
            return '';
        }

        $slug = wp_unslash( $_GET['work_category'] );

        return is_string( $slug ) ? sanitize_title( $slug ) : '';
    }
}

if ( ! function_exists( 'sumou_get_work_filter_url' ) ) {
    function sumou_get_work_filter_url( $slug = '' ) {
        $archive = get_post_type_archive_link( 'works' );
        if ( ! $archive ) {
            return '';
        }

        return '' === $slug ? $archive : add_query_arg( 'work_category', $slug, $archive );
    }
}

if ( ! function_exists( 'sumou_filter_works_archive' ) ) {
    function sumou_filter_works_archive( $query ) {
        if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'works' ) ) {
            return;
        }

        $slug = sumou_get_work_filter_slug();
        if ( '' === $slug ) {
            return;
        }

        $term = get_term_by( 'slug', $slug, 'work_category' );
        if ( ! $term ) {
            $query->set_404();
            return;
        }

        $query->set( 'tax_query', array(
            array(
                'taxonomy'         => 'work_category',
                'field'            => 'term_id',
                'terms'            => array( (int) $term->term_id ),
                'include_children' => true,
            ),
        ) );
    }
}
add_action( 'pre_get_posts', 'sumou_filter_works_archive' );
