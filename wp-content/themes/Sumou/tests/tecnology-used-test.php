<?php
/**
 * Render tests for the "Tecnology Used" ACF options page and template part.
 *
 * Run with: php tests/tecnology-used-test.php
 */

error_reporting( E_ALL );

$theme_dir = dirname( __DIR__ );

$GLOBALS['test_options_pages'] = array();
$GLOBALS['test_field_groups']  = array();
$GLOBALS['test_field_values']  = array();
$GLOBALS['test_failures']      = array();
$GLOBALS['test_assertions']    = 0;

function acf_add_options_page( $page ) {
    $GLOBALS['test_options_pages'][] = $page;
}

function acf_add_local_field_group( $group ) {
    $GLOBALS['test_field_groups'][] = $group;
}

function get_field( $name, $post_id = null ) {
    return $GLOBALS['test_field_values'][ $name ] ?? null;
}

function esc_html( $text ) {
    return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}

function esc_attr( $text ) {
    return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}

function esc_url( $url ) {
    return htmlspecialchars( (string) $url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}

function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
}

function add_theme_support( $feature ) {
}

function assert_true( $condition, $message ) {
    $GLOBALS['test_assertions']++;
    if ( ! $condition ) {
        $GLOBALS['test_failures'][] = $message;
    }
}

function assert_contains( $needle, $haystack, $message ) {
    assert_true( false !== strpos( $haystack, $needle ), $message . ' (missing: ' . $needle . ')' );
}

function assert_not_contains( $needle, $haystack, $message ) {
    assert_true( false === strpos( $haystack, $needle ), $message . ' (unexpected: ' . $needle . ')' );
}

function render_tecnology_part() {
    global $theme_dir;
    ob_start();
    include $theme_dir . '/template-parts/tecnology_used.php';
    return ob_get_clean();
}

function find_tecnology_page() {
    foreach ( $GLOBALS['test_options_pages'] as $page ) {
        if ( ( $page['menu_slug'] ?? '' ) === 'tecnology-used-options' ) {
            return $page;
        }
    }
    return null;
}

function find_tecnology_group() {
    foreach ( $GLOBALS['test_field_groups'] as $group ) {
        $location = $group['location'][0][0] ?? array();
        if ( ( $location['value'] ?? '' ) === 'tecnology-used-options' ) {
            return $group;
        }
    }
    return null;
}

function find_group_field( $group, $name ) {
    if ( ! $group ) {
        return null;
    }
    foreach ( $group['fields'] as $field ) {
        if ( ( $field['name'] ?? '' ) === $name ) {
            return $field;
        }
    }
    return null;
}

include $theme_dir . '/functions.php';

$tecnology_page = find_tecnology_page();
assert_true( null !== $tecnology_page, 'The "Tecnology Used" ACF options page is registered' );
assert_true( 'Tecnology Used' === ( $tecnology_page['page_title'] ?? '' ), 'The options page title is "Tecnology Used"' );
assert_true( 'Tecnology Used' === ( $tecnology_page['menu_title'] ?? '' ), 'The options menu title is "Tecnology Used"' );
assert_true( 'edit_posts' === ( $tecnology_page['capability'] ?? '' ), 'The options page requires edit_posts' );

$functions_source = file_get_contents( $theme_dir . '/functions.php' );
assert_contains( 'Functions/Options/tecnology_used_options.php', $functions_source, 'functions.php loads the Tecnology Used options registration' );

$index_source = file_get_contents( $theme_dir . '/index.php' );
assert_contains( 'template-parts/tecnology_used', $index_source, 'The front page renders the Tecnology Used template part' );

$tecnology_group = find_tecnology_group();
assert_true( null !== $tecnology_group, 'The Tecnology Used field group is bound to the options page' );

$badge_field = find_group_field( $tecnology_group, 'tecnology_badge' );
assert_true( null !== $badge_field, 'The options group has a tecnology_badge field' );
$title_field = find_group_field( $tecnology_group, 'tecnology_title' );
assert_true( null !== $title_field, 'The options group has a tecnology_title field' );
$highlight_field = find_group_field( $tecnology_group, 'tecnology_title_highlight' );
assert_true( null !== $highlight_field, 'The options group has a tecnology_title_highlight field' );

$items_field = find_group_field( $tecnology_group, 'tecnology_items' );
assert_true( null !== $items_field, 'The options group has a tecnology_items field' );
assert_true( 'repeater' === ( $items_field['type'] ?? '' ), 'tecnology_items is a repeater' );

