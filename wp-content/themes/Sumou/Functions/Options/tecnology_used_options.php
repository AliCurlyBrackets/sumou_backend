<?php
//******************** ACF Options: Tecnology Used ********************//

// Register the "Tecnology Used" options page.
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title'    => 'Tecnology Used',
        'menu_title'    => 'Tecnology Used',
        'menu_slug'     => 'tecnology-used-options',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-code-standards',
        'position'      => 62,
        'redirect'      => false,
        'update_button' => 'Save Tecnology Used',
    ) );
}

// Register the fields of the technology section.
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_tecnology_used_options',
        'title'    => 'Tecnology Used',
        'fields'   => array(

            // ----- Content -----
            array(
                'key'   => 'field_tecnology_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_tecnology_badge',
                'label'         => 'Badge Text',
                'name'          => 'tecnology_badge',
                'type'          => 'text',
                'default_value' => 'ترسانة الابتكار والتقنية',
            ),
            array(
                'key'           => 'field_tecnology_title',
                'label'         => 'Heading',
                'name'          => 'tecnology_title',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'نعمل بأقوى ما توصلت إليه',
            ),
            array(
                'key'           => 'field_tecnology_title_highlight',
                'label'         => 'Heading Highlight',
                'name'          => 'tecnology_title_highlight',
                'type'          => 'text',
                'instructions'  => 'The gold gradient part of the heading.',
                'default_value' => 'التقنيات السحابية وهندسة البرمجيات',
            ),

            // ----- Technologies -----
            array(
                'key'   => 'field_tecnology_tab_items',
                'label' => 'Technologies',
                'type'  => 'tab',
            ),
            array(
                'key'          => 'field_tecnology_items',
                'label'        => 'Technologies',
                'name'         => 'tecnology_items',
                'type'         => 'repeater',
                'instructions' => 'Leave the label empty to hide this technology.',
                'layout'       => 'table',
                'button_label' => 'Add Technology',
                'sub_fields'   => array(
                    array(
                        'key'           => 'field_tecnology_item_icon',
                        'label'         => 'Icon',
                        'name'          => 'icon',
                        'type'          => 'text',
                        'instructions'  => 'Font Awesome class, e.g. fa-brands fa-react',
                        'default_value' => 'fa-brands fa-react',
                    ),
                    array(
                        'key'           => 'field_tecnology_item_icon_color',
                        'label'         => 'Icon Color',
                        'name'          => 'icon_color',
                        'type'          => 'select',
                        'choices'       => array(
                            'cyan'        => 'Cyan',
                            'amber-light' => 'Light Amber',
                            'blue-light'  => 'Light Blue',
                            'red'         => 'Red',
                            'amber'       => 'Amber',
                            'blue'        => 'Blue',
                            'blue-deep'   => 'Deep Blue',
                            'gold'        => 'Gold',
                        ),
                        'default_value' => 'cyan',
                    ),
                    array(
                        'key'   => 'field_tecnology_item_text',
                        'label' => 'Label',
                        'name'  => 'text',
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
                    'value'    => 'tecnology-used-options',
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
