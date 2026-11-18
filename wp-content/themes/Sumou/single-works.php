<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<?php
$work_id           = get_the_ID();
$work_category     = sumou_get_work_category( $work_id );
$work_accent       = sumou_get_work_accent( $work_id );
$work_badge        = sumou_get_work_badge( $work_id );
$work_sector       = sumou_get_work_sector( $work_id );
$work_metric       = sumou_get_work_metric( $work_id );
$work_result       = sumou_get_work_result( $work_id );
$work_summary      = sumou_get_work_summary( $work_id );
$work_technologies = sumou_get_work_technologies( $work_id );
$works_archive     = get_post_type_archive_link( 'works' );

if ( null === $work_accent ) {
    $work_accent = array(
        'badge'  => 'text-slate-200 border-slate-500/40',
        'metric' => 'bg-slate-700/40 text-slate-200 border-slate-500/40',
        'link'   => 'text-slate-300 hover:text-white',
    );
}
?>

<div class="relative">
<div class="absolute -top-32 right-1/4 w-96 h-96 bg-brand-gold/10 rounded-full blur-[140px] pointer-events-none"></div>
<div class="absolute top-[700px] -left-20 w-[480px] h-[480px] bg-brand-blue/15 rounded-full blur-[150px] pointer-events-none"></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 relative z-10">
<nav aria-label="مسار التنقل" class="flex flex-wrap items-center gap-2 text-xs md:text-sm text-slate-400 mb-8 font-medium">
<a class="hover:text-amber-400 transition-colors flex items-center gap-1.5" href="<?php echo esc_url( home_url( '/' ) ); ?>">
<span class="material-symbols-outlined text-base">home</span>
<span>الرئيسية</span>
</a>
<span class="text-slate-600">/</span>
<?php if ( $works_archive ) : ?>
<a class="hover:text-amber-400 transition-colors" href="<?php echo esc_url( $works_archive ); ?>">سابقة الأعمال</a>
<span class="text-slate-600">/</span>
<?php endif; ?>
<span class="text-amber-300 font-bold"><?php the_title(); ?></span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
<div class="lg:col-span-8 space-y-10">
<header class="space-y-5 reveal-on-scroll">
<?php if ( $work_badge ) : ?>
<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-900/80 border text-xs font-semibold <?php echo esc_attr( $work_accent['badge'] ); ?>">
<span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
            <?php echo esc_html( $work_badge ); ?>
          </div>
<?php endif; ?>
<h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
            <?php the_title(); ?>
          </h1>
<?php if ( $work_summary ) : ?>
<p class="text-slate-300 text-base sm:text-lg leading-relaxed"><?php echo esc_html( $work_summary ); ?></p>
<?php endif; ?>
<?php if ( $work_technologies ) : ?>
<div class="flex flex-wrap gap-2 text-[11px] text-slate-400 font-mono">
<?php foreach ( $work_technologies as $work_technology ) : ?>
<span class="bg-slate-800 px-2.5 py-1 rounded"><?php echo esc_html( $work_technology ); ?></span>
<?php endforeach; ?>
</div>
<?php endif; ?>
</header>

<?php if ( has_post_thumbnail() ) : ?>
<figure class="rounded-3xl overflow-hidden border border-amber-500/25 reveal-on-scroll">
<?php
            echo get_the_post_thumbnail( $work_id, 'full', array(
                'class'   => 'w-full h-64 sm:h-96 object-cover',
                'loading' => 'eager',
            ) );
?>
</figure>
<?php endif; ?>

<?php if ( trim( wp_strip_all_tags( get_the_content() ) ) !== '' ) : ?>
<div class="glass-luxury rounded-3xl p-6 sm:p-8 reveal-on-scroll">
<div class="work-content text-slate-300 text-sm sm:text-base leading-relaxed space-y-4 [&_h2]:text-2xl [&_h2]:font-black [&_h2]:text-white [&_h2]:mt-6 [&_h3]:text-xl [&_h3]:font-bold [&_h3]:text-white [&_h3]:mt-5 [&_ul]:list-disc [&_ul]:pr-5 [&_ul]:space-y-2 [&_a]:text-brand-gold [&_a]:underline [&_strong]:text-white">
<?php the_content(); ?>
</div>
</div>
<?php endif; ?>
</div>

<aside class="lg:col-span-4 sticky top-28 space-y-6">
<div class="glass-luxury rounded-3xl p-6 sm:p-7 border-2 border-amber-500/40 shadow-[0_20px_50px_rgba(0,0,0,0.7)] relative overflow-hidden">
<div class="flex items-center justify-between gap-2 pb-4 mb-5 border-b border-slate-800">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-cyan/20 border border-brand-cyan/40 text-brand-cyan text-xs font-bold">
<span class="w-1.5 h-1.5 rounded-full bg-brand-cyan animate-pulse"></span>
                نتائج المشروع
              </span>
<span class="text-xs text-amber-300 font-bold">وكالة سمو</span>
</div>
<?php if ( $work_sector ) : ?>
<div class="flex items-center justify-between gap-3 pb-3 mb-3 border-b border-slate-800/70 text-xs">
<span class="text-slate-400">القطاع</span>
<span class="text-slate-200 font-bold"><?php echo esc_html( $work_sector ); ?></span>
</div>
<?php endif; ?>
<?php if ( $work_metric ) : ?>
<div class="flex items-center justify-between gap-3 pb-3 mb-3 border-b border-slate-800/70 text-xs">
<span class="text-slate-400">النتيجة الأساسية</span>
<span class="font-bold <?php echo esc_attr( $work_accent['link'] ); ?>"><?php echo esc_html( $work_metric ); ?></span>
</div>
<?php endif; ?>
<?php if ( $work_result ) : ?>
<div class="flex items-center justify-between gap-3 pb-3 mb-5 border-b border-slate-800/70 text-xs">
<span class="text-slate-400">الأثر التجاري</span>
<span class="text-slate-200 font-bold font-num"><?php echo esc_html( $work_result ); ?></span>
</div>
<?php endif; ?>
<a class="w-full gold-btn-gradient py-3.5 rounded-xl text-slate-950 font-black text-sm flex items-center justify-center gap-2 shadow-lg" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">
              اطلب مشروعاً مشابهاً
            </a>
</div>

<?php if ( $works_archive ) : ?>
<a class="block text-center text-xs font-bold text-slate-300 hover:text-amber-300 transition-colors" href="<?php echo esc_url( $works_archive ); ?>">
            عرض جميع الأعمال
          </a>
<?php endif; ?>
</aside>
</div>

<?php
$related_works = new WP_Query( array(
    'post_type'           => 'works',
    'posts_per_page'      => 3,
    'post__not_in'        => array( $work_id ),
    'orderby'             => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
) );

if ( $related_works->have_posts() ) :
?>
<section class="mt-16 sm:mt-24 reveal-on-scroll">
<div class="flex items-end justify-between gap-4 mb-8">
<h2 class="text-2xl sm:text-3xl font-black text-white">أعمال أخرى قد تهمك</h2>
<?php if ( $works_archive ) : ?>
<a class="text-xs font-bold text-amber-300 hover:text-brand-goldLight transition-colors" href="<?php echo esc_url( $works_archive ); ?>">عرض الكل</a>
<?php endif; ?>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
<?php
$related_index = 0;
while ( $related_works->have_posts() ) :
    $related_works->the_post();
    $related_delays = array( 'reveal-delay-100', 'reveal-delay-200', 'reveal-delay-300' );
    get_template_part( 'template-parts/work-card', null, array(
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
