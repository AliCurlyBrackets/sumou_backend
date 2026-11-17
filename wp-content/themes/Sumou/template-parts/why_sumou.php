<?php
/**
 * Why Sumou — content is managed from WP Admin > Why Sumou (ACF Options).
 */

$why_sumou_badge           = sumou_option( 'why_sumou_badge', 'لماذا وكالة سمو؟' );
$why_sumou_title           = sumou_option( 'why_sumou_title', 'لا نقدّم وعوداً رنانة، بل نصيغ' );
$why_sumou_title_highlight = sumou_option( 'why_sumou_title_highlight', 'معادلات نمو هندسية حتمية' );
$why_sumou_description     = sumou_option( 'why_sumou_description', 'تأسست "سُـمـوّ" لردم الفجوة بين التقنيات البرمجية المعقدة والاستراتيجيات التسويقية المربحة. نحن نعمل كامتداد استراتيجي لمجلس إدارتك وفريقك الداخلي.' );

$why_sumou_pillars = sumou_option( 'why_sumou_pillars', array() );
if ( ! is_array( $why_sumou_pillars ) ) {
    $why_sumou_pillars = array();
}
$why_sumou_pillars = array_values( array_filter( $why_sumou_pillars, function ( $pillar ) {
    return ! empty( $pillar['title'] );
} ) );
if ( empty( $why_sumou_pillars ) ) {
    $why_sumou_pillars = array(
        array(
            'title'       => 'فريق نخبوي متكامل',
            'description' => 'خبراء برمجيات، مسوقون معتمدون، ومحللو بيانات بخبرات إقليمية وعالمية عريضة.',
            'color'       => 'gold',
        ),
        array(
            'title'       => 'قرارات مبنية على الأرقام',
            'description' => 'نستبعد التخمين تماماً؛ تحليلات دقيقة وسجلات عائد استثمار (ROI) موثقة لحظة بلحظة.',
            'color'       => 'cyan',
        ),
        array(
            'title'       => 'معمارية سحابية ذكية',
            'description' => 'تطوير حلول برمجية قابلة للتوسع اللامتناهي تتحمل ملايين الزيارات دون انقطاع.',
            'color'       => 'gold',
        ),
        array(
            'title'       => 'شراكة استراتيجية 24/7',
            'description' => 'فريق دعم مخصص، استشارات دورية مع صناع القرار، ومواكبة لحظية لتحديثات الأسواق.',
            'color'       => 'cyan',
        ),
    );
}

$why_sumou_pillar_colors = array(
    'gold' => 'bg-amber-500/20 text-brand-gold',
    'cyan' => 'bg-cyan-500/20 text-cyan-400',
);

$why_sumou_image = sumou_option( 'why_sumou_image', '' );
if ( is_array( $why_sumou_image ) ) {
    $why_sumou_image_url = $why_sumou_image['url'] ?? '';
} elseif ( is_numeric( $why_sumou_image ) ) {
    $why_sumou_image_url = wp_get_attachment_image_url( $why_sumou_image, 'full' );
} else {
    $why_sumou_image_url = $why_sumou_image;
}
if ( empty( $why_sumou_image_url ) ) {
    $why_sumou_image_url = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDxVEfcgq33do_shKnqhWZ9522528umICyAcx5hw8e-RXzajTZhtfA1-8aY8DSM1St-cH8SYlhOmNgqc2N3CLaJY-lcKvMFVjngcW2SY3M9avpladiJgAXnmuZdUAsM6bg-utb_lHq6Xl92cPA5ovs-EbssBrgJ4rq8it6cAVMkR2Ol4t7IMRNEocssF04cq227c8s2Z4ESz6PWHho-FOra_4mNF_AKqqMvIVPPYHhG3Mb_w5qQOeDl';
}

$why_sumou_image_alt       = sumou_option( 'why_sumou_image_alt', 'رمز صقر السمو' );
$why_sumou_emblem_title    = sumou_option( 'why_sumou_emblem_title', 'درع الحماية والنمو السيبراني' );
$why_sumou_emblem_subtitle = sumou_option( 'why_sumou_emblem_subtitle', 'SUMOU ENTERPRISE GRADE' );
$why_sumou_tag_icon        = sumou_option( 'why_sumou_tag_icon', 'fa-solid fa-shield-cat' );
$why_sumou_tag_text        = sumou_option( 'why_sumou_tag_text', 'حماية وحوكمة بيانات 100%' );
?>

