<?php
//******************** ACF Options: Baka ********************//

// Register the "Baka" options page.
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title'    => 'Baka',
        'menu_title'    => 'Baka',
        'menu_slug'     => 'baka-options',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-tickets-alt',
        'position'      => 62,
        'redirect'      => false,
        'update_button' => 'Save Baka',
    ) );
}

// Register the fields of the baka section.
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_baka_options',
        'title'    => 'Baka',
        'fields'   => array(

            // ----- Content -----
            array(
                'key'   => 'field_baka_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_baka_badge',
                'label'         => 'Badge Text',
                'name'          => 'baka_badge',
                'type'          => 'text',
                'default_value' => 'باقات الاستثمار والنمو',
            ),
            array(
                'key'           => 'field_baka_title',
                'label'         => 'Heading',
                'name'          => 'baka_title',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'استثمار مدروس يضمن ',
            ),
            array(
                'key'           => 'field_baka_title_highlight',
                'label'         => 'Heading Highlight',
                'name'          => 'baka_title_highlight',
                'type'          => 'text',
                'instructions'  => 'The gold gradient part of the heading.',
                'default_value' => 'عائدات تفوق التوقعات',
            ),
            array(
                'key'           => 'field_baka_description',
                'label'         => 'Description',
                'name'          => 'baka_description',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'اختر الباقة المناسبة لمرحلة نمو مشروعك الحالية مع إمكانية التخصيص الكامل.',
            ),

            // ----- Packages -----
            array(
                'key'   => 'field_baka_tab_packages',
                'label' => 'Packages',
                'type'  => 'tab',
            ),
            array(
                'key'          => 'field_baka_packages',
                'label'        => 'Packages',
                'name'         => 'baka_packages',
                'type'         => 'repeater',
                'instructions' => 'Packages without a name are not shown. Prices are not part of this section.',
                'layout'       => 'table',
                'button_label' => 'Add Package',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_baka_package_tier',
                        'label' => 'Tier',
                        'name'  => 'tier',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_baka_package_name',
                        'label' => 'Name',
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_baka_package_description',
                        'label' => 'Description',
                        'name'  => 'description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ),
                    array(
                        'key'          => 'field_baka_package_features',
                        'label'        => 'Features',
                        'name'         => 'features',
                        'type'         => 'textarea',
                        'rows'         => 5,
                        'instructions' => 'One feature per line.',
                    ),
                    array(
                        'key'   => 'field_baka_package_cta_label',
                        'label' => 'Button Label',
                        'name'  => 'cta_label',
                        'type'  => 'text',
                    ),
                    array(
                        'key'           => 'field_baka_package_cta_link',
                        'label'         => 'Button Link',
                        'name'          => 'cta_link',
                        'type'          => 'text',
                        'default_value' => '#contact',
                    ),
                    array(
                        'key'           => 'field_baka_package_color',
                        'label'         => 'Accent Color',
                        'name'          => 'color',
                        'type'          => 'select',
                        'choices'       => array(
                            'gold' => 'Gold',
                            'cyan' => 'Cyan',
                        ),
                        'default_value' => 'gold',
                    ),
                    array(
                        'key'   => 'field_baka_package_featured',
                        'label' => 'Featured',
                        'name'  => 'featured',
                        'type'  => 'true_false',
                    ),
                    array(
                        'key'           => 'field_baka_package_featured_badge',
                        'label'         => 'Featured Badge',
                        'name'          => 'featured_badge',
                        'type'          => 'text',
                        'instructions'  => 'Shown above the card when Featured is on.',
                        'default_value' => 'الباقة الأكثر طلباً والأنسب للنمو',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'baka-options',
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
