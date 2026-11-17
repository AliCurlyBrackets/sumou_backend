<?php
/**
 * Services grid — shows the first 6 Services posts (Services > All Services).
 * Each card is rendered from template-parts/service-card.php.
 */

$services_query = new WP_Query( array(
    'post_type'           => 'services',
    'posts_per_page'      => 6,
    'orderby'             => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
) );

if ( ! $services_query->have_posts() ) {
    return;
}
?>
<!-- BEGIN: ServicesSection -->
<section class="py-24 relative" data-purpose="services-grid" id="services">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
<!-- Section Header -->
<div class="text-center max-w-3xl mx-auto mb-16 space-y-4 reveal-on-scroll">
<div class="inline-block px-4 py-1 rounded-full text-xs font-bold text-brand-gold bg-brand-gold/10 border border-brand-gold/25">
            منظومة خدماتنا المتكاملة
          </div>
<h2 class="text-3xl sm:text-4xl lg:text-5xl font-black">
            حلول رقمية شاملة تنقلك من التواجد العادي إلى 
            <span class="gold-gradient-text">الريادة المطلقة</span>
</h2>
<p class="text-slate-400 text-sm sm:text-base leading-relaxed">
            نصمم ونطور كل تفصيلة وفق معايير عالمية تجمع بين الفن التسويقي والهندسة التقنية الدقيقة.
          </p>
</div>
<!-- 6 Interactive Luxury Glass Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
<?php
$service_index = 0;
while ( $services_query->have_posts() ) :
    $services_query->the_post();
    $service_delays = array( '', 'delay-100', 'delay-200' );
    get_template_part( 'template-parts/service-card', null, array(
        'post_id' => get_the_ID(),
        'delay'   => $service_delays[ $service_index % 3 ],
    ) );
    $service_index++;
endwhile;
wp_reset_postdata();
?>
</div>
</div>
</section>
<!-- END: ServicesSection -->
