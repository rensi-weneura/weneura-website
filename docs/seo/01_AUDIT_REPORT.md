# Stage 1: Initial Audit & Codebase Baseline Report

**Project:** Weneura Futuretech Website Rebuild  
**Prepared For:** Siddharth Varsani, Founder & Director  
**Date:** 16 November 2026  
**Status:** Clean Slate Rebuild / Pure HTML5, CSS3, Vanilla JS  
**Reference Document:** Weneura Website Rebuild Pack v2 (`/pdf/`)

---

## 1. Architecture & Hosting Specification

* **Stack:** Pure Semantic HTML5, Modern CSS3 (custom responsive styling, CSS variables, zero bloat), and Vanilla JavaScript (ES6+ modular, deferred loading).
* **Hosting Assumption:** Apache / Standard Web Server (compatible with Cloudflare CDN, cPanel, Nginx, or static hosting).
* **Rendering Model:** 100% Server-Rendered Static HTML (all headings, copy, links, mega-menu anchors, meta tags, and JSON-LD `@graph` schemas are present in raw HTML source — readable via `curl` and crawler bots without executing JavaScript).
* **URL Architecture:** Folder-per-page structure with clean trailing slashes (`/services/robotics-industrial-automation/` -> `services/robotics-industrial-automation/index.html`).
* **Planned Folder Hierarchy (3 Levels):**
  ```
  d:\Weneura\Weneura-website\
  ├── index.html
  ├── 404.html
  ├── .htaccess
  ├── robots.txt
  ├── sitemap.xml
  ├── llms.txt
  ├── site.webmanifest
  ├── favicon.ico, favicon.svg, apple-touch-icon.png, icon-192.png, icon-512.png
  ├── about/
  │   ├── index.html
  │   └── siddharth-varsani/
  │       └── index.html
  ├── services/
  │   ├── index.html
  │   ├── robotics-industrial-automation/
  │   │   └── index.html
  │   ├── computer-vision/
  │   │   └── index.html
  │   ├── hardware-automation/
  │   │   └── index.html
  │   ├── ai-development/
  │   │   └── index.html
  │   └── software-development/
  │       └── index.html
  ├── case-studies/
  │   └── index.html
  ├── blog/
  │   ├── index.html
  │   ├── human-centric-artificial-intelligence/
  │   ├── ai-odyssey-logic-gates-to-learning-machines/
  │   ├── ai-ethics-digital-morality/
  │   └── ai-in-daily-life/
  ├── career/
  │   └── index.html
  ├── contact/
  │   └── index.html
  ├── privacy-policy/
  │   └── index.html
  ├── terms/
  │   └── index.html
  ├── thank-you/
  │   └── index.html
  ├── assets/
  │   ├── css/
  │   │   ├── critical.css (inlined in <head>)
  │   │   └── main.css (minified, async/deferred)
  │   ├── js/
  │   │   ├── menu.js (mega-menu toggle, pure accessible JS)
  │   │   ├── forms.js (validation + GA4 event triggers)
  │   │   └── analytics.js (GA4 + Consent Mode)
  │   ├── fonts/ (self-hosted WOFF2 only)
  │   └── img/
  │       ├── brand/ (SVG logos)
  │       ├── og/ (1200x630 JPG share cards)
  │       ├── services/ (WebP/AVIF images)
  │       └── team/ (founder headshot)
  └── docs/
      └── seo/
  ```

---

## 2. Page Inventory (Target v2 Launch Scope: ~20 Pages)

| Page Route | Page Type | Primary Objective | Est. Word Count Target | Canonical Target |
| :--- | :--- | :--- | :--- | :--- |
| `/` | Homepage | Entity definition, trust, 5 divisions, founder note | 900–1,400 | `https://www.weneurafuturetech.com/` |
| `/about/` | About Us | Company story, vision, capabilities, Rajkot facility | 700–1,100 | `https://www.weneurafuturetech.com/about/` |
| `/about/siddharth-varsani/` | Founder Page | Siddharth Varsani bio, leadership, person schema | 600–1,000 | `https://www.weneurafuturetech.com/about/siddharth-varsani/` |
| `/services/` | Services Hub | Overview of 5 core engineering divisions | 800–1,200 | `https://www.weneurafuturetech.com/services/` |
| `/services/robotics-industrial-automation/` | Category Hub | Robotics & Industrial Automation (6-Axis, AGV, Welding, Cobots, Palletizing, SPM) | 1,200–1,800 | `https://www.weneurafuturetech.com/services/robotics-industrial-automation/` |
| `/services/software-development/` | Category Hub | Software Development (Custom ERP, Odoo ERP, Web, Mobile, iOS/Android) | 1,200–1,800 | `https://www.weneurafuturetech.com/services/software-development/` |
| `/services/hardware-automation/` | Category Hub | Hardware & Automation (Weight Scales, IR Sensors, Thermal, Foundry RTC, Custom) | 1,200–1,800 | `https://www.weneurafuturetech.com/services/hardware-automation/` |
| `/services/computer-vision/` | Category Hub | Computer Vision (High-Speed Cameras, Object Detection, Counting, Visual QA) | 1,200–1,800 | `https://www.weneurafuturetech.com/services/computer-vision/` |
| `/services/ai-development/` | Category Hub | AI Development (Custom AI, Consulting, Manufacturing AI, Automation) | 1,200–1,800 | `https://www.weneurafuturetech.com/services/ai-development/` |
| `/case-studies/` | Case Studies Hub | Real industrial project proofs & measurable ROI | 800–1,500 | `https://www.weneurafuturetech.com/case-studies/` |
| `/blog/` | Blog Hub | Engineering insights, AI in industry, guides | 200–400 | `https://www.weneurafuturetech.com/blog/` |
| `/blog/{4-posts}/` | 4 Migrated Posts | Refreshed legacy articles with author attribution | 1,200–2,500 each | Canonical to `/blog/{slug}/` |
| `/career/` | Careers Page | Open positions, culture, Rajkot technology jobs | 500–900 | `https://www.weneurafuturetech.com/career/` |
| `/contact/` | Contact Page | Inquiry form, map facade, direct phone & WhatsApp | 300–600 | `https://www.weneurafuturetech.com/contact/` |
| `/privacy-policy/` & `/terms/` | Legal Pages | DPDP Act compliant templates | Standard | Self-referencing |
| `/thank-you/` | Conversion Page | Confirmation & conversion trigger (`noindex`) | Short | Self-referencing |
| `/404.html` | Error Page | Helpful recovery links, 404 HTTP status | Short | N/A |

