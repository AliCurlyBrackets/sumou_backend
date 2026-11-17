<?php
/**
 * Time Line — content is managed from WP Admin > Time Line (ACF Options).
 * Steps without a title are not rendered.
 */

$time_line_badge           = sumou_option( 'time_line_badge', 'منهجية التنفيذ الرصينة' );
$time_line_title           = sumou_option( 'time_line_title', 'مسار عمل هندسي دقيق يقودك نحو' );
$time_line_title_highlight = sumou_option( 'time_line_title_highlight', 'القمة' );
$time_line_subtitle        = sumou_option( 'time_line_subtitle', 'خطوات واضحة وشفافة تبدأ بالتحليل وتنتهي بالنجاح المتسارع المستدام.' );

$time_line_steps = sumou_option( 'time_line_steps', array() );
if ( empty( $time_line_steps ) || ! is_array( $time_line_steps ) ) {
    $time_line_steps = array(
        array(
            'number'      => '01',
            'title'       => 'الاستشارة والتحليل',
            'description' => 'دراسة نموذج عملك، تحليل المنافسين وتحديد الفرص غير المستغلة في السوق.',
            'color'       => 'gold',
        ),
        array(
            'number'      => '02',
            'title'       => 'هندسة الاستراتيجية',
            'description' => 'صياغة خطة العمل الرقمية، هندسة البرمجيات، وتحديد مؤشرات الأداء الأساسية (KPIs).',
            'color'       => 'cyan',
        ),
        array(
            'number'      => '03',
            'title'       => 'التطوير والتنفيذ',
            'description' => 'برمجة الأنظمة، تصميم الهويات البصرية، وإطلاق الحملات التسويقية التجريبية.',
            'color'       => 'gold',
        ),
        array(
            'number'      => '04',
            'title'       => 'الفحص والإطلاق',
            'description' => 'اختبار الأداء، التأكد من تجربة العميل الخالية من العيوب، وتدشين النظام رسمياً.',
            'color'       => 'cyan',
        ),
        array(
            'number'      => '05',
            'title'       => 'النمو والمضاعفة',
            'description' => 'مراقبة التحليلات، التوسع في الميزانيات الرابحة، وتحديث النظم لضمان استدامة السمو.',
            'color'       => 'emerald',
        ),
    );
}

$time_line_step_colors = array(
    'gold'    => array(
        'card'   => 'hover:border-brand-gold',
        'border' => 'border-brand-gold',
        'text'   => 'text-brand-gold',
    ),
    'cyan'    => array(
        'card'   => 'hover:border-cyan-400',
        'border' => 'border-cyan-400',
        'text'   => 'text-cyan-400',
    ),
    'emerald' => array(
        'card'   => 'hover:border-emerald-400',
        'border' => 'border-emerald-400',
        'text'   => 'text-emerald-400',
    ),
);
?>
<!-- BEGIN: ProcessTimeline -->
<section class="py-24 relative overflow-hidden" data-purpose="work-process" id="process">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
<div class="text-center max-w-3xl mx-auto mb-20 space-y-4 reveal-on-scroll">
<div class="inline-block px-4 py-1 rounded-full text-xs font-bold text-brand-gold bg-brand-gold/10 border border-brand-gold/25">
            <?php echo esc_html( $time_line_badge ); ?>
          </div>
<h2 class="text-3xl sm:text-4xl font-black">
            <?php echo esc_html( $time_line_title ); ?> 
            <span class="gold-gradient-text"><?php echo esc_html( $time_line_title_highlight ); ?></span>
</h2>
<p class="text-slate-400 text-sm"><?php echo esc_html( $time_line_subtitle ); ?></p>
</div>
<!-- Interactive Horizontal Timeline Nodes -->
<div class="relative">
<!-- Desktop Connecting Neon Line -->
<div class="hidden lg:block absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-brand-gold via-cyan-500 to-brand-gold transform -translate-y-1/2 z-0 opacity-40"></div>
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 relative z-10">
<?php foreach ( $time_line_steps as $index => $step ) :
    $step_title = $step['title'] ?? '';
    if ( '' === trim( (string) $step_title ) ) {
        continue;
    }
    $step_number = $step['number'] ?? '';
    $step_text   = $step['description'] ?? '';
    $step_color  = $time_line_step_colors[ $step['color'] ?? 'gold' ] ?? $time_line_step_colors['gold'];
    $step_delay  = $index > 0 && $index <= 4 ? ' delay-' . ( $index * 100 ) : '';
?>
<div class="glass-luxury p-6 rounded-2xl border border-slate-700 text-center relative group <?php echo esc_attr( $step_color['card'] ); ?> transition-colors reveal-on-scroll<?php echo esc_attr( $step_delay ); ?>">
<div class="w-14 h-14 rounded-full bg-brand-navy border-2 <?php echo esc_attr( $step_color['border'] ); ?> <?php echo esc_attr( $step_color['text'] ); ?> font-bold flex items-center justify-center mx-auto mb-4 text-lg shadow-lg group-hover:scale-110 transition-transform">
                <?php echo esc_html( $step_number ); ?>
              </div>
<h4 class="font-bold text-white text-base mb-2"><?php echo esc_html( $step_title ); ?></h4>
<p class="text-xs text-slate-300 leading-relaxed">
                <?php echo esc_html( $step_text ); ?>
              </p>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</section>
<!-- END: ProcessTimeline -->
