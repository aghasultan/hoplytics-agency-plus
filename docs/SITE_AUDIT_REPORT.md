# Hoplytics.com — Comprehensive Site Audit Report

**Date:** February 11, 2026  
**Auditor:** Antigravity AI  
**Domain:** [hoplytics.com](https://hoplytics.com)  
**Tech Stack:** WordPress + Elementor (classic, non-FSE)  
**Theme:** Flavor / flavor-developer (custom child theme)  

---

## Table of Contents

1. [Executive Summary](#1-executive-summary)
2. [Page-by-Page Audit](#2-page-by-page-audit)
3. [WordPress Content Inventory](#3-wordpress-content-inventory)
4. [Cross-Cutting Issues](#4-cross-cutting-issues)
5. [Prioritised Epics](#5-prioritised-epics)

---

## 1. Executive Summary

The live hoplytics.com website is a **WordPress + Elementor** marketing site for a digital marketing agency. While the homepage and individual service pages (SMM, SEM, SEO, Content Marketing) are broadly functional, the site suffers from several **critical and high-severity issues** that undermine credibility and user experience:

| Severity | Count | Summary |
|----------|-------|---------|
| 🔴 Critical | 3 | Two 404 pages linked from navigation; one completely empty page |
| 🟠 High | 4 | Outdated 2021 blog content; placeholder case-studies page; sample/test posts visible; services hub doesn't link to actual service pages |
| 🟡 Medium | 5 | Missing About/Team page; no free tools functionality; stats may be outdated; homepage relies on Elementor's visual editing with no block-based fallback; no blog pagination |
| 🔵 Low | 3 | SEO metadata gaps; no dark mode or modern UI enhancements; accessibility concerns |

**Overall health score: 4/10** — The site is online but presents a poor impression to prospective clients due to broken pages, stale content, and missing core sections.

---

## 2. Page-by-Page Audit

### 2.1 Homepage — `https://hoplytics.com/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| Template | Elementor (WP Page ID: 28) |
| Last Modified | April 25, 2021 |

**Content Inventory:**
- Hero section: "Digital Marketing Simplified" with CTA → Get Started
- "HOW IT WORKS" (3-step: Discover → Devise → Deploy)
- "OUR SERVICES" — 4 service cards linking to individual service pages:
  - Social Media Marketing → `/social-media-marketing/`
  - Content Marketing → `/content-marketing-services/`
  - Search Engine Marketing → `/search-engine-marketing/`
  - Search Engine Optimization → `/search-engine-optimization/`
- "UNLOCK BUSINESS POTENTIAL WITH DIGITAL MARKETING" — value proposition
- "WHAT YOU GET" — 3 benefit cards with CTAs
- "LATEST INSIGHTS" — pulls 3 most recent blog posts (all from Feb 2021)
- "Let us Give your Sales a Boost" — CTA section with contact form

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| H-1 | **Stale "Latest Insights" section** — All 3 blog posts are from February 2021, making the site appear abandoned | 🟠 High |
| H-2 | Page last modified in April 2021 — nearly 5 years ago | 🟡 Medium |
| H-3 | Service cards link to individual pages but the nav "Services" link goes to the **empty** `/services/` page | 🟠 High |
| H-4 | Hero stats counters (if any) may show outdated figures | 🟡 Medium |

---

### 2.2 Services Hub — `https://hoplytics.com/services/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| Template | Default WordPress page template |
| WP Page ID | 181 |
| Last Modified | December 20, 2020 |

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| S-1 | **Page is completely EMPTY** — rendered content is literally `""`. Only the header "Services" from the page title is shown | 🔴 Critical |
| S-2 | This page is linked from the main navigation menu, leading visitors to a blank page | 🔴 Critical |
| S-3 | No links to the 4 actual service pages (SMM, SEM, SEO, Content Marketing) | 🟠 High |

---

### 2.3 Free Tools — `https://hoplytics.com/free-tools/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ❌ 404 Not Found |
| Template | WordPress default 404 |

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| F-1 | **Page returns 404** — WordPress default "page not found" error | 🔴 Critical |
| F-2 | "Free Tools" is linked from the main navigation menu, leading to a broken experience | 🔴 Critical |
| F-3 | No page exists in WordPress for this slug — the feature was never built | 🟠 High |

---

### 2.4 About — `https://hoplytics.com/about/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ❌ 404 Not Found |
| Template | WordPress default 404 |

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| A-1 | **Page returns 404** — no About page exists | 🔴 Critical |
| A-2 | An About page is standard for any business website; its absence hurts trust | 🟠 High |
| A-3 | May or may not be linked from the navigation (needs footer/nav check) | 🟡 Medium |

---

### 2.5 Get Started (Contact) — `https://hoplytics.com/get-started/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| Template | Default WordPress page template |
| WP Page ID | 8 |
| Title | "Lets Connect" |
| Last Modified | April 25, 2021 |

**Content Inventory:**
- "How Can We Help?" headline
- Side-by-side layout: Contact form (left) + text content (right)
- Sub-sections: "Book an Online Consultation?" and "Book a Demo?"

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| G-1 | Typo in page title: "Lets Connect" should be "Let's Connect" | 🔵 Low |
| G-2 | Form functionality needs verification — is it connected to email/CRM? | 🟡 Medium |
| G-3 | Page references "form given on your left" — may be incorrect on mobile | 🟡 Medium |

---

### 2.6 Case Studies — `https://hoplytics.com/case-studies/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| Content | "Coming soon" placeholder |

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| C-1 | **Placeholder page** — "Coming soon" for nearly 5 years | 🟠 High |
| C-2 | Linked from navigation, setting unmet expectations | 🟠 High |
| C-3 | No case study content exists anywhere on the site | 🟡 Medium |

---

### 2.7 Social Media Marketing — `https://hoplytics.com/social-media-marketing/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| WP Page ID | 7 |
| Last Modified | March 7, 2021 |

**Content Inventory:**
- Hero: "Social Media Marketing" + description + CTA
- "WHY SOCIAL MEDIA MARKETING?" section
- "WHAT WE OFFER" — 6 items (Social Media Setup, Customized Posts, Content Creation, Post Boosting, Ad Management, Monthly Reports)
- "WHY GET OUR SERVICES" — 5 benefit cards
- "LET US BUILD YOU AN ONLINE PRESENCE" — CTA + contact form

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| SM-1 | Page not linked from the `/services/` hub (which is empty) | 🟠 High |
| SM-2 | Content unchanged since March 2021 | 🟡 Medium |

---

### 2.8 Search Engine Marketing — `https://hoplytics.com/search-engine-marketing/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| WP Page ID | 303 |
| Last Modified | March 7, 2021 |

**Content Inventory:**
- Hero: "Search Engine Marketing" + description + CTA
- "WHY SEARCH ENGINE MARKETING?" section
- "WHAT WE OFFER" — 6 items (Traffic, Brand Awareness, Lead Gen, App Promotion, Consideration, Remarketing)
- "WHY GET OUR SERVICES" — 4 benefit cards
- "LATEST INSIGHTS" — same 3 stale blog posts
- "LET US HELP YOU REACH A GLOBAL AUDIENCE" — CTA

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| SEM-1 | "LATEST INSIGHTS" section shows 2021 content | 🟡 Medium |
| SEM-2 | Content unchanged since March 2021 | 🟡 Medium |

---

### 2.9 Search Engine Optimization — `https://hoplytics.com/search-engine-optimization/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| WP Page ID | 6 |
| Last Modified | March 7, 2021 |

**Content Inventory:**
- Hero: "Search Engine Optimization" + description + CTA
- "WHY SEO?" section
- "WHAT WE OFFER" — 11 items (Site Audit, Backlink Analysis, Link Building, Keyword Research, Image Optimization, Meta Tags, Content Creation, GA Reports, GSC Optimization, Page Speed, Customized SEO)
- "OUR SEO PROCESS" — 5 steps (Understanding Goals → Website Analysis → Strategy Development → Execution → Impact Analysis)
- "WHY GET OUR SERVICES" — 4 benefit cards
- "GET A FREE SEO AUDIT" — CTA + contact form

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| SEO-1 | "GET A FREE SEO AUDIT" CTA needs verification — does the backend support this? | 🟡 Medium |
| SEO-2 | Content unchanged since March 2021 | 🟡 Medium |

---

### 2.10 Content Marketing Services — `https://hoplytics.com/content-marketing-services/`

| Attribute | Status |
|-----------|--------|
| HTTP Status | ✅ 200 OK |
| WP Page ID | 2 |
| Last Modified | June 8, 2021 |

**Content Inventory:**
- Hero: "Content Marketing" + description + CTA
- "WHY CONTENT MARKETING?" section
- "WHAT WE OFFER" — 5 items (Strategy, Distribution, Content Gen, Optimization, Reporting)
- "WHY GET OUR SERVICES" — 5 benefit cards
- "LET US WRITE COMPELLING CONTENT FOR YOU" — CTA + contact form

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| CM-1 | Content unchanged since June 2021 | 🟡 Medium |

---

### 2.11 Blog / Insights Page — `https://hoplytics.com/insights/` (or embedded in pages)

| Attribute | Status |
|-----------|--------|
| WP Page ID | 1349 |
| Template | `elementor_header_footer` |

**Blog Posts Inventory (from WP REST API):**

| # | Title | Date | Category | Status |
|---|-------|------|----------|--------|
| 1 | 5 Key Metrics to Measure Google Ads Performance | Feb 27, 2021 | Articles | ✅ Published |
| 2 | 5 SEO Tips to Dominate Search Engines in 2021 | Feb 26, 2021 | SEO | ✅ Published |
| 3 | 6 Tips for Running Successful Facebook Ads | Feb 23, 2021 | Articles | ✅ Published |
| 4 | Sample Post 3 | Dec 20, 2020 | Uncategorized | ⚠️ **Test content** |
| 5 | Sample post 2 | Dec 20, 2020 | Uncategorized | ⚠️ **Test content** |

**Issues Found:**
| # | Issue | Severity |
|---|-------|----------|
| B-1 | **Sample/test posts still published** — "Sample Post 3" and "Sample post 2" are live and visible | 🟠 High |
| B-2 | All legitimate articles are from February 2021 — site appears abandoned | 🟠 High |
| B-3 | Blog titles reference "2021" — feels severely outdated in 2026 | 🟡 Medium |
| B-4 | Only 3 real articles exist — very thin content library | 🟡 Medium |
| B-5 | No blog index/archive page with pagination | 🟡 Medium |

---

## 3. WordPress Content Inventory

### 3.1 Published Pages (8 total)

| ID | Slug | Title | Has Content? | Template |
|----|------|-------|-------------|----------|
| 28 | `home` | Home | ✅ Yes | Default + Elementor |
| 2 | `content-marketing-services` | Content Marketing Services | ✅ Yes | Default |
| 6 | `search-engine-optimization` | Search Engine Optimization | ✅ Yes | Default |
| 7 | `social-media-marketing` | Social Media Marketing | ✅ Yes | Default |
| 8 | `get-started` | Lets Connect | ✅ Yes | Default |
| 181 | `services` | Services | ❌ **EMPTY** | Default |
| 303 | `search-engine-marketing` | Search Engine Marketing | ✅ Yes | Default |
| 1349 | (insights) | Insights (Blog) | ✅ Yes | `elementor_header_footer` |

### 3.2 Missing Pages (exist in navigation but not in WordPress)

| Expected Slug | Status | Notes |
|---------------|--------|-------|
| `free-tools` | ❌ 404 | No WP page exists |
| `about` | ❌ 404 | No WP page exists |
| `case-studies` | ⚠️ Placeholder | "Coming soon" since ~2020 |

### 3.3 Published Posts (5 total — 3 real + 2 test)

| ID | Title | Date | Real Content? |
|----|-------|------|--------------|
| 1584 | 5 Key Metrics to Measure Google Ads Performance | 2021-02-27 | ✅ Yes |
| 1518 | 5 SEO Tips to Dominate Search Engines in 2021 | 2021-02-26 | ✅ Yes |
| 1402 | 6 Tips for Running Successful Facebook Ads | 2021-02-23 | ✅ Yes |
| — | Sample Post 3 | 2020-12-20 | ❌ Test data |
| — | Sample post 2 | 2020-12-20 | ❌ Test data |

---

## 4. Cross-Cutting Issues

### 4.1 Navigation & Information Architecture

| # | Issue | Severity |
|---|-------|----------|
| NAV-1 | Main navigation links to 2 broken pages (Free Tools, About) and 1 empty page (Services) | 🔴 Critical |
| NAV-2 | The `/services/` page is empty but individual service pages exist — massive disconnect | 🔴 Critical |
| NAV-3 | No clear path from Services hub → individual service pages | 🟠 High |

### 4.2 Content Freshness

| # | Issue | Severity |
|---|-------|----------|
| CF-1 | Newest content on the entire site is from **June 2021** — nearly 5 years old | 🟠 High |
| CF-2 | Blog references "2021" trends that are no longer relevant | 🟡 Medium |
| CF-3 | No content update strategy or publishing cadence apparent | 🟡 Medium |

### 4.3 SEO & Technical

| # | Issue | Severity |
|---|-------|----------|
| T-1 | 404 pages use WordPress default error template — no custom 404 page | 🟡 Medium |
| T-2 | Potential missing meta descriptions on several pages | 🟡 Medium |
| T-3 | No structured data (Schema.org) detected | 🟡 Medium |
| T-4 | No sitemap.xml verification performed | 🔵 Low |
| T-5 | Sample posts may be indexed by search engines | 🟡 Medium |

### 4.4 UI/UX Design

| # | Issue | Severity |
|---|-------|----------|
| UX-1 | Site heavily dependent on Elementor — no native block editor fallback | 🟡 Medium |
| UX-2 | No dark mode support | 🔵 Low |
| UX-3 | Mobile responsiveness needs field testing (form references "left side") | 🟡 Medium |
| UX-4 | No loading animations or micro-interactions — feels static | 🔵 Low |
| UX-5 | Contact forms embedded via Elementor — backend connectivity unverified | 🟡 Medium |

---

## 5. Prioritised Epics

Below are recommended epics to address all identified issues, prioritised by business impact.

---

### 🔴 Epic 1: Fix Critical Broken Pages (Priority: P0 — Immediate)

**Goal:** Eliminate all 404 errors and empty pages reachable from the main navigation.

| Story | Description | Effort |
|-------|-------------|--------|
| 1.1 | **Populate `/services/` page** — Add content to the Services hub page linking to all 4 service pages (SMM, SEM, SEO, Content Marketing) with descriptions and CTAs | M |
| 1.2 | **Create `/about/` page** — Build an About Us page with company story, team info, mission/values, and trust signals | M |
| 1.3 | **Resolve `/free-tools/` 404** — Either create a Free Tools page with at least 1 working tool (e.g., SEO audit checker), or remove the link from navigation until tools are ready | S |
| 1.4 | **Update navigation menu** — Ensure all nav links point to working, content-filled pages | S |

**Acceptance Criteria:**
- Zero 404 errors from any navigation link
- All pages have meaningful content
- Services hub links to all 4 individual service pages

---

### 🟠 Epic 2: Content Cleanup & Freshness (Priority: P1 — This Sprint)

**Goal:** Remove test content, update outdated references, and restore content credibility.

| Story | Description | Effort |
|-------|-------------|--------|
| 2.1 | **Delete sample/test posts** — Remove "Sample Post 2" and "Sample Post 3" from WordPress | XS |
| 2.2 | **Update or archive 2021 blog posts** — Edit titles to remove year references (e.g., "5 SEO Tips to Dominate Search Engines" instead of "...in 2021"). Update content to be evergreen or add a [Updated 2026] note | S |
| 2.3 | **Update `/case-studies/` page** — Either add real case study content or change to a CTA page (e.g., "Want to see results? Contact us for case studies") instead of "Coming soon" | S |
| 2.4 | **Fix Get Started page typo** — Change "Lets Connect" → "Let's Connect" | XS |
| 2.5 | **Review and update homepage copy** — Refresh stats, testimonials, and any time-sensitive claims | M |

**Acceptance Criteria:**
- No test/sample content visible to the public
- No content explicitly referencing "2021" as current
- Case Studies page provides value or clear next step

---

### 🟡 Epic 3: SEO & Technical Foundations (Priority: P2 — Next Sprint)

**Goal:** Establish proper SEO foundation and technical best practices.

| Story | Description | Effort |
|-------|-------------|--------|
| 3.1 | **Create custom 404 page** — Design a branded 404 page with navigation, search, and helpful links | S |
| 3.2 | **Add meta descriptions** to all pages — Ensure every page has unique, keyword-optimized meta descriptions | S |
| 3.3 | **Add Schema.org structured data** — LocalBusiness, Organization, Service, and BlogPosting schemas | M |
| 3.4 | **Verify and submit sitemap.xml** — Ensure sitemap is generated, correct, and submitted to Google Search Console | S |
| 3.5 | **De-index sample posts** — If not deleted, add noindex tags to prevent search engine indexing of test content | XS |
| 3.6 | **Verify contact form functionality** — Test all embedded contact forms end-to-end (submission → email notification) | S |

**Acceptance Criteria:**
- Custom 404 page deployed
- All pages have unique meta descriptions
- Sitemap submitted to GSC
- All contact forms confirmed working

---

### 🔵 Epic 4: Free Tools Suite (Priority: P3 — Future Sprint)

**Goal:** Build the Free Tools section referenced in navigation to drive organic traffic and leads.

| Story | Description | Effort |
|-------|-------------|--------|
| 4.1 | **Create Free Tools landing page** — Hub page listing available tools with descriptions | S |
| 4.2 | **Build SEO Audit Tool** — A simple website analyzer that checks on-page SEO factors (meta tags, headings, image alt text, page speed) | L |
| 4.3 | **Build Social Media Post Preview Tool** — Let users preview how their posts will look on Facebook, Instagram, LinkedIn | L |
| 4.4 | **Build UTM Builder Tool** — Campaign URL builder with copy-to-clipboard functionality | M |
| 4.5 | **Add lead capture gates** — Require email to access full results, feeding into CRM | S |

**Acceptance Criteria:**
- `/free-tools/` page is live with at least 2 working tools
- Tools generate leads via email capture
- Tools are fast, mobile-friendly, and branded

---

### 🔵 Epic 5: UI/UX Modernisation (Priority: P3 — Future Sprint)

**Goal:** Modernise the visual design and improve user experience across the site.

| Story | Description | Effort |
|-------|-------------|--------|
| 5.1 | **Mobile responsiveness audit** — Fix all mobile layout issues (especially "form on your left" references) | M |
| 5.2 | **Add micro-animations** — Loading states, hover effects, scroll-triggered animations | M |
| 5.3 | **Implement dark mode** — User-toggleable dark theme | L |
| 5.4 | **Redesign Services page** — Modern card layout with hover effects, icons, and clear CTAs | M |
| 5.5 | **Add blog archive/pagination** — Build a proper blog index page with categories and pagination | S |

**Acceptance Criteria:**
- Site scores 90+ on Google Lighthouse mobile
- Smooth micro-animations enhance UX without hurting performance
- Blog has a proper browsable archive

---

### 🔵 Epic 6: Content Strategy & Publishing (Priority: P4 — Ongoing)

**Goal:** Establish a content pipeline to keep the site fresh and drive organic growth.

| Story | Description | Effort |
|-------|-------------|--------|
| 6.1 | **Publish 3 new evergreen articles** — Topics aligned with service offerings (SMM trends, SEO best practices, PPC optimization) | L |
| 6.2 | **Create case study content** — At least 2 real or representative case studies with metrics | M |
| 6.3 | **Set up an editorial calendar** — Monthly publishing schedule with assigned topics | S |
| 6.4 | **Add newsletter signup** — Email capture on blog pages for subscription | M |

---

## Effort Key

| Code | Estimate |
|------|----------|
| XS | < 1 hour |
| S | 1–4 hours |
| M | 4–8 hours (half day to full day) |
| L | 1–3 days |
| XL | 3–5 days |

---

## Summary Action Matrix

| Priority | Epic | Impact | Effort |
|----------|------|--------|--------|
| **P0** | Epic 1: Fix Critical Broken Pages | 🔴 Eliminates 404s and empty pages | Medium |
| **P1** | Epic 2: Content Cleanup & Freshness | 🟠 Removes embarrassing test content and outdated references | Small |
| **P2** | Epic 3: SEO & Technical Foundations | 🟡 Proper search indexing and technical health | Medium |
| **P3** | Epic 4: Free Tools Suite | 🔵 New feature to drive leads | Large |
| **P3** | Epic 5: UI/UX Modernisation | 🔵 Design refresh | Large |
| **P4** | Epic 6: Content Strategy & Publishing | 🔵 Ongoing growth | Ongoing |

---

*This audit was conducted by crawling the live site, inspecting the WordPress REST API, and visually reviewing screenshots of each page. All findings are based on the production state of hoplytics.com as of February 11, 2026.*
