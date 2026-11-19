# Stage 2: Strategic Rebuild & Implementation Plan

**Project:** Weneura Futuretech Website Rebuild  
**Prepared For:** Siddharth Varsani, Founder & Director  
**Date:** 16 November 2026  
**Status:** Architecture & Mapping Complete (Pure HTML5/CSS3/Vanilla JS)  
**Deliverables Generated:**
1. `docs/seo/redirects.csv` (Complete 301 & 410 redirect specifications)
2. `docs/seo/keyword-map.csv` (Keyword strategy, titles, descriptions, H1s, questions)
3. `docs/seo/02_PLAN.md` (This document)

---

## 1. Final URL Mapping Structure

All URLs follow clean, trailing-slash folder conventions (`/path/` loading `path/index.html`):

### Core Brand & Trust Pages
* `/` — Homepage (Company Positioning, Trust Bar, 5 Divisions, Featured Proof, FAQs)
* `/about/` — About Weneura Futuretech (Mission, Engineering Philosophy, Rajkot Facility, CIN/Legal Info)
* `/about/siddharth-varsani/` — Founder & Director Profile (Bio, Credentials, Person Schema, Speaking & Leadership)
* `/contact/` — Inquiries & Consultation (Form with Validation, E.164 Click-to-Call, WhatsApp link, Map Facade)
* `/career/` — Careers & Culture (Engineering Roles in Robotics, AI, and Software in Rajkot)
* `/case-studies/` — Industrial Case Proofs (Problem, Architecture, Measurable ROI)

### Services Hub & 5 Core Category Divisions
* `/services/` — Master Services Directory (Explore All Services)
* `/services/robotics-industrial-automation/` — Robotics & Industrial Automation Hub
  *(Covers 6-Axis Robotic Systems, AGVs, Robotic Welding, Cobots, Robotic Palletizing, SPM directly on this page)*
* `/services/software-development/` — Software Development Hub
  *(Covers Custom ERP, Odoo ERP Development & Implementation, Web Apps, Mobile Apps, Android & iOS Apps directly on this page)*
* `/services/hardware-automation/` — Hardware & Automation Hub
  *(Covers Weight Scale Sensors, IR Sensors, Thermal Sensors, Foundry RTC Solutions, Custom Automation, Custom Sensors directly on this page)*
* `/services/computer-vision/` — Computer Vision Hub
  *(Covers High-Speed Camera Integration, Object Detection, Object Counting, Automated Quality Inspection, Industrial Visual Inspection directly on this page)*
* `/services/ai-development/` — AI Development Hub
  *(Covers Custom AI Development, AI Consultancy, Manufacturing AI Solutions, AI-Powered Industrial Automation directly on this page)*

### Blog & Technical Articles
* `/blog/` — Engineering Blog Index
* `/blog/human-centric-artificial-intelligence/` — Migrated & Refreshed Post 1
* `/blog/ai-odyssey-logic-gates-to-learning-machines/` — Migrated & Refreshed Post 2
* `/blog/ai-ethics-digital-morality/` — Migrated & Refreshed Post 3
* `/blog/ai-in-daily-life/` — Migrated & Refreshed Post 4

### Compliance & Conversion
* `/privacy-policy/` — India DPDP Act & Global Compliance Template
* `/terms/` — Commercial & Website Terms of Use
* `/thank-you/` — Lead Confirmation Page (`noindex`, conversion tracking)
* `/404.html` — Custom Server Error Page (HTTP 404 Status)

---

## 2. Technical Component & Layout Architecture (Pure HTML/CSS/JS)

To ensure zero code duplication while maintaining 100% pure static HTML, the codebase is structured around clean, reusable patterns:

1. **Inlined Critical CSS (`<style>` in `<head>`):**
   * Global CSS reset, typography variables, header layout, hero styling, and critical button styles.
   * Total size: $\le 14$ KB uncompressed.
2. **Asynchronous Stylesheet (`assets/css/main.css`):**
   * Preload pattern (`rel="preload" as="style" onload="this.rel='stylesheet'"`).
   * Contains grid systems, cards, tables, footer, and secondary elements.
3. **Accessible Header & Mega Menu (`assets/js/menu.js`):**
   * Pure semantic `<nav aria-label="Main">`.
   * Standard `<a href="...">` links directly in the HTML (no JavaScript required for crawlers to read links).
   * Mobile responsive accordion triggered by `<button aria-expanded="false" aria-controls="mega-menu">`.
4. **Interactive Lead Form & Conversion Tracking (`assets/js/forms.js`):**
   * Client-side validation with standard input attributes (`type="email"`, `type="tel"`, `required`).
   * Invisible honeypot field (`aria-hidden="true"`, styled off-screen) to trap spam bots.
   * Direct firing of Google Analytics 4 event: `generate_lead`.
5. **Standardized JSON-LD Schema Engine:**
   * Single `<script type="application/ld+json">` containing a unified `@graph` on every page.
   * Interlinked entities: `Organization` -> `founder` (Person) -> `Service` -> `FAQPage` -> `BreadcrumbList`.

---

## 3. Ordered Task List & Implementation Phases

| Step | Action Item | Deliverables / Targets |
| :--- | :--- | :--- |
| **Stage 3** | **Foundation & Technical Infrastructure** | `.htaccess` (HTTPS, redirects, 410s, security headers), `robots.txt`, `sitemap.xml`, `llms.txt`, `site.webmanifest`, SVG favicons, base CSS design system (`assets/css/main.css`), header/navigation, footer, and Google Search Console / GA4 setup. |
| **Stage 4** | **Page Authoring & Content Assembly** | Build all ~20 static HTML pages with rich GEO/AEO copy, direct-answer question blocks, specifications tables, validated JSON-LD `@graph`, and OpenGraph tags. |
| **Stage 5** | **Automated QA & Script Validation** | Run automated link crawler, verify redirects, validate schema syntax, verify responsive layout breakpoints (360px to 1920px), and check Lighthouse mobile performance. |
| **Stage 6** | **3-Layer Sign-off & Final Report** | Generate `docs/seo/03_FINAL_REPORT.md` and complete the launch verification checklist. |

---

### **Stage 2 Status:** COMPLETE
⛔ **Antigravity Protocol:** Stage 2 planning is finalized.  
**Awaiting your approval before proceeding to Stage 3 (Foundation: .htaccess, robots.txt, sitemap.xml, llms.txt, favicons, base CSS & Header/Footer components).**

