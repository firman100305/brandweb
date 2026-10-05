// Desktop: the sidebar opens on hover by itself (handled in CSS).
// Mobile: the round button opens/closes the panel.
const body = document.body;
const fab = document.querySelector('.fab');
const links = document.querySelectorAll('.side-nav a');
const setOpen = (open) => {
    body.classList.toggle('nav-open', open);
    fab.setAttribute('aria-expanded', String(open));
    fab.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
};
fab.addEventListener('click', () => setOpen(!body.classList.contains('nav-open')));
document.querySelector('.scrim').addEventListener('click', () => setOpen(false));
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
links.forEach((a) => a.addEventListener('click', () => { setOpen(false); a.blur(); }));

// Highlight the menu item for the section in view (the last section that has passed 40% of the viewport height)
const spyLinks = document.querySelectorAll('[data-spy]');
const sections = [...document.querySelectorAll('section[id]')];
let spyTick = false;
const updateSpy = () => {
    spyTick = false;
    let cur = sections[0];
    sections.forEach((s) => { if (s.getBoundingClientRect().top <= innerHeight * .4) cur = s; });
    if (innerHeight + scrollY >= document.documentElement.scrollHeight - 4) cur = sections[sections.length - 1];
    spyLinks.forEach((l) => l.toggleAttribute('aria-current', l.dataset.spy === cur.id));
};
addEventListener('scroll', () => { if (!spyTick) { spyTick = true; requestAnimationFrame(updateSpy); } }, { passive: true });
updateSpy();

// Category filter: fade out, swap the content, then fade back in
const grid = document.querySelector('.grid');
const cards = document.querySelectorAll('.card');
const tabs = document.querySelectorAll('.tabs button');
let switching;
tabs.forEach((tab) => tab.addEventListener('click', () => {
    const f = tab.dataset.filter;
    tabs.forEach((t) => t.setAttribute('aria-pressed', String(t === tab)));
    grid.classList.add('is-switching');
    clearTimeout(switching);
    switching = setTimeout(() => {
        cards.forEach((c) => { c.hidden = f !== 'All' && c.dataset.category !== f; });
        grid.classList.remove('is-switching');
    }, 320);
}));

// Product detail (native browser dialog). Rows without data are hidden.
const dialog = document.getElementById('detail');
const el = (id) => document.getElementById(id);
const setRow = (id, value) => {
    const dd = el(id);
    dd.textContent = value || '';
    dd.hidden = dd.previousElementSibling.hidden = !value;
};
cards.forEach((card) => card.addEventListener('click', () => {
    const p = JSON.parse(card.dataset.product);
    const shot = card.querySelector('.shot');
    el('d-shot').className = shot.className + ' d-shot';
    el('d-shot').innerHTML = shot.innerHTML;
    el('d-cat').textContent = p.category;
    el('d-name').textContent = p.name;
    el('d-desc').textContent = p.desc;
    setRow('d-for', p.for);
    setRow('d-material', p.material);
    setRow('d-colors', p.colors && p.colors.join(', '));
    setRow('d-sizes', p.sizes);
    dialog.showModal();
}));
dialog.addEventListener('click', (e) => { if (e.target === dialog) dialog.close(); });

// Spider clock: the hands follow the device time
const hh = document.getElementById('hand-h');
const hm = document.getElementById('hand-m');
const hs = document.getElementById('hand-s');
if (hh && hm && hs) {
    const rot = (node, deg) => node.setAttribute('transform', `rotate(${deg} 100 150)`);
    const tick = () => {
        const d = new Date();
        const s = d.getSeconds();
        const m = d.getMinutes() + s / 60;
        const h = (d.getHours() % 12) + m / 60;
        rot(hh, h * 30);
        rot(hm, m * 6);
        rot(hs, s * 6);
    };
    tick();
    setInterval(tick, 1000);
}

