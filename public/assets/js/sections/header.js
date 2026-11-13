/* ============================================================
   JS NAVBAR
   Navbar solid/sembunyi saat scroll + buka/tutup menu mobile.
   ============================================================ */
(() => {
  const header = document.getElementById('header');
  const menu = document.getElementById('menu');
  const open = header.querySelector('.hd-menu');
  const close = menu.querySelector('.mn-close');
  let last = window.scrollY, ticking = false;
  const update = () => {
    const y = window.scrollY;
    if (y > 80) header.setAttribute('data-solid', ''); else header.removeAttribute('data-solid');
    if (y > last + 1 && y > 160 && menu.hidden) header.setAttribute('data-hidden', '');
    else if (y < last - 1 || y <= 160) header.removeAttribute('data-hidden');
    last = y; ticking = false;
  };
  window.addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(update); } }, { passive: true });
  update();
  header.addEventListener('focusin', () => header.removeAttribute('data-hidden'));
  const setOpen = state => {
    menu.hidden = !state;
    open.setAttribute('aria-expanded', String(state));
    if (state) { window.motionKit?.wheel?.stop(); close.focus(); } else { window.motionKit?.wheel?.start(); open.focus(); }
  };
  open.addEventListener('click', () => setOpen(true));
  close.addEventListener('click', () => setOpen(false));
  menu.addEventListener('keydown', event => { if (event.key === 'Escape') setOpen(false); });
  menu.querySelectorAll('a').forEach(link => link.addEventListener('click', () => { menu.hidden = true; open.setAttribute('aria-expanded', 'false'); window.motionKit?.wheel?.start(); }));
})();
