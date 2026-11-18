<?php
/**
 * Baka — content is managed from WP Admin > Baka (ACF Options).
 * Packages without a name are not rendered. This section does not show prices.
 */

$baka_badge           = sumou_option( 'baka_badge', 'باقات الاستثمار والنمو' );
$baka_title           = sumou_option( 'baka_title', 'استثمار مدروس يضمن ' );
$baka_title_highlight = sumou_option( 'baka_title_highlight', 'عائدات تفوق التوقعات' );
$baka_description     = sumou_option( 'baka_description', 'اختر الباقة المناسبة لمرحلة نمو مشروعك الحالية مع إمكانية التخصيص الكامل.' );

$baka_packages = sumou_option( 'baka_packages', array() );
if ( empty( $baka_packages ) || ! is_array( $baka_packages ) ) {
    $baka_packages = array(
        array(
            'tier'           => 'باقة الانطلاق',
            'name'           => 'Start Growth',
            'description'    => 'مثالية للشركات الناشئة والمتاجر الجديدة الراغبة في تأسيس حضور قوي وسريع.',
            'features'       => "إدارة وتطوير متجر/موقع إلكتروني\nإدارة إعلانات ممولة لمنصتين مختارتين\n12 تصميم احترافي + 4 فيديوهات قصيرة\nتحسين السيو الداخلي الأساسي\nتقرير تحليلي شهري مفصل بالأرقام",
            'cta_label'      => 'اختر باقة الانطلاق',
            'cta_link'       => '#contact',
            'color'          => 'gold',
            'featured'       => false,
            'featured_badge' => 'الباقة الأكثر طلباً والأنسب للنمو',
        ),
        array(
            'tier'           => 'باقة السمو الاحترافية',
            'name'           => 'Sumou Pro Scale',
            'description'    => 'الحل الشامل للشركات الطموحة للسيطرة على السوق ومضاعفة المبيعات بأدوات الذكاء الاصطناعي.',
            'features'       => "برمجة وتطوير مستمر للمنصة / التطبيق\nإدارة كاملة للحملات الإعلانية (Google, Meta, TikTok)\nنظام SEO متقدم وتتصدر الصفحة الأولى\nدمج روبوت محادثة ذكي AI Chatbot\nإنتاج محتوى إبداعي غير محدود وهوية متجددة\nمدير حساب استراتيجي واجتماعات أسبوعية",
            'cta_label'      => 'ابدأ مع باقة السمو الاحترافية',
            'cta_link'       => '#contact',
            'color'          => 'gold',
            'featured'       => true,
            'featured_badge' => 'الباقة الأكثر طلباً والأنسب للنمو',
        ),
        array(
            'tier'           => 'باقة المؤسسات الكبرى',
            'name'           => 'Enterprise Sovereign',
            'description'    => 'مخصصة للشركات والجهات الحكومية التي تتطلب حلول برمجية وتسويقية مخصصة بالكامل.',
            'features'       => "فريق هندسي وتسويقي مخصص بالكامل (Dedicated Team)\nتطوير منصات مخصصة وسحابية ضخمة\nاستشارات حوكمة البيانات وأمن المعلومات (Cybersecurity)\nدعم فني متميز وتقارير تنفيذية لمجلس الإدارة\nاتفاقيات مستوى خدمة صارمة (SLA 99.9%)",
            'cta_label'      => 'طلب استشارة مخصصة',
            'cta_link'       => '#contact',
            'color'          => 'cyan',
            'featured'       => false,
            'featured_badge' => 'الباقة الأكثر طلباً والأنسب للنمو',
        ),
    );
}

