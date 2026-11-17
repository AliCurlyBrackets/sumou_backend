<?php
/**
 * Reusable service card.
 * Usage: get_template_part( 'template-parts/service-card', null, array( 'post_id' => $id, 'delay' => 'delay-100' ) );
 */

$card_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
if ( ! $card_id ) {
    return;
}

$card_title    = get_the_title( $card_id );
$card_permalink = get_permalink( $card_id );
$card_icon_url = sumou_get_service_icon_url( $card_id );
$card_summary  = sumou_get_service_summary( $card_id );
$card_features = sumou_get_service_features( $card_id );
$card_accent   = sumou_get_service_accent( $card_id );
$card_bg_url   = sumou_get_service_card_background_url( $card_id );
$card_delay    = isset( $args['delay'] ) ? $args['delay'] : '';
?>
<article class="service-card group relative overflow-hidden glass-luxury rounded-3xl p-8 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between reveal-on-scroll <?php echo esc_attr( $card_delay ); ?>" data-purpose="service-item">
<?php if ( $card_bg_url ) : ?>
<!-- Card background image shown on hover -->
<div class="pointer-events-none absolute inset-0 z-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" aria-hidden="true">
<img alt="" class="w-full h-full object-cover" loading="lazy" src="<?php echo esc_url( $card_bg_url ); ?>"/>
<div class="absolute inset-0 bg-brand-navy/85"></div>
</div>
<?php endif; ?>
<div class="relative z-10">
<?php if ( $card_icon_url ) : ?>
<div class="w-16 h-16 rounded-2xl border <?php echo esc_attr( $card_accent['icon_box'] ); ?> flex items-center justify-center mb-6 p-2.5 group-hover:scale-110 transition-transform">
<img alt="<?php echo esc_attr( $card_title ); ?>" class="w-full h-full object-contain" loading="lazy" src="<?php echo esc_url( $card_icon_url ); ?>"/>
</div>
<?php endif; ?>
<h3 class="text-xl font-bold text-white mb-3 <?php echo esc_attr( $card_accent['hover_title'] ); ?> transition-colors">
                <?php echo esc_html( $card_title ); ?>
              </h3>
<?php if ( $card_summary ) : ?>
<p class="text-slate-300 text-sm leading-relaxed mb-6">
                <?php echo esc_html( $card_summary ); ?>
              </p>
<?php endif; ?>
<?php if ( ! empty( $card_features ) ) : ?>
<ul class="space-y-2.5 text-xs text-slate-300 font-medium border-t border-slate-800 pt-5">
<?php foreach ( $card_features as $card_feature ) : ?>
<li class="flex items-center gap-2"><i class="fa-solid fa-check <?php echo esc_attr( $card_accent['check'] ); ?>"></i> <?php echo esc_html( $card_feature ); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
<a class="relative z-10 mt-8 inline-flex items-center gap-2 text-xs font-bold <?php echo esc_attr( $card_accent['link'] ); ?> transition-colors" href="<?php echo esc_url( $card_permalink ); ?>">
<span>تفاصيل الخدمة</span>
<i class="fa-solid fa-arrow-left"></i>
</a>
</article>
