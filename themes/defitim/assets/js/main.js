/* =============================================================
   DÉFI TIM — main.js
   FAQ accordion · Donation picker · Contact form · Mobile nav · Share
   ============================================================= */

(function () {
  'use strict';

  /* ----------------------------------------------------------------
     FAQ ACCORDION
  ---------------------------------------------------------------- */
  function initFAQ() {
    const list = document.querySelector('.faq-list');
    if (!list) return;

    list.addEventListener('click', function (e) {
      const btn = e.target.closest('.faq-q');
      if (!btn) return;

      const item   = btn.closest('.faq-item');
      const answer = item.querySelector('.faq-a');
      const icon   = btn.querySelector('.faq-q-x');
      const isOpen = item.classList.contains('faq-open');

      // Close all
      list.querySelectorAll('.faq-item.faq-open').forEach(function (open) {
        open.classList.remove('faq-open');
        open.querySelector('.faq-q').setAttribute('aria-expanded', 'false');
        open.querySelector('.faq-a').hidden = true;
        const x = open.querySelector('.faq-q-x');
        if (x) x.textContent = '+';
      });

      // Open clicked (if it was closed)
      if (!isOpen) {
        item.classList.add('faq-open');
        btn.setAttribute('aria-expanded', 'true');
        answer.hidden = false;
        if (icon) icon.textContent = '–';
      }
    });
  }

  /* ----------------------------------------------------------------
     DONATION AMOUNT PICKER
  ---------------------------------------------------------------- */
  function initDonationPicker() {
    const container  = document.querySelector('.help-donate-amounts');
    const donateBtn  = document.getElementById('donate-btn');
    const amountSpan = document.getElementById('donate-amount');
    const customInput = document.getElementById('amount-custom');

    if (!container) return;

    let currentAmount = 50;

    function updateBtn(amount) {
      currentAmount = amount;
      if (amountSpan) amountSpan.textContent = '€' + amount;

      // Update donate-btn href if it's a HelloAsso link
      if (donateBtn && donateBtn.tagName === 'A') {
        const url = new URL(donateBtn.href, window.location.href);
        url.searchParams.set('amount', amount * 100); // cents
        donateBtn.href = url.toString();
      }
    }

    function clearPresets() {
      container.querySelectorAll('.amt[data-amount]').forEach(function (b) {
        b.classList.remove('amt-active');
        b.setAttribute('aria-pressed', 'false');
      });
    }

    container.addEventListener('click', function (e) {
      const btn = e.target.closest('.amt[data-amount]');
      if (!btn) return;
      clearPresets();
      btn.classList.add('amt-active');
      btn.setAttribute('aria-pressed', 'true');
      if (customInput) {
        customInput.value = '';
        customInput.parentElement.classList.remove('amt-active');
      }
      updateBtn(parseInt(btn.dataset.amount, 10));
    });

    if (customInput) {
      customInput.addEventListener('input', function () {
        const v = parseInt(customInput.value, 10);
        clearPresets();
        if (v > 0) {
          customInput.parentElement.classList.add('amt-active');
          updateBtn(v);
        } else {
          customInput.parentElement.classList.remove('amt-active');
        }
      });
    }

    // HelloAsso checkout via AJAX (when no direct URL is set)
    if (donateBtn && donateBtn.tagName === 'BUTTON') {
      donateBtn.addEventListener('click', function () {
        if (!window.defitim) return;
        donateBtn.disabled = true;
        donateBtn.textContent = window.defitim.strings.sending || 'Envoi…';

        fetch(window.defitim.ajax_url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({
            action:      'defitim_helloasso_checkout',
            nonce:       window.defitim.nonce,
            amount_cents: currentAmount * 100,
          }),
        })
          .then(function (r) { return r.json(); })
          .then(function (data) {
            if (data.success && data.data.redirect_url) {
              window.location.href = data.data.redirect_url;
            } else {
              donateBtn.disabled = false;
              donateBtn.textContent = window.defitim.strings.error || 'Erreur';
            }
          })
          .catch(function () {
            donateBtn.disabled = false;
          });
      });
    }
  }

  /* ----------------------------------------------------------------
     CONTACT FORM (AJAX)
  ---------------------------------------------------------------- */
  function initContactForm() {
    const form = document.getElementById('contact-form');
    if (!form || !window.defitim) return;

    const feedback = form.querySelector('.cf-feedback');
    const submitBtn = form.querySelector('[type="submit"]');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const data = new FormData(form);
      data.append('action', 'defitim_contact');
      data.append('nonce', window.defitim.nonce);

      submitBtn.disabled = true;
      if (feedback) {
        feedback.hidden = false;
        feedback.textContent = window.defitim.strings.sending || 'Envoi…';
        feedback.className = 'cf-feedback cf-info';
      }

      fetch(window.defitim.ajax_url, {
        method: 'POST',
        body: data,
      })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) {
            form.reset();
            if (feedback) {
              feedback.hidden = false;
              feedback.textContent = (res.data && res.data.message) || window.defitim.strings.success;
              feedback.className = 'cf-feedback cf-success';
            }
          } else {
            throw new Error((res.data && res.data.message) || window.defitim.strings.error);
          }
        })
        .catch(function (err) {
          if (feedback) {
            feedback.hidden = false;
            feedback.textContent = err.message || window.defitim.strings.error;
            feedback.className = 'cf-feedback cf-error';
          }
          submitBtn.disabled = false;
        });
    });
  }

  /* ----------------------------------------------------------------
     MOBILE NAV TOGGLE
  ---------------------------------------------------------------- */
  function initMobileNav() {
    const toggle  = document.querySelector('.nav-toggle');
    const navMob  = document.getElementById('nav-mobile');
    if (!toggle || !navMob) return;

    toggle.addEventListener('click', function () {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', !expanded);
      navMob.hidden = expanded;
    });

    // Close on anchor click
    navMob.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        navMob.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ----------------------------------------------------------------
     TOPBAR SCROLL SHADOW
  ---------------------------------------------------------------- */
  function initTopbarScroll() {
    const topbar = document.querySelector('.topbar');
    if (!topbar) return;
    const cls = 'topbar-scrolled';
    function update() {
      topbar.classList.toggle(cls, window.scrollY > 8);
    }
    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  /* ----------------------------------------------------------------
     SMOOTH SCROLL (anchor links)
  ---------------------------------------------------------------- */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        const target = document.querySelector(a.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  }

  /* ----------------------------------------------------------------
     SHARE BUTTON (Web Share API → fallback clipboard)
  ---------------------------------------------------------------- */
  function initShare() {
    const btn = document.getElementById('share-btn');
    if (!btn) return;

    btn.addEventListener('click', function () {
      if (navigator.share) {
        navigator.share({
          title: 'Un Défi pour Tim',
          text: 'Soutenez le collectif Un Défi pour Tim — Marathon de l\'Espace, Kourou 2026.',
          url: window.location.href,
        }).catch(function () {});
      } else {
        navigator.clipboard.writeText(window.location.href).then(function () {
          const orig = btn.textContent;
          btn.textContent = 'Lien copié !';
          setTimeout(function () { btn.textContent = orig; }, 2000);
        }).catch(function () {});
      }
    });
  }

  /* ----------------------------------------------------------------
     INIT
  ---------------------------------------------------------------- */
  document.addEventListener('DOMContentLoaded', function () {
    initFAQ();
    initDonationPicker();
    initContactForm();
    initMobileNav();
    initTopbarScroll();
    initSmoothScroll();
    initShare();
  });
})();
