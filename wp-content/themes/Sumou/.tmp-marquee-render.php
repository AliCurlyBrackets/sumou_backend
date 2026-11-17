<?php
// Builds .tmp-marquee-test.html: real template output + real style.css, RTL page,
// with a coverage sampler that seeks the marquee animation and looks for gaps.
function sumou_option( $name, $default = '' ) {
    static $opts = array(
        'analytics_stats'          => array(),
        'analytics_partners_title' => 'Our clients',
        'analytics_partners'       => array(
            array( 'logo' => array( 'url' => 'crb.png', 'alt' => 'CRB' ), 'name' => 'CRB' ),
            array( 'logo' => array( 'url' => 'evimki.png', 'alt' => 'evimki' ), 'name' => 'evimki' ),
            array( 'logo' => array( 'url' => 'gt.png', 'alt' => 'GT' ), 'name' => 'GT' ),
            array( 'logo' => array( 'url' => 'four.png', 'alt' => 'Four' ), 'name' => 'Four' ),
        ),
    );
    return $opts[ $name ] ?? $default;
}
function wp_get_attachment_image_url( $id, $size = 'full' ) { return ''; }
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); }
function esc_attr( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); }
function esc_url( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); }

ob_start();
include __DIR__ . '/template-parts/analytic.php';
$section = ob_get_clean();

$sizes   = array( 'crb.png' => 70, 'evimki.png' => 140, 'gt.png' => 45, 'four.png' => 120 );
foreach ( $sizes as $file => $w ) {
    $svg      = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="40"><rect width="100%" height="100%" fill="#888"/></svg>';
    $section  = str_replace( 'src="' . $file . '"', 'src="data:image/svg+xml;base64,' . base64_encode( $svg ) . '"', $section );
}

$page = <<<'HTML'
<!doctype html><html dir="rtl"><head><meta charset="utf-8">
<link rel="stylesheet" href="assets/css/style.css">
<style>
.logo-marquee{overflow:hidden;position:relative}
.logo-marquee-track>div{display:flex;align-items:center;gap:32px;padding-inline-end:32px}
@media(min-width:768px){.logo-marquee-track>div{gap:56px;padding-inline-end:56px}}
.logo-marquee-track>div>div{display:flex;align-items:center;justify-content:center;height:64px;padding:0 24px;border:1px solid #1e293b}
@media(min-width:768px){.logo-marquee-track>div>div{height:80px;padding:0 32px}}
.logo-marquee-track img{height:36px;width:auto;max-width:140px;object-fit:contain}
@media(min-width:768px){.logo-marquee-track img{height:44px}}
.wrap{max-width:1280px;margin:0 auto;padding:0 32px}
</style></head><body>
<div class="wrap">__SECTION__</div>
<pre id="out"></pre>
<script>
try {
  const strip = document.querySelector('.logo-marquee');
  const track = strip.querySelector('.logo-marquee-track');
  const cards = Array.from(track.querySelectorAll('img')).map(i => i.parentElement);
  track.style.animationPlayState = 'paused';

  const samples = [];
  for (const t of [0, 0.12, 0.25, 0.37, 0.5, 0.63, 0.75, 0.87]) {
    track.style.animationDelay = (-t * parseFloat(getComputedStyle(track).animationDuration)) + 's';
    const s = strip.getBoundingClientRect();
    const rects = cards
      .map(c => c.getBoundingClientRect())
      .filter(r => r.right > s.left && r.left < s.right)
      .sort((a, b) => a.left - b.left);
    let covered = 0, prev = s.left, gap = 0;
    for (const r of rects) {
      const l = Math.max(prev, r.left), rr = Math.min(r.right, s.right);
      if (rr > l) { covered += rr - l; prev = Math.max(prev, rr); }
    }
    gap = Math.round(s.width - covered);
    samples.push({ t, visibleCards: rects.length, uncoveredPx: gap });
  }
  document.getElementById('out').textContent = JSON.stringify({
    stripW: Math.round(strip.getBoundingClientRect().width),
    halfW: Math.round(track.children[0].getBoundingClientRect().width),
    totalCards: cards.length,
    animation: getComputedStyle(track).animationName + ' ' + getComputedStyle(track).animationDuration,
    samples
  });
} catch (e) { document.getElementById('out').textContent = 'ERR: ' + e.message; }
</script></body></html>
HTML;

file_put_contents( __DIR__ . '/.tmp-marquee-test.html', str_replace( '__SECTION__', $section, $page ) );
echo "written\n";
