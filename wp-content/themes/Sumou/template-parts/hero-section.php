<?php
/**
 * Hero Section — content is managed from WP Admin > Hero Section (ACF Options).
 */

$hero_badge            = sumou_option( 'hero_badge', 'وكالة استراتيجية لنمو الأعمال الرقمية الذكية' );
$hero_title            = sumou_option( 'hero_title', 'نصنع لعلامتك التجارية حضوراً رقمياً يعلو بها إلى' );
$hero_title_highlight  = sumou_option( 'hero_title_highlight', 'قمم السمو والريادة' );
$hero_subtitle         = sumou_option( 'hero_subtitle', 'ندمج قوة الذكاء الاصطناعي وهندسة البرمجيات المتطورة والتسويق عالي الأداء لمضاعفة إيرادات شركتك، تصدّر محركات البحث، وبناء هوية راسخة تنافس عالمياً.' );

$hero_cta1_label = sumou_option( 'hero_cta1_label', 'ابدأ مشروعك الآن' );
$hero_cta1_link  = sumou_option( 'hero_cta1_link', array( 'url' => '#contact' ) );
$hero_cta1_icon  = sumou_option( 'hero_cta1_icon', 'fa-solid fa-arrow-left' );

$hero_cta2_label = sumou_option( 'hero_cta2_label', 'استكشف سابقة الأعمال' );
$hero_cta2_link  = sumou_option( 'hero_cta2_link', array( 'url' => '#portfolio' ) );
$hero_cta2_icon  = sumou_option( 'hero_cta2_icon', 'fa-solid fa-circle-play' );

$hero_cta1_url = is_array( $hero_cta1_link ) ? ( $hero_cta1_link['url'] ?? '#contact' ) : $hero_cta1_link;
$hero_cta2_url = is_array( $hero_cta2_link ) ? ( $hero_cta2_link['url'] ?? '#portfolio' ) : $hero_cta2_link;

$hero_trust_items = sumou_option( 'hero_trust_items', array() );
if ( empty( $hero_trust_items ) || ! is_array( $hero_trust_items ) ) {
    $hero_trust_items = array(
        array( 'icon' => 'fa-solid fa-shield-halved', 'icon_color' => 'gold', 'text' => 'شريك جوجل وميتا معتمد' ),
        array( 'icon' => 'fa-solid fa-chart-line', 'icon_color' => 'cyan', 'text' => 'عائد استثمار تسويقي موثق (+340%)' ),
        array( 'icon' => 'fa-solid fa-bolt', 'icon_color' => 'amber', 'text' => 'تقنيات وحلول أتمتة AI 2026' ),
    );
}

$hero_trust_colors = array(
    'gold'    => 'text-brand-gold',
    'cyan'    => 'text-brand-cyan',
    'emerald' => 'text-emerald-400',
    'amber'   => 'text-amber-400',
);

$hero_image = sumou_option( 'hero_image', '' );
if ( is_array( $hero_image ) ) {
    $hero_image_url = $hero_image['url'] ?? '';
} elseif ( is_numeric( $hero_image ) ) {
    $hero_image_url = wp_get_attachment_image_url( $hero_image, 'full' );
} else {
    $hero_image_url = $hero_image;
}
if ( empty( $hero_image_url ) ) {
    $hero_image_url = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDxVEfcgq33do_shKnqhWZ9522528umICyAcx5hw8e-RXzajTZhtfA1-8aY8DSM1St-cH8SYlhOmNgqc2N3CLaJY-lcKvMFVjngcW2SY3M9avpladiJgAXnmuZdUAsM6bg-utb_lHq6Xl92cPA5ovs-EbssBrgJ4rq8it6cAVMkR2Ol4t7IMRNEocssF04cq227c8s2Z4ESz6PWHho-FOra_4mNF_AKqqMvIVPPYHhG3Mb_w5qQOeDl';
}

$hero_image_alt    = sumou_option( 'hero_image_alt', 'شعار سمو الذهبي' );
$hero_seo_label    = sumou_option( 'hero_seo_label', 'محركات البحث' );
$hero_seo_value    = sumou_option( 'hero_seo_value', 'SEO Score: 99.8%' );
$hero_ai_label     = sumou_option( 'hero_ai_label', 'الذكاء الاصطناعي' );
$hero_ai_value     = sumou_option( 'hero_ai_value', 'AI Engine Active' );
$hero_growth_text  = sumou_option( 'hero_growth_text', '+320% نمو الأرباح' );
?>

<!-- BEGIN: HeroSection -->
<section class="relative pt-12 pb-24 md:py-28 overflow-hidden" data-purpose="hero-section" id="hero">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
<!-- Hero Text & Pitch -->
<div class="lg:col-span-7 text-center lg:text-right space-y-6 reveal-on-scroll">
<!-- Strategic Badge -->
<div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full border border-amber-500/30 bg-amber-500/10 backdrop-blur-md">
<span class="w-2 h-2 rounded-full bg-brand-gold animate-ping"></span>
<span class="text-xs md:text-sm font-semibold text-brand-goldLight tracking-wide">
                <?php echo esc_html( $hero_badge ); ?>
              </span>
</div>
<!-- Primary Headline -->
<h1 class="text-3xl sm:text-5xl lg:text-6xl font-black leading-tight sm:leading-snug">
              <?php echo esc_html( $hero_title ); ?>
              <span class="gold-gradient-text block mt-1"><?php echo esc_html( $hero_title_highlight ); ?></span>
