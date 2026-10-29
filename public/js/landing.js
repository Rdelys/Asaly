(() => {
  const d = document;
  const root = d.documentElement;
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const fine = matchMedia('(hover: hover) and (pointer: fine)').matches;
  const pad = (n) => String(n).padStart(2, '0');
  const $ = (id) => d.getElementById(id);

  const nav = $('nav');
  const toggle = d.querySelector('.nav-toggle');
  const bar = $('sp');
  const hero = d.querySelector('.hero');

  /* ====================================================================
     Confettis (canvas) — couleurs bleu / rouge uniquement
     ==================================================================== */
  const cv = $('fx');
  const ctx = cv && !reduce ? cv.getContext('2d') : null;
  const COLORS = ['#2f6bff', '#5b8cff', '#ff2d46', '#ff5a6e'];
  let parts = [];
  let fxRun = false;

  const sizeCanvas = () => {
    if (!ctx) return;
    const dpr = Math.min(devicePixelRatio || 1, 2);
    cv.width = innerWidth * dpr;
    cv.height = innerHeight * dpr;
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  };
  sizeCanvas();
  addEventListener('resize', sizeCanvas);

  const fxLoop = () => {
    ctx.clearRect(0, 0, innerWidth, innerHeight);
    parts = parts.filter((p) => p.life > 0 && p.y < innerHeight + 40);
    parts.forEach((p) => {
      p.vy += p.g; p.x += p.vx; p.y += p.vy; p.vx *= 0.99;
      p.rot += p.vr; p.life -= p.decay;
      ctx.save();
      ctx.globalAlpha = Math.max(p.life, 0);
      ctx.translate(p.x, p.y);
      ctx.rotate(p.rot);
      ctx.fillStyle = p.c;
      if (p.sq) ctx.fillRect(-p.r, -p.r / 2, p.r * 2, p.r);
      else { ctx.beginPath(); ctx.arc(0, 0, p.r / 1.5, 0, 7); ctx.fill(); }
      ctx.restore();
    });
    if (parts.length) requestAnimationFrame(fxLoop);
    else { fxRun = false; ctx.clearRect(0, 0, innerWidth, innerHeight); }
  };

  const burst = (x, y, n = 36) => {
    if (!ctx) return;
    for (let i = 0; i < n; i++) {
      const a = Math.random() * Math.PI * 2;
      const s = 2 + Math.random() * 6;
      parts.push({
        x, y, vx: Math.cos(a) * s, vy: Math.sin(a) * s - 3, g: 0.18,
        r: 3 + Math.random() * 4, rot: Math.random() * 6, vr: (Math.random() - 0.5) * 0.4,
        life: 1, decay: 0.011 + Math.random() * 0.012, c: COLORS[i % COLORS.length], sq: Math.random() > 0.5,
      });
    }
    if (!fxRun) { fxRun = true; requestAnimationFrame(fxLoop); }
  };

  // Petite explosion sur chaque bouton
  d.addEventListener('click', (e) => {
    const b = e.target.closest?.('.btn');
    if (b && e.clientX) burst(e.clientX, e.clientY, 14);
  });

  /* ====================================================================
     Scroll : navbar, progression, parallaxe (1 seul handler rAF)
     ==================================================================== */
  let ticking = false;
  const onScroll = () => {
    const y = scrollY;
    nav.classList.toggle('is-scrolled', y > 12);
    const max = root.scrollHeight - innerHeight;
    if (bar && max > 0) bar.style.transform = `scaleX(${Math.min(y / max, 1)})`;
    if (hero && !reduce && y < 1000) hero.style.setProperty('--py', y);
    ticking = false;
  };
  addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
  onScroll();

  /* ---------- Menu mobile ---------- */
  const setOpen = (open) => {
    nav.classList.toggle('is-open', open);
    d.body.classList.toggle('no-scroll', open);
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
  };
  toggle.addEventListener('click', () => setOpen(!nav.classList.contains('is-open')));
  d.querySelectorAll('.nav-menu a').forEach((a) => a.addEventListener('click', () => setOpen(false)));
  addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
  addEventListener('resize', () => { if (innerWidth > 960) setOpen(false); });

  /* ---------- Titre du hero : révélation mot par mot ---------- */
  const h1 = d.querySelector('.hero h1');
  if (h1 && !reduce) {
    h1.setAttribute('aria-label', h1.textContent.trim().replace(/\s+/g, ' '));
    let n = 0;
    const walk = (node) => {
      [...node.childNodes].forEach((child) => {
        if (child.nodeType === 3) {
          const frag = d.createDocumentFragment();
          child.textContent.split(/(\s+)/).forEach((part) => {
            if (!part) return;
            if (/^\s+$/.test(part)) { frag.append(' '); return; }
            const w = d.createElement('span');
            w.className = 'w';
            w.setAttribute('aria-hidden', 'true');
            const s = d.createElement('span');
            s.style.setProperty('--i', n++);
            s.textContent = part;
            w.append(s);
            frag.append(w);
          });
          child.replaceWith(frag);
        } else if (child.nodeType === 1) {
          walk(child);
        }
      });
    };
    walk(h1);
    h1.classList.add('is-split');
  }

  /* ---------- Lien actif selon la section visible ---------- */
  const links = [...d.querySelectorAll('.nav-links a')];
  const map = new Map(links.map((a) => [a.getAttribute('href').slice(1), a]));
  const spy = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      links.forEach((l) => l.classList.remove('active'));
      map.get(e.target.id)?.classList.add('active');
    });
  }, { rootMargin: '-45% 0px -50% 0px' });
  map.forEach((_, id) => { const s = d.getElementById(id); if (s) spy.observe(s); });

  /* ---------- Révélation + compteurs ---------- */
  const countUp = (el) => {
    const target = +el.dataset.count, suffix = el.dataset.suffix || '';
    if (reduce || target === 0) { el.textContent = target + suffix; return; }
    const t0 = performance.now(), dur = 1400;
    const step = (t) => {
      const p = Math.min((t - t0) / dur, 1);
      el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))) + suffix;
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      e.target.classList.add('in');
      if (e.target.dataset.count !== undefined) countUp(e.target);
      io.unobserve(e.target);
    });
  }, { threshold: 0.15 });
  d.querySelectorAll('.reveal, [data-count], .steps').forEach((el) => io.observe(el));

  /* ---------- Chronomètre de la maquette (hero) ---------- */
  const timer = d.querySelector('[data-timer]');
  if (timer && !reduce) {
    let s = +timer.dataset.timer;
    setInterval(() => {
      if (d.hidden) return;
      s++;
      timer.textContent = `${pad(Math.floor(s / 3600))}:${pad(Math.floor(s / 60) % 60)}:${pad(s % 60)}`;
    }, 1000);
  }

  // Clic sur la maquette du hero = confettis
  const stageEl = d.querySelector('.stage');
  if (stageEl) stageEl.addEventListener('click', (e) => burst(e.clientX, e.clientY, 34));

  /* ====================================================================
     JEU 1 — Chrono & gains (démarrer, régler le taux, mode turbo)
     ==================================================================== */
  (() => {
    const box = $('p-timer');
    if (!box) return;
    const clock = box.querySelector('[data-clock]');
    const earn = box.querySelector('[data-earn]');
    const rate = box.querySelector('[data-rate]');
    const rateOut = box.querySelector('[data-rate-out]');
    const tgl = box.querySelector('[data-toggle]');
    const rst = box.querySelector('[data-reset]');
    const turbo = box.querySelector('[data-turbo]');
    let el = 0, run = false, id = 0, lastHour = 0;

    const draw = () => {
      const s = Math.floor(el);
      clock.textContent = `${pad(Math.floor(s / 3600))}:${pad(Math.floor(s / 60) % 60)}:${pad(s % 60)}`;
      earn.textContent = Math.round((el / 3600) * +rate.value).toLocaleString('fr-FR');
      rateOut.textContent = (+rate.value).toLocaleString('fr-FR') + ' Ar/h';
    };
    const setBtn = () => {
      tgl.querySelector('i').className = run ? 'fa-solid fa-pause' : 'fa-solid fa-play';
      tgl.querySelector('span').textContent = run ? 'Pause' : (el > 0 ? 'Reprendre' : 'Démarrer');
      box.classList.toggle('running', run);
    };
    const start = () => {
      run = true;
      id = setInterval(() => {
        el += 0.1 * (turbo.checked ? 60 : 1);
        const h = Math.floor(el / 3600);
        if (h > lastHour) {
          lastHour = h;
          const r = clock.getBoundingClientRect();
          burst(r.left + r.width / 2, r.top + r.height / 2, 40);
        }
        draw();
      }, 100);
      setBtn();
    };
    const stop = () => { run = false; clearInterval(id); setBtn(); };

    tgl.addEventListener('click', () => (run ? stop() : start()));
    rst.addEventListener('click', () => { stop(); el = 0; lastHour = 0; draw(); setBtn(); });
    rate.addEventListener('input', draw);
    draw();
  })();

  /* ====================================================================
     JEU 2 — Kanban jouable (glisser-déposer + bouton flèche)
     ==================================================================== */
  (() => {
    const board = d.querySelector('.pk-board');
    if (!board) return;
    const order = ['todo', 'doing', 'done'];
    const cards = [...board.querySelectorAll('.pk-card')];
    const total = cards.length;
    const initial = cards.map((c) => ({ c, col: c.closest('[data-col]').dataset.col }));
    const bar2 = $('pk-bar');
    const pct = $('pk-pct');
    const listOf = (k) => board.querySelector(`[data-col="${k}"] .pk-list`);
    let dragged = null;

    const refresh = () => {
      order.forEach((k) => {
        const list = listOf(k);
        board.querySelector(`[data-col="${k}"] em`).textContent = list.children.length;
        list.querySelectorAll('.pk-next i').forEach((i) => {
          i.className = k === 'done' ? 'fa-solid fa-rotate-left' : 'fa-solid fa-arrow-right';
        });
      });
      const done = listOf('done').children.length;
      const p = Math.round((done / total) * 100);
      bar2.style.setProperty('--p', p + '%');
      pct.textContent = p + ' % livré';
    };

    const moveTo = (card, k, fx = true) => {
      listOf(k).appendChild(card);
      card.classList.remove('pop'); void card.offsetWidth; card.classList.add('pop');
      refresh();
      if (k === 'done' && fx) {
        const r = card.getBoundingClientRect();
        burst(r.left + r.width / 2, r.top + r.height / 2, 24);
        if (listOf('done').children.length === total) {
          const b = board.getBoundingClientRect();
          burst(b.left + b.width / 2, b.top + b.height / 3, 90);
        }
      }
    };

    cards.forEach((card) => {
      card.addEventListener('dragstart', (e) => {
        dragged = card;
        card.classList.add('drag');
        e.dataTransfer.effectAllowed = 'move';
        try { e.dataTransfer.setData('text/plain', card.dataset.id || ''); } catch (err) {}
      });
      card.addEventListener('dragend', () => {
        card.classList.remove('drag');
        board.querySelectorAll('.pk-col').forEach((c) => c.classList.remove('over'));
        dragged = null;
      });
      card.querySelector('.pk-next').addEventListener('click', () => {
        const cur = card.closest('[data-col]').dataset.col;
        moveTo(card, order[(order.indexOf(cur) + 1) % order.length]);
      });
    });

    board.querySelectorAll('.pk-col').forEach((col) => {
      col.addEventListener('dragover', (e) => { e.preventDefault(); col.classList.add('over'); });
      col.addEventListener('dragleave', (e) => { if (!col.contains(e.relatedTarget)) col.classList.remove('over'); });
      col.addEventListener('drop', (e) => {
        e.preventDefault();
        col.classList.remove('over');
        if (dragged && dragged.closest('[data-col]') !== col) moveTo(dragged, col.dataset.col);
      });
    });

    $('pk-reset')?.addEventListener('click', () => {
      initial.forEach(({ c, col }) => moveTo(c, col, false));
    });
    refresh();
  })();

  /* ====================================================================
     JEU 3 — Facture Rush : attrapez les factures, évitez les bugs
     ==================================================================== */
  (() => {
    const field = $('g-field');
    if (!field) return;
    const ov = $('g-overlay');
    const startBtn = $('g-start');
    const ovTitle = $('g-title');
    const ovText = $('g-text');
    const elTime = $('g-time');
    const elScore = $('g-score');
    const elBest = $('g-best');

    let best = 0;
    try { best = +localStorage.getItem('rush-best') || 0; } catch (e) {}
    elBest.textContent = best;

    const DURATION = 30;
    const TYPES = {
      inv:  { k: 'inv',  icon: 'fa-file-invoice-dollar', pts: 1,  v: [130, 210], label: 'Facture' },
      gold: { k: 'gold', icon: 'fa-coins',               pts: 3,  v: [250, 330], label: 'Gros paiement' },
      bug:  { k: 'bug',  icon: 'fa-bug',                 pts: -2, v: [120, 200], label: 'Bug' },
    };
    let items = [], running = false, score = 0, left = DURATION, last = 0, acc = 0, elapsed = 0;

    const pick = () => { const r = Math.random(); return r < 0.6 ? TYPES.inv : r < 0.8 ? TYPES.gold : TYPES.bug; };
    const removeItem = (it) => {
      const i = items.indexOf(it);
      if (i > -1) items.splice(i, 1);
      it.el.remove();
    };
    const pop = (it) => {
      const s = d.createElement('span');
      s.className = 'g-pop ' + (it.t.pts > 0 ? 'plus' : 'minus');
      s.textContent = (it.t.pts > 0 ? '+' : '') + it.t.pts;
      s.style.left = it.x + 12 + 'px';
      s.style.top = it.y + 'px';
      field.appendChild(s);
      setTimeout(() => s.remove(), 750);
    };
    const hit = (it, ev) => {
      if (!running) return;
      score = Math.max(0, score + it.t.pts);
      elScore.textContent = score;
      pop(it);
      removeItem(it);
      if (it.t.k === 'bug') {
        field.classList.remove('shake'); void field.offsetWidth; field.classList.add('shake');
        burst(ev.clientX, ev.clientY, 8);
      } else {
        burst(ev.clientX, ev.clientY, it.t.k === 'gold' ? 22 : 10);
      }
    };
    const spawn = () => {
      const t = pick();
      const b = d.createElement('button');
      b.type = 'button';
      b.className = 'g-item ' + t.k;
      b.setAttribute('aria-label', t.label);
      b.innerHTML = `<i class="fa-solid ${t.icon}"></i>`;
      const x = Math.random() * Math.max(field.clientWidth - 58, 10);
      const speed = (t.v[0] + Math.random() * (t.v[1] - t.v[0])) * (1 + (elapsed / DURATION) * 0.7);
      const it = { el: b, x, y: -60, speed, t };
      b.style.transform = `translate3d(${x}px,-60px,0)`;
      b.addEventListener('pointerdown', (ev) => { ev.preventDefault(); hit(it, ev); });
      field.appendChild(b);
      items.push(it);
    };

    const end = () => {
      running = false;
      items.slice().forEach(removeItem);
      const record = score > best;
      if (record) {
        best = score;
        elBest.textContent = best;
        try { localStorage.setItem('rush-best', String(best)); } catch (e) {}
      }
      ovTitle.textContent = record && score > 0 ? 'Nouveau record !' : 'Temps écoulé';
      ovText.textContent = `Vous avez encaissé ${score} point${score > 1 ? 's' : ''}. ` + (record && score > 0 ? 'Bravo, meilleur score battu.' : `Le record à battre : ${best}.`);
      startBtn.querySelector('span').textContent = 'Rejouer';
      ov.hidden = false;
      if (record && score > 0) {
        const r = field.getBoundingClientRect();
        burst(r.left + r.width / 2, r.top + r.height / 2, 120);
      }
    };

    const tick = (now) => {
      if (!running) return;
      const dt = Math.min((now - last) / 1000, 0.05);
      last = now;
      left -= dt; elapsed += dt;
      elTime.textContent = Math.max(0, Math.ceil(left));
      acc += dt;
      if (acc >= Math.max(0.32, 0.7 - elapsed * 0.012)) { acc = 0; spawn(); }
      const h = field.clientHeight;
      for (let i = items.length - 1; i >= 0; i--) {
        const it = items[i];
        it.y += it.speed * dt;
        if (it.y > h) removeItem(it);
        else it.el.style.transform = `translate3d(${it.x}px,${it.y}px,0)`;
      }
      if (left <= 0) { end(); return; }
      requestAnimationFrame(tick);
    };

    startBtn.addEventListener('click', () => {
      items.slice().forEach(removeItem);
      score = 0; left = DURATION; elapsed = 0; acc = 0;
      elScore.textContent = 0; elTime.textContent = DURATION;
      ov.hidden = true;
      running = true;
      last = performance.now();
      requestAnimationFrame(tick);
    });
  })();

  /* ====================================================================
     Effets souris (uniquement écrans avec souris)
     ==================================================================== */
  if (fine && !reduce) {
    // Halo qui suit le curseur (lissé)
    const glow = $('cg');
    if (glow) {
      let gx = innerWidth / 2, gy = innerHeight / 2, tx = gx, ty = gy, running = false;
      const loop = () => {
        gx += (tx - gx) * 0.12;
        gy += (ty - gy) * 0.12;
        glow.style.transform = `translate3d(${gx - 160}px, ${gy - 160}px, 0)`;
        if (Math.abs(tx - gx) > 0.4 || Math.abs(ty - gy) > 0.4) requestAnimationFrame(loop);
        else running = false;
      };
      addEventListener('pointermove', (e) => {
        tx = e.clientX; ty = e.clientY;
        glow.classList.add('on');
        if (!running) { running = true; requestAnimationFrame(loop); }
      }, { passive: true });
      d.addEventListener('pointerleave', () => glow.classList.remove('on'));
    }

    // Inclinaison 3D des cartes (hors zone de jeu) et des tarifs
    d.querySelectorAll('.card:not(.play), .plan').forEach((el) => {
      el.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        el.style.setProperty('--ry', `${x * 8}deg`);
        el.style.setProperty('--rx', `${-y * 8}deg`);
      });
      el.addEventListener('pointerleave', () => {
        el.style.setProperty('--ry', '0deg');
        el.style.setProperty('--rx', '0deg');
      });
    });

    // Inclinaison 3D de la maquette
    const stage = d.querySelector('.stage');
    const device = d.querySelector('.device');
    if (stage && device) {
      stage.addEventListener('pointermove', (e) => {
        const r = stage.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        device.style.setProperty('--ry', `${x * 14}deg`);
        device.style.setProperty('--rx', `${-y * 12}deg`);
      });
      stage.addEventListener('pointerleave', () => {
        device.style.setProperty('--ry', '0deg');
        device.style.setProperty('--rx', '0deg');
      });
    }

    // Boutons magnétiques
    d.querySelectorAll('.btn-primary, .btn-dark').forEach((btn) => {
      btn.addEventListener('pointermove', (e) => {
        const r = btn.getBoundingClientRect();
        btn.style.setProperty('--tx', `${(e.clientX - r.left - r.width / 2) * 0.18}px`);
        btn.style.setProperty('--ty', `${(e.clientY - r.top - r.height / 2) * 0.25}px`);
      });
      btn.addEventListener('pointerleave', () => {
        btn.style.setProperty('--tx', '0px');
        btn.style.setProperty('--ty', '0px');
      });
    });
  }

  /* ====================================================================
     Tarifs : période + devise (prix lus depuis data-prices)
     ==================================================================== */
  const plans = [...d.querySelectorAll('[data-prices]')];
  const perBtns = [...d.querySelectorAll('[data-per]')];
  const curBtns = [...d.querySelectorAll('[data-cur]')];

  let tz = '';
  try { tz = Intl.DateTimeFormat().resolvedOptions().timeZone; } catch (e) {}
  let per = 'm';
  let cur = tz === 'Indian/Antananarivo' ? 'MGA' : 'EUR'; // pré-sélection selon le pays, modifiable

  const fmt = (n, c) => {
    if (c === 'MGA') return n.toLocaleString('fr-FR') + ' Ar';
    if (c === 'EUR') return n.toLocaleString('fr-FR') + ' €';
    return '$' + n.toLocaleString('en-US');
  };

  const render = () => {
    perBtns.forEach((b) => b.setAttribute('aria-pressed', String(b.dataset.per === per)));
    curBtns.forEach((b) => b.setAttribute('aria-pressed', String(b.dataset.cur === cur)));
    plans.forEach((card) => {
      const prices = JSON.parse(card.dataset.prices);
      const value = prices[cur][per === 'm' ? 0 : 1];
      const amount = card.querySelector('.amount');
      amount.textContent = fmt(value, cur);
      amount.classList.remove('tick'); void amount.offsetWidth; amount.classList.add('tick');
      card.querySelector('.period').textContent = value === 0 ? 'pour toujours' : (per === 'm' ? '/mois' : '/an');
      card.querySelector('.save').hidden = !(per === 'y' && value > 0);
    });
  };
  perBtns.forEach((b) => b.addEventListener('click', () => { per = b.dataset.per; render(); }));
  curBtns.forEach((b) => b.addEventListener('click', () => { cur = b.dataset.cur; render(); }));
  render();

  /* ---------- Suivi des clics sur les plans (branche ton analytics ici) ---------- */
  d.querySelectorAll('[data-plan-click]').forEach((a) =>
    a.addEventListener('click', () => {
      // ex : gtag('event', 'plan_click', { plan: a.dataset.planClick, period: per, currency: cur });
      d.dispatchEvent(new CustomEvent('plan:click', { detail: { plan: a.dataset.planClick, per, cur } }));
    })
  );
})();