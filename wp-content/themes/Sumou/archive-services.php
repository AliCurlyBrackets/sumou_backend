<?php get_header(); ?>

<div class="relative">
<div class="absolute -top-32 right-1/4 w-96 h-96 bg-brand-gold/10 rounded-full blur-[140px] pointer-events-none"></div>
<div class="absolute top-[600px] -left-20 w-[480px] h-[480px] bg-brand-blue/15 rounded-full blur-[150px] pointer-events-none"></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 relative z-10">
<!-- Breadcrumb -->
<nav aria-label="مسار التنقل" class="flex items-center gap-2 text-xs md:text-sm text-slate-400 mb-8 font-medium">
<a class="hover:text-brand-gold transition-colors flex items-center gap-1.5" href="<?php echo esc_url( home_url( '/' ) ); ?>">
<span class="material-symbols-outlined text-base">home</span>
<span>الرئيسية</span>
</a>
<span class="text-slate-600">/</span>
<span class="text-brand-gold font-bold">خدماتنا</span>
</nav>

<!-- Archive Header -->
<header class="max-w-3xl space-y-5 mb-14 reveal-on-scroll">
<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-900/80 border border-brand-gold/30 text-xs font-semibold text-brand-gold">
<span class="w-2 h-2 rounded-full bg-brand-gold animate-ping"></span>
            منظومة خدمات سُـمُـوّ
          </div>
<h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
            حلول رقمية وهندسية تصنع
            <span class="gold-gradient-text block mt-1">الريادة والنمو الاستثنائي</span>
</h1>
<?php
$services_archive_description = get_the_post_type_description();
if ( $services_archive_description ) :
?>
<p class="text-slate-300 text-sm sm:text-base leading-relaxed"><?php echo esc_html( wp_strip_all_tags( $services_archive_description ) ); ?></p>
<?php else : ?>
<p class="text-slate-300 text-sm sm:text-base leading-relaxed">
            استكشف خدماتنا التخصصية في تطوير المنصات والتطبيقات، والتسويق الرقمي، وحلول الذكاء الاصطناعي والأتمتة.
          </p>
<?php endif; ?>
</header>

<?php if ( have_posts() ) : ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
<?php
$archive_index = 0;
while ( have_posts() ) :
    the_post();
    $archive_delays = array( '', 'delay-100', 'delay-200' );
    get_template_part( 'template-parts/service-card', null, array(
        'post_id' => get_the_ID(),
        'delay'   => $archive_delays[ $archive_index % 3 ],
    ) );
    $archive_index++;
endwhile;
?>
</div>

<div class="mt-14 text-center">
<?php
the_posts_pagination( array(
    'mid_size'  => 1,
    'prev_text' => 'السابق',
    'next_text' => 'التالي',
) );
?>
</div>
<?php else : ?>
<div class="glass-luxury rounded-3xl p-10 text-center text-slate-300 text-sm">
          لا توجد خدمات منشورة حالياً.
        </div>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
