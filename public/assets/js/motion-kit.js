/* ============================================================
   ENGINE ANIMASI
   Smooth scroll, reveal, split teks, tracker scroll. Jangan diedit kalau tidak perlu. Dimuat sebelum file lain.
   ============================================================ */
(() => {
const live = document.documentElement.hasAttribute('data-8b-live');
const measures = new Set();
let queued = false;
const run = fn => { try { fn(); } catch (error) { console.error('[motion-kit] measure failed', error); } };
const remeasure = () => {
if (queued) return;
queued = true;
requestAnimationFrame(() => { queued = false; measures.forEach(run); realign(); });
};
const realign = () => document.getAnimations().forEach(animation => {
if (animation.timeline && animation.timeline !== document.timeline && animation.playState === 'running') { animation.pause(); animation.play(); }
});
window.motionKit = {
live,
box(element) {
if (!(element instanceof HTMLElement)) { const r = element.getBoundingClientRect(); return { x: r.left + scrollX, y: r.top + scrollY, w: r.width, h: r.height }; }
let x = 0, y = 0, node = element;
while (node) { x += node.offsetLeft; y += node.offsetTop; node = node.offsetParent; }
return { x, y, w: element.offsetWidth, h: element.offsetHeight };
},
set(element, vars) { for (const [name, value] of Object.entries(vars)) element.style.setProperty(name, String(value)); },
measure(fn) { if (!live) return; measures.add(fn); run(fn); },
scene(id, fn) {
if (!live) return;
try { fn(); } catch (error) {
console.error(`[motion-kit] scene ${id} failed; its section stays static`, error);
document.querySelector(`[data-8b-part="scene:${id}"]`)?.setAttribute('media', 'not all');
}
}
};
if (!live) { window.motionReady = Promise.resolve(); return; }
const number = () => document.querySelectorAll('[data-8b-items]').forEach(group => {
let items;
try { items = [...group.querySelectorAll(group.getAttribute('data-8b-items'))]; } catch { return; }
items.forEach((item, index) => { item.style.setProperty('--i', index); item.style.setProperty('--n', items.length); });
});
number();
measures.add(number);
requestAnimationFrame(realign);
new ResizeObserver(remeasure).observe(document.body);
document.fonts?.ready.then(remeasure);
addEventListener('load', remeasure);
window.motionReady = (document.fonts?.ready ?? Promise.resolve()).then(() => new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve))));
})();
(() => {
const kit = window.motionKit;
if (!kit.live || !matchMedia('(pointer: fine)').matches) return;
let target = scrollY, current = scrollY, last = 0, running = false, paused = false;
const inner = (node, dy) => {
for (; node && node !== document.body && node !== document.documentElement; node = node.parentElement) {
if (!/(auto|scroll)/.test(getComputedStyle(node).overflowY) || node.scrollHeight <= node.clientHeight) continue;
if (dy > 0 ? node.scrollTop + node.clientHeight < node.scrollHeight - 1 : node.scrollTop > 0) return true;
}
return false;
};
const step = now => {
current += (target - current) * (1 - Math.exp(-5.3 * Math.min(0.05, (now - last) / 1000)));
last = now;
if (Math.abs(target - current) < 0.5) current = target;
scrollTo({ top: current, behavior: 'instant' });
if (current !== target) requestAnimationFrame(step); else running = false;
};
addEventListener('wheel', event => {
if (paused || event.ctrlKey || Math.abs(event.deltaX) > Math.abs(event.deltaY) || inner(event.target, event.deltaY)) return;
event.preventDefault();
if (!running) target = current = scrollY;
const unit = event.deltaMode === 1 ? 40 : event.deltaMode === 2 ? innerHeight : 1;
target = Math.max(0, Math.min(document.documentElement.scrollHeight - innerHeight, target + event.deltaY * unit * 0.95));
if (!running) { running = true; last = performance.now(); requestAnimationFrame(step); }
}, { passive: false });
kit.wheel = { stop() { paused = true; }, start() { paused = false; } };
})();
(() => {
const kit = window.motionKit;
if (!kit.live) return;
const at = element => {
const own = /^(\d{1,3}(?:\.\d+)?)%$/.exec((element.getAttribute('data-8b-enter') || '').trim());
return own && +own[1] <= 100 ? own[1] / 100 : 0.88;
};
let pending = [...document.querySelectorAll('[data-8b-motion]')].map(element => ({ element, y: 0, at: at(element) }));
let queued = false;
const check = () => {
queued = false;
pending = pending.filter(item => {
if (item.y > scrollY + innerHeight * item.at) return true;
item.element.classList.add('is-in');
return false;
});
};
const queue = () => { if (!queued) { queued = true; requestAnimationFrame(check); } };
kit.measure(() => { pending.forEach(item => { item.y = kit.box(item.element).y; }); queue(); });
addEventListener('scroll', queue, { passive: true });
})();
(() => {
const kit = window.motionKit;
if (!kit.live) return;
const sheet = new CSSStyleSheet();
sheet.replaceSync('.line{display:block;overflow:clip;padding-block:.12em;margin-block:-.12em}.line:not(:last-child){margin-bottom:0}.line+.line{margin-top:-.24em}.line+.line>.line__in{text-indent:0}:where(h1,h2,h3,h4,h5,h6,p,div,blockquote,figcaption,dd,dt):where([data-8b-split="lines"]:has(>.line)){display:flow-root}.line__in{display:block}.kit-sr{position:absolute;width:1px;height:1px;overflow:hidden;clip-path:inset(50%);white-space:nowrap}');
document.adoptedStyleSheets = [...document.adoptedStyleSheets, sheet];
const sources = new WeakMap(), widths = new WeakMap();
const graphemes = typeof Intl.Segmenter === 'function'
? text => [...new Intl.Segmenter(undefined, { granularity: 'grapheme' }).segment(text)].map(part => part.segment)
: text => [...text];
const span = (className, text) => { const element = document.createElement('span'); element.className = className; if (text != null) element.textContent = text; return element; };
const split = element => {
const mode = element.getAttribute('data-8b-split');
if (sources.has(element)) element.innerHTML = sources.get(element); else sources.set(element, element.innerHTML);
const walker = document.createTreeWalker(element, NodeFilter.SHOW_TEXT), texts = [];
while (walker.nextNode()) texts.push(walker.currentNode);
let index = 0;
for (const node of texts) {
const fragment = document.createDocumentFragment();
for (const piece of node.data.split(/(\s+)/)) {
if (!piece) continue;
if (/^\s+$/.test(piece)) { fragment.append(piece); continue; }
const word = span('w');
if (mode === 'chars') {
word.setAttribute('aria-hidden', 'true');
for (const character of graphemes(piece)) { const c = span('c', character); c.style.setProperty('--i', index++); word.append(c); }
} else {
word.textContent = piece;
if (mode === 'words') word.style.setProperty('--i', index++);
}
fragment.append(word);
}
node.replaceWith(fragment);
}
if (mode === 'chars') element.append(span('kit-sr', element.textContent.replace(/\s+/g, ' ').trim()));
if (mode === 'lines') {
const lines = [];
let top = null;
for (const child of [...element.childNodes]) {
const probe = child.nodeType === 1 ? child : null;
const at = probe ? probe.getBoundingClientRect().top : top;
if (probe && (top === null || Math.abs(at - top) > 2)) { lines.push([]); top = at; }
if (!lines.length) lines.push([]);
lines.at(-1).push(child);
}
lines.forEach((nodes, i) => {
const line = span('line'), inner = span('line__in');
line.style.setProperty('--i', i);
nodes[0].before(line);
inner.append(...nodes);
line.append(inner);
});
index = lines.length;
widths.set(element, element.clientWidth);
}
element.style.setProperty('--n', index);
};
const pending = [];
let busy = false;
const drain = () => {
if (busy) return;
const element = pending.shift();
if (!element) return;
busy = true;
setTimeout(() => { try { split(element); } catch (error) { console.error('[motion-kit] split failed', error); } busy = false; drain(); }, 0);
};
const near = new IntersectionObserver(entries => entries.forEach(entry => {
if (!entry.isIntersecting) return;
near.unobserve(entry.target);
pending.push(entry.target);
drain();
}), { rootMargin: '100% 0px 100% 0px' });
(document.fonts?.ready ?? Promise.resolve()).then(() => document.querySelectorAll('[data-8b-split]').forEach(element => near.observe(element)));
kit.measure(() => document.querySelectorAll('[data-8b-split="lines"]').forEach(element => {
if (sources.has(element) && widths.get(element) !== element.clientWidth) { pending.push(element); drain(); }
}));
})();
(() => {
if (!window.motionKit.live) return;
const sheet = new CSSStyleSheet();
sheet.replaceSync('[data-8b-off],[data-8b-off]::before,[data-8b-off]::after{animation-play-state:paused!important}');
document.adoptedStyleSheets = [...document.adoptedStyleSheets, sheet];
const watch = new IntersectionObserver(entries => entries.forEach(entry => entry.target.toggleAttribute('data-8b-off', !entry.isIntersecting)));
const watched = new WeakSet();
const scan = () => document.getAnimations().forEach(animation => {
const element = animation.effect?.target;
if (!element || watched.has(element) || animation.effect.getTiming().iterations !== Infinity || animation.timeline !== document.timeline) return;
watched.add(element);
watch.observe(element);
});
scan();
addEventListener('load', scan);
document.addEventListener('animationstart', scan, true);
})();
(() => {
const kit = window.motionKit;
kit.track = () => {};
if (!kit.live) return;
const named = { top: 0, center: 0.5, bottom: 1 };
const point = text => text.trim().split(/\s+/).map(word => named[word] ?? parseFloat(word) / 100);
kit.track = (element, start, end, fn) => {
const [s0, v0] = point(start), [s1, v1] = point(end);
let queued = false;
const run = () => {
queued = false;
const box = element.getBoundingClientRect(), vh = innerHeight;
const d0 = box.top + box.height * s0 - vh * v0, d1 = box.top + box.height * s1 - vh * v1;
fn(d1 === d0 ? (d0 <= 0 ? 1 : 0) : Math.min(1, Math.max(0, -d0 / (d1 - d0))));
};
addEventListener('scroll', () => { if (!queued) { queued = true; requestAnimationFrame(run); } }, { passive: true });
kit.measure(run);
};
})();
