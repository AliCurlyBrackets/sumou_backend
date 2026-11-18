<?php
/**
 * Render tests for the "Works" post type, its work_category taxonomy,
 * the archive and single templates and the home page portfolio section.
 *
 * Run with: php tests/works_test.php
 */

error_reporting( E_ALL );

$theme_dir                  = dirname( __DIR__ );
$GLOBALS['theme_dir']       = $theme_dir;
$GLOBALS['test_post_types'] = array();
$GLOBALS['test_taxonomies'] = array();
$GLOBALS['test_actions']    = array();
$GLOBALS['test_hooks']      = array();
$GLOBALS['test_options']    = array();
$GLOBALS['test_failures']   = array();
$GLOBALS['test_assertions'] = 0;

$GLOBALS['test_field_groups']        = array();
$GLOBALS['test_field_values']        = array();
$GLOBALS['test_titles']              = array();
$GLOBALS['test_excerpts']            = array();
$GLOBALS['test_thumbnails']          = array();
$GLOBALS['test_content']             = array();
$GLOBALS['test_post_terms']          = array();
$GLOBALS['test_terms']               = array();
$GLOBALS['test_term_queries']        = array();
$GLOBALS['test_existing_term_slugs'] = array();
$GLOBALS['test_inserted_terms']      = array();
$GLOBALS['test_loop_ids']            = array();
$GLOBALS['test_loop_index']          = -1;
$GLOBALS['test_current_id']          = 0;
$GLOBALS['test_queries']             = array();
$GLOBALS['test_query_ids']           = array();
$GLOBALS['test_template_parts']      = array();
$GLOBALS['test_pagination_calls']    = 0;
$GLOBALS['test_published_works']     = 0;

class WP_Term {
    public $term_id;
    public $slug;
    public $name;
    public $count;

    public function __construct( $term_id, $slug, $name, $count = 0 ) {
        $this->term_id = $term_id;
        $this->slug    = $slug;
        $this->name    = $name;
        $this->count   = $count;
    }
}

function register_post_type( $post_type, $args = array() ) {
    $GLOBALS['test_post_types'][ $post_type ] = $args;
}

function register_taxonomy( $taxonomy, $object_type, $args = array() ) {
    $GLOBALS['test_taxonomies'][ $taxonomy ] = array(
        'object_type' => (array) $object_type,
        'args'        => $args,
    );
}

function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
    $GLOBALS['test_actions'][]       = $hook;
    $GLOBALS['test_hooks'][ $hook ][] = is_string( $callback ) ? $callback : '';
}

function get_option( $name, $default = false ) {
    return $GLOBALS['test_options'][ $name ] ?? $default;
}

function update_option( $name, $value ) {
    $GLOBALS['test_options'][ $name ] = $value;

    return true;
}

function add_theme_support( $feature ) {
}

function flush_rewrite_rules() {
}

function get_terms( $args = array() ) {
    $GLOBALS['test_term_queries'][] = $args;

    $terms = $GLOBALS['test_terms'];
    if ( ! empty( $args['hide_empty'] ) ) {
        $terms = array_values( array_filter( $terms, function ( $term ) {
            return $term->count > 0;
        } ) );
    }

    return $terms;
}

function get_the_terms( $post_id, $taxonomy ) {
    $terms = $GLOBALS['test_post_terms'][ (int) $post_id ] ?? array();

    return $terms ? $terms : false;
}

function get_term_by( $field, $value, $taxonomy ) {
    foreach ( $GLOBALS['test_terms'] as $term ) {
        if ( 'slug' === $field && $term->slug === $value ) {
            return $term;
        }
    }

    return false;
}

function term_exists( $term, $taxonomy = '', $parent = null ) {
    return ! empty( $GLOBALS['test_existing_term_slugs'][ $term ] );
}

function wp_insert_term( $term, $taxonomy, $args = array() ) {
    $GLOBALS['test_inserted_terms'][] = array(
        'name'     => $term,
        'taxonomy' => $taxonomy,
        'slug'     => $args['slug'] ?? '',
    );

    return array( 'term_id' => count( $GLOBALS['test_inserted_terms'] ) );
}

function sanitize_title( $title ) {
    $slug = preg_replace( '/[^a-z0-9]+/', '-', strtolower( (string) $title ) );

    return trim( (string) $slug, '-' );
}

function wp_unslash( $value ) {
    return $value;
}

function add_query_arg( $key, $value, $url ) {
    return $url . ( false === strpos( $url, '?' ) ? '?' : '&' ) . rawurlencode( $key ) . '=' . rawurlencode( $value );
}

function is_admin() {
    return false;
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
    public $posts      = array();
    public $query_vars = array();
    public $is_404     = false;
    public $main       = false;
    public $archive    = '';
    private $index     = -1;

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

    public function is_main_query() {
        return $this->main;
    }

    public function is_post_type_archive( $post_type = '' ) {
        return $this->archive === $post_type;
    }

    public function set_404() {
        $this->is_404 = true;
    }

    public function set( $key, $value ) {
        $this->query_vars[ $key ] = $value;
    }

    public function get( $key, $default = '' ) {
        return $this->query_vars[ $key ] ?? $default;
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

function extract_work_card( $html ) {
    $start = strpos( $html, '<article' );
    $end   = strpos( $html, '</article>' );

    if ( false === $start || false === $end ) {
        return '';
    }

    return substr( $html, $start, $end - $start + strlen( '</article>' ) );
}

function render_portfolio() {
    global $theme_dir;
    ob_start();
    include $theme_dir . '/template-parts/portofolio.php';
    return ob_get_clean();
}

include $theme_dir . '/Functions/Post-Types/works_post_type.php';

sumou_register_works_post_type();
sumou_register_work_category_taxonomy();

//******************** Post type ********************//

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
assert_true( in_array( 'pre_get_posts', $GLOBALS['test_actions'], true ), 'The archive filter is hooked on pre_get_posts' );

$functions_source = file_get_contents( $theme_dir . '/functions.php' );
assert_contains( 'Functions/Post-Types/works_post_type.php', $functions_source, 'functions.php loads the Works post type' );

//******************** Taxonomy ********************//

$work_taxonomy = $GLOBALS['test_taxonomies']['work_category'] ?? null;
assert_true( null !== $work_taxonomy, 'The work_category taxonomy is registered' );
assert_true( in_array( 'works', $work_taxonomy['object_type'] ?? array(), true ), 'The taxonomy is attached to the works post type' );
assert_true( true === ( $work_taxonomy['args']['hierarchical'] ?? false ), 'The taxonomy is hierarchical' );
assert_true( true === ( $work_taxonomy['args']['public'] ?? false ), 'The taxonomy is public' );
assert_true( true === ( $work_taxonomy['args']['show_in_rest'] ?? false ), 'The taxonomy is exposed in REST' );
assert_true( true === ( $work_taxonomy['args']['show_admin_column'] ?? false ), 'The taxonomy shows its admin column' );
assert_true( 'Work Categories' === ( $work_taxonomy['args']['labels']['name'] ?? '' ), 'The taxonomy plural label is "Work Categories"' );
assert_true( 'Work Category' === ( $work_taxonomy['args']['labels']['singular_name'] ?? '' ), 'The taxonomy singular label is "Work Category"' );
assert_true( 'work_category' === ( $work_taxonomy['args']['query_var'] ?? '' ), 'The taxonomy is addressed by the work_category query var' );

$default_terms = sumou_default_work_categories();
assert_true(
    array( 'platforms', 'mobile', 'ecommerce', 'marketing', 'seo' ) === array_keys( $default_terms ),
    'The default work categories follow the archive filter order'
);
assert_true( 'مواقع ومنصات تفاعلية' === ( $default_terms['platforms'] ?? '' ), 'The platforms category label matches the archive chip' );
assert_true( 'تطبيقات الجوال (iOS & Android)' === ( $default_terms['mobile'] ?? '' ), 'The mobile category label matches the archive chip' );
assert_true( 'متاجر إلكترونية فاخرة' === ( $default_terms['ecommerce'] ?? '' ), 'The ecommerce category label matches the archive chip' );
assert_true( 'حملات تسويقية وتطوير أعمال' === ( $default_terms['marketing'] ?? '' ), 'The marketing category label matches the archive chip' );
assert_true( 'تصدر محركات البحث (SEO)' === ( $default_terms['seo'] ?? '' ), 'The seo category label matches the archive chip' );

sumou_seed_work_categories();
assert_true( 5 === count( $GLOBALS['test_inserted_terms'] ), 'Seeding creates the five default categories' );
assert_true( 'platforms' === ( $GLOBALS['test_inserted_terms'][0]['slug'] ?? '' ), 'Seeding keeps the platforms slug the archive filters on' );
assert_true( 'work_category' === ( $GLOBALS['test_inserted_terms'][0]['taxonomy'] ?? '' ), 'Seeding writes into the work_category taxonomy' );

$GLOBALS['test_inserted_terms']      = array();
$GLOBALS['test_existing_term_slugs'] = array_fill_keys( array_keys( $default_terms ), true );
sumou_seed_work_categories();
assert_true( 0 === count( $GLOBALS['test_inserted_terms'] ), 'Seeding again inserts no duplicate categories' );

assert_true(
    in_array( 'sumou_seed_work_categories_once', $GLOBALS['test_hooks']['init'] ?? array(), true ),
    'The default categories are seeded on init so a theme update creates them'
);

$GLOBALS['test_inserted_terms']      = array();
$GLOBALS['test_existing_term_slugs'] = array();
$GLOBALS['test_options']             = array();
sumou_seed_work_categories_once();
assert_true( 5 === count( $GLOBALS['test_inserted_terms'] ), 'The first request seeds the five default categories' );
assert_true( '1' === get_option( 'sumou_work_categories_seeded' ), 'The seeding is remembered so it does not run again' );

$GLOBALS['test_inserted_terms'] = array();
$GLOBALS['test_existing_term_slugs'] = array();
sumou_seed_work_categories_once();
assert_true( 0 === count( $GLOBALS['test_inserted_terms'] ), 'Later requests do not query or recreate the categories' );

//******************** ACF group ********************//

$works_group = find_group( 'works' );
assert_true( null !== $works_group, 'The Works field group is bound to the works post type' );
assert_true( null === find_group_field( $works_group, 'work_category' ), 'The category is a taxonomy term, not a duplicated ACF field' );

foreach ( array( 'work_badge' => 'text', 'work_sector' => 'text', 'work_metric' => 'text', 'work_result' => 'text', 'work_summary' => 'textarea' ) as $field_name => $field_type ) {
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

//******************** Terms and helpers ********************//

$GLOBALS['test_terms'] = array(
    new WP_Term( 11, 'platforms', 'مواقع ومنصات تفاعلية', 3 ),
    new WP_Term( 12, 'mobile', 'تطبيقات الجوال (iOS & Android)', 1 ),
    new WP_Term( 13, 'ecommerce', 'متاجر إلكترونية فاخرة', 0 ),
    new WP_Term( 14, 'marketing', 'حملات تسويقية وتطوير أعمال', 2 ),
    new WP_Term( 15, 'seo', 'تصدر محركات البحث (SEO)', 1 ),
);

$GLOBALS['test_post_terms'][101] = array(
    new WP_Term( 11, 'platforms', 'مواقع ومنصات تفاعلية' ),
);
$GLOBALS['test_post_terms'][102] = array();
$GLOBALS['test_post_terms'][104] = array(
    new WP_Term( 15, 'seo', 'تصدر محركات البحث (SEO)' ),
);
$GLOBALS['test_post_terms'][105] = array(
    new WP_Term( 12, 'mobile', 'تطبيقات الجوال (iOS & Android)' ),
);
$GLOBALS['test_post_terms'][106] = array(
    new WP_Term( 13, 'ecommerce', 'متاجر إلكترونية فاخرة' ),
    new WP_Term( 14, 'marketing', 'حملات تسويقية وتطوير أعمال' ),
);
$GLOBALS['test_post_terms'][107] = array(
    new WP_Term( 15, 'seo', 'تصدر محركات البحث (SEO)' ),
);
$GLOBALS['test_post_terms'][108] = array(
    new WP_Term( 11, 'platforms', 'مواقع ومنصات تفاعلية' ),
);

$GLOBALS['test_field_values'][101] = array(
    'work_badge'        => 'منصة مؤسسية ذكية',
    'work_sector'       => 'الاستثمار والتطوير العقاري',
    'work_metric'       => '1.2 مليار ر.س صفقات',
    'work_result'       => 'أكثر من 40,000 عقار معتمد',
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

assert_true( 'platforms' === sumou_get_work_category( 101 ), 'The category slug comes from the assigned term' );
assert_true( 'مواقع ومنصات تفاعلية' === sumou_get_work_category_label( 101 ), 'The category label comes from the assigned term' );
assert_true( '' === sumou_get_work_category( 102 ), 'A work without a term has no category' );
assert_true( 'منصة مؤسسية ذكية' === sumou_get_work_badge( 101 ), 'The card badge comes from the work field' );
assert_true( 'الاستثمار والتطوير العقاري' === sumou_get_work_sector( 101 ), 'The sector label is resolved' );
assert_true( '1.2 مليار ر.س صفقات' === sumou_get_work_metric( 101 ), 'The metric is resolved' );
assert_true( 'أكثر من 40,000 عقار معتمد' === sumou_get_work_result( 101 ), 'The footer result is resolved' );
assert_true( 'منظومة وساطة واستثمار عقاري شاملة بالذكاء الاصطناعي.' === sumou_get_work_summary( 101 ), 'The summary comes from the work field' );
assert_true(
    array( 'Mapbox GL', 'PostgreSQL' ) === sumou_get_work_technologies( 101 ),
    'Technologies are collected and blank rows are dropped'
);

$GLOBALS['test_field_values'][102] = array(
    'work_summary' => '',
);
$GLOBALS['test_titles'][102]   = 'عمل بدون تصنيف';
$GLOBALS['test_excerpts'][102] = 'مقتطف العمل';

assert_true( null === sumou_get_work_accent( 102 ), 'A work without a term has no accent' );
assert_true( 'مقتطف العمل' === sumou_get_work_summary( 102 ), 'An empty summary falls back to the excerpt' );
assert_true( 'تصدر محركات البحث (SEO)' === sumou_get_work_badge( 104 ), 'A missing badge falls back to the category term name' );
assert_true( '' === sumou_get_work_badge( 102 ), 'A work without a term has no badge fallback' );

$platforms_accent = sumou_get_work_accent( 101 );
assert_true( 'text-sky-300 border-sky-400/30' === ( $platforms_accent['badge'] ?? '' ), 'The platforms accent follows the design' );
assert_true( null !== sumou_get_work_accent( 106 ), 'A work with several terms still resolves an accent' );

$filter_terms = sumou_get_work_filter_terms();
assert_true( 4 === count( $filter_terms ), 'The filter chips come from the non-empty taxonomy terms' );
assert_true( 'platforms' === ( $filter_terms[0]->slug ?? '' ), 'The filter chips keep the taxonomy order' );
assert_true( 'ecommerce' !== ( $filter_terms[3]->slug ?? '' ), 'A term without works is not offered as a filter chip' );
assert_true( 'work_category' === ( $GLOBALS['test_term_queries'][ count( $GLOBALS['test_term_queries'] ) - 1 ]['taxonomy'] ?? '' ), 'The chips are read from the work_category taxonomy' );
assert_true( true === ( $GLOBALS['test_term_queries'][ count( $GLOBALS['test_term_queries'] ) - 1 ]['hide_empty'] ?? false ), 'Empty categories are hidden from the chips' );

$_GET = array();
assert_true( '' === sumou_get_work_filter_slug(), 'No filter is active without a query var' );
assert_true( 'https://example.test/works/' === sumou_get_work_filter_url(), 'The all filter links to the plain archive' );
assert_true( 'https://example.test/works/?work_category=mobile' === sumou_get_work_filter_url( 'mobile' ), 'A category filter links to the filtered archive' );

$_GET['work_category'] = ' Mobile App ';
assert_true( 'mobile-app' === sumou_get_work_filter_slug(), 'The filter slug is sanitized' );
$_GET['work_category'] = array( 'mobile' );
assert_true( '' === sumou_get_work_filter_slug(), 'A non-string filter is ignored' );
$_GET = array();

//******************** Archive query filter ********************//

$archive_query = new WP_Query();
$archive_query->main    = true;
$archive_query->archive = 'works';

$_GET['work_category'] = 'mobile';
sumou_filter_works_archive( $archive_query );
assert_true( isset( $archive_query->query_vars['tax_query'] ), 'A category filter adds a tax query to the archive' );
assert_true( 'work_category' === ( $archive_query->query_vars['tax_query'][0]['taxonomy'] ?? '' ), 'The archive filter queries the work_category taxonomy' );
assert_true( array( 12 ) === ( $archive_query->query_vars['tax_query'][0]['terms'] ?? array() ), 'The archive filter restricts to the selected term' );
assert_true( true === ( $archive_query->query_vars['tax_query'][0]['include_children'] ?? false ), 'The archive filter includes child categories' );
assert_true( false === $archive_query->is_404, 'A known category filter does not 404' );

$_GET['work_category'] = 'not-a-category';
$unknown_query         = new WP_Query();
$unknown_query->main    = true;
$unknown_query->archive = 'works';
sumou_filter_works_archive( $unknown_query );
assert_true( true === $unknown_query->is_404, 'An unknown category filter answers 404 instead of showing everything' );
assert_true( ! isset( $unknown_query->query_vars['tax_query'] ), 'An unknown category filter adds no tax query' );

$_GET['work_category'] = 'mobile';
$untouched_query        = new WP_Query();
$untouched_query->main  = false;
$untouched_query->archive = 'works';
sumou_filter_works_archive( $untouched_query );
assert_true( ! isset( $untouched_query->query_vars['tax_query'] ), 'A secondary query is not filtered' );

$other_archive           = new WP_Query();
$other_archive->main     = true;
$other_archive->archive  = 'services';
sumou_filter_works_archive( $other_archive );
assert_true( ! isset( $other_archive->query_vars['tax_query'] ), 'Another post type archive is not filtered' );

$unfiltered_query           = new WP_Query();
$unfiltered_query->main     = true;
$unfiltered_query->archive  = 'works';
$_GET = array();
sumou_filter_works_archive( $unfiltered_query );
assert_true( ! isset( $unfiltered_query->query_vars['tax_query'] ), 'The unfiltered archive keeps all works' );

//******************** Work card ********************//

$card_output = render_work_card( 101, 'reveal-delay-100' );
assert_contains( 'project-card', $card_output, 'The card carries the project-card class the filter script binds to' );
assert_contains( 'data-category="platforms"', $card_output, 'The card exposes its taxonomy terms to the filter script' );
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
assert_contains( 'https://example.test/works/?work_category=platforms', $card_output, 'The card links its category to the filtered archive' );
assert_contains( 'دراسة الحالة', $card_output, 'The card links to the case study' );
assert_contains( 'text-sky-300', $card_output, 'The card accent follows the category' );

$no_category_card = render_work_card( 102 );
assert_not_contains( 'data-category=', $no_category_card, 'A work without a term carries no filter value' );
assert_contains( 'عمل بدون تصنيف', $no_category_card, 'A work without a term still renders its title' );
assert_contains( 'https://example.test/?p=102', $no_category_card, 'A work without a term still links to its page' );

$multi_term_card = render_work_card( 106 );
assert_contains( 'data-category="ecommerce marketing"', $multi_term_card, 'A work with several terms exposes all of them to the filter' );

$GLOBALS['test_field_values'][105]['work_summary'] = '<script>alert(1)</script>';
$GLOBALS['test_field_values'][105]['work_badge']   = '<script>badge()</script>';
$GLOBALS['test_titles'][105]                       = 'عنوان <script>alert(2)</script>';
$escaped_card                                      = render_work_card( 105 );
assert_not_contains( '<script>', $escaped_card, 'Work values are escaped in the card' );
assert_contains( '&lt;script&gt;alert(2)&lt;/script&gt;', $escaped_card, 'The work title is HTML encoded' );

//******************** Archive template ********************//

$GLOBALS['test_loop_ids']         = array( 101, 102 );
$GLOBALS['test_loop_index']       = -1;
$GLOBALS['test_current_id']       = 0;
$GLOBALS['test_pagination_calls'] = 0;
$GLOBALS['test_term_queries']     = array();
$_GET                             = array();
$archive_output                   = render_template( 'archive-works.php' );
assert_contains( 'سابقة الأعمال والمشاريع', $archive_output, 'The archive renders its breadcrumb' );
assert_contains( 'أعمالنا — بصمات رقمية ترسم ملامح', $archive_output, 'The archive renders its hero title' );
assert_contains( 'workspace_premium', $archive_output, 'The archive renders the hero badge icon' );
assert_contains( 'id="projectsContainer"', $archive_output, 'The archive renders the filterable grid container' );
assert_contains( 'href="https://example.test/works/"', $archive_output, 'The all chip links to the unfiltered archive' );
assert_contains( 'data-filter="all"', $archive_output, 'The archive renders the all filter chip' );
foreach ( array( 'platforms', 'mobile', 'marketing', 'seo' ) as $category_slug ) {
    assert_contains( 'data-filter="' . $category_slug . '"', $archive_output, 'The archive renders the ' . $category_slug . ' filter chip' );
}
assert_not_contains( 'data-filter="ecommerce"', $archive_output, 'A category without works gets no chip' );
assert_contains( 'مواقع ومنصات تفاعلية', $archive_output, 'The chips read their labels from the taxonomy terms' );
assert_contains( 'href="https://example.test/works/?work_category=platforms"', $archive_output, 'A chip links to the filtered archive' );
assert_true( 1 === substr_count( $archive_output, 'active-filter' ), 'Exactly one chip is the active filter' );
assert_contains( 'الاستثمار والتطوير العقاري', $archive_output, 'The archive renders its featured case study' );
assert_contains( 'OUR STRATEGIC PARTNERS', $archive_output, 'The archive renders the partners wall' );
assert_contains( 'مشروعك القادم يبدأ هنا', $archive_output, 'The archive renders its closing call to action' );
assert_contains( 'منصة هكتار العقارية الذكية', $archive_output, 'The archive renders the first work' );
assert_contains( 'عمل بدون تصنيف', $archive_output, 'The archive renders the second work' );
assert_true( 2 === substr_count( $archive_output, 'project-card' ), 'The archive renders one card per work' );
assert_true( 1 === $GLOBALS['test_pagination_calls'], 'The archive renders pagination' );
assert_true( true === ( $GLOBALS['test_term_queries'][0]['hide_empty'] ?? false ), 'The archive chips are read from the non-empty terms' );

$_GET['work_category'] = 'mobile';
$filtered_archive      = render_template( 'archive-works.php' );
assert_contains( 'href="https://example.test/works/?work_category=mobile"', $filtered_archive, 'The filtered archive renders its chip link' );
assert_true( false !== strpos( $filtered_archive, 'data-filter="mobile"' ), 'The filtered archive still offers the mobile chip' );
$mobile_chip = substr( $filtered_archive, strpos( $filtered_archive, 'data-filter="mobile"' ) - 200, 200 );
assert_contains( 'active-filter', $mobile_chip, 'The selected category chip is marked active' );
assert_not_contains( 'filter-chip active-filter', substr( $filtered_archive, strpos( $filtered_archive, 'data-filter="all"' ) - 200, 200 ), 'The all chip is not active while a category is filtered' );
$_GET = array();

$GLOBALS['test_loop_ids']   = array();
$GLOBALS['test_loop_index'] = -1;
$empty_archive              = render_template( 'archive-works.php' );
assert_contains( 'لا توجد أعمال منشورة حالياً', $empty_archive, 'An empty archive shows its empty state' );
assert_not_contains( 'pagination', $empty_archive, 'An empty archive renders no pagination' );

//******************** Single template ********************//

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
assert_contains( 'https://example.test/works/?work_category=platforms', $single_output, 'The single page links its category to the filtered archive' );
assert_true( isset( $GLOBALS['test_queries'][0] ), 'The single page queries related works' );
assert_true( 'works' === ( $GLOBALS['test_queries'][0]['post_type'] ?? '' ), 'The related query reads the works post type' );

//******************** Home portfolio section ********************//

$GLOBALS['test_query_ids']       = array( 101, 102, 105, 106, 107, 108 );
$GLOBALS['test_published_works'] = 6;
$GLOBALS['test_queries']         = array();
$GLOBALS['test_term_queries']    = array();
$GLOBALS['test_titles'][102]     = 'عمل ثان';
$GLOBALS['test_titles'][105]     = 'عمل ثالث';
$GLOBALS['test_titles'][106]     = 'عمل رابع';
$GLOBALS['test_titles'][107]     = 'عمل خامس';
$GLOBALS['test_titles'][108]     = 'عمل سادس';
$portfolio_output                = render_portfolio();
assert_contains( 'id="portfolio"', $portfolio_output, 'The home section keeps its anchor' );
assert_contains( 'منصة هكتار العقارية الذكية', $portfolio_output, 'The home section renders the works' );
assert_contains( 'عمل سادس', $portfolio_output, 'The home section renders six works' );
assert_true( 6 === substr_count( $portfolio_output, '<article' ), 'The home section renders exactly six work cards' );
assert_not_contains( 'work-showcase-card', $portfolio_output, 'The home section reuses the archive card instead of a showcase variant' );
assert_contains( 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8', $portfolio_output, 'The home section lays its cards out on the archive grid' );
assert_true(
    trim( extract_work_card( $portfolio_output ) ) === trim( render_work_card( 101, 'reveal-delay-100' ) ),
    'The home section renders the archive card markup unchanged'
);
assert_contains( 'https://example.test/works/', $portfolio_output, 'The home section links to the works archive' );
assert_contains( '(+6)', $portfolio_output, 'The home section shows the published works count' );
assert_true( 'works' === ( $GLOBALS['test_queries'][0]['post_type'] ?? '' ), 'The home section queries the works post type' );
assert_true( 6 === ( $GLOBALS['test_queries'][0]['posts_per_page'] ?? 0 ), 'The home section asks for six works' );
assert_contains( 'data-filter="all"', $portfolio_output, 'The home section offers the all filter' );
assert_contains( 'data-filter="platforms"', $portfolio_output, 'The home section offers the taxonomy filters' );
assert_contains( 'data-category="platforms"', $portfolio_output, 'The home section cards carry their taxonomy for the filter' );

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