$baka_styles = array(
    'gold' => array(
        'card'        => 'glass-luxury rounded-3xl p-8 border border-slate-700/80 flex flex-col justify-between reveal-on-scroll',
        'tier'        => 'text-slate-400',
        'description' => 'text-slate-300',
        'features'    => 'text-slate-300',
        'icon'        => 'fa-solid fa-check text-brand-gold',
        'button'      => 'py-3 font-bold border border-slate-600 hover:border-brand-gold text-white hover:text-brand-gold transition-colors',
    ),
    'cyan' => array(
        'card'        => 'glass-luxury rounded-3xl p-8 border border-slate-700/80 flex flex-col justify-between reveal-on-scroll',
        'tier'        => 'text-cyan-400',
        'description' => 'text-slate-300',
        'features'    => 'text-slate-300',
        'icon'        => 'fa-solid fa-check text-cyan-400',
        'button'      => 'py-3 font-bold border border-cyan-400 text-cyan-300 hover:bg-cyan-500 hover:text-slate-950 transition-colors',
    ),
    'featured' => array(
        'card'        => 'relative glass-luxury rounded-3xl p-8 border-2 border-brand-gold shadow-[0_0_40px_rgba(212,165,55,0.3)] flex flex-col justify-between transform lg:-translate-y-4 reveal-on-scroll',
        'tier'        => 'text-brand-goldLight mt-2',
        'description' => 'text-slate-300',
        'features'    => 'text-slate-200',
        'icon'        => 'fa-solid fa-circle-check text-brand-gold',
        'button'      => 'py-3.5 font-black gold-btn-gradient text-slate-950 shadow-xl',
    ),
);
?>
<!-- BEGIN: PricingAndPackages -->
<section class="py-24 bg-[#0A1020]/90 border-t border-slate-800" data-purpose="pricing-packages" id="packages">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="text-center max-w-3xl mx-auto mb-16 space-y-4 reveal-on-scroll">
<div class="inline-block px-4 py-1 rounded-full text-xs font-bold text-brand-gold bg-brand-gold/10 border border-brand-gold/25">
            <?php echo esc_html( $baka_badge ); ?>
          </div>
<h2 class="text-3xl sm:text-4xl font-black">
            <?php echo esc_html( $baka_title ); ?>
            <span class="gold-gradient-text"><?php echo esc_html( $baka_title_highlight ); ?></span>
</h2>
<p class="text-slate-400 text-sm"><?php echo esc_html( $baka_description ); ?></p>
</div>
<!-- Packages -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
<?php foreach ( $baka_packages as $index => $package ) :
    $package_name = $package['name'] ?? '';
    if ( '' === trim( (string) $package_name ) ) {
        continue;
    }

    $package_tier     = $package['tier'] ?? '';
    $package_text     = $package['description'] ?? '';
    $package_cta      = $package['cta_label'] ?? '';
    $package_link     = $package['cta_link'] ?? '#contact';
    $is_featured      = ! empty( $package['featured'] );
    $style_key        = $is_featured ? 'featured' : ( $package['color'] ?? 'gold' );
    $style            = $baka_styles[ $style_key ] ?? $baka_styles['gold'];
    $featured_badge   = $is_featured ? ( $package['featured_badge'] ?? 'الباقة الأكثر طلباً والأنسب للنمو' ) : '';
    $package_delay    = $index > 0 && $index <= 4 ? ' delay-' . ( $index * 100 ) : '';
    $package_features = $package['features'] ?? '';
    $feature_lines    = is_string( $package_features )
        ? array_filter( array_map( 'trim', explode( "\n", $package_features ) ), 'strlen' )
        : array();
?>
<div class="<?php echo esc_attr( $style['card'] . $package_delay ); ?>" data-purpose="<?php echo $is_featured ? 'featured-pricing-card' : 'pricing-card'; ?>">
<?php if ( $is_featured && '' !== trim( (string) $featured_badge ) ) : ?>
<div class="absolute -top-4 inset-x-0 mx-auto w-max px-4 py-1 rounded-full text-[11px] font-black bg-brand-gold text-slate-950 uppercase tracking-wider shadow-lg">
              <?php echo esc_html( $featured_badge ); ?>
            </div>
<?php endif; ?>
<div>
<div class="<?php echo esc_attr( $style['tier'] ); ?> text-xs font-bold uppercase tracking-wider mb-2"><?php echo esc_html( $package_tier ); ?></div>
<h3 class="text-2xl font-bold text-white mb-4"><?php echo esc_html( $package_name ); ?></h3>
<p class="text-xs <?php echo esc_attr( $style['description'] ); ?> mb-6"><?php echo esc_html( $package_text ); ?></p>
<ul class="space-y-3.5 text-xs <?php echo esc_attr( $style['features'] ); ?>">
<?php foreach ( $feature_lines as $feature ) : ?>
<li class="flex items-center gap-2"><i class="<?php echo esc_attr( $style['icon'] ); ?>"></i> <?php echo esc_html( $feature ); ?></li>
<?php endforeach; ?>
</ul>
</div>
<a class="mt-8 block text-center rounded-full text-xs <?php echo esc_attr( $style['button'] ); ?>" href="<?php echo esc_url( $package_link ); ?>">
              <?php echo esc_html( $package_cta ); ?>
            </a>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- END: PricingAndPackages -->
