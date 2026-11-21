/**
 * Weneura Futuretech - Interactive Navigation & Component Controller (common.js)
 * Enhances server-rendered static HTML header/footer components:
 * - Active link highlighting
 * - Mega menu hover & focus events
 * - Sticky header on scroll
 * - Mobile offcanvas interactions
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    highlightActiveLink();
    initHeaderFeatures();
  });

  if (window.location.pathname.toLowerCase().startsWith('/blog')) {
    document.body.classList.add('page-blog');
  }

  // 1. Highlight Active Navigation Link based on current URL path
  function highlightActiveLink() {
    const currentPath = (window.location.pathname || '').replace(/\\/g, '/').toLowerCase();

    document.querySelectorAll('.nav-capsule-links .nav-link, .offcanvas-nav-link').forEach(link => {
      const href = (link.getAttribute('href') || '').toLowerCase();
      if (href === currentPath || (currentPath === '/' && href === '/')) {
        link.classList.add('active');
      } else if (href !== '/' && href !== '' && currentPath.startsWith(href)) {
        link.classList.add('active');
      }
    });
  }

  // 2. Interactive Mega-Menu & Sticky Header
  function initHeaderFeatures() {
    const siteHeader = document.querySelector('.site-header');
    const servicesTrigger = document.getElementById('servicesTrigger');
    const servicesMegaMenu = document.getElementById('servicesMegaMenu');
    let megaMenuTimeout = null;

    function openMegaMenu() {
      if (megaMenuTimeout) clearTimeout(megaMenuTimeout);
      if (siteHeader) siteHeader.classList.add('mega-menu-open');
      if (servicesMegaMenu) servicesMegaMenu.setAttribute('aria-hidden', 'false');
      if (servicesTrigger) servicesTrigger.setAttribute('aria-expanded', 'true');
    }

    function closeMegaMenuWithDelay() {
      if (megaMenuTimeout) clearTimeout(megaMenuTimeout);
      megaMenuTimeout = setTimeout(function () {
        if (siteHeader) siteHeader.classList.remove('mega-menu-open');
        if (servicesMegaMenu) servicesMegaMenu.setAttribute('aria-hidden', 'true');
        if (servicesTrigger) servicesTrigger.setAttribute('aria-expanded', 'false');
      }, 220);
    }

    function closeMegaMenuImmediately() {
      if (megaMenuTimeout) clearTimeout(megaMenuTimeout);
      if (siteHeader) siteHeader.classList.remove('mega-menu-open');
      if (servicesMegaMenu) servicesMegaMenu.setAttribute('aria-hidden', 'true');
      if (servicesTrigger) servicesTrigger.setAttribute('aria-expanded', 'false');
    }

    if (servicesTrigger) {
      servicesTrigger.addEventListener('mouseenter', openMegaMenu);
      servicesTrigger.addEventListener('mouseleave', closeMegaMenuWithDelay);
      servicesTrigger.addEventListener('click', function () {
        closeMegaMenuImmediately();
      });
    }

    if (servicesMegaMenu) {
      servicesMegaMenu.addEventListener('mouseenter', openMegaMenu);
      servicesMegaMenu.addEventListener('mouseleave', closeMegaMenuWithDelay);

      servicesMegaMenu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMegaMenuImmediately);
      });
    }

    document.addEventListener('click', function (e) {
      if (!siteHeader) return;
      if (!siteHeader.contains(e.target)) {
        closeMegaMenuImmediately();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeMegaMenuImmediately();
    });

    // Sticky Header Scroll
    function handleStickyHeader() {
      if (!siteHeader) return;
      if (window.scrollY > 60) {
        siteHeader.classList.add('is-sticky');
      } else {
        siteHeader.classList.remove('is-sticky');
      }
    }
    window.addEventListener('scroll', handleStickyHeader, { passive: true });
    handleStickyHeader();
  }

})();
