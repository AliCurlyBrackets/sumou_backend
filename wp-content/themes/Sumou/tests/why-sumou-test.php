<?php
/**
 * Standalone checks for the Why Sumou ACF options page and template part.
 *
 * Run from the theme directory: php tests/why-sumou-test.php
 */

$theme = dirname( __DIR__ );

$GLOBALS['acf_pages']  = array();
$GLOBALS['acf_groups'] = array();
$GLOBALS['acf_values'] = array();
$GLOBALS['failures']   = 0;

function acf_add_options_page( $page ) {
    $GLOBALS['acf_pages'][] = $page;
    return true;
}

function acf_add_local_field_group( $group ) {
    $GLOBALS['acf_groups'][] = $group;
    return true;
}

function get_field( $name, $post_id = '' ) {
    return array_key_exists( $name, $GLOBALS['acf_values'] ) ? $GLOBALS['acf_values'][ $name ] : null;
}

function wp_get_attachment_image_url( $id, $size = 'full' ) {
    return 'attachment-' . $id . '-' . $size . '.png';
}

function esc_html( $value ) {
    return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8' );
}

function esc_attr( $value ) {
    return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8' );
}

function esc_url( $value ) {
    return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8' );
}

function check( $label, $condition, $detail = '' ) {
    if ( $condition ) {
        echo "PASS  {$label}\n";
        return;
    }
    $GLOBALS['failures']++;
    echo "FAIL  {$label}" . ( '' !== $detail ? "  -> {$detail}" : '' ) . "\n";
}

function render_why_sumou( $theme ) {
    ob_start();
    include $theme . '/template-parts/why_sumou.php';
    return ob_get_clean();
}

function find_by( $items, $key, $value ) {
    foreach ( $items as $item ) {
        if ( ( $item[ $key ] ?? null ) === $value ) {
            return $item;
        }
    }
    return null;
}

// hero_section_options.php provides the shared sumou_option() reader.
require $theme . '/Functions/Options/hero_section_options.php';
require $theme . '/Functions/Options/why_sumou_options.php';

$page = find_by( $GLOBALS['acf_pages'], 'menu_slug', 'why-sumou-options' );
check( 'options page registered', null !== $page );
check( 'options page title', 'Why Sumou' === ( $page['page_title'] ?? '' ) );
check( 'options page capability', 'edit_posts' === ( $page['capability'] ?? '' ) );

$group = find_by( $GLOBALS['acf_groups'], 'key', 'group_why_sumou_options' );
check( 'field group registered', null !== $group );
check( 'field group attached to the options page', 'options_page' === ( $group['location'][0][0]['param'] ?? '' ) && 'why-sumou-options' === ( $group['location'][0][0]['value'] ?? '' ) );

$field_names = array();
foreach ( $group['fields'] ?? array() as $field ) {
    if ( isset( $field['name'] ) ) {
        $field_names[] = $field['name'];
    }
    foreach ( $field['sub_fields'] ?? array() as $sub_field ) {
        if ( isset( $sub_field['name'] ) ) {
            $field_names[] = $field['name'] . '.' . $sub_field['name'];
        }
    }
}
$expected_fields = array(
    'why_sumou_badge',
    'why_sumou_title',
    'why_sumou_title_highlight',
    'why_sumou_description',
    'why_sumou_pillars',
    'why_sumou_pillars.title',
    'why_sumou_pillars.description',
    'why_sumou_pillars.color',
    'why_sumou_image',
    'why_sumou_image_alt',
    'why_sumou_emblem_title',
    'why_sumou_emblem_subtitle',
    'why_sumou_tag_icon',
    'why_sumou_tag_text',
);
$missing_fields = array_diff( $expected_fields, $field_names );
check( 'all fields registered', array() === array_values( $missing_fields ), 'missing=' . implode( ',', $missing_fields ) );

// Empty options fall back to the shipped content.
$GLOBALS['acf_values'] = array();
$html                  = render_why_sumou( $theme );
check( 'default badge', strpos( $html, 'لماذا وكالة سمو؟' ) !== false );
check( 'default heading', strpos( $html, 'لا نقدّم وعوداً رنانة، بل نصيغ' ) !== false );
check( 'default highlight', strpos( $html, 'معادلات نمو هندسية حتمية' ) !== false );
check( 'default image', strpos( $html, 'lh3.googleusercontent.com' ) !== false );
check( 'default pillars', 4 === substr_count( $html, 'glass-luxury p-5' ), 'count=' . substr_count( $html, 'glass-luxury p-5' ) );
check( 'pillars numbered from one', strpos( $html, '>01<' ) !== false && strpos( $html, '>04<' ) !== false );
check( 'default pillar colors', strpos( $html, 'bg-amber-500/20 text-brand-gold' ) !== false && strpos( $html, 'bg-cyan-500/20 text-cyan-400' ) !== false );

// Saved options replace every editable part of the section.
$GLOBALS['acf_values'] = array(
    'why_sumou_badge'           => 'Custom Badge',
    'why_sumou_title'           => 'Custom Heading',
    'why_sumou_title_highlight' => 'Custom Highlight',
    'why_sumou_description'     => 'Custom description.',
    'why_sumou_pillars'         => array(
        array(
            'title'       => 'Pillar One',
            'description' => 'First body',
            'color'       => 'cyan',
        ),
        array(
            'title'       => '',
            'description' => 'Hidden body',
            'color'       => 'gold',
        ),
        array(
            'title'       => 'Pillar Two',
            'description' => 'Second body',
            'color'       => 'gold',
        ),
    ),
    'why_sumou_image'           => array( 'url' => 'https://example.test/emblem.png' ),
    'why_sumou_image_alt'       => 'Custom Alt',
    'why_sumou_emblem_title'    => 'Custom Emblem',
    'why_sumou_emblem_subtitle' => 'CUSTOM SUBTITLE',
    'why_sumou_tag_icon'        => 'fa-solid fa-bolt',
    'why_sumou_tag_text'        => 'Custom tag',
);
$html = render_why_sumou( $theme );
check( 'saved badge', strpos( $html, 'Custom Badge' ) !== false );
check( 'saved heading', strpos( $html, 'Custom Heading' ) !== false );
check( 'saved highlight', strpos( $html, 'Custom Highlight' ) !== false );
check( 'saved description', strpos( $html, 'Custom description.' ) !== false );
check( 'saved image', strpos( $html, 'src="https://example.test/emblem.png"' ) !== false );
check( 'saved image alt', strpos( $html, 'alt="Custom Alt"' ) !== false );
check( 'saved emblem', strpos( $html, 'Custom Emblem' ) !== false && strpos( $html, 'CUSTOM SUBTITLE' ) !== false );
check( 'saved tag', strpos( $html, 'fa-solid fa-bolt' ) !== false && strpos( $html, 'Custom tag' ) !== false );
check( 'pillar without a title is hidden', strpos( $html, 'Hidden body' ) === false );
check( 'empty pillar keeps numbering in order', 2 === substr_count( $html, 'glass-luxury p-5' ) && strpos( $html, '>02<' ) !== false && strpos( $html, '>03<' ) === false );
check( 'pillar color applied', 1 === substr_count( $html, 'bg-cyan-500/20 text-cyan-400' ) );
check( 'defaults replaced', strpos( $html, 'لماذا وكالة سمو؟' ) === false );

// Subtle resolution and escaping.
$GLOBALS['acf_values'] = array(
    'why_sumou_image' => 42,
    'why_sumou_title' => '<script>alert(1)</script>',
);
$html = render_why_sumou( $theme );
check( 'attachment id resolved to a url', strpos( $html, 'attachment-42-full.png' ) !== false );
check( 'saved title is escaped', strpos( $html, '<script>alert(1)</script>' ) === false && strpos( $html, '&lt;script&gt;' ) !== false );

// A repeater value that is not an array cannot break the section.
$GLOBALS['acf_values'] = array( 'why_sumou_pillars' => 'not-an-array' );
$html                  = render_why_sumou( $theme );
check( 'invalid pillars fall back', 4 === substr_count( $html, 'glass-luxury p-5' ), 'count=' . substr_count( $html, 'glass-luxury p-5' ) );

echo 0 === $GLOBALS['failures'] ? "\nOK\n" : "\n{$GLOBALS['failures']} FAILURE(S)\n";
exit( 0 === $GLOBALS['failures'] ? 0 : 1 );
