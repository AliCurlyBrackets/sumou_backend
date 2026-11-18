<?php
/**
 * Reusable showcase card for the home page portfolio section.
 * Usage: get_template_part( 'template-parts/work-showcase-card', null, array( 'post_id' => $id, 'variant' => 1, 'delay' => 'delay-100' ) );
 */

$showcase_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
if ( ! $showcase_id ) {
    return;
}

$showcase_title        = get_the_title( $showcase_id );
$showcase_permalink    = get_permalink( $showcase_id );
$showcase_terms        = sumou_get_work_terms( $showcase_id );
$showcase_categories   = implode( ' ', array_map( function ( $term ) {
    return $term->slug;
}, $showcase_terms ) );
$showcase_badge        = sumou_get_work_badge( $showcase_id );
$showcase_metric       = sumou_get_work_metric( $showcase_id );
$showcase_tagline      = sumou_get_work_tagline( $showcase_id );
$showcase_summary      = sumou_get_work_summary( $showcase_id );
$showcase_technologies = sumou_get_work_technologies( $showcase_id );
$showcase_accent       = sumou_get_work_accent( $showcase_id );
$showcase_variant      = isset( $args['variant'] ) ? (int) $args['variant'] : 1;
$showcase_delay        = isset( $args['delay'] ) ? $args['delay'] : '';

if ( null === $showcase_accent ) {
    $showcase_accent = array(
        'badge'  => 'text-slate-200 border-slate-500/40',
        'metric' => 'bg-slate-700/40 text-slate-200 border-slate-500/40',
        'link'   => 'text-slate-300 hover:text-white',
    );
}

$showcase_variants = array(
    1 => array(
        'header' => 'from-blue-900/60 to-slate-900',
        'hover'  => 'group-hover:text-amber-300',
    ),
    2 => array(
        'header' => 'from-amber-950/40 via-slate-900 to-slate-900',
        'hover'  => 'group-hover:text-cyan-300',
    ),
    3 => array(
        'header' => 'from-emerald-950/40 via-slate-900 to-slate-900',
        'hover'  => 'group-hover:text-amber-300',
    ),
);
$showcase_style = $showcase_variants[ $showcase_variant ] ?? $showcase_variants[1];
?>
<div class="work-showcase-card project-card glass-luxury rounded-3xl overflow-hidden border border-slate-700/80 group reveal-on-scroll <?php echo esc_attr( $showcase_delay ); ?>"<?php echo $showcase_categories ? ' data-category="' . esc_attr( $showcase_categories ) . '"' : ''; ?>>
<div class="h-56 bg-gradient-to-br <?php echo esc_attr( $showcase_style['header'] ); ?> relative p-6 flex flex-col justify-between overflow-hidden">
<div class="flex justify-between items-center gap-2 z-10">
<?php if ( $showcase_badge ) : ?>
<span class="px-3 py-1 rounded-full text-[11px] font-bold border bg-slate-900/60 <?php echo esc_attr( $showcase_accent['badge'] ); ?>"><?php echo esc_html( $showcase_badge ); ?></span>
<?php endif; ?>
<?php if ( $showcase_metric ) : ?>
<span class="px-3 py-1 rounded-full text-[11px] font-bold border font-num <?php echo esc_attr( $showcase_accent['metric'] ); ?>"><?php echo esc_html( $showcase_metric ); ?></span>
<?php endif; ?>
</div>
<div class="relative z-10">
<h3 class="text-2xl font-black text-white transition-colors <?php echo esc_attr( $showcase_style['hover'] ); ?>">
<a href="<?php echo esc_url( $showcase_permalink ); ?>"><?php echo esc_html( $showcase_title ); ?></a>
</h3>
<?php if ( $showcase_tagline ) : ?>
<p class="text-xs text-slate-300"><?php echo esc_html( $showcase_tagline ); ?></p>
<?php endif; ?>
</div>
<?php if ( 1 === $showcase_variant ) : ?>
<div class="absolute -bottom-8 -right-6 w-52 h-32 rounded-xl bg-slate-800/90 border border-slate-600/50 shadow-2xl p-3 transform rotate-6 group-hover:rotate-0 transition-transform duration-500" aria-hidden="true">
<div class="h-2 w-16 bg-brand-gold rounded mb-2"></div>
<div class="h-2 w-28 bg-slate-600 rounded"></div>
</div>
<?php elseif ( 2 === $showcase_variant ) : ?>
<div class="absolute -bottom-8 -right-4 w-44 h-36 rounded-2xl bg-slate-800 border border-cyan-500/40 shadow-2xl p-3 transform -rotate-3 group-hover:rotate-0 transition-transform duration-500 flex flex-col justify-between" aria-hidden="true">
<div class="flex items-center gap-2">
<div class="w-6 h-6 rounded-full bg-cyan-400/30"></div>
<div class="h-2 w-16 bg-slate-600 rounded"></div>
</div>
<div class="h-2 w-24 bg-slate-600 rounded"></div>
</div>
<?php else : ?>
<div class="absolute -bottom-6 -right-6 w-48 h-32 rounded-xl bg-slate-900 border border-amber-500/30 shadow-2xl p-3 transform rotate-3 group-hover:rotate-0 transition-transform duration-500" aria-hidden="true">
<div class="h-2 w-20 bg-amber-500/60 rounded"></div>
<div class="mt-2 h-1.5 w-full bg-slate-700 rounded"></div>
</div>
<?php endif; ?>
</div>
<div class="p-6 space-y-4">
<?php if ( $showcase_terms ) : ?>
<div class="flex flex-wrap gap-1.5">
<?php foreach ( $showcase_terms as $showcase_term ) : ?>
<a class="text-[10px] px-2 py-0.5 rounded border border-slate-700/80 text-slate-400 hover:border-amber-400/40 hover:text-amber-300 transition-colors" href="<?php echo esc_url( sumou_get_work_filter_url( $showcase_term->slug ) ); ?>"><?php echo esc_html( $showcase_term->name ); ?></a>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ( $showcase_summary ) : ?>
<p class="text-xs text-slate-300 leading-relaxed">
                <?php echo esc_html( $showcase_summary ); ?>
              </p>
<?php endif; ?>
<?php if ( ! empty( $showcase_technologies ) ) : ?>
<div class="flex flex-wrap gap-2 text-[11px] text-slate-400 font-num">
<?php foreach ( $showcase_technologies as $showcase_technology ) : ?>
<span class="bg-slate-800 px-2.5 py-1 rounded"><?php echo esc_html( $showcase_technology ); ?></span>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</div>