</h1>
<!-- Subtitle -->
<p class="text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed mx-auto lg:mx-0 font-normal">
              <?php echo esc_html( $hero_subtitle ); ?>
            </p>
<!-- Dual Action CTAs -->
<div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-4">
<?php if ( $hero_cta1_label ) : ?>
<a class="gold-btn-gradient text-slate-950 font-bold px-8 py-3.5 rounded-full text-base flex items-center gap-2.5" href="<?php echo esc_url( $hero_cta1_url ); ?>">
<span><?php echo esc_html( $hero_cta1_label ); ?></span>
<?php if ( $hero_cta1_icon ) : ?>
<i class="<?php echo esc_attr( $hero_cta1_icon ); ?> text-sm"></i>
<?php endif; ?>
</a>
<?php endif; ?>
<?php if ( $hero_cta2_label ) : ?>
<a class="px-7 py-3.5 rounded-full text-base font-semibold border border-brand-cyan/40 bg-brand-navyLight/60 hover:bg-brand-navyLight hover:border-brand-cyan text-brand-cyan transition-all flex items-center gap-2.5" href="<?php echo esc_url( $hero_cta2_url ); ?>">
<?php if ( $hero_cta2_icon ) : ?>
<i class="<?php echo esc_attr( $hero_cta2_icon ); ?> text-brand-cyan"></i>
<?php endif; ?>
<span><?php echo esc_html( $hero_cta2_label ); ?></span>
</a>
<?php endif; ?>
</div>
<!-- Trust Indicators -->
<?php if ( ! empty( $hero_trust_items ) ) : ?>
<div class="pt-6 border-t border-slate-800/80 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs sm:text-sm text-slate-400">
<?php foreach ( $hero_trust_items as $item ) :
    $item_icon  = $item['icon'] ?? '';
    $item_text  = $item['text'] ?? '';
    $item_color = $hero_trust_colors[ $item['icon_color'] ?? 'gold' ] ?? 'text-brand-gold';
    if ( ! $item_text ) {
        continue;
    }
?>
<div class="flex items-center gap-2">
<?php if ( $item_icon ) : ?>
<i class="<?php echo esc_attr( $item_icon . ' ' . $item_color ); ?>"></i>
<?php endif; ?>
<span><?php echo esc_html( $item_text ); ?></span>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
<!-- Hero 3D Graphic Composition -->
<div class="lg:col-span-5 relative flex justify-center items-center reveal-on-scroll delay-200" data-purpose="hero-3d-visual">
<div class="relative w-full max-w-md lg:max-w-none aspect-square flex items-center justify-center">
<!-- Outer Glowing Energy Rings -->
<div class="absolute inset-0 rounded-full border border-brand-gold/20 animate-spin-slow"></div>
<div class="absolute inset-6 rounded-full border border-dashed border-cyan-500/25 animate-spin-reverse"></div>
<div class="absolute inset-16 rounded-full bg-gradient-to-tr from-brand-blue/20 via-transparent to-brand-gold/20 blur-2xl"></div>
<!-- Main Floating Brand Emblem Card -->
<div class="relative z-10 w-72 h-72 sm:w-88 sm:h-88 rounded-3xl p-3 glass-luxury border-2 border-brand-gold/40 shadow-[0_0_50px_rgba(212,165,55,0.25)] animate-float-slow">
<div class="w-full h-full rounded-2xl overflow-hidden relative group">
<img alt="<?php echo esc_attr( $hero_image_alt ); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?php echo esc_url( $hero_image_url ); ?>"/>
<div class="absolute inset-0 bg-gradient-to-t from-brand-navy via-transparent to-transparent opacity-30"></div>
</div>
</div>
<!-- Floating Interactive 3D Badges -->
<!-- Badge 1: SEO Ranking -->
<div class="absolute -top-4 -right-4 sm:top-2 sm:right-0 z-20 glass-luxury px-3.5 py-2.5 rounded-2xl border border-brand-gold/40 flex items-center gap-3 shadow-xl">
<div class="w-10 h-10 rounded-xl bg-amber-500/20 text-brand-gold flex items-center justify-center font-black text-sm">
<i class="fa-solid fa-magnifying-glass-chart"></i>
</div>
<div>
<div class="text-[10px] text-slate-400 font-semibold"><?php echo esc_html( $hero_seo_label ); ?></div>
<div class="text-xs sm:text-sm font-bold text-white"><?php echo esc_html( $hero_seo_value ); ?></div>
</div>
</div>
<!-- Badge 2: AI Engine Active -->
<div class="absolute -bottom-6 -left-4 sm:bottom-4 sm:left-0 z-20 glass-blue px-4 py-2.5 rounded-2xl border border-cyan-400/40 flex items-center gap-3 shadow-xl">
<div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center text-sm font-black animate-pulse">
<i class="fa-solid fa-microchip"></i>
</div>
<div>
<div class="text-[10px] text-cyan-200"><?php echo esc_html( $hero_ai_label ); ?></div>
<div class="text-xs sm:text-sm font-bold text-white"><?php echo esc_html( $hero_ai_value ); ?></div>
</div>
</div>
<!-- Badge 3: Sales Growth Indicator -->
<div class="absolute bottom-20 -right-6 z-20 glass-luxury px-3 py-2 rounded-xl border border-emerald-400/40 flex items-center gap-2 shadow-lg">
<span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
<span class="text-xs font-bold text-emerald-300 font-num"><?php echo esc_html( $hero_growth_text ); ?></span>
<i class="fa-solid fa-arrow-trend-up text-emerald-400 text-xs"></i>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- END: HeroSection -->
