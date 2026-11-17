<?php
//******************** ACF Options: Why Sumou ********************//

// Register the "Why Sumou" options page.
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title'    => 'Why Sumou',
        'menu_title'    => 'Why Sumou',
        'menu_slug'     => 'why-sumou-options',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-awards',
        'position'      => 61,
        'redirect'      => false,
        'update_button' => 'Save Why Sumou',
    ) );
}

// Register the fields of the why sumou section.
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_why_sumou_options',
        'title'    => 'Why Sumou',
        'fields'   => array(

            // ----- Content -----
            array(
                'key'   => 'field_why_sumou_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_why_sumou_badge',
                'label'         => 'Badge Text',
                'name'          => 'why_sumou_badge',
                'type'          => 'text',
                'default_value' => 'لماذا وكالة سمو؟',
            ),
            array(
                'key'           => 'field_why_sumou_title',
                'label'         => 'Heading',
                'name'          => 'why_sumou_title',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'لا نقدّم وعوداً رنانة، بل نصيغ',
            ),
            array(
                'key'           => 'field_why_sumou_title_highlight',
                'label'         => 'Heading Highlight',
                'name'          => 'why_sumou_title_highlight',
                'type'          => 'text',
                'instructions'  => 'The gold gradient part of the heading.',
                'default_value' => 'معادلات نمو هندسية حتمية',
            ),
            array(
                'key'           => 'field_why_sumou_description',
                'label'         => 'Description',
                'name'          => 'why_sumou_description',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'تأسست "سُـمـوّ" لردم الفجوة بين التقنيات البرمجية المعقدة والاستراتيجيات التسويقية المربحة. نحن نعمل كامتداد استراتيجي لمجلس إدارتك وفريقك الداخلي.',
            ),

            // ----- Pillars -----
            array(
                'key'   => 'field_why_sumou_tab_pillars',
                'label' => 'Pillars',
                'type'  => 'tab',
            ),
            array(
                'key'          => 'field_why_sumou_pillars',
                'label'        => 'Pillars',
                'name'         => 'why_sumou_pillars',
                'type'         => 'repeater',
                'instructions' => 'Leave the title empty to hide this pillar.',
                'layout'       => 'table',
                'button_label' => 'Add Pillar',
                'sub_fields'   => array(
                    array(
                        'key'   => 'field_why_sumou_pillar_title',
                        'label' => 'Title',
                        'name'  => 'title',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_why_sumou_pillar_description',
                        'label' => 'Description',
                        'name'  => 'description',
                        'type'  => 'textarea',
                        'rows'  => 2,
                    ),
                    array(
                        'key'           => 'field_why_sumou_pillar_color',
                        'label'         => 'Badge Color',
                        'name'          => 'color',
                        'type'          => 'select',
                        'choices'       => array(
                            'gold' => 'Gold',
                            'cyan' => 'Cyan',
                        ),
                        'default_value' => 'gold',
                    ),
                ),
            ),

            // ----- Visual -----
            array(
                'key'   => 'field_why_sumou_tab_visual',
                'label' => 'Visual',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_why_sumou_image',
                'label'         => 'Emblem Image',
                'name'          => 'why_sumou_image',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'mime_types'    => 'jpg, jpeg, png, webp, svg',
            ),
            array(
                'key'           => 'field_why_sumou_image_alt',
                'label'         => 'Emblem Image Alt',
                'name'          => 'why_sumou_image_alt',
                'type'          => 'text',
                'default_value' => 'رمز صقر السمو',
            ),
            array(
                'key'           => 'field_why_sumou_emblem_title',
                'label'         => 'Emblem Title',
                'name'          => 'why_sumou_emblem_title',
                'type'          => 'text',
                'default_value' => 'درع الحماية والنمو السيبراني',
            ),
            array(
                'key'           => 'field_why_sumou_emblem_subtitle',
                'label'         => 'Emblem Subtitle',
                'name'          => 'why_sumou_emblem_subtitle',
                'type'          => 'text',
                'default_value' => 'SUMOU ENTERPRISE GRADE',
            ),
            array(
                'key'           => 'field_why_sumou_tag_icon',
                'label'         => 'Floating Tag Icon',
                'name'          => 'why_sumou_tag_icon',
                'type'          => 'text',
                'instructions'  => 'Font Awesome class, e.g. fa-solid fa-shield-cat',
                'default_value' => 'fa-solid fa-shield-cat',
            ),
            array(
                'key'           => 'field_why_sumou_tag_text',
                'label'         => 'Floating Tag Text',
                'name'          => 'why_sumou_tag_text',
                'type'          => 'text',
                'default_value' => 'حماية وحوكمة بيانات 100%',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'why-sumou-options',
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
