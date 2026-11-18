<?php
/**
 * Render tests for the "Works" post type, its archive and single templates
 * and the home page portfolio section.
 *
 * Run with: php tests/works_test.php
 */

error_reporting( E_ALL );

$theme_dir                 = dirname( __DIR__ );
$GLOBALS['theme_dir']      = $theme_dir;
$GLOBALS['test_post_types'] = array();
$GLOBALS['test_actions']    = array();
$GLOBALS['test_failures']   = array();
$GLOBALS['test_assertions'] = 0;

$GLOBALS['test_field_groups']     = array();
$GLOBALS['test_field_values']     = array();
$GLOBALS['test_titles']           = array();
$GLOBALS['test_excerpts']         = array();
$GLOBALS['test_thumbnails']       = array();
$GLOBALS['test_content']          = array();
$GLOBALS['test_loop_ids']         = array();
$GLOBALS['test_loop_index']       = -1;
$GLOBALS['test_current_id']       = 0;
$GLOBALS['test_queries']          = array();
$GLOBALS['test_query_ids']        = array();
$GLOBALS['test_template_parts']   = array();
$GLOBALS['test_pagination_calls'] = 0;
$GLOBALS['test_published_works']  = 0;

function register_post_type( $post_type, $args = array() ) {
    $GLOBALS['test_post_types'][ $post_type ] = $args;
}

function add_action( $hook, $callback ) {
    $GLOBALS['test_actions'][] = $hook;
}

function add_theme_support( $feature ) {
}

function flush_rewrite_rules() {
}

function acf_add_local_field_group( $group ) {
    $GLOBALS['test_field_groups'][] = $group;
}

