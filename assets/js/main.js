/**
 * Weneura Futuretech - IT Solutions & Services
 * Main JavaScript File (Page Content Interactions)
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // 1. Scroll-Triggered Text Animation (Main Headings Only)
  const mainHeadings = document.querySelectorAll(
    '.sec-title, .hero-title, .statement-heading, .footer-cta-title, [data-anim]'
  );

  if ('IntersectionObserver' in window) {
    const observerOptions = {
      root: null,
      rootMargin: '0px 0px -6% 0px',
      threshold: 0.1
    };

    const headingObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-animated');
          observer.unobserve(entry.target); // Animates once smoothly on scroll down
        }
      });
    }, observerOptions);

    mainHeadings.forEach(function (heading) {
      // Default to 'blur-up' if no specific preset is assigned
      if (!heading.hasAttribute('data-anim')) {
        heading.setAttribute('data-anim', 'blur-up');
      }
      headingObserver.observe(heading);
    });
  } else {
    // Fallback for older browsers without IntersectionObserver
    mainHeadings.forEach(function (heading) {
      heading.classList.add('is-animated');
    });
  }

  // 2. Build Together Section - Rotating Lottie Contact Badge
  const contactLottieContainer = document.getElementById('contactLottie');
  if (contactLottieContainer && typeof lottie !== 'undefined') {
    try {
      lottie.loadAnimation({
        container: contactLottieContainer,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/assets/img/contact-white.json'
      });
    } catch (err) {
      console.warn('Lottie initialization warning:', err);
    }
  }

  // 3. Build Together Form Submission Handler
  const buildForm = document.getElementById('buildContactForm');
  if (buildForm) {
    buildForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const submitBtn = buildForm.querySelector('.btn-build-send');
      const originalHTML = submitBtn ? submitBtn.innerHTML : '';

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Sending...</span> <i class="bi bi-hourglass-split"></i>';
      }

      setTimeout(function () {
        if (submitBtn) {
          submitBtn.innerHTML = '<span>Message Sent!</span> <i class="bi bi-check2"></i>';
          submitBtn.style.backgroundColor = '#198754';
          submitBtn.style.borderColor = '#198754';
        }
        buildForm.reset();

        setTimeout(function () {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
            submitBtn.style.backgroundColor = '';
            submitBtn.style.borderColor = '';
          }
        }, 3500);
      }, 1000);
    });
  }
});

