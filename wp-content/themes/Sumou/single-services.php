<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<?php
$service_id       = get_the_ID();
$service_icon_url = sumou_get_service_icon_url( $service_id );
$service_summary  = sumou_get_service_summary( $service_id );
$service_features = sumou_get_service_features( $service_id );
$service_accent   = sumou_get_service_accent( $service_id );
$services_archive = get_post_type_archive_link( 'services' );
?>

<div class="relative">
<div class="absolute -top-32 right-1/4 w-96 h-96 bg-brand-gold/10 rounded-full blur-[140px] pointer-events-none"></div>
<div class="absolute top-[700px] -left-20 w-[480px] h-[480px] bg-brand-blue/15 rounded-full blur-[150px] pointer-events-none"></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 relative z-10">
<!-- Breadcrumb -->
<nav aria-label="مسار التنقل" class="flex flex-wrap items-center gap-2 text-xs md:text-sm text-slate-400 mb-8 font-medium">
<a class="hover:text-brand-gold transition-colors flex items-center gap-1.5" href="<?php echo esc_url( home_url( '/' ) ); ?>">
<span class="material-symbols-outlined text-base">home</span>
<span>الرئيسية</span>
</a>
<span class="text-slate-600">/</span>
<?php if ( $services_archive ) : ?>
<a class="hover:text-brand-gold transition-colors" href="<?php echo esc_url( $services_archive ); ?>">خدماتنا</a>
<span class="text-slate-600">/</span>
<?php endif; ?>
<span class="text-brand-gold font-bold"><?php the_title(); ?></span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
<!-- Main content -->
<div class="lg:col-span-8 space-y-10">
<header class="space-y-5 reveal-on-scroll">
<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-900/80 border border-brand-gold/30 text-xs font-semibold text-brand-gold">
<span class="w-2 h-2 rounded-full bg-brand-gold animate-ping"></span>
            خدمة تخصصية من وكالة سُـمُـوّ
          </div>
<h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
            <?php the_title(); ?>
          </h1>
<?php if ( $service_summary ) : ?>
<p class="text-slate-300 text-base sm:text-lg leading-relaxed"><?php echo esc_html( $service_summary ); ?></p>
<?php endif; ?>
</header>

<?php if ( has_post_thumbnail() ) : ?>
<!-- Featured Image (Services > Service > Featured Image) -->
<figure class="rounded-3xl overflow-hidden border border-brand-gold/25 reveal-on-scroll">
<?php
            echo get_the_post_thumbnail( $service_id, 'full', array(
                'class'   => 'w-full h-64 sm:h-80 object-cover',
                'loading' => 'eager',
            ) );
?>
</figure>
<?php endif; ?>

<?php if ( trim( wp_strip_all_tags( get_the_content() ) ) !== '' ) : ?>
<div class="glass-luxury rounded-3xl p-6 sm:p-8 reveal-on-scroll">
<div class="service-content text-slate-300 text-sm sm:text-base leading-relaxed space-y-4 [&_h2]:text-2xl [&_h2]:font-black [&_h2]:text-white [&_h2]:mt-6 [&_h3]:text-xl [&_h3]:font-bold [&_h3]:text-white [&_h3]:mt-5 [&_ul]:list-disc [&_ul]:pr-5 [&_ul]:space-y-2 [&_a]:text-brand-gold [&_a]:underline [&_strong]:text-white">
<?php the_content(); ?>
</div>
</div>
<?php endif; ?>

<?php if ( ! empty( $service_features ) ) : ?>
<section class="glass-luxury rounded-3xl p-6 sm:p-8 reveal-on-scroll">
<h2 class="text-xl sm:text-2xl font-black text-white mb-5">ماذا تشمل هذه الخدمة؟</h2>
<ul class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs sm:text-sm">
<?php foreach ( $service_features as $service_feature ) : ?>
<li class="flex items-start gap-2.5 text-slate-200">
<i class="fa-solid fa-circle-check <?php echo esc_attr( $service_accent['check'] ); ?> mt-0.5"></i>
<span><?php echo esc_html( $service_feature ); ?></span>
</li>
<?php endforeach; ?>
</ul>
</section>
<?php endif; ?>
</div>

