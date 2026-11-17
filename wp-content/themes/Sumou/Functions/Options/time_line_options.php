<?php
//******************** ACF Options: Time Line ********************//

// Register the "Time Line" options page.
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title'    => 'Time Line',
        'menu_title'    => 'Time Line',
        'menu_slug'     => 'time-line-options',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-editor-ol',
        'position'      => 61,
        'redirect'      => false,
        'update_button' => 'Save Time Line',
    ) );
}

// Register the fields of the time line section.
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_time_line_options',
        'title'    => 'Time Line',
        'fields'   => array(

            // ----- Content -----
            array(
                'key'   => 'field_time_line_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_time_line_badge',
                'label'         => 'Badge Text',
                'name'          => 'time_line_badge',
                'type'          => 'text',
                'default_value' => 'منهجية التنفيذ الرصينة',
            ),
            array(
                'key'           => 'field_time_line_title',
                'label'         => 'Headline',
                'name'          => 'time_line_title',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'مسار عمل هندسي دقيق يقودك نحو',
            ),
            array(
                'key'           => 'field_time_line_title_highlight',
                'label'         => 'Headline Highlight',
                'name'          => 'time_line_title_highlight',
                'type'          => 'text',
                'instructions'  => 'The gold gradient part of the headline.',
                'default_value' => 'القمة',
            ),
            array(
                'key'           => 'field_time_line_subtitle',
                'label'         => 'Subtitle',
                'name'          => 'time_line_subtitle',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'خطوات واضحة وشفافة تبدأ بالتحليل وتنتهي بالنجاح المتسارع المستدام.',
            ),

            // ----- Steps -----
            array(
                'key'   => 'field_time_line_tab_steps',
                'label' => 'Steps',
                'type'  => 'tab',
            ),
            array(
                'key'          => 'field_time_line_steps',
                'label'        => 'Timeline Steps',
                'name'         => 'time_line_steps',
                'type'         => 'repeater',
                'instructions' => 'Steps without a title are not shown.',
                'layout'       => 'table',
                'button_label' => 'Add Step',
                'sub_fields'   => array(
                    array(
                        'key'          => 'field_time_line_step_number',
                        'label'        => 'Number',
                        'name'         => 'number',
                        'type'         => 'text',
                        'instructions' => 'Shown in the step badge, e.g. 01',
                    ),
                    array(
                        'key'   => 'field_time_line_step_title',
                        'label' => 'Title',
                        'name'  => 'title',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_time_line_step_description',
                        'label' => 'Description',
                        'name'  => 'description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ),
                    array(
                        'key'           => 'field_time_line_step_color',
                        'label'         => 'Accent Color',
                        'name'          => 'color',
                        'type'          => 'select',
                        'choices'       => array(
                            'gold'    => 'Gold',
                            'cyan'    => 'Cyan',
                            'emerald' => 'Emerald',
                        ),
                        'default_value' => 'gold',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'time-line-options',
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
