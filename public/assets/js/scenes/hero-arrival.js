/* ============================================================
   JS ANIMASI HERO
   Mengukur tinggi layar pertama untuk animasi scroll hero.
   ============================================================ */
motionKit.scene('hero', () => {
  const section = document.getElementById('hero');
  const first = section.querySelector('.op-first');
  motionKit.measure(() => motionKit.set(section, { '--arrival-first': `${first.offsetHeight}px` }));
});