<!-- Sticky sidebar -->
<aside class="lg:col-span-4 sticky top-28 space-y-6">
<div class="glass-luxury rounded-3xl p-6 sm:p-7 border-2 border-brand-gold/40 shadow-[0_20px_50px_rgba(0,0,0,0.7)] relative overflow-hidden">
<div class="flex items-center justify-between gap-2 pb-4 mb-5 border-b border-slate-800">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-cyan/20 border border-brand-cyan/40 text-brand-cyan text-xs font-bold">
<span class="w-1.5 h-1.5 rounded-full bg-brand-cyan animate-pulse"></span>
                استشارة فورية
              </span>
<span class="text-xs text-brand-gold font-bold">وكالة سمو</span>
</div>
<?php if ( $service_icon_url ) : ?>
<div class="w-16 h-16 rounded-2xl border <?php echo esc_attr( $service_accent['icon_box'] ); ?> flex items-center justify-center mb-4 p-2.5">
<img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-contain" src="<?php echo esc_url( $service_icon_url ); ?>"/>
</div>
<?php endif; ?>
<h2 class="text-xl font-black text-white mb-2"><?php the_title(); ?></h2>
<?php if ( $service_summary ) : ?>
<p class="text-xs text-slate-300 leading-relaxed mb-5"><?php echo esc_html( $service_summary ); ?></p>
<?php endif; ?>
<a class="w-full gold-btn-gradient py-3.5 rounded-xl text-slate-950 font-black text-sm flex items-center justify-center gap-2 shadow-lg" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">
<!-- <span class="material-symbols-outlined text-lg">rocket_launch</span> -->
              اطلب هذه الخدمة الآن
            </a>
<div class="mt-5 pt-5 border-t border-slate-800 space-y-2.5 text-[11px] text-slate-400">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-brand-gold text-xs">verified_user</span>
                سرية تامة لاتفاقية عدم الإفصاح (NDA).
              </div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-brand-cyan text-xs">tune</span>
                عقود مرنة بدون شروط مقيدة.
              </div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-emerald-400 text-xs">task_alt</span>
                تقارير تفاعلية مدعومة بالبيانات.
              </div>
</div>
</div>

<?php if ( $services_archive ) : ?>
<a class="block text-center text-xs font-bold text-slate-300 hover:text-brand-gold transition-colors" href="<?php echo esc_url( $services_archive ); ?>">
            عرض جميع الخدمات
          </a>
<?php endif; ?>
</aside>
</div>

<?php
$related_services = new WP_Query( array(
    'post_type'           => 'services',
    'posts_per_page'      => 3,
    'post__not_in'        => array( $service_id ),
    'orderby'             => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
) );

if ( $related_services->have_posts() ) :
?>
<section class="mt-16 sm:mt-24 reveal-on-scroll">
<div class="flex items-end justify-between gap-4 mb-8">
<h2 class="text-2xl sm:text-3xl font-black text-white">خدمات أخرى قد تهمك</h2>
<?php if ( $services_archive ) : ?>
<a class="text-xs font-bold text-brand-gold hover:text-brand-goldLight transition-colors" href="<?php echo esc_url( $services_archive ); ?>">عرض الكل</a>
<?php endif; ?>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
<?php
$related_index = 0;
while ( $related_services->have_posts() ) :
    $related_services->the_post();
    $related_delays = array( '', 'delay-100', 'delay-200' );
    get_template_part( 'template-parts/service-card', null, array(
        'post_id' => get_the_ID(),
        'delay'   => $related_delays[ $related_index % 3 ],
    ) );
    $related_index++;
endwhile;
wp_reset_postdata();
?>
</div>
</section>
<?php endif; ?>
</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
