<?php
/**
 * Tecnology Used — content is managed from WP Admin > Tecnology Used (ACF Options).
 */

$tecnology_badge           = sumou_option( 'tecnology_badge', 'ترسانة الابتكار والتقنية' );
$tecnology_title           = sumou_option( 'tecnology_title', 'نعمل بأقوى ما توصلت إليه' );
$tecnology_title_highlight = sumou_option( 'tecnology_title_highlight', 'التقنيات السحابية وهندسة البرمجيات' );

$tecnology_items = sumou_option( 'tecnology_items', array() );
if ( ! is_array( $tecnology_items ) ) {
    $tecnology_items = array();
}
$tecnology_items = array_values( array_filter( $tecnology_items, function ( $item ) {
    return is_array( $item ) && ! empty( $item['text'] );
} ) );
if ( empty( $tecnology_items ) ) {
    $tecnology_items = array(
        array( 'text' => 'React / Next.js 14' ),
        array( 'text' => 'Python & AI LLMs' ),
        array( 'text' => 'Flutter Mobile' ),
        array( 'text' => 'Laravel Enterprise' ),
        array( 'text' => 'AWS Cloud Infrastructure' ),
        array( 'text' => 'Google Cloud & Ads' ),
        array( 'text' => 'Meta Marketing API' ),
    );
}

$tecnology_delays = array( '', ' delay-100', ' delay-200', ' delay-300', ' delay-100', ' delay-200', ' delay-300' );
?>

<!-- BEGIN: TechStackOrbit -->
<section class="py-20 relative overflow-hidden" data-purpose="tech-stack">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-on-scroll">
<div class="inline-block px-4 py-1 rounded-full text-xs font-bold text-brand-cyan bg-brand-cyan/10 border border-brand-cyan/25 mb-4">
          <?php echo esc_html( $tecnology_badge ); ?>
        </div>
<h2 class="text-2xl sm:text-3xl font-black mb-10">
          <?php echo esc_html( $tecnology_title ); ?> <span class="gold-gradient-text"><?php echo esc_html( $tecnology_title_highlight ); ?></span>
</h2>
<!-- Interactive Tech Badges Grid -->
<div class="flex flex-wrap justify-center items-center gap-4 sm:gap-6 max-w-4xl mx-auto">
<?php foreach ( $tecnology_items as $tecnology_index => $tecnology_item ) :
    $tecnology_image = $tecnology_item['image'] ?? '';
    if ( is_array( $tecnology_image ) ) {
        $tecnology_image_url = $tecnology_image['url'] ?? '';
    } elseif ( is_numeric( $tecnology_image ) ) {
        $tecnology_image_url = wp_get_attachment_image_url( $tecnology_image, 'full' );
    } else {
        $tecnology_image_url = $tecnology_image;
    }
    $tecnology_delay = $tecnology_delays[ $tecnology_index % count( $tecnology_delays ) ];
?>
<div class="glass-luxury px-5 py-3 rounded-2xl border border-slate-700 hover:border-brand-gold/60 flex items-center gap-2.5 reveal-on-scroll<?php echo esc_attr( $tecnology_delay ); ?>">
<?php if ( ! empty( $tecnology_image_url ) ) : ?>
<img class="w-6 h-6 object-contain" src="<?php echo esc_url( $tecnology_image_url ); ?>" alt="<?php echo esc_attr( $tecnology_item['text'] ); ?>"/>
<?php endif; ?>
<span class="text-xs sm:text-sm font-bold text-white font-num"><?php echo esc_html( $tecnology_item['text'] ); ?></span>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- END: TechStackOrbit -->