<!-- BEGIN: WhySumou (Strategic Pillars) -->
<section class="py-24 bg-[#0A1122]/70 relative border-y border-slate-800" data-purpose="why-choose-sumou" id="about">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
<!-- Left Visual: Holographic Cyber Shield with Brand Eagle -->
<div class="lg:col-span-5 order-2 lg:order-1 flex justify-center reveal-on-scroll">
<div class="relative w-80 h-80 sm:w-96 sm:h-96 flex items-center justify-center">
<!-- Concentric Cyber Circuit Rings -->
<div class="absolute inset-0 rounded-full border border-amber-500/20 animate-radar"></div>
<div class="absolute inset-8 rounded-full border border-dashed border-cyan-500/30"></div>
<!-- Emblem Shield Container -->
<div class="relative z-10 w-64 h-64 rounded-3xl glass-luxury border-2 border-brand-gold/60 p-4 shadow-[0_0_40px_rgba(212,165,55,0.25)] flex flex-col items-center justify-center text-center">
<img alt="<?php echo esc_attr( $why_sumou_image_alt ); ?>" class="w-36 h-36 object-contain drop-shadow-[0_0_20px_rgba(212,165,55,0.5)] mb-2" src="<?php echo esc_url( $why_sumou_image_url ); ?>"/>
<div class="text-sm font-bold text-white"><?php echo esc_html( $why_sumou_emblem_title ); ?></div>
<div class="text-[11px] text-brand-goldLight font-semibold"><?php echo esc_html( $why_sumou_emblem_subtitle ); ?></div>
</div>
<!-- Floating Micro Tag -->
<div class="absolute top-4 left-0 glass-blue px-3 py-1.5 rounded-xl border border-cyan-400/40 text-xs font-bold text-cyan-300 shadow-md">
<?php if ( $why_sumou_tag_icon ) : ?>
<i class="<?php echo esc_attr( $why_sumou_tag_icon ); ?> ml-1"></i>
<?php endif; ?>
<?php echo esc_html( $why_sumou_tag_text ); ?>
              </div>
</div>
</div>
<!-- Right Content: The 4 Pillars of Excellence -->
<div class="lg:col-span-7 order-1 lg:order-2 space-y-6 reveal-on-scroll delay-100">
<div class="inline-block px-4 py-1 rounded-full text-xs font-bold text-brand-cyan bg-brand-cyan/10 border border-brand-cyan/25">
              <?php echo esc_html( $why_sumou_badge ); ?>
            </div>
<h2 class="text-3xl sm:text-4xl font-black leading-tight">
              <?php echo esc_html( $why_sumou_title ); ?>
              <span class="gold-gradient-text"><?php echo esc_html( $why_sumou_title_highlight ); ?></span>
</h2>
<p class="text-slate-300 text-sm sm:text-base leading-relaxed">
              <?php echo esc_html( $why_sumou_description ); ?>
            </p>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-4">
<?php foreach ( $why_sumou_pillars as $why_sumou_index => $why_sumou_pillar ) :
    $why_sumou_pillar_color = $why_sumou_pillar_colors[ $why_sumou_pillar['color'] ?? 'gold' ] ?? 'bg-amber-500/20 text-brand-gold';
    $why_sumou_delay        = $why_sumou_index > 0 && $why_sumou_index <= 3 ? ' delay-' . ( $why_sumou_index * 100 ) : '';
?>
<!-- Pillar <?php echo esc_html( $why_sumou_index + 1 ); ?> -->
<div class="glass-luxury p-5 rounded-2xl border border-slate-700/60 reveal-on-scroll<?php echo esc_attr( $why_sumou_delay ); ?>">
<div class="flex items-center gap-3 mb-2">
<span class="w-8 h-8 rounded-lg <?php echo esc_attr( $why_sumou_pillar_color ); ?> flex items-center justify-center font-bold font-num text-sm"><?php echo esc_html( sprintf( '%02d', $why_sumou_index + 1 ) ); ?></span>
<h4 class="font-bold text-white text-base"><?php echo esc_html( $why_sumou_pillar['title'] ); ?></h4>
</div>
<p class="text-xs text-slate-300 leading-relaxed">
                  <?php echo esc_html( $why_sumou_pillar['description'] ?? '' ); ?>
                </p>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</section>
<!-- END: WhySumou -->