function get_field( $name, $post_id = null ) {
    if ( null === $post_id ) {
        return null;
    }
    return $GLOBALS['test_field_values'][ $post_id ][ $name ] ?? null;
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

function wp_strip_all_tags( $text ) {
    return strip_tags( (string) $text );
}

function wp_get_attachment_image_url( $id, $size = 'thumbnail' ) {
    return '';
}

function get_the_ID() {
    return $GLOBALS['test_current_id'];
}

function get_the_title( $post_id = null ) {
    return $GLOBALS['test_titles'][ (int) $post_id ] ?? '';
}

function get_the_excerpt( $post_id = null ) {
    return $GLOBALS['test_excerpts'][ (int) $post_id ] ?? '';
}

function get_permalink( $post_id = null ) {
    return 'https://example.test/?p=' . (int) $post_id;
}

function get_the_post_thumbnail_url( $post_id = null, $size = 'full' ) {
    return $GLOBALS['test_thumbnails'][ (int) $post_id ] ?? false;
}

function has_post_thumbnail( $post_id = null ) {
    return ! empty( $GLOBALS['test_thumbnails'][ (int) $post_id ] );
}

function get_the_post_thumbnail( $post_id = null, $size = 'full', $attr = array() ) {
    $url = get_the_post_thumbnail_url( $post_id, $size );
    if ( ! $url ) {
        return '';
    }
    return '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( get_the_title( $post_id ) ) . '" />';
}

function the_title() {
    echo esc_html( get_the_title( get_the_ID() ) );
}

function the_title_attribute( $args = array() ) {
    echo esc_attr( get_the_title( get_the_ID() ) );
}

function get_the_content() {
    return $GLOBALS['test_content'][ get_the_ID() ] ?? '';
}

function the_content() {
    echo get_the_content();
}

function have_posts() {
    return ( $GLOBALS['test_loop_index'] + 1 ) < count( $GLOBALS['test_loop_ids'] );
}

function the_post() {
    $GLOBALS['test_loop_index']++;
    $GLOBALS['test_current_id'] = $GLOBALS['test_loop_ids'][ $GLOBALS['test_loop_index'] ];
}

function wp_reset_postdata() {
    $GLOBALS['test_current_id'] = 0;
}

function the_posts_pagination( $args = array() ) {
    $GLOBALS['test_pagination_calls']++;
    echo '<nav class="pagination">' . esc_html( $args['prev_text'] ?? '' ) . '</nav>';
}

function get_post_type_archive_link( $post_type ) {
    return 'https://example.test/' . $post_type . '/';
}

function home_url( $path = '' ) {
    return 'https://example.test' . $path;
}

function wp_count_posts( $post_type ) {
    return (object) array( 'publish' => $GLOBALS['test_published_works'] );
}

function get_header() {
}

function get_footer() {
}

function get_template_part( $slug, $name = null, $args = array() ) {
    $GLOBALS['test_template_parts'][] = $slug;
    $template                         = $GLOBALS['theme_dir'] . '/' . $slug . '.php';
    if ( file_exists( $template ) ) {
        include $template;
    }
}

class WP_Query {
    public $posts = array();
    private $index = -1;

    public function __construct( $args = array() ) {
        $GLOBALS['test_queries'][] = $args;
        $this->posts               = $GLOBALS['test_query_ids'];
    }

    public function have_posts() {
        return ( $this->index + 1 ) < count( $this->posts );
    }

    public function the_post() {
        $this->index++;
        $GLOBALS['test_current_id'] = $this->posts[ $this->index ];
    }
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

function find_group( $post_type ) {
    foreach ( $GLOBALS['test_field_groups'] as $group ) {
        $location = $group['location'][0][0] ?? array();
        if ( ( $location['value'] ?? '' ) === $post_type ) {
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

function render_template( $relative_path ) {
    global $theme_dir;
    ob_start();
    include $theme_dir . '/' . $relative_path;
    return ob_get_clean();
}

function render_work_card( $post_id, $delay = '' ) {
    global $theme_dir;
    $args = array( 'post_id' => $post_id, 'delay' => $delay );
    ob_start();
    include $theme_dir . '/template-parts/work-card.php';
    return ob_get_clean();
}

function render_portfolio() {
    global $theme_dir;
    ob_start();
    include $theme_dir . '/template-parts/portofolio.php';
    return ob_get_clean();
}

include $theme_dir . '/Functions/Post-Types/works_post_type.php';

sumou_register_works_post_type();

$works_post_type = $GLOBALS['test_post_types']['works'] ?? null;
assert_true( null !== $works_post_type, 'The "works" post type is registered' );
assert_true( 'Works' === ( $works_post_type['labels']['name'] ?? '' ), 'The post type plural label is "Works"' );
assert_true( 'Work' === ( $works_post_type['labels']['singular_name'] ?? '' ), 'The post type singular label is "Work"' );
assert_true( true === ( $works_post_type['public'] ?? false ), 'The post type is public' );
assert_true( true === ( $works_post_type['has_archive'] ?? false ), 'The post type has an archive' );
assert_true( 'works' === ( $works_post_type['rewrite']['slug'] ?? '' ), 'The post type rewrite slug is works' );
assert_true( true === ( $works_post_type['show_in_rest'] ?? false ), 'The post type is exposed in REST' );
foreach ( array( 'title', 'editor', 'excerpt', 'thumbnail' ) as $support ) {
    assert_true( in_array( $support, $works_post_type['supports'] ?? array(), true ), 'The post type supports ' . $support );
}
assert_true( in_array( 'init', $GLOBALS['test_actions'], true ), 'The post type registration is hooked on init' );
assert_true( in_array( 'after_switch_theme', $GLOBALS['test_actions'], true ), 'The rewrite rules are flushed when the theme is activated' );

$functions_source = file_get_contents( $theme_dir . '/functions.php' );
assert_contains( 'Functions/Post-Types/works_post_type.php', $functions_source, 'functions.php loads the Works post type' );

$works_group = find_group( 'works' );
assert_true( null !== $works_group, 'The Works field group is bound to the works post type' );

$category_field = find_group_field( $works_group, 'work_category' );
assert_true( null !== $category_field, 'The Works group has a work_category field' );
assert_true( 'select' === ( $category_field['type'] ?? '' ), 'work_category is a select field' );
assert_true(
    array( 'platforms', 'mobile', 'ecommerce', 'marketing', 'seo' ) === array_keys( $category_field['choices'] ?? array() ),
    'work_category offers the five archive filter categories'
);

foreach ( array( 'work_badge' => 'text', 'work_sector' => 'text', 'work_metric' => 'text', 'work_result' => 'text', 'work_tagline' => 'text', 'work_summary' => 'textarea' ) as $field_name => $field_type ) {
    $field = find_group_field( $works_group, $field_name );
    assert_true( null !== $field, 'The Works group has a ' . $field_name . ' field' );
    assert_true( $field_type === ( $field['type'] ?? '' ), $field_name . ' is a ' . $field_type . ' field' );
}

$technologies_field = find_group_field( $works_group, 'work_technologies' );
assert_true( null !== $technologies_field, 'The Works group has a work_technologies field' );
assert_true( 'repeater' === ( $technologies_field['type'] ?? '' ), 'work_technologies is a repeater' );
$technology_sub_fields = array_map( function ( $field ) {
    return $field['name'] ?? '';
}, $technologies_field['sub_fields'] ?? array() );
assert_true( in_array( 'label', $technology_sub_fields, true ), 'work_technologies has a label sub field' );

$categories = sumou_get_work_categories();
assert_true(
    array( 'platforms', 'mobile', 'ecommerce', 'marketing', 'seo' ) === array_keys( $categories ),
    'The work categories follow the archive filter order'
);
assert_true( 'مواقع ومنصات تفاعلية' === ( $categories['platforms']['label'] ?? '' ), 'The platforms category label matches the archive chip' );
assert_true( 'تطبيقات الجوال (iOS & Android)' === ( $categories['mobile']['label'] ?? '' ), 'The mobile category label matches the archive chip' );
assert_true( 'متاجر إلكترونية فاخرة' === ( $categories['ecommerce']['label'] ?? '' ), 'The ecommerce category label matches the archive chip' );
assert_true( 'حملات تسويقية وتطوير أعمال' === ( $categories['marketing']['label'] ?? '' ), 'The marketing category label matches the archive chip' );
assert_true( 'تصدر محركات البحث (SEO)' === ( $categories['seo']['label'] ?? '' ), 'The seo category label matches the archive chip' );

$GLOBALS['test_field_values'][101] = array(
    'work_category'     => 'platforms',
    'work_badge'        => 'منصة مؤسسية ذكية',
    'work_sector'       => 'الاستثمار والتطوير العقاري',
    'work_metric'       => '1.2 مليار ر.س صفقات',
    'work_result'       => 'أكثر من 40,000 عقار معتمد',
    'work_tagline'      => 'منصة متطورة لحجز العقارات الفاخرة بالرياض ودبي',
    'work_summary'      => 'منظومة وساطة واستثمار عقاري شاملة بالذكاء الاصطناعي.',
    'work_technologies' => array(
        array( 'label' => 'Mapbox GL' ),
        array( 'label' => 'PostgreSQL' ),
        array( 'label' => '   ' ),
    ),
);
$GLOBALS['test_titles'][101]     = 'منصة هكتار العقارية الذكية';
$GLOBALS['test_thumbnails'][101] = 'https://example.test/hektar.jpg';
$GLOBALS['test_excerpts'][101]   = 'مقتطف احتياطي';
$GLOBALS['test_content'][101]    = '<p>تفاصيل دراسة الحالة.</p>';

assert_true( 'platforms' === sumou_get_work_category( 101 ), 'The category of a work is resolved' );
assert_true( 'منصة مؤسسية ذكية' === sumou_get_work_badge( 101 ), 'The card badge comes from the work field' );
assert_true( 'الاستثمار والتطوير العقاري' === sumou_get_work_sector( 101 ), 'The sector label is resolved' );
assert_true( '1.2 مليار ر.س صفقات' === sumou_get_work_metric( 101 ), 'The metric is resolved' );
assert_true( 'أكثر من 40,000 عقار معتمد' === sumou_get_work_result( 101 ), 'The footer result is resolved' );
assert_true( 'منصة متطورة لحجز العقارات الفاخرة بالرياض ودبي' === sumou_get_work_tagline( 101 ), 'The showcase tagline is resolved' );
assert_true( 'منظومة وساطة واستثمار عقاري شاملة بالذكاء الاصطناعي.' === sumou_get_work_summary( 101 ), 'The summary comes from the work field' );
assert_true(
    array( 'Mapbox GL', 'PostgreSQL' ) === sumou_get_work_technologies( 101 ),
    'Technologies are collected and blank rows are dropped'
);

$GLOBALS['test_field_values'][102] = array(
    'work_category' => 'not-a-category',
    'work_summary'  => '',
);
$GLOBALS['test_titles'][102]   = 'عمل بدون تصنيف';
$GLOBALS['test_excerpts'][102] = 'مقتطف العمل';

assert_true( '' === sumou_get_work_category( 102 ), 'An unknown category is dropped' );
assert_true( null === sumou_get_work_accent( 102 ), 'An unknown category has no accent' );
assert_true( 'مقتطف العمل' === sumou_get_work_summary( 102 ), 'An empty summary falls back to the excerpt' );

$GLOBALS['test_field_values'][103] = array(
    'work_category' => 'eoocommerce',
);
$GLOBALS['test_field_values'][104] = array(
    'work_category' => 'seo',
);
assert_true( 'منصة مؤسسية ذكية' === sumou_get_work_badge( 101 ), 'A work badge is kept when set' );
assert_true( 'تصدر محركات البحث (SEO)' === sumou_get_work_badge( 104 ), 'A missing badge falls back to the category label' );
assert_true( '' === sumou_get_work_badge( 103 ), 'An invalid category yields no badge' );

$card_output = render_work_card( 101, 'reveal-delay-100' );
assert_contains( 'project-card', $card_output, 'The card carries the project-card class the filter script binds to' );
assert_contains( 'data-category="platforms"', $card_output, 'The card exposes its category to the filter script' );
assert_contains( 'reveal-delay-100', $card_output, 'The card accepts its reveal delay' );
assert_contains( 'منصة هكتار العقارية الذكية', $card_output, 'The card renders the work title' );
assert_contains( 'منصة مؤسسية ذكية', $card_output, 'The card renders the badge' );
assert_contains( 'الاستثمار والتطوير العقاري', $card_output, 'The card renders the sector label' );
assert_contains( '1.2 مليار ر.س صفقات', $card_output, 'The card renders the metric' );
assert_contains( 'منظومة وساطة واستثمار عقاري شاملة بالذكاء الاصطناعي.', $card_output, 'The card renders the summary' );
assert_contains( 'Mapbox GL', $card_output, 'The card renders the technologies' );
assert_contains( 'أكثر من 40,000 عقار معتمد', $card_output, 'The card renders the footer result' );
assert_contains( 'https://example.test/hektar.jpg', $card_output, 'The card renders the featured image' );
assert_contains( 'https://example.test/?p=101', $card_output, 'The card links to the work' );
assert_contains( 'دراسة الحالة', $card_output, 'The card links to the case study' );
assert_contains( 'text-sky-300', $card_output, 'The card accent follows the category' );

$no_category_card = render_work_card( 102 );
assert_not_contains( 'data-category=', $no_category_card, 'A work without a category carries no filter value' );
assert_contains( 'عمل بدون تصنيف', $no_category_card, 'A work without a category still renders its title' );
assert_contains( 'https://example.test/?p=102', $no_category_card, 'A work without a category still links to its page' );

$GLOBALS['test_field_values'][105] = array(
    'work_category' => 'mobile',
    'work_summary'  => '<script>alert(1)</script>',
    'work_badge'    => '<script>badge()</script>',
);
$GLOBALS['test_titles'][105] = 'عنوان <script>alert(2)</script>';
$escaped_card                = render_work_card( 105 );
assert_not_contains( '<script>', $escaped_card, 'Work values are escaped in the card' );
assert_contains( '&lt;script&gt;alert(2)&lt;/script&gt;', $escaped_card, 'The work title is HTML encoded' );

$GLOBALS['test_loop_ids']        = array( 101, 102 );
$GLOBALS['test_loop_index']      = -1;
$GLOBALS['test_current_id']      = 0;
$GLOBALS['test_pagination_calls'] = 0;
$archive_output                  = render_template( 'archive-works.php' );
assert_contains( 'سابقة الأعمال والمشاريع', $archive_output, 'The archive renders its breadcrumb' );
assert_contains( 'أعمالنا — بصمات رقمية ترسم ملامح', $archive_output, 'The archive renders its hero title' );
assert_contains( 'workspace_premium', $archive_output, 'The archive renders the hero badge icon' );
assert_contains( 'id="projectsContainer"', $archive_output, 'The archive renders the filterable grid container' );
assert_contains( 'data-filter="all"', $archive_output, 'The archive renders the all filter chip' );
foreach ( array( 'platforms', 'mobile', 'ecommerce', 'marketing', 'seo' ) as $category_slug ) {
    assert_contains( 'data-filter="' . $category_slug . '"', $archive_output, 'The archive renders the ' . $category_slug . ' filter chip' );
}
assert_contains( 'الاستثمار والتطوير العقاري', $archive_output, 'The archive renders its featured case study' );
assert_contains( 'OUR STRATEGIC PARTNERS', $archive_output, 'The archive renders the partners wall' );
assert_contains( 'مشروعك القادم يبدأ هنا', $archive_output, 'The archive renders the closing call to action' );
assert_contains( 'منصة هكتار العقارية الذكية', $archive_output, 'The archive renders the first work' );
assert_contains( 'عمل بدون تصنيف', $archive_output, 'The archive renders the second work' );
assert_true( 2 === substr_count( $archive_output, 'project-card' ), 'The archive renders one card per work' );
assert_true( 1 === $GLOBALS['test_pagination_calls'], 'The archive renders pagination' );

$GLOBALS['test_loop_ids']   = array();
$GLOBALS['test_loop_index'] = -1;
$empty_archive              = render_template( 'archive-works.php' );
assert_contains( 'لا توجد أعمال منشورة حالياً', $empty_archive, 'An empty archive shows its empty state' );
assert_not_contains( 'pagination', $empty_archive, 'An empty archive renders no pagination' );

$GLOBALS['test_loop_ids']   = array( 101 );
$GLOBALS['test_loop_index'] = -1;
$GLOBALS['test_query_ids']  = array();
$GLOBALS['test_queries']    = array();
$single_output              = render_template( 'single-works.php' );
assert_contains( 'منصة هكتار العقارية الذكية', $single_output, 'The single page renders the work title' );
assert_contains( 'منصة مؤسسية ذكية', $single_output, 'The single page renders the badge' );
assert_contains( 'منظومة وساطة واستثمار عقاري شاملة بالذكاء الاصطناعي.', $single_output, 'The single page renders the summary' );
assert_contains( 'تفاصيل دراسة الحالة.', $single_output, 'The single page renders the work content' );
assert_contains( 'Mapbox GL', $single_output, 'The single page lists the technologies' );
assert_contains( 'https://example.test/works/', $single_output, 'The single page links back to the archive' );
assert_contains( 'https://example.test/#contact', $single_output, 'The single page links its call to action' );
assert_contains( 'الاستثمار والتطوير العقاري', $single_output, 'The single page renders the results panel' );
assert_true( isset( $GLOBALS['test_queries'][0] ), 'The single page queries related works' );
assert_true( 'works' === ( $GLOBALS['test_queries'][0]['post_type'] ?? '' ), 'The related query reads the works post type' );

$GLOBALS['test_query_ids']      = array( 101, 102, 105, 106, 107, 108 );
$GLOBALS['test_published_works'] = 6;
$GLOBALS['test_queries']         = array();
$GLOBALS['test_titles'][102]     = 'عمل ثان';
$GLOBALS['test_titles'][105]     = 'عمل ثالث';
$GLOBALS['test_titles'][106]     = 'عمل رابع';
$GLOBALS['test_titles'][107]     = 'عمل خامس';
$GLOBALS['test_titles'][108]     = 'عمل سادس';
$portfolio_output                = render_portfolio();
assert_contains( 'id="portfolio"', $portfolio_output, 'The home section keeps its anchor' );
assert_contains( 'منصة هكتار العقارية الذكية', $portfolio_output, 'The home section renders the works' );
assert_contains( 'عمل سادس', $portfolio_output, 'The home section renders six works' );
assert_true( 6 === substr_count( $portfolio_output, 'work-showcase-card' ), 'The home section renders exactly six work cards' );
assert_contains( 'https://example.test/works/', $portfolio_output, 'The home section links to the works archive' );
assert_contains( '(+6)', $portfolio_output, 'The home section shows the published works count' );
assert_true( 'works' === ( $GLOBALS['test_queries'][0]['post_type'] ?? '' ), 'The home section queries the works post type' );
assert_true( 6 === ( $GLOBALS['test_queries'][0]['posts_per_page'] ?? 0 ), 'The home section asks for six works' );

$GLOBALS['test_query_ids'] = array();
$empty_portfolio           = render_portfolio();
assert_contains( 'لا توجد أعمال منشورة حالياً', $empty_portfolio, 'An empty home section shows its empty state' );

if ( $GLOBALS['test_failures'] ) {
    echo 'FAIL (' . count( $GLOBALS['test_failures'] ) . '/' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
    foreach ( $GLOBALS['test_failures'] as $failure ) {
        echo ' - ' . $failure . PHP_EOL;
    }
    exit( 1 );
}

echo 'OK (' . $GLOBALS['test_assertions'] . ' assertions)' . PHP_EOL;
