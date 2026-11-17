<?php
//******************** ACF Options: Analytics ********************//

// Register the "Analytics" options page.
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title'    => 'Analytics',
        'menu_title'    => 'Analytics',
        'menu_slug'     => 'analytics-options',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-chart-bar',
        'position'      => 60,
        'redirect'      => false,
        'update_button' => 'Save Analytics',
    ) );
}

// Register the fields of the analytics section.
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_analytics_options',
        'title'    => 'Analytics',
        'fields'   => array(

            // ----- Key Metrics -----
            array(
                'key'   => 'field_analytics_tab_stats',
                'label' => 'Key Metrics',
                'type'  => 'tab',
            ),
            array(
                'key'          => 'field_analytics_stats',
                'label'        => 'Metrics',
                'name'         => 'analytics_stats',
                'type'         => 'repeater',
                'instructions' => 'Leave the value or the label empty to hide this metric.',
                'layout'       => 'table',
                'button_label' => 'Add Metric',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_analytics_stat_value',
                        'label' => 'Value',
                        'name'  => 'value',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_analytics_stat_label',
                        'label' => 'Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ),
                    array(
                        'key'           => 'field_analytics_stat_color',
                        'label'         => 'Value Color',
                        'name'          => 'color',
                        'type'          => 'select',
                        'choices'       => array(
                            'gold'    => 'Gold',
                            'cyan'    => 'Cyan',
                            'emerald' => 'Emerald',
                            'white'   => 'White',
                        ),
                        'default_value' => 'gold',
                    ),
                ),
            ),

            // ----- Client Partners -----
            array(
                'key'   => 'field_analytics_tab_partners',
                'label' => 'Client Partners',
                'type'  => 'tab',
            ),
            array(
                'key'   => 'field_analytics_partners_title',
                'label' => 'Slider Heading',
                'name'  => 'analytics_partners_title',
                'type'  => 'text',
                'instructions' => 'Leave empty to hide the heading above the logo slider.',
            ),
            array(
                'key'          => 'field_analytics_partners',
                'label'        => 'Partner Logos',
                'name'         => 'analytics_partners',
                'type'         => 'repeater',
                'instructions' => 'Each logo scrolls in the infinite slider. Logos without an image are not shown.',
                'layout'       => 'table',
                'button_label' => 'Add Logo',
                'sub_fields'   => array(
                    array(
                        'key'           => 'field_analytics_partner_logo',
                        'label'         => 'Logo',
                        'name'          => 'logo',
                        'type'          => 'image',
                        'return_format' => 'array',
                        'preview_size'  => 'medium',
                        'mime_types'    => 'jpg, jpeg, png, webp, svg',
                    ),
                    array(
                        'key'   => 'field_analytics_partner_name',
                        'label' => 'Name / Alt Text',
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'analytics-options',
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
