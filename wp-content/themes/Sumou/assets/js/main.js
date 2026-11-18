/* Sumou – shared scripts (all pages). Every block is guarded, so it only
   runs on the pages that contain the matching elements. */

/* ---------- Services page helpers (called from inline onclick) ---------- */
function filterServices(category) {
  const items = document.querySelectorAll('.service-row');
  const buttons = document.querySelectorAll('.cat-filter-btn');
  const base = 'cat-filter-btn px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold';
  const activeCls = base + ' transition-all duration-300 gold-btn-gradient text-slate-950 shadow-md flex items-center gap-2';

  buttons.forEach(btn => {
    btn.className = base + ' text-slate-300 hover:text-white transition-all duration-300 flex items-center gap-2';
  });
  const activeBtn = document.getElementById('tab-' + category);
  if (activeBtn) activeBtn.className = activeCls;

  items.forEach(item => {
    item.style.display = (category === 'all' || item.getAttribute('data-category') === category) ? 'block' : 'none';
  });
}

function toggleFaq(button) {
  const answer = button.nextElementSibling;
  const icon = button.querySelector('.material-symbols-outlined');
  const isOpen = !answer.classList.contains('hidden');

  document.querySelectorAll('.faq-answer').forEach(el => el.classList.add('hidden'));
  document.querySelectorAll('.faq-item .material-symbols-outlined').forEach(ic => {
    ic.style.transform = 'rotate(0deg)';
  });

  if (!isOpen) {
    answer.classList.remove('hidden');
    if (icon) icon.style.transform = 'rotate(180deg)';
  }
}

document.addEventListener('DOMContentLoaded', () => {

  /* ---------- Mobile menu (header) ---------- */
  const menuBtn = document.getElementById('mobileMenuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    mobileMenu.querySelectorAll('a').forEach(link =>
      link.addEventListener('click', () => mobileMenu.classList.add('hidden'))
    );
  }

  /* ---------- Scroll reveal ---------- */
  const revealEls = document.querySelectorAll('.reveal-on-scroll, .reveal-item, .reveal-fade');
  const markRevealed = el => el.classList.add('revealed', 'is-revealed', 'is-visible');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduceMotion || !('IntersectionObserver' in window)) {
    revealEls.forEach(markRevealed);
  } else {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          markRevealed(entry.target);
          obs.unobserve(entry.target);
        }
      });
    }, { root: null, threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => observer.observe(el));
  }

  /* ---------- Pricing page: marketing / tech tabs ---------- */
  const tabMarketing = document.getElementById('tab-marketing');
  const tabTech = document.getElementById('tab-tech');
  if (tabMarketing && tabTech) {
    const activeClasses = ['bg-gradient-to-r', 'from-amber-400', 'to-amber-500', 'text-slate-950', 'font-bold', 'shadow-md', 'shadow-amber-500/20'];
    const inactiveClasses = ['text-slate-400', 'font-medium', 'hover:text-white'];
    const activate = (on, off) => {
      on.classList.add(...activeClasses);
      on.classList.remove(...inactiveClasses);
      off.classList.remove(...activeClasses);
      off.classList.add(...inactiveClasses);
    };
    tabMarketing.addEventListener('click', () => activate(tabMarketing, tabTech));
    tabTech.addEventListener('click', () => activate(tabTech, tabMarketing));
  }

  /* ---------- Portfolio page: project filters ---------- */
  const filterButtons = document.querySelectorAll('.filter-chip');
  const projectCards = document.querySelectorAll('.project-card');
  if (filterButtons.length && projectCards.length) {
    const activeCls = ['active-filter', 'bg-gradient-to-r', 'from-amber-300', 'to-amber-500', 'text-slate-950', 'shadow-[0_0_15px_rgba(212,165,55,0.4)]'];
    filterButtons.forEach(button => {
      button.addEventListener('click', event => {
        const filter = button.getAttribute('data-filter');

        if (button.getAttribute('href')) {
          event.preventDefault();
          history.replaceState(null, '', button.getAttribute('href'));
        }

        filterButtons.forEach(btn => {
          btn.classList.remove(...activeCls);
          btn.classList.add('text-slate-300', 'bg-slate-900/80', 'border', 'border-slate-700/60');
        });
        button.classList.add(...activeCls);
        button.classList.remove('text-slate-300', 'bg-slate-900/80', 'border-slate-700/60');

        projectCards.forEach(card => {
          const categories = (card.getAttribute('data-category') || '').split(' ').filter(Boolean);
          const show = filter === 'all' || categories.includes(filter);
          if (show) {
            card.style.display = 'flex';
            setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'scale(1)'; }, 50);
          } else {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.96)';
            setTimeout(() => { card.style.display = 'none'; }, 250);
          }
        });
      });
    });
  }

  /* ---------- SEO page: audit form ---------- */
  const auditForm = document.getElementById('seoAuditForm');
  const successMsg = document.getElementById('formSuccessMessage');
  if (auditForm && successMsg) {
    auditForm.addEventListener('submit', e => {
      e.preventDefault();
      const submitBtn = auditForm.querySelector('button[type="submit"]');
      const originalHTML = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-base">progress_activity</span> جاري التحليل والإرسال...';

      setTimeout(() => {
        auditForm.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHTML;
        successMsg.classList.remove('hidden');
        setTimeout(() => successMsg.classList.add('hidden'), 8000);
      }, 1200);
    });
  }
});