$sub_field_names = array_map( function ( $field ) {
    return $field['name'] ?? '';
}, $items_field['sub_fields'] ?? array() );
foreach ( array( 'icon', 'icon_color', 'text' ) as $sub_field_name ) {
    assert_true( in_array( $sub_field_name, $sub_field_names, true ), 'tecnology_items has a ' . $sub_field_name . ' sub field' );
}

$default_output = render_tecnology_part();
assert_contains( 'ترسانة الابتكار والتقنية', $default_output, 'The default badge is rendered' );
assert_contains( 'نعمل بأقوى ما توصلت إليه', $default_output, 'The default title is rendered' );
assert_contains( 'التقنيات السحابية وهندسة البرمجيات', $default_output, 'The default title highlight is rendered' );
assert_contains( 'React / Next.js 14', $default_output, 'The first default technology is rendered' );
assert_contains( 'Meta Marketing API', $default_output, 'The last default technology is rendered' );
assert_true( 7 === substr_count( $default_output, 'glass-luxury px-5 py-3' ), 'Seven default technology badges are rendered' );
assert_contains( 'text-cyan-400', $default_output, 'The default icon color is rendered' );
assert_contains( 'hover:border-amber-500', $default_output, 'The default hover border color is rendered' );
assert_contains( 'hover:border-blue-600', $default_output, 'The default Meta badge keeps its blue hover color' );

$GLOBALS['test_field_values'] = array(
    'tecnology_badge'           => 'شارة مخصصة',
    'tecnology_title'           => 'عنوان مخصص',
    'tecnology_title_highlight' => 'تمييز مخصص',
    'tecnology_items'           => array(
        array(
            'icon'       => 'fa-solid fa-bolt',
            'icon_color' => 'red',
            'text'       => 'تقنية مخصصة',
        ),
        array(
            'icon'       => 'fa-solid fa-star',
            'icon_color' => 'unknown',
            'text'       => 'تقنية بلون افتراضي',
        ),
        array(
            'icon'       => 'fa-solid fa-cog',
            'icon_color' => 'cyan',
            'text'       => '',
        ),
    ),
);

$configured_output = render_tecnology_part();
assert_contains( 'شارة مخصصة', $configured_output, 'The configured badge is rendered' );
assert_contains( 'عنوان مخصص', $configured_output, 'The configured title is rendered' );
assert_contains( 'تمييز مخصص', $configured_output, 'The configured title highlight is rendered' );
assert_contains( 'fa-solid fa-bolt', $configured_output, 'The configured icon is rendered' );
assert_contains( 'تقنية مخصصة', $configured_output, 'The configured technology is rendered' );
assert_contains( 'text-red-500', $configured_output, 'The configured icon color is rendered' );
assert_contains( 'hover:border-red-400', $configured_output, 'The configured hover border color is rendered' );
assert_contains( 'تقنية بلون افتراضي', $configured_output, 'A technology with an unknown color is still rendered' );
assert_contains( 'text-brand-gold', $configured_output, 'An unknown color falls back to gold' );
assert_not_contains( 'React / Next.js 14', $configured_output, 'The default technologies are replaced by the configured ones' );
assert_not_contains( 'fa-solid fa-cog', $configured_output, 'A technology without a label is not rendered' );
assert_true( 2 === substr_count( $configured_output, 'glass-luxury px-5 py-3' ), 'Only the configured technologies with a label are rendered' );

$GLOBALS['test_field_values']['tecnology_badge'] = '<script>alert(1)</script>';
$escaped_output = render_tecnology_part();
assert_not_contains( '<script>', $escaped_output, 'Option values are escaped in the markup' );
assert_contains( '&lt;script&gt;alert(1)&lt;/script&gt;', $escaped_output, 'Option values are HTML encoded' );

$GLOBALS['test_field_values'] = array(
    'tecnology_badge'           => '',
    'tecnology_title'           => '',
    'tecnology_title_highlight' => '',
    'tecnology_items'           => array(),
);

$fallback_output = render_tecnology_part();
assert_contains( 'ترسانة الابتكار والتقنية', $fallback_output, 'An empty badge falls back to the default copy' );
assert_contains( 'React / Next.js 14', $fallback_output, 'An empty technology list falls back to the default technologies' );
assert_true( 7 === substr_count( $fallback_output, 'glass-luxury px-5 py-3' ), 'Seven default badges are rendered after empty options' );

if ( $GLOBALS['test_failures'] ) {
    echo 'FAIL (' . count( $GLOBALS['test_failures'] ) . '/' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
    foreach ( $GLOBALS['test_failures'] as $failure ) {
        echo ' - ' . $failure . PHP_EOL;
    }
    exit( 1 );
}

echo 'OK (' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