// Living spider: head and eyes follow the cursor, fangs open when the cursor is near, a click startles it.
const spider = document.querySelector('.spider');
const head = document.getElementById('spider-head');
const eyes = document.getElementById('spider-eyes');
const pupils = document.getElementById('spider-pupils');
if (spider && head && eyes && pupils && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const svg = spider.querySelector('.spider-svg');
    const clamp = (v, a, b) => Math.max(a, Math.min(b, v));
    const cur = { a: 0, ex: 0, ey: 0 };
    const tgt = { a: 0, ex: 0, ey: 0 };
    let raf = 0;
    let idle;

    const render = () => {
        cur.a += (tgt.a - cur.a) * .14;
        cur.ex += (tgt.ex - cur.ex) * .2;
        cur.ey += (tgt.ey - cur.ey) * .2;
        head.setAttribute('transform', `rotate(${cur.a.toFixed(2)} 100 222)`);
        eyes.setAttribute('transform', `translate(${(cur.ex * .8).toFixed(2)} ${(cur.ey * .8).toFixed(2)})`);
        pupils.setAttribute('transform', `translate(${(cur.ex * .9).toFixed(2)} ${(cur.ey * .9).toFixed(2)})`);
        const busy = Math.abs(tgt.a - cur.a) > .05 || Math.abs(tgt.ex - cur.ex) > .02 || Math.abs(tgt.ey - cur.ey) > .02;
        raf = busy ? requestAnimationFrame(render) : 0;
    };
    const kick = () => { if (!raf) raf = requestAnimationFrame(render); };
    const recenter = () => { tgt.a = tgt.ex = tgt.ey = 0; spider.classList.remove('alert'); kick(); };

    window.addEventListener('pointermove', (e) => {
        const r = svg.getBoundingClientRect();
        if (r.bottom < 0 || r.top > innerHeight) return;
        // eye position on screen (viewBox 200x330, eyes around 100,258)
        const er = eyes.getBoundingClientRect();
        const cx = er.left + er.width / 2;
        const cy = er.top + er.height / 2;
        const dx = e.clientX - cx;
        const dy = e.clientY - cy;
        const dist = Math.hypot(dx, dy) || 1;
        // the head faces down; rotate counter-clockwise to look right.
        // Subtract the body tilt (pendulum) so the angle is relative to the body.
        const bodyTilt = parseFloat(spider.dataset.lean || '0');
        tgt.a = clamp(-Math.atan2(dx, dy) * 180 / Math.PI - bodyTilt, -16, 16);
        tgt.ex = (dx / dist) * 1.6;
        tgt.ey = (dy / dist) * 1.3;
        spider.classList.toggle('alert', dist < r.width * 1.6);
        kick();
        clearTimeout(idle);
        idle = setTimeout(recenter, 3500);
    }, { passive: true });
    document.addEventListener('pointerleave', recenter);

    // Click: startle, legs flail, body bounces on the thread
    let calm;
    spider.addEventListener('click', () => {
        svg.classList.remove('startle');
        void svg.getBoundingClientRect();
        svg.classList.add('startle');
        spider.classList.add('startled');
        clearTimeout(calm);
        calm = setTimeout(() => {
            svg.classList.remove('startle');
            spider.classList.remove('startled');
        }, 1250);
    });
}

