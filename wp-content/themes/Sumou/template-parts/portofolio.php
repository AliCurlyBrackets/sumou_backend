<!-- BEGIN: PortfolioSection -->
<?php
$portfolio_query = new WP_Query( array(
    'post_type'           => 'works',
    'posts_per_page'      => 6,
    'orderby'             => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
) );

$portfolio_archive = get_post_type_archive_link( 'works' );
$portfolio_count   = wp_count_posts( 'works' )->publish;
$portfolio_delays  = array( '', 'delay-100', 'delay-200' );
?>
<section class="py-24 bg-brand-navyLight/40 border-t border-slate-800" data-purpose="portfolio-showcase" id="portfolio">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6 reveal-on-scroll">
<div class="space-y-3">
<div class="inline-block px-4 py-1 rounded-full text-xs font-bold text-brand-gold bg-brand-gold/10 border border-brand-gold/25">
              أحدث قصص النجاح
            </div>
<h2 class="text-3xl sm:text-4xl font-black">
              أعمال استثنائية صنعت فارقاً حقيقياً في 
              <span class="blue-gradient-text">حجم المبيعات</span>
</h2>
</div>
<?php if ( $portfolio_archive ) : ?>
<div>
<a class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-700 hover:border-brand-gold text-sm font-semibold text-slate-300 hover:text-white transition-all" href="<?php echo esc_url( $portfolio_archive ); ?>">
<span>عرض جميع المشاريع (+<?php echo esc_html( $portfolio_count ); ?>)</span>
<i class="fa-solid fa-arrow-left text-xs"></i>
</a>
</div>
<?php endif; ?>
</div>
<?php
$portfolio_filter_terms = sumou_get_work_filter_terms();
if ( $portfolio_filter_terms ) :
?>
<div class="flex flex-wrap items-center gap-2.5 mb-10 reveal-on-scroll" id="portfolioSectionFilter">
<button class="filter-chip active-filter whitespace-nowrap px-5 py-2 rounded-full text-xs font-bold transition-all duration-300 bg-gradient-to-r from-amber-300 to-amber-500 text-slate-950 shadow-[0_0_15px_rgba(212,165,55,0.4)]" data-filter="all">
            الكل
          </button>
<?php foreach ( $portfolio_filter_terms as $portfolio_filter_term ) : ?>
<button class="filter-chip whitespace-nowrap px-4 py-2 rounded-full text-xs font-semibold text-slate-300 bg-slate-900/80 border border-slate-700/60 hover:border-amber-400/40 hover:text-amber-200 transition-all duration-300" data-filter="<?php echo esc_attr( $portfolio_filter_term->slug ); ?>">
            <?php echo esc_html( $portfolio_filter_term->name ); ?>
          </button>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ( $portfolio_query->have_posts() ) : ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<?php
$portfolio_index = 0;
while ( $portfolio_query->have_posts() ) :
    $portfolio_query->the_post();
    get_template_part( 'template-parts/work-showcase-card', null, array(
        'post_id' => get_the_ID(),
        'variant' => ( $portfolio_index % 3 ) + 1,
        'delay'   => $portfolio_delays[ $portfolio_index % 3 ],
    ) );
    $portfolio_index++;
endwhile;
wp_reset_postdata();
?>
</div>
<?php else : ?>
<div class="glass-luxury rounded-3xl p-10 text-center text-slate-300 text-sm">
          لا توجد أعمال منشورة حالياً.
        </div>
<?php endif; ?>
</div>
</section>
<!-- END: PortfolioSection -->
<?php
wp_reset_postdata();
