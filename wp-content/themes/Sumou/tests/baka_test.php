<?php
/**
 * Render tests for the "Baka" ACF options page and template part.
 *
 * Run with: php tests/baka_test.php
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

function esc_url( $text ) {
    return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
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

function render_baka_part() {
    global $theme_dir;
    ob_start();
    include $theme_dir . '/template-parts/baka.php';
    return ob_get_clean();
}

function find_baka_group() {
    foreach ( $GLOBALS['test_field_groups'] as $group ) {
        $location = $group['location'][0][0] ?? array();
        if ( ( $location['value'] ?? '' ) === 'baka-options' ) {
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

function baka_field_names( $group ) {
    $names = array();
    foreach ( $group['fields'] ?? array() as $field ) {
        if ( isset( $field['name'] ) ) {
            $names[] = $field['name'];
        }
        foreach ( $field['sub_fields'] ?? array() as $sub_field ) {
            if ( isset( $sub_field['name'] ) ) {
                $names[] = $sub_field['name'];
            }
        }
    }
    return $names;
}

include $theme_dir . '/Functions/Options/hero_section_options.php';

$baka_options_file = $theme_dir . '/Functions/Options/baka_options.php';
assert_true( file_exists( $baka_options_file ), 'The Baka options registration file exists' );
if ( file_exists( $baka_options_file ) ) {
    include $baka_options_file;
}

$baka_page = null;
foreach ( $GLOBALS['test_options_pages'] as $page ) {
    if ( ( $page['menu_slug'] ?? '' ) === 'baka-options' ) {
        $baka_page = $page;
        break;
    }
}

assert_true( null !== $baka_page, 'The "Baka" ACF options page is registered' );
assert_true( 'Baka' === ( $baka_page['page_title'] ?? '' ), 'The options page title is "Baka"' );
assert_true( 'Baka' === ( $baka_page['menu_title'] ?? '' ), 'The options menu title is "Baka"' );

$functions_source = file_get_contents( $theme_dir . '/functions.php' );
assert_contains( 'Functions/Options/baka_options.php', $functions_source, 'functions.php loads the Baka options registration' );

$index_source = file_get_contents( $theme_dir . '/index.php' );
assert_contains( 'template-parts/baka', $index_source, 'The front page renders the Baka template part' );

$baka_group = find_baka_group();
assert_true( null !== $baka_group, 'The Baka field group is bound to the baka-options page' );

$packages_field = find_group_field( $baka_group, 'baka_packages' );
assert_true( null !== $packages_field, 'The options group has a baka_packages field' );
assert_true( 'repeater' === ( $packages_field['type'] ?? '' ), 'baka_packages is a repeater' );

$sub_field_names = array_map( function ( $field ) {
    return $field['name'] ?? '';
}, $packages_field['sub_fields'] ?? array() );
foreach ( array( 'tier', 'name', 'description', 'features', 'cta_label', 'cta_link', 'color', 'featured', 'featured_badge' ) as $sub_field_name ) {
    assert_true( in_array( $sub_field_name, $sub_field_names, true ), 'baka_packages has a ' . $sub_field_name . ' sub field' );
}

$field_names = baka_field_names( $baka_group );
foreach ( array( 'baka_badge', 'baka_title', 'baka_title_highlight', 'baka_description' ) as $field_name ) {
    assert_true( in_array( $field_name, $field_names, true ), 'The options group has a ' . $field_name . ' field' );
}
foreach ( $field_names as $field_name ) {
    assert_true(
        false === stripos( $field_name, 'price' ) && false === stripos( $field_name, 'pricing' ) && false === stripos( $field_name, 'cost' ),
        'The Baka options have no price field (found: ' . $field_name . ')'
    );
}

$baka_source = file_get_contents( $theme_dir . '/template-parts/baka.php' );
foreach ( array( '3,900', '8,500', 'ريال', 'شهرياً', 'تخصيص كامل', 'حسب نطاق العمل المطلوب' ) as $price_text ) {
    assert_not_contains( $price_text, $baka_source, 'The Baka template has no "' . $price_text . '"' );
}

$default_output = render_baka_part();
assert_contains( 'باقات الاستثمار والنمو', $default_output, 'The default badge is rendered' );
assert_contains( 'استثمار مدروس يضمن', $default_output, 'The default title is rendered' );
assert_contains( 'عائدات تفوق التوقعات', $default_output, 'The default title highlight is rendered' );
assert_contains( 'اختر الباقة المناسبة لمرحلة نمو مشروعك الحالية', $default_output, 'The default description is rendered' );
assert_contains( 'Start Growth', $default_output, 'The first default package is rendered' );
assert_contains( 'Sumou Pro Scale', $default_output, 'The featured default package is rendered' );
assert_contains( 'Enterprise Sovereign', $default_output, 'The last default package is rendered' );
assert_contains( 'إدارة إعلانات ممولة لمنصتين مختارتين', $default_output, 'Default package features are rendered' );
assert_contains( 'الباقة الأكثر طلباً والأنسب للنمو', $default_output, 'The default featured badge is rendered' );
assert_true( 2 === substr_count( $default_output, 'data-purpose="pricing-card"' ), 'Two regular default package cards are rendered' );
assert_true( 1 === substr_count( $default_output, 'data-purpose="featured-pricing-card"' ), 'One featured default package card is rendered' );
foreach ( array( '3,900', '8,500', 'ريال', 'شهرياً', 'تخصيص كامل', 'حسب نطاق العمل المطلوب' ) as $price_text ) {
    assert_not_contains( $price_text, $default_output, 'No default price is rendered ("' . $price_text . '")' );
}

$GLOBALS['test_field_values'] = array(
    'baka_badge'           => 'شارة مخصصة',
    'baka_title'           => 'عنوان مخصص',
    'baka_title_highlight' => 'تمييز مخصص',
    'baka_description'     => 'وصف مخصص',
    'baka_packages'        => array(
        array(
            'tier'           => 'مستوى مخصص',
            'name'           => 'باقة مخصصة',
            'description'    => 'وصف الباقة المخصصة',
            'features'       => "ميزة أولى\nميزة ثانية",
            'cta_label'      => 'اشترك الآن',
            'cta_link'       => 'https://example.test/join',
            'color'          => 'cyan',
            'featured'       => false,
            'featured_badge' => '',
        ),
        array(
            'tier'           => 'مستوى مخفي',
            'name'           => '',
            'description'    => 'وصف مخفي',
            'features'       => 'ميزة مخفية',
            'cta_label'      => 'مخفي',
            'cta_link'       => '#',
            'color'          => 'gold',
            'featured'       => false,
            'featured_badge' => '',
        ),
        array(
            'tier'           => 'مستوى مميز',
            'name'           => 'باقة مميزة',
            'description'    => 'وصف الباقة المميزة',
            'features'       => 'ميزة مميزة',
            'cta_label'      => 'ابدأ الآن',
            'cta_link'       => '#contact',
            'color'          => 'cyan',
            'featured'       => true,
            'featured_badge' => 'الأكثر طلباً',
        ),
    ),
);

$configured_output = render_baka_part();
assert_contains( 'شارة مخصصة', $configured_output, 'The configured badge is rendered' );
assert_contains( 'عنوان مخصص', $configured_output, 'The configured title is rendered' );
assert_contains( 'تمييز مخصص', $configured_output, 'The configured title highlight is rendered' );
assert_contains( 'وصف مخصص', $configured_output, 'The configured description is rendered' );
assert_contains( 'باقة مخصصة', $configured_output, 'The configured package name is rendered' );
assert_contains( 'وصف الباقة المخصصة', $configured_output, 'The configured package description is rendered' );
assert_contains( 'ميزة أولى', $configured_output, 'The first configured feature is rendered' );
assert_contains( 'ميزة ثانية', $configured_output, 'The second configured feature is rendered' );
assert_contains( 'اشترك الآن', $configured_output, 'The configured CTA label is rendered' );
assert_contains( 'href="https://example.test/join"', $configured_output, 'The configured CTA link is rendered' );
assert_contains( 'text-cyan-400', $configured_output, 'The configured package colour is rendered' );
assert_contains( 'باقة مميزة', $configured_output, 'The featured configured package is rendered' );
assert_contains( 'الأكثر طلباً', $configured_output, 'The configured featured badge is rendered' );
assert_true( 1 === substr_count( $configured_output, 'data-purpose="pricing-card"' ), 'Only the named regular packages are rendered' );
assert_true( 1 === substr_count( $configured_output, 'data-purpose="featured-pricing-card"' ), 'Only the named featured package is rendered' );
assert_not_contains( 'وصف مخفي', $configured_output, 'A package without a name is not rendered' );
assert_not_contains( 'Start Growth', $configured_output, 'The default packages are replaced by the configured ones' );

$GLOBALS['test_field_values']['baka_badge'] = '<script>alert(1)</script>';
$escaped_output = render_baka_part();
assert_not_contains( '<script>', $escaped_output, 'Option values are escaped in the markup' );
assert_contains( '&lt;script&gt;alert(1)&lt;/script&gt;', $escaped_output, 'Option values are HTML encoded' );

$GLOBALS['test_field_values'] = array( 'baka_packages' => 'not-an-array' );
$fallback_output = render_baka_part();
assert_contains( 'Start Growth', $fallback_output, 'An invalid package list falls back to the defaults' );

if ( $GLOBALS['test_failures'] ) {
    echo 'FAIL (' . count( $GLOBALS['test_failures'] ) . '/' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
    foreach ( $GLOBALS['test_failures'] as $failure ) {
        echo ' - ' . $failure . PHP_EOL;
    }
    exit( 1 );
}

echo 'OK (' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
