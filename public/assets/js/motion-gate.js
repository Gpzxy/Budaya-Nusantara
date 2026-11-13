/* ============================================================
   MOTION GATE
   Dimuat di <head>. Menandai <html data-8b-live> bila browser mendukung animasi scroll.
   ============================================================ */
if (matchMedia('(prefers-reduced-motion: no-preference)').matches && CSS.supports('animation-timeline: view()')) document.documentElement.setAttribute('data-8b-live', '');
document.documentElement.setAttribute('data-js', '');