// When the sidebar is open, the thread lengthens and the spider descends and swings toward the cursor, then reaches out with its legs.
(() => {
    const spider = document.querySelector('.spider');
    const side = document.querySelector('.side');
    const lean = spider && spider.querySelector('.spider-lean');
    const svg = spider && spider.querySelector('.spider-svg');
    const thread = document.getElementById('spider-thread');
    const rig = document.getElementById('spider-rig');
    if (!spider || !side || !lean || !svg || !thread || !rig || matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const BASE = 84;  // initial thread length (viewBox units)
    const EYE = 258;  // distance from the hanging point to the eyes (viewBox units)
    const clamp = (v, a, b) => Math.max(a, Math.min(b, v));
    const wrap = (a) => Math.atan2(Math.sin(a), Math.cos(a));
    const legs = [...spider.querySelectorAll('.leg-reach')].map((g) => {
        const d = g.dataset;
        const ax = +d.ax, ay = +d.ay;
        return { g, ax, ay, side: d.side, w: +d.w, phi: Math.atan2(+d.fy - ay, +d.fx - ax), v: 0 };
    });

    const st = { d: 0, lean: 0 };
    let open = false;
    let ptr = null;
    let raf = 0;

    const frame = () => {
        // the .spider container does not descend, so it is a stable reference point
        const host = spider.getBoundingClientRect();
        const scale = host.width / 200;
        const px = host.left + host.width / 2;
        const py = host.top;
        const want = !!(open && ptr && host.bottom > 0 && host.top < innerHeight);

        let goalD = 0, goalLean = 0;
        if (want) {
            const vx = ptr.x - px, vy = ptr.y - py;
            const dist = Math.hypot(vx, vy);
            const maxLen = Math.min(innerHeight * .8, 620);
            // stop about 50px short of the cursor
            goalD = clamp(dist / scale - EYE - 50 / scale, 0, maxLen / scale - EYE);
            // the thread points toward the cursor
            goalLean = -clamp(Math.atan2(vx, vy) * 180 / Math.PI, -50, 50);
        }
        st.d += (goalD - st.d) * .08;
        st.lean += (goalLean - st.lean) * .1;
        const bodyMoving = Math.abs(goalD - st.d) > .05 || Math.abs(goalLean - st.lean) > .05;

        thread.setAttribute('y2', (BASE + st.d).toFixed(2));
        rig.setAttribute('transform', st.d > .01 ? `translate(0 ${st.d.toFixed(2)})` : '');
        lean.style.transform = Math.abs(st.lean) > .01 ? `rotate(${st.lean.toFixed(2)}deg)` : '';
        spider.dataset.lean = st.lean.toFixed(1);
        spider.classList.toggle('reaching', want);

        // cursor position in spider coordinates (accounts for the swing and the body's descent)
        let tx = 100, ty = EYE + st.d + 60;
        const ctm = svg.getScreenCTM();
        if (want && ctm) {
            const p = new DOMPoint(ptr.x, ptr.y).matrixTransform(ctm.inverse());
            tx = p.x; ty = p.y - st.d;
        }
        const ahead = Math.abs(tx - 100) < 45;
        const reachSide = tx >= 100 ? 'r' : 'l';

        let legsMoving = false;
        legs.forEach((l) => {
            const goal = want && (ahead || l.side === reachSide) ? 1 : 0;
            l.v += (goal - l.v) * .14;
            if (Math.abs(goal - l.v) < .004) l.v = goal; else legsMoving = true;
            if (l.v === 0) { l.g.removeAttribute('transform'); return; }
            // cursor in front of the head: front legs reach, upper legs follow only slightly
            const w = ahead ? (l.w < .9 ? 1 : .25) : l.w;
            const delta = clamp(wrap(Math.atan2(ty - l.ay, tx - l.ax) - l.phi), -1.2, 1.2);
            const th = (delta * l.v * w * 180 / Math.PI).toFixed(2);
            const ph = (l.phi * 180 / Math.PI).toFixed(2);
            const sc = (1 + .6 * l.v * w).toFixed(3);
            l.g.setAttribute('transform', `translate(${l.ax} ${l.ay}) rotate(${th}) rotate(${ph}) scale(${sc} 1) rotate(${-ph}) translate(${-l.ax} ${-l.ay})`);
        });
        raf = want || bodyMoving || legsMoving ? requestAnimationFrame(frame) : 0;
    };
    const kick = () => { if (!raf) raf = requestAnimationFrame(frame); };

    const refresh = () => {
        open = side.matches(':hover') || side.matches(':focus-within') || body.classList.contains('nav-open');
        kick();
    };
    ['pointerenter', 'pointerleave', 'focusin', 'focusout'].forEach((t) => side.addEventListener(t, refresh));
    new MutationObserver(refresh).observe(body, { attributes: true, attributeFilter: ['class'] });
    window.addEventListener('pointermove', (e) => {
        ptr = { x: e.clientX, y: e.clientY };
        if (open) kick();
    }, { passive: true });
})();

// Tagline "BREAK THE ROUTINE." takes exactly the width of the THREAM wordmark:
// measure the word inside its SVG and pass the ratio to CSS (--word-w).
(() => {
    const lockup = document.querySelector('.hero-lockup');
    const word = document.querySelector('.word-sketch .wd-fill');
    if (!lockup || !word) return;
    const fit = () => {
        const vb = word.ownerSVGElement.viewBox.baseVal.width;
        const w = word.getBBox().width;
        if (vb && w) lockup.style.setProperty('--word-w', (w / vb).toFixed(4));
    };
    fit();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(fit);
})();
