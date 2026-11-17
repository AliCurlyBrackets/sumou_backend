<?php
//******************** ACF Options: Hero Section ********************//

/**
 * Read an ACF option value with a fallback when ACF is not active.
 *
 * @param string $name    Field name.
 * @param mixed  $default Fallback value.
 * @return mixed
 */
function sumou_option( $name, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $name, 'option' );
        if ( $value !== null && $value !== '' && $value !== false ) {
            return $value;
        }
    }
    return $default;
}

// Register the "Hero Section" options page.
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title'  => 'Hero Section',
        'menu_title'  => 'Hero Section',
        'menu_slug'   => 'hero-section-options',
        'capability'  => 'edit_posts',
        'icon_url'    => 'dashicons-cover-image',
        'position'    => 59,
        'redirect'    => false,
        'update_button' => 'Save Hero Section',
    ) );
}

// Register the fields of the hero section.
if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'      => 'group_hero_section_options',
        'title'    => 'Hero Section',
        'fields'   => array(

            // ----- Content -----
            array(
                'key'   => 'field_hero_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_hero_badge',
                'label'         => 'Badge Text',
                'name'          => 'hero_badge',
                'type'          => 'text',
                'default_value' => 'وكالة استراتيجية لنمو الأعمال الرقمية الذكية',
            ),
            array(
                'key'           => 'field_hero_title',
                'label'         => 'Headline',
                'name'          => 'hero_title',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'نصنع لعلامتك التجارية حضوراً رقمياً يعلو بها إلى',
            ),
            array(
                'key'           => 'field_hero_title_highlight',
                'label'         => 'Headline Highlight',
                'name'          => 'hero_title_highlight',
                'type'          => 'text',
                'instructions'  => 'The gold gradient part of the headline.',
                'default_value' => 'قمم السمو والريادة',
            ),
            array(
                'key'           => 'field_hero_subtitle',
                'label'         => 'Subtitle',
                'name'          => 'hero_subtitle',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'ندمج قوة الذكاء الاصطناعي وهندسة البرمجيات المتطورة والتسويق عالي الأداء لمضاعفة إيرادات شركتك، تصدّر محركات البحث، وبناء هوية راسخة تنافس عالمياً.',
            ),

            // ----- Buttons -----
            array(
                'key'   => 'field_hero_tab_buttons',
                'label' => 'Buttons',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_hero_cta1_label',
                'label'         => 'Primary Button Label',
                'name'          => 'hero_cta1_label',
                'type'          => 'text',
                'default_value' => 'ابدأ مشروعك الآن',
            ),
            array(
                'key'           => 'field_hero_cta1_link',
                'label'         => 'Primary Button Link',
                'name'          => 'hero_cta1_link',
                'type'          => 'link',
                'return_format' => 'array',
            ),
            array(
                'key'           => 'field_hero_cta1_icon',
                'label'         => 'Primary Button Icon',
                'name'          => 'hero_cta1_icon',
                'type'          => 'text',
                'instructions'  => 'Font Awesome class, e.g. fa-solid fa-arrow-left',
                'default_value' => 'fa-solid fa-arrow-left',
            ),
            array(
                'key'           => 'field_hero_cta2_label',
                'label'         => 'Secondary Button Label',
                'name'          => 'hero_cta2_label',
                'type'          => 'text',
                'default_value' => 'استكشف سابقة الأعمال',
            ),
            array(
                'key'           => 'field_hero_cta2_link',
                'label'         => 'Secondary Button Link',
                'name'          => 'hero_cta2_link',
                'type'          => 'link',
                'return_format' => 'array',
            ),
            array(
                'key'           => 'field_hero_cta2_icon',
                'label'         => 'Secondary Button Icon',
                'name'          => 'hero_cta2_icon',
                'type'          => 'text',
                'instructions'  => 'Font Awesome class, e.g. fa-solid fa-circle-play',
                'default_value' => 'fa-solid fa-circle-play',
            ),

            // ----- Trust Indicators -----
            array(
                'key'   => 'field_hero_tab_trust',
                'label' => 'Trust Indicators',
                'type'  => 'tab',
            ),
            array(
                'key'          => 'field_hero_trust_items',
                'label'        => 'Trust Indicators',
                'name'         => 'hero_trust_items',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Indicator',
                'sub_fields'   => array(
                    array(
                        'key'           => 'field_hero_trust_icon',
                        'label'         => 'Icon',
                        'name'          => 'icon',
                        'type'          => 'text',
                        'instructions'  => 'Font Awesome class, e.g. fa-solid fa-shield-halved',
                        'default_value' => 'fa-solid fa-shield-halved',
                    ),
                    array(
                        'key'           => 'field_hero_trust_icon_color',
                        'label'         => 'Icon Color',
                        'name'          => 'icon_color',
                        'type'          => 'select',
                        'choices'       => array(
                            'gold'    => 'Gold',
                            'cyan'    => 'Cyan',
                            'emerald' => 'Emerald',
                            'amber'   => 'Amber',
                        ),
                        'default_value' => 'gold',
                    ),
                    array(
                        'key'   => 'field_hero_trust_text',
                        'label' => 'Text',
                        'name'  => 'text',
                        'type'  => 'text',
                    ),
                ),
            ),

            // ----- Visual -----
            array(
                'key'   => 'field_hero_tab_visual',
                'label' => 'Visual',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_hero_image',
                'label'         => 'Emblem Image',
                'name'          => 'hero_image',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'mime_types'    => 'jpg, jpeg, png, webp, svg',
            ),
            array(
                'key'           => 'field_hero_image_alt',
                'label'         => 'Emblem Image Alt',
                'name'          => 'hero_image_alt',
                'type'          => 'text',
                'default_value' => 'شعار سمو الذهبي',
            ),
            array(
                'key'           => 'field_hero_seo_label',
                'label'         => 'SEO Badge Label',
                'name'          => 'hero_seo_label',
                'type'          => 'text',
                'default_value' => 'محركات البحث',
            ),
            array(
                'key'           => 'field_hero_seo_value',
                'label'         => 'SEO Badge Value',
                'name'          => 'hero_seo_value',
                'type'          => 'text',
                'default_value' => 'SEO Score: 99.8%',
            ),
            array(
                'key'           => 'field_hero_ai_label',
                'label'         => 'AI Badge Label',
                'name'          => 'hero_ai_label',
                'type'          => 'text',
                'default_value' => 'الذكاء الاصطناعي',
            ),
            array(
                'key'           => 'field_hero_ai_value',
                'label'         => 'AI Badge Value',
                'name'          => 'hero_ai_value',
                'type'          => 'text',
                'default_value' => 'AI Engine Active',
            ),
            array(
                'key'           => 'field_hero_growth_text',
                'label'         => 'Growth Badge Text',
                'name'          => 'hero_growth_text',
                'type'          => 'text',
                'default_value' => '+320% نمو الأرباح',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'hero-section-options',
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
