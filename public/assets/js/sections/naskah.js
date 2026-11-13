/* ============================================================
   JS NASKAH
   Ganti foto naskah di sisi sticky mengikuti paragraf penjelasan yang sedang dibaca.
   ============================================================ */
(() => {
  const section = document.getElementById('naskah');
  if (!section) return;
  const steps = [...section.querySelectorAll('.nk-step')];
  const pages = [...section.querySelectorAll('.nk-page')];
  const counter = section.querySelector('.nk-counter');
  const pad = n => String(n).padStart(2, '0');
  const show = i => {
    if (i < 0) return;
    steps.forEach((s, k) => s.classList.toggle('is-active', k === i));
    pages.forEach((p, k) => p.classList.toggle('is-active', k === i));
    if (counter) counter.textContent = pad(i + 1) + ' / ' + pad(steps.length);
  };
  show(0);
  if (!('IntersectionObserver' in window)) { steps.forEach(s => s.classList.add('is-active')); return; }
  const io = new IntersectionObserver(entries => entries.forEach(e => { if (e.isIntersecting) show(steps.indexOf(e.target)); }), { rootMargin: '-45% 0px -45% 0px' });
  steps.forEach(s => io.observe(s));
})();
