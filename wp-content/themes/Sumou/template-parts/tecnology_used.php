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
        array( 'icon' => 'fa-brands fa-react', 'icon_color' => 'cyan', 'text' => 'React / Next.js 14' ),
        array( 'icon' => 'fa-brands fa-python', 'icon_color' => 'amber-light', 'text' => 'Python & AI LLMs' ),
        array( 'icon' => 'fa-brands fa-flutter', 'icon_color' => 'blue-light', 'text' => 'Flutter Mobile' ),
        array( 'icon' => 'fa-brands fa-laravel', 'icon_color' => 'red', 'text' => 'Laravel Enterprise' ),
        array( 'icon' => 'fa-brands fa-aws', 'icon_color' => 'amber', 'text' => 'AWS Cloud Infrastructure' ),
        array( 'icon' => 'fa-brands fa-google', 'icon_color' => 'blue', 'text' => 'Google Cloud & Ads' ),
        array( 'icon' => 'fa-brands fa-meta', 'icon_color' => 'blue-deep', 'text' => 'Meta Marketing API' ),
    );
}

$tecnology_color_styles = array(
    'cyan'        => array( 'text-cyan-400', 'hover:border-cyan-400' ),
    'amber-light' => array( 'text-amber-300', 'hover:border-amber-400' ),
    'blue-light'  => array( 'text-blue-400', 'hover:border-blue-400' ),
    'red'         => array( 'text-red-500', 'hover:border-red-400' ),
    'amber'       => array( 'text-amber-500', 'hover:border-amber-500' ),
    'blue'        => array( 'text-blue-500', 'hover:border-blue-500' ),
    'blue-deep'   => array( 'text-blue-500', 'hover:border-blue-600' ),
    'gold'        => array( 'text-brand-gold', 'hover:border-brand-gold/60' ),
);

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
    $tecnology_color = $tecnology_color_styles[ $tecnology_item['icon_color'] ?? 'gold' ] ?? $tecnology_color_styles['gold'];
    $tecnology_delay = $tecnology_delays[ $tecnology_index % count( $tecnology_delays ) ];
?>
<div class="glass-luxury px-5 py-3 rounded-2xl border border-slate-700 <?php echo esc_attr( $tecnology_color[1] ); ?> flex items-center gap-2.5 reveal-on-scroll<?php echo esc_attr( $tecnology_delay ); ?>">
<i class="<?php echo esc_attr( trim( ( $tecnology_item['icon'] ?? '' ) . ' ' . $tecnology_color[0] . ' text-lg' ) ); ?>"></i>
<span class="text-xs sm:text-sm font-bold text-white font-num"><?php echo esc_html( $tecnology_item['text'] ); ?></span>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- END: TechStackOrbit -->
