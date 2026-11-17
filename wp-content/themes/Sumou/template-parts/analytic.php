<?php
/**
 * Stats & Partners — content is managed from WP Admin > Analytics (ACF Options).
 * Any metric, partner or heading left empty is not rendered.
 */

$analytics_stats = sumou_option( 'analytics_stats', array() );
if ( ! is_array( $analytics_stats ) ) {
    $analytics_stats = array();
}
$analytics_stats = array_values( array_filter( $analytics_stats, function ( $stat ) {
    return ! empty( $stat['value'] ) && ! empty( $stat['label'] );
} ) );

$analytics_stats_colors = array(
    'gold'    => 'gold-gradient-text',
    'cyan'    => 'text-brand-cyan',
    'emerald' => 'text-emerald-400',
    'white'   => 'text-white',
);

$analytics_partners_title = sumou_option( 'analytics_partners_title', '' );

$analytics_partners = sumou_option( 'analytics_partners', array() );
if ( ! is_array( $analytics_partners ) ) {
    $analytics_partners = array();
}

// Keep only partners that have a logo, and resolve each logo to a URL.
$analytics_partner_logos = array();
foreach ( $analytics_partners as $partner ) {
    $logo = $partner['logo'] ?? '';
    if ( is_array( $logo ) ) {
        $logo_url = $logo['url'] ?? '';
        $logo_alt = $partner['name'] ?? ( $logo['alt'] ?? '' );
    } elseif ( is_numeric( $logo ) ) {
        $logo_url = wp_get_attachment_image_url( $logo, 'full' );
        $logo_alt = $partner['name'] ?? '';
    } else {
        $logo_url = $logo;
        $logo_alt = $partner['name'] ?? '';
    }

    if ( empty( $logo_url ) ) {
        continue;
    }

    $analytics_partner_logos[] = array(
        'url' => $logo_url,
        'alt' => $logo_alt,
    );
}

// Nothing configured yet: render nothing at all.
if ( empty( $analytics_stats ) && empty( $analytics_partner_logos ) && empty( $analytics_partners_title ) ) {
    return;
}

// The marquee is two identical halves that slide by exactly one half width.
// Each half must be wider than the strip itself, otherwise a blank gap travels
// across it — so the logo set is repeated until the half is long enough.
$marquee_half     = array();
$marquee_duration = 35;
if ( ! empty( $analytics_partner_logos ) ) {
    $marquee_min_per_half = 16;
    $marquee_repeat       = max( 1, (int) ceil( $marquee_min_per_half / count( $analytics_partner_logos ) ) );
    for ( $marquee_i = 0; $marquee_i < $marquee_repeat; $marquee_i++ ) {
        $marquee_half = array_merge( $marquee_half, $analytics_partner_logos );
    }
    // Keep the scroll speed steady no matter how many logos are repeated.
    $marquee_duration = max( 35, count( $marquee_half ) * 4 );
}
?>
<!-- BEGIN: StatsAndPartners -->
<section class="py-12 border-y border-amber-500/15 bg-brand-navyLight/50 relative overflow-hidden" data-purpose="stats-and-social-proof">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<?php if ( ! empty( $analytics_stats ) ) : ?>
<!-- Key Numeric Metric Counters -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8 <?php echo ! empty( $analytics_partner_logos ) ? 'mb-12' : ''; ?>">
<?php foreach ( $analytics_stats as $index => $stat ) :
    $stat_color = $analytics_stats_colors[ $stat['color'] ?? 'gold' ] ?? 'gold-gradient-text';
    $stat_delay = $index > 0 && $index <= 3 ? ' delay-' . ( $index * 100 ) : '';
?>
<div class="text-center p-4 rounded-2xl border border-slate-800 bg-brand-navy/60 reveal-on-scroll<?php echo esc_attr( $stat_delay ); ?>">
<div class="text-3xl sm:text-4xl lg:text-5xl font-black font-num <?php echo esc_attr( $stat_color ); ?> mb-1"><?php echo esc_html( $stat['value'] ); ?></div>
<div class="text-xs sm:text-sm text-slate-300 font-medium"><?php echo esc_html( $stat['label'] ); ?></div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ( ! empty( $analytics_partner_logos ) ) : ?>
<!-- Prestigious Client Brand Marquee Strip -->
<div class="pt-4 border-t border-slate-800/80 reveal-on-scroll">
<?php if ( $analytics_partners_title ) : ?>
<p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400 mb-6">
            <?php echo esc_html( $analytics_partners_title ); ?>
          </p>
<?php endif; ?>
<div class="logo-marquee relative overflow-hidden">
<!-- Edge fades -->
<div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-12 md:w-24 bg-gradient-to-l from-brand-navyLight to-transparent"></div>
<div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-12 md:w-24 bg-gradient-to-r from-brand-navyLight to-transparent"></div>
<div class="logo-marquee-track" style="animation-duration: <?php echo esc_attr( $marquee_duration ); ?>s">
<?php for ( $group = 0; $group < 2; $group++ ) : ?>
<div class="flex shrink-0 items-center gap-8 pe-8 md:gap-14 md:pe-14"<?php echo $group ? ' aria-hidden="true"' : ''; ?>>
<?php foreach ( $marquee_half as $partner_logo ) : ?>
<div class="flex h-16 md:h-20 items-center justify-center rounded-2xl border border-slate-800 bg-brand-navy/60 px-6 md:px-8">
<img alt="<?php echo esc_attr( $partner_logo['alt'] ); ?>" class="h-9 md:h-11 w-auto max-w-[140px] object-contain" loading="lazy" src="<?php echo esc_url( $partner_logo['url'] ); ?>"/>
</div>
<?php endforeach; ?>
</div>
<?php endfor; ?>
</div>
</div>
</div>
<?php endif; ?>
</div>
</section>
<!-- END: StatsAndPartners -->