---

## 3. Exists / Missing / Action Matrix

| Asset / Feature | Current State | Required Action for Build |
| :--- | :--- | :--- |
| `robots.txt` | Missing | Create with allowed AI crawlers (GPTBot, ClaudeBot, etc.) + sitemap directive |
| `sitemap.xml` | Missing | Generate pure 200 URLs with accurate `<lastmod>` dates |
| `llms.txt` | Missing | Create structured AI overview with positioning sentence and key links |
| `.htaccess` | Missing | Create 1-hop HTTPS+WWW canonicalization + 301 redirects + 410 for courses |
| GSC Meta Tag | Saved from v1 | Add `<meta name="google-site-verification" content="BSDnOxG5C8oU9K22MvHCkXM4shrrOSaL1MuhDNS8yF4">` to `index.html` |
| GA4 Setup | Saved from v1 | Embed `G-ZELBR96617` via lightweight script with Consent Mode |
| OpenGraph / Twitter Cards | Missing | Build custom 1200x630 JPG cards for all launch pages |
| Favicons & Manifest | Missing | Generate SVG, ICO, Apple touch icons, and `site.webmanifest` |
| JSON-LD Schema | Missing | Implement `@graph` schemas (Organization, Person, Service, FAQPage, BreadcrumbList) |

---

## 4. Remediation Plan for Old-Site Issues (PDF Table B2)

1. **NAP Consistency:** Strictly use:
   * **Name:** Weneura Futuretech Private Limited
   * **Address:** RK Trade Tower, 150 Ring Road, Rajkot, Gujarat, India
   * **Phone:** `+91 83202 68596`
   * **Email:** `info@weneurafuturetech.com`
   * *Zero occurrences of the old Noida address or old 93280 phone number.*
2. **Old Brand Removal:** Completely purge "Weneura Technologies" and `weneuratechnologies.com` from copy, schema, alt text, and comments.
3. **Valid JSON-LD Schema:** Clean, validated `@graph` per page without trailing commas or broken syntax.
4. **URL Typos Fixed:** Clean hyphenated URLs (replacing `cloud mordanization.html`, `applied ai.html`, etc.) mapped via 301 redirects.
5. **No AdSense:** Zero `adsbygoogle` scripts, meta tags, or `ads.txt`.
6. **No Preloader Spinners / Heavy Animations:** Immediate first paint without preloader overlays or typing animation delays on H1 headings.

---

## 5. Performance Budget (Simulated Mobile Slow 4G)

* **First Load Weight:** $\le$ 900 KB for Home ($\le$ 1.2 MB for Service Pages).
* **JavaScript:** $\le$ 100 KB total (gzip).
* **CSS:** $\le$ 40 KB total (gzip), with inlined critical CSS ($\le$ 14 KB).
* **Largest Contentful Paint (LCP):** $\le$ 2.0s.
* **Cumulative Layout Shift (CLS):** $\le$ 0.05.
* **Total Blocking Time (TBT):** $\le$ 150ms.
* **Target Mobile Lighthouse Score:** $\ge$ 90.

---

## 6. Leftover / Blacklist Verification

Ran a check across the workspace repository for banned strings:
* `weneuratechnologies`: 0 matches
* `Weneura Technologies`: 0 matches
* `Noida` / `D-29`: 0 matches
* `93280`: 0 matches
* `adsbygoogle` / `ca-pub-`: 0 matches
* `Maldives` / `lorem`: 0 matches
* Result: **100% CLEAN** (workspace is fresh).

---

## 7. Open Questions / Items for Siddharth
Before content authoring in Stage 4, the following details from Section 8 of the summary pack will be required:
1. Exact office unit/suite number and PIN code for RK Trade Tower, Rajkot.
2. Official Corporate Identification Number (CIN) and date of founding.
3. Active social profile links (LinkedIn, X, YouTube, etc.).
4. Real photos/specifications for the top priority services (e.g. robotic welding cells, vision inspection setups).
5. Two verified client case study summaries with measurable metrics.

---

### **Stage 1 Status:** COMPLETE
⛔ **Antigravity Protocol:** Stage 1 audit report is finalized and saved at `docs/seo/01_AUDIT_REPORT.md`.  
**Awaiting your approval before proceeding to Stage 2 (Planning: URL map, redirects.csv, keyword-map.csv, and content tiers).**

