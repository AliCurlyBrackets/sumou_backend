<?php
/**
 * Reusable work card for the works archive and related lists.
 * Usage: get_template_part( 'template-parts/work-card', null, array( 'post_id' => $id, 'delay' => 'reveal-delay-100' ) );
 */

$card_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
if ( ! $card_id ) {
    return;
}

$card_title        = get_the_title( $card_id );
$card_permalink    = get_permalink( $card_id );
$card_image_url    = get_the_post_thumbnail_url( $card_id, 'large' );
$card_terms        = sumou_get_work_terms( $card_id );
$card_categories   = implode( ' ', array_map( function ( $term ) {
    return $term->slug;
}, $card_terms ) );
$card_accent       = sumou_get_work_accent( $card_id );
$card_badge        = sumou_get_work_badge( $card_id );
$card_sector       = sumou_get_work_sector( $card_id );
$card_metric       = sumou_get_work_metric( $card_id );
$card_result       = sumou_get_work_result( $card_id );
$card_summary      = sumou_get_work_summary( $card_id );
$card_technologies = sumou_get_work_technologies( $card_id );
$card_delay        = isset( $args['delay'] ) ? $args['delay'] : '';

if ( null === $card_accent ) {
    $card_accent = array(
        'badge'  => 'text-slate-200 border-slate-500/40',
        'metric' => 'bg-slate-700/40 text-slate-200 border-slate-500/40',
        'link'   => 'text-slate-300 hover:text-white',
    );
}
?>
<article class="reveal-on-scroll <?php echo esc_attr( $card_delay ); ?> project-card group relative rounded-3xl overflow-hidden bg-slate-900/80 border border-amber-500/20 backdrop-blur-xl hover:border-amber-400/60 transition-all duration-500 flex flex-col justify-between"<?php echo $card_categories ? ' data-category="' . esc_attr( $card_categories ) . '"' : ''; ?>>
<div>
<div class="relative h-60 overflow-hidden bg-slate-950">
<?php if ( $card_image_url ) : ?>
<img alt="<?php echo esc_attr( $card_title ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" src="<?php echo esc_url( $card_image_url ); ?>"/>
<?php endif; ?>
<?php if ( $card_badge ) : ?>
<div class="absolute top-4 right-4 flex gap-2">
<span class="px-3 py-1 rounded-full text-[11px] font-bold bg-slate-950/80 border backdrop-blur-md <?php echo esc_attr( $card_accent['badge'] ); ?>">
                <?php echo esc_html( $card_badge ); ?>
              </span>
</div>
<?php endif; ?>
<?php if ( $card_sector || $card_metric ) : ?>
<div class="absolute bottom-3 right-3 left-3 flex justify-between items-center gap-2 bg-slate-950/70 p-2.5 rounded-xl backdrop-blur-md border border-white/10">
<?php if ( $card_sector ) : ?>
<span class="text-[11px] text-slate-300"><?php echo esc_html( $card_sector ); ?></span>
<?php endif; ?>
<?php if ( $card_metric ) : ?>
<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border <?php echo esc_attr( $card_accent['metric'] ); ?>"><?php echo esc_html( $card_metric ); ?></span>
<?php endif; ?>
</div>
<?php endif; ?>
</div>
<div class="p-6 space-y-3">
<h3 class="text-xl font-bold text-white group-hover:text-amber-300 transition-colors">
              <?php echo esc_html( $card_title ); ?>
            </h3>
<?php if ( $card_terms ) : ?>
<div class="flex flex-wrap gap-1.5">
<?php foreach ( $card_terms as $card_term ) : ?>
<a class="text-[10px] px-2 py-0.5 rounded border border-slate-700/80 text-slate-400 hover:border-amber-400/40 hover:text-amber-300 transition-colors" href="<?php echo esc_url( sumou_get_work_filter_url( $card_term->slug ) ); ?>"><?php echo esc_html( $card_term->name ); ?></a>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ( $card_summary ) : ?>
<p class="text-xs text-slate-300/85 leading-relaxed line-clamp-2">
              <?php echo esc_html( $card_summary ); ?>
            </p>
<?php endif; ?>
<?php if ( ! empty( $card_technologies ) ) : ?>
<div class="flex flex-wrap gap-1.5 pt-2">
<?php foreach ( $card_technologies as $card_technology ) : ?>
<span class="text-[10px] px-2 py-0.5 rounded bg-slate-800 text-slate-300 font-mono"><?php echo esc_html( $card_technology ); ?></span>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</div>
<div class="p-6 pt-0 border-t border-slate-800/80 flex items-center justify-between gap-3">
<?php if ( $card_result ) : ?>
<span class="text-xs text-slate-400 font-num"><?php echo esc_html( $card_result ); ?></span>
<?php endif; ?>
<a class="text-xs font-bold flex items-center gap-1 group-hover:translate-x-[-3px] transition-transform <?php echo esc_attr( $card_accent['link'] ); ?>" href="<?php echo esc_url( $card_permalink ); ?>">
<span>دراسة الحالة</span>
<span class="material-symbols-outlined text-sm">arrow_back</span>
</a>
</div>
</article>
