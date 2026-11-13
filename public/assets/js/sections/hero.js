/* ============================================================
   JS HERO
   Pause animasi kabut saat hero tidak terlihat.
   ============================================================ */
(() => {
  const section = document.getElementById('hero');
  const fog = section.querySelector('.op-veil');
  if (!('IntersectionObserver' in window)) return;
  new IntersectionObserver(entries => entries.forEach(entry => {
    if (entry.isIntersecting) section.removeAttribute('data-off'); else section.setAttribute('data-off', '');
  })).observe(fog);
})();
