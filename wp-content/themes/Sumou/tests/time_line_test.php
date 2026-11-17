<?php
/**
 * Render tests for the "Time Line" ACF options page and template part.
 *
 * Run with: php tests/time_line_test.php
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

function wp_get_attachment_image_url( $id, $size = 'thumbnail' ) {
    return '';
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

function render_time_line_part() {
    global $theme_dir;
    ob_start();
    include $theme_dir . '/template-parts/time_line.php';
    return ob_get_clean();
}

function find_time_line_group() {
    foreach ( $GLOBALS['test_field_groups'] as $group ) {
        $location = $group['location'][0][0] ?? array();
        if ( ( $location['value'] ?? '' ) === 'time-line-options' ) {
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

include $theme_dir . '/Functions/Options/hero_section_options.php';
include $theme_dir . '/Functions/Options/time_line_options.php';

$time_line_page = null;
foreach ( $GLOBALS['test_options_pages'] as $page ) {
    if ( ( $page['menu_slug'] ?? '' ) === 'time-line-options' ) {
        $time_line_page = $page;
        break;
    }
}

assert_true( null !== $time_line_page, 'The "Time Line" ACF options page is registered' );
assert_true( 'Time Line' === ( $time_line_page['page_title'] ?? '' ), 'The options page title is "Time Line"' );
assert_true( 'Time Line' === ( $time_line_page['menu_title'] ?? '' ), 'The options menu title is "Time Line"' );

$time_line_group = find_time_line_group();
assert_true( null !== $time_line_group, 'The Time Line field group is bound to the time-line-options page' );

$steps_field = find_group_field( $time_line_group, 'time_line_steps' );
assert_true( null !== $steps_field, 'The options group has a time_line_steps field' );
assert_true( 'repeater' === ( $steps_field['type'] ?? '' ), 'time_line_steps is a repeater' );

$sub_field_names = array_map( function ( $field ) {
    return $field['name'] ?? '';
}, $steps_field['sub_fields'] ?? array() );
foreach ( array( 'number', 'title', 'description', 'color' ) as $sub_field_name ) {
    assert_true( in_array( $sub_field_name, $sub_field_names, true ), 'time_line_steps has a ' . $sub_field_name . ' sub field' );
}

$default_output = render_time_line_part();
assert_contains( 'منهجية التنفيذ الرصينة', $default_output, 'The default badge is rendered' );
assert_contains( 'مسار عمل هندسي دقيق يقودك نحو', $default_output, 'The default title is rendered' );
assert_contains( 'القمة', $default_output, 'The default title highlight is rendered' );
assert_contains( 'خطوات واضحة وشفافة تبدأ بالتحليل وتنتهي بالنجاح المتسارع المستدام.', $default_output, 'The default subtitle is rendered' );
assert_contains( 'الاستشارة والتحليل', $default_output, 'The first default step is rendered' );
assert_contains( 'النمو والمضاعفة', $default_output, 'The last default step is rendered' );
assert_true( 5 === substr_count( $default_output, 'glass-luxury p-6' ), 'Five default step cards are rendered' );

$GLOBALS['test_field_values'] = array(
    'time_line_badge'           => 'شارة مخصصة',
    'time_line_title'           => 'عنوان مخصص',
    'time_line_title_highlight' => 'تمييز مخصص',
    'time_line_subtitle'        => 'وصف مخصص',
    'time_line_steps'           => array(
        array(
            'number'      => '07',
            'title'       => 'خطوة مخصصة',
            'description' => 'وصف الخطوة المخصصة',
            'color'       => 'cyan',
        ),
        array(
            'number'      => '08',
            'title'       => '',
            'description' => 'خطوة بدون عنوان',
            'color'       => 'gold',
        ),
    ),
);

$configured_output = render_time_line_part();
assert_contains( 'شارة مخصصة', $configured_output, 'The configured badge is rendered' );
assert_contains( 'عنوان مخصص', $configured_output, 'The configured title is rendered' );
assert_contains( 'تمييز مخصص', $configured_output, 'The configured title highlight is rendered' );
assert_contains( 'وصف مخصص', $configured_output, 'The configured subtitle is rendered' );
assert_contains( 'خطوة مخصصة', $configured_output, 'The configured step title is rendered' );
assert_contains( 'وصف الخطوة المخصصة', $configured_output, 'The configured step description is rendered' );
assert_contains( '07', $configured_output, 'The configured step number is rendered' );
assert_contains( 'text-cyan-400', $configured_output, 'The configured step colour is rendered' );
assert_not_contains( 'الاستشارة والتحليل', $configured_output, 'The default steps are replaced by the configured ones' );
assert_not_contains( 'خطوة بدون عنوان', $configured_output, 'A step without a title is not rendered' );
assert_true( 1 === substr_count( $configured_output, 'glass-luxury p-6' ), 'Only the configured steps with a title are rendered' );

$GLOBALS['test_field_values']['time_line_badge'] = '<script>alert(1)</script>';
$escaped_output = render_time_line_part();
assert_not_contains( '<script>', $escaped_output, 'Option values are escaped in the markup' );
assert_contains( '&lt;script&gt;alert(1)&lt;/script&gt;', $escaped_output, 'Option values are HTML encoded' );

$GLOBALS['test_field_values'] = array(
    'time_line_badge'           => '',
    'time_line_title'           => '',
    'time_line_title_highlight' => '',
    'time_line_subtitle'        => '',
    'time_line_steps'           => array(),
);

$fallback_output = render_time_line_part();
assert_contains( 'منهجية التنفيذ الرصينة', $fallback_output, 'An empty badge falls back to the default copy' );
assert_contains( 'الاستشارة والتحليل', $fallback_output, 'An empty step list falls back to the default steps' );

if ( $GLOBALS['test_failures'] ) {
    echo 'FAIL (' . count( $GLOBALS['test_failures'] ) . '/' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
    foreach ( $GLOBALS['test_failures'] as $failure ) {
        echo ' - ' . $failure . PHP_EOL;
    }
    exit( 1 );
}

echo 'OK (' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
