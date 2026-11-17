<!DOCTYPE html>
<html class="scroll-smooth" dir="rtl" lang="ar">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>سمو | SUMOU - للتسويق الإلكتروني وتطوير الأعمال</title>
<!-- Fonts & icons -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&amp;family=Cinzel:wght@500;600;700;800;900&amp;family=Space+Grotesk:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind (CDN) + shared config -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="<?php echo get_template_directory_uri(  ) . '/assets/js/tailwind-config.js' ?>"></script>
<!-- Shared styles -->
<link href="<?php echo get_template_directory_uri(  ) . '/assets/css/style.css?ver=' . filemtime( get_template_directory() . '/assets/css/style.css' ) ?>" rel="stylesheet"/>
<?php wp_head() ; ?>
</head>
<body class="page-home bg-brand-navy text-slate-100 selection:bg-brand-gold selection:text-brand-navy relative cyber-grid-pattern min-h-screen" style="font-family: Tajawal, sans-serif;">
<!-- Ambient Golden and Neon Blue Backdrops -->
<div class="circuit-glow-orb w-96 h-96 bg-brand-gold/15 -top-20 right-10"></div>
<div class="circuit-glow-orb w-[500px] h-[500px] bg-brand-blue/20 top-[600px] -left-20"></div>
<div class="circuit-glow-orb w-96 h-96 bg-cyan-500/10 top-[1800px] right-20"></div>
<!-- BEGIN: MainHeader (Navbar) - EXCLUDED completely from reveal hiding -->
<header class="sticky top-0 z-50 backdrop-blur-xl bg-[#070C18]/85 border-b border-amber-500/15 transition-all duration-300">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex items-center justify-between h-20">
<!-- Brand Logo & Identity -->
<a class="flex items-center gap-3.5 group" data-purpose="brand-logo-container" href="index.html">
<div class="relative w-12 h-12 rounded-xl overflow-hidden border border-brand-gold/40 shadow-[0_0_15px_rgba(212,165,55,0.3)] group-hover:scale-105 transition-transform duration-300">
<img alt="شعار سمو - للتسويق وتطوير الأعمال" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDxVEfcgq33do_shKnqhWZ9522528umICyAcx5hw8e-RXzajTZhtfA1-8aY8DSM1St-cH8SYlhOmNgqc2N3CLaJY-lcKvMFVjngcW2SY3M9avpladiJgAXnmuZdUAsM6bg-utb_lHq6Xl92cPA5ovs-EbssBrgJ4rq8it6cAVMkR2Ol4t7IMRNEocssF04cq227c8s2Z4ESz6PWHho-FOra_4mNF_AKqqMvIVPPYHhG3Mb_w5qQOeDl"/>
</div>
<div class="flex flex-col">
<div class="flex items-center gap-2">
<span class="text-2xl font-black font-cairo text-white tracking-wide">سُـمُـوّ</span>
<span class="text-xs font-cinzel text-brand-gold font-bold tracking-widest border-r border-slate-700 pr-2">SUMOU</span>
</div>
<span class="text-[10px] text-slate-400 font-medium tracking-tight">للتسويق الإلكتروني وتطوير الأعمال</span>
</div>
</a>
<!-- Desktop Navigation Menu -->
<nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-slate-300" data-purpose="desktop-nav">
<a class="text-brand-gold transition-colors hover:text-brand-goldLight" href="index.html">الرئيسية</a>
<a class="transition-colors hover:text-brand-goldLight" href="about.html">من نحن</a>
<a class="transition-colors hover:text-brand-goldLight" href="services.html">خدماتنا</a>
<a class="transition-colors hover:text-brand-goldLight" href="portfolio.html">سابقة الأعمال</a>
<a class="transition-colors hover:text-brand-goldLight" href="pricing.html">الباقات</a>
<a class="transition-colors hover:text-brand-goldLight" href="blog.html">المدونة</a>
<a class="transition-colors hover:text-brand-goldLight" href="seo.html">خدمة السيو</a>
<a class="transition-colors hover:text-brand-goldLight" href="index.html#contact">تواصل معنا</a>
</nav>
<!-- Navbar Action CTAs -->
<div class="flex items-center gap-3 sm:gap-4">

<!-- Primary CTA Button -->
<a class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs md:text-sm font-bold text-slate-950 gold-btn-gradient" href="index.html#contact">
<i class="fa-solid fa-bolt-lightning text-xs"></i>
<span>اطلب عرض سعر</span>
</a>
<!-- Mobile Hamburger Toggle -->
<button aria-label="قائمة الموبايل" class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-brand-gold hover:bg-slate-800/60 focus:outline-none" id="mobileMenuBtn">
<i class="fa-solid fa-bars-staggered text-xl"></i>
</button>
</div>
</div>
</div>
<!-- Mobile Navigation Drawer -->
<div class="hidden lg:hidden bg-[#0A1020]/95 border-b border-amber-500/20 px-6 py-6 transition-all duration-300" id="mobileMenu">
<div class="flex flex-col gap-4 text-base font-semibold">
<a class="text-brand-gold hover:text-brand-goldLight py-1 border-b border-slate-800" href="index.html">الرئيسية</a>
<a class="hover:text-brand-goldLight py-1 border-b border-slate-800" href="about.html">من نحن</a>
<a class="hover:text-brand-goldLight py-1 border-b border-slate-800" href="services.html">خدماتنا</a>
<a class="hover:text-brand-goldLight py-1 border-b border-slate-800" href="portfolio.html">سابقة الأعمال</a>
<a class="hover:text-brand-goldLight py-1 border-b border-slate-800" href="pricing.html">الباقات</a>
<a class="hover:text-brand-goldLight py-1 border-b border-slate-800" href="blog.html">المدونة</a>
<a class="hover:text-brand-goldLight py-1 border-b border-slate-800" href="seo.html">خدمة السيو</a>
<a class="gold-btn-gradient text-slate-950 text-center py-2.5 rounded-xl font-bold mt-2" href="index.html#contact">ابدأ مشروعك الآن</a>
</div>
</div>
</header>
<!-- END: MainHeader -->
<main>