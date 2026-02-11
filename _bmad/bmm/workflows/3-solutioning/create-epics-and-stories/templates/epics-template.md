---
stepsCompleted: []
inputDocuments: [hoplytics_wp.sql, main.css, variables.css, theme.json, functions.php]
---

# Hoplytics v4.0 — Next-Gen Agency Platform — Epic Breakdown

## Overview

This document decomposes the Hoplytics Agency Plus theme into a complete next-generation agency platform. The upgrade covers 3 pillars: (1) **Free Interactive Tools** that generate leads and demonstrate expertise, (2) **SEO-Optimized Content** rewritten from the original Hoplytics.com copy, and (3) **Modern UI/UX Redesign** for a premium, conversion-optimized experience.

**Original Site:** Hoplytics — "Digital Marketing Simplified" (hoplytics.com)
**Target:** Full-featured agency website with free diagnostic tools, interactive calculators, and a modern design system that converts visitors into clients.

---

## Requirements Inventory

### Functional Requirements

- FR-01: Free Website Audit Tool — crawls a user-submitted URL and returns performance, SEO, and accessibility scores
- FR-02: Meta Pixel & GTM Checker — detects Facebook Pixel, Google Tag Manager, GA4, and other tracking scripts on any URL
- FR-03: SEO Score Calculator — real-time on-page SEO analysis (title, meta, headings, images, links)
- FR-04: Page Speed Analyzer — measures Core Web Vitals (LCP, FID, CLS) via PageSpeed Insights API
- FR-05: Social Media Audit — checks brand presence, profile completeness, and posting frequency
- FR-06: Google Ads ROI Calculator — interactive calculator (already exists as block, needs upgrade)
- FR-07: Lead Magnet Generator — gated downloadable reports behind email capture
- FR-08: Contact Form with Smart Routing — routes inquiries to correct department based on service selected
- FR-09: Blog / Insights Hub — filterable, SEO-optimized blog with categories and search
- FR-10: Service Pages — 6 service landing pages with structured data and conversion CTAs
- FR-11: Case Studies / Portfolio — project showcase with results metrics
- FR-12: Testimonial Carousel — dynamic social proof from real clients
- FR-13: Dark Mode Toggle — user-facing theme switcher (already built in Tier 2)
- FR-14: Mobile Navigation — hamburger menu with focus trap (already built in Tier 2)
- FR-15: Pricing Calculator — interactive tool for custom quote generation

### NonFunctional Requirements

- NFR-01: WCAG 2.1 AA compliance across all pages (in progress from Tier 2)
- NFR-02: Core Web Vitals passing (LCP < 2.5s, FID < 100ms, CLS < 0.1)
- NFR-03: SEO — all pages must have unique title, meta description, structured data (JSON-LD)
- NFR-04: Mobile-first responsive design (320px → 2560px)
- NFR-05: PHP 8.2+ and WordPress 6.5+ (already enforced)
- NFR-06: GDPR compliance — cookie consent, privacy policy, data handling
- NFR-07: Page load < 3s on 3G mobile networks
- NFR-08: 95+ Lighthouse score (Performance, Accessibility, Best Practices, SEO)

### Additional Requirements

- AR-01: All free tools must capture email before showing full results (lead generation)
- AR-02: All tool results must be shareable via unique URL
- AR-03: Results data stored in custom post type for admin analytics dashboard
- AR-04: Google reCAPTCHA v3 on all forms to prevent spam
- AR-05: Structured data (JSON-LD) for Organization, LocalBusiness, Service, FAQPage, BreadcrumbList
- AR-06: Open Graph + Twitter Card meta for social sharing
- AR-07: Automated sitemap generation (WordPress native)

### FR Coverage Map

| FR | Epic 1 | Epic 2 | Epic 3 | Epic 4 | Epic 5 | Epic 6 | Epic 7 | Epic 8 |
|----|--------|--------|--------|--------|--------|--------|--------|--------|
| FR-01 | ✅ | | | | | | | |
| FR-02 | ✅ | | | | | | | |
| FR-03 | ✅ | | | | | | | |
| FR-04 | ✅ | | | | | | | |
| FR-05 | ✅ | | | | | | | |
| FR-06 | ✅ | | | | | | | |
| FR-07 | | ✅ | | | | | | |
| FR-08 | | ✅ | | | | | | |
| FR-09 | | | ✅ | | | | | |
| FR-10 | | | | ✅ | | | | |
| FR-11 | | | | ✅ | | | | |
| FR-12 | | | | | ✅ | | | |
| FR-13 | | | | | ✅ | | | |
| FR-14 | | | | | ✅ | | | |
| FR-15 | ✅ | | | | | | | |
| NFR-01–08 | | | | | | ✅ | ✅ | ✅ |

## Epic List

1. **Epic 1: Free Interactive Tools Suite** — Build lead-generating diagnostic tools
2. **Epic 2: Lead Capture & CRM** — Email gating, smart forms, and lead management
3. **Epic 3: SEO-Optimized Content Engine** — Rewrite all copy, blog system, structured data
4. **Epic 4: Service Pages & Portfolio** — 6 high-converting service landing pages + case studies
5. **Epic 5: Modern UI/UX Redesign** — Complete design system overhaul, animations, responsive
6. **Epic 6: Performance & Core Web Vitals** — Sub-3s load, 95+ Lighthouse
7. **Epic 7: SEO Infrastructure** — JSON-LD, Open Graph, sitemap, breadcrumbs
8. **Epic 8: Analytics & Admin Dashboard** — Tool usage tracking, lead analytics

---

## Epic 1: Free Interactive Tools Suite

Build a suite of free diagnostic tools that demonstrate Hoplytics' expertise while capturing leads. Each tool accepts a URL or business data, runs analysis, and returns actionable insights behind an email gate.

### Story 1.1: Website Audit Tool

As a **business owner**,
I want to **enter my website URL and receive a comprehensive audit report**,
So that **I understand what's working and what needs improvement on my site**.

**Acceptance Criteria:**

**Given** a user enters a valid URL in the audit form
**When** they click "Audit My Site"
**Then** the system crawls the URL via a REST API endpoint
**And** returns scores for: Performance (0-100), SEO (0-100), Accessibility (0-100), Mobile-Friendliness (pass/fail)
**And** provides 5-10 actionable recommendations with severity levels (Critical, Warning, Info)
**And** the full report is gated behind an email capture form
**And** the report is saved as a custom post type (`site_audit`) for admin review

**Technical Notes:**
- Use WordPress REST API endpoint `hoplytics/v1/audit`
- Backend uses `wp_remote_get()` to fetch the target URL
- Parse HTML for: `<title>`, `<meta description>`, `<h1>` count, image alt tags, HTTPS check, viewport meta
- Integrate with Google PageSpeed Insights API (free tier: 25K queries/day) for Core Web Vitals
- Store results in `wp_hoplytics_audits` custom table or post meta

---

### Story 1.2: Meta Pixel & Tracking Script Checker

As a **marketer**,
I want to **check if a website has Facebook Pixel, Google Tag Manager, GA4, and other tracking pixels installed**,
So that **I can verify my tracking setup or identify gaps in a prospect's analytics**.

**Acceptance Criteria:**

**Given** a user enters a URL
**When** the checker analyzes the page
**Then** it detects and reports:
  - Facebook/Meta Pixel (fbq script, pixel ID)
  - Google Tag Manager (GTM container ID)
  - Google Analytics 4 (GA4 measurement ID)
  - Google Ads Conversion Tracking
  - LinkedIn Insight Tag
  - TikTok Pixel
  - Hotjar / Microsoft Clarity
  - Custom events detected
**And** shows a pass/fail badge for each tracker
**And** provides setup guides for missing trackers (linking to relevant Hoplytics service pages)

**Technical Notes:**
- REST endpoint `hoplytics/v1/pixel-check`
- Regex patterns to detect each script: `fbq(`, `gtag(`, `gtm.js`, `clarity(`, `hj(`, `ttq.load`
- Response JSON includes: `{detected: [...], missing: [...], recommendations: [...]}`

---

### Story 1.3: SEO Score Calculator

As a **content creator**,
I want to **paste my page URL or content and get a real-time SEO score**,
So that **I can optimize my content before publishing**.

**Acceptance Criteria:**

**Given** a user enters a URL or pastes HTML content
**When** the analyzer runs
**Then** it returns an SEO score (0-100) broken down by:
  - Title tag (exists, length 30-60 chars, contains target keyword)
  - Meta description (exists, length 120-160 chars)
  - H1 tag (exactly one, contains keyword)
  - H2-H6 hierarchy (proper nesting)
  - Image alt attributes (% of images with alt text)
  - Internal/external link ratio
  - Word count (min 300 for pages, 1500+ for blog posts)
  - URL slug (descriptive, hyphenated, no underscores)
  - Mobile viewport meta tag
  - HTTPS enforcement
**And** each factor shows: current value, ideal value, and a pass/warn/fail status
**And** provides a downloadable PDF checklist

---

### Story 1.4: Page Speed Analyzer

As a **website owner**,
I want to **test my page speed and get Core Web Vitals scores**,
So that **I know if my site meets Google's performance requirements**.

**Acceptance Criteria:**

**Given** a user enters a URL
**When** they click "Test Speed"
**Then** the tool calls the Google PageSpeed Insights API
**And** returns: LCP (s), FID (ms), CLS (score), TTFB (ms), Speed Index
**And** shows a visual gauge (green/yellow/red) for each metric
**And** lists the top 5 performance opportunities with estimated time savings
**And** compares results for both mobile and desktop

**Technical Notes:**
- API key stored in WordPress options (admin settings page)
- Free tier: 25,000 queries/day (sufficient for lead gen)
- Cache results for 24 hours per URL to avoid API rate limits

---

### Story 1.5: Social Media Presence Checker

As a **business owner**,
I want to **check if my brand has a presence across major social platforms**,
So that **I can identify gaps in my social media strategy**.

**Acceptance Criteria:**

**Given** a user enters their brand/business name
**When** the checker runs
**Then** it searches for matching profiles on: Facebook, Instagram, LinkedIn, Twitter/X, TikTok, YouTube, Pinterest
**And** reports: Found/Not Found for each platform
**And** for found profiles: last post date (if public), follower count estimate, profile completeness score
**And** provides recommendations for platforms without a presence

**Technical Notes:**
- Uses OpenGraph/meta tag scraping of social platform profile pages
- Fallback: link-based detection from the company's website (social links in footer/header)

---

### Story 1.6: Google Ads ROI Calculator (Upgrade)

As a **marketing manager**,
I want to **model my Google Ads ROI with different budget scenarios**,
So that **I can justify ad spend to stakeholders**.

**Acceptance Criteria:**

**Given** the existing ROI Calculator block (Interactivity API)
**When** upgraded
**Then** it includes: Monthly Budget, Expected CPC, Conversion Rate, Average Deal Value, Close Rate
**And** calculates: Estimated Clicks, Estimated Leads, Estimated Revenue, ROI Percentage, Cost per Acquisition
**And** shows a comparison table for 3 budget scenarios (Conservative, Moderate, Aggressive)
**And** includes a "Get Custom Analysis" CTA that routes to the contact form

---

### Story 1.7: Pricing Estimator

As a **potential client**,
I want to **get an instant cost estimate for digital marketing services**,
So that **I can budget appropriately before scheduling a call**.

**Acceptance Criteria:**

**Given** a user selects services (SEO, PPC, Social, Content, Web Dev)
**When** they adjust parameters (business size, industry, goals)
**Then** the estimator shows a monthly price range
**And** sends the estimate via email with a "Schedule a Call" CTA
**And** stores the estimate data for sales team follow-up

---

## Epic 2: Lead Capture & CRM

Convert free tool users into qualified leads through strategic email gating, smart forms, and CRM integration.

### Story 2.1: Email Gate Component

As a **marketer (Hoplytics)**,
I want to **require an email before showing full tool results**,
So that **every free tool generates a lead for our sales pipeline**.

**Acceptance Criteria:**

**Given** a user completes a free tool analysis
**When** the results are ready
**Then** a preview (3-5 items) is shown immediately
**And** the full report is behind an email gate overlay
**And** the user enters: Name, Email, Company (optional), Phone (optional)
**And** after submission, the full report unlocks
**And** the lead is stored as a `lead` custom post type with source tool metadata
**And** a notification email is sent to the sales team

---

### Story 2.2: Smart Contact Form

As a **site visitor**,
I want to **fill out a contact form that routes to the right team**,
So that **my inquiry is handled by the right person quickly**.

**Acceptance Criteria:**

**Given** the existing REST API `/lead` endpoint
**When** enhanced with smart routing
**Then** the form includes: Name, Email, Phone, Service Interest (dropdown), Budget Range, Message
**And** submissions are routed: SEO → SEO team, PPC → Ads team, General → Admin
**And** auto-responder email sent to the visitor with next steps
**And** Slack/email notification to the assigned team member

---

### Story 2.3: Lead Magnet Downloads

As a **content team**,
I want to **offer downloadable resources (PDFs, templates, checklists)**,
So that **visitors exchange their email for valuable content**.

**Acceptance Criteria:**

**Given** admin uploads a lead magnet (PDF) via WordPress media library
**When** tagged with the `lead_magnet` taxonomy
**Then** a download CTA block is available in the block editor
**And** the download link is gated behind email capture
**And** download count is tracked per resource
**And** follow-up email sequence is triggered (via hook for external ESP integration)

---

## Epic 3: SEO-Optimized Content Engine

Rewrite all website copy from the original Hoplytics.com, optimized for search engines and conversions.

### Story 3.1: Homepage Content

As a **first-time visitor**,
I want to **immediately understand what Hoplytics does and why I should care**,
So that **I stay on the site and explore services**.

**Acceptance Criteria:**

**Original Copy (from backup):**
> "Cutting-Edge Marketing And Branding Solutions That Help Businesses"
> "Hoplytics is a digital marketing services provider that understands the importance of maintaining a strong brand presence in the ever-evolving digital world."

**Rewritten SEO-Optimized Copy:**

**Hero Section:**
- H1: "Data-Driven Digital Marketing That Actually Grows Revenue"
- Subheadline: "We help ambitious brands turn clicks into customers with performance marketing, SEO, and conversion-focused web development."
- Primary CTA: "Get Your Free Website Audit" (links to free audit tool)
- Secondary CTA: "See Our Results" (links to case studies)
- Social proof bar: "Trusted by 140+ brands | 8.2x Average ROI | $12M+ Revenue Generated"

**Services Preview Section:**
- Section H2: "Marketing Services Built for Growth"
- 6 service cards linking to individual service pages

**Free Tools Section:**
- Section H2: "Free Marketing Diagnostics — No Strings Attached"
- Grid of 5 free tools with icons and brief descriptions
- Subtext: "We publish free tools because we believe in earning trust before earning business."

**Social Proof Section:**
- Testimonial carousel (3-5 client quotes)
- Logo cloud of client brands
- Stats row: Clients Served, Revenue Generated, Avg ROI, Years Experience

**CTA Section:**
- H2: "Ready to Stop Guessing and Start Growing?"
- Subtext: "Book a free 30-minute strategy session. No pitch deck, just real answers."
- CTA: "Book Your Free Session"

---

### Story 3.2: SEO Service Page

**Original Copy:**
> "Build a rock-solid SEO base that helps your business grow. Hoplytics provides customized Search Engine Optimization strategies fine-tuned to your business needs."

**Rewritten SEO-Optimized Copy:**

- **URL:** `/services/search-engine-optimization`
- **Title Tag:** "SEO Services | Organic Growth & Rankings | Hoplytics"
- **Meta Description:** "Drive sustainable organic traffic with Hoplytics SEO services. Technical audits, keyword strategy, link building, and content optimization — all backed by data."
- **H1:** "SEO Services That Drive Measurable Organic Growth"
- **Services Grid:**
  - Complete Technical SEO Audit
  - Competitor & Keyword Research
  - On-Page Optimization (Title, Meta, Headers, Schema)
  - Link Building & Digital PR
  - Content Strategy & Creation
  - Local SEO & Google Business Profile
  - Monthly Analytics & Reporting
  - Core Web Vitals Optimization
- **Process Section:** "How Our SEO Process Works" (4-step visual: Audit → Strategy → Execute → Report)
- **FAQ Section (FAQPage schema):** 6-8 common SEO questions with answers
- **CTA:** "Get Your Free SEO Audit" (links to free tool)

---

### Story 3.3: Content Marketing Service Page

**Original Copy:**
> "Share engaging content that attracts traffic to your website from various online channels."
> "Content marketing is the best way to organically increase traffic on your website."

**Rewritten SEO-Optimized Copy:**

- **URL:** `/services/content-marketing`
- **Title Tag:** "Content Marketing Services | Strategy & Creation | Hoplytics"
- **Meta Description:** "Convert readers into revenue. Our content marketing services combine strategy, SEO-optimized writing, and distribution to grow your organic pipeline."
- **H1:** "Content Marketing That Converts Readers Into Revenue"
- **Services Grid (from original, upgraded):**
  - Content Strategy Development
  - Blog & Article Writing (SEO-Optimized)
  - Content Distribution & Amplification
  - Email Newsletter Management
  - Social Content Creation
  - Content Performance Analytics
- **CTA:** "Get a Custom Content Strategy"

---

### Story 3.4: Social Media Marketing Service Page

**Original Copy:**
> Social Media Setup, Customized Social Media Posts, Content Creation & Execution, Post Boosting & Management, Ad Creation & Management, Monthly Social Media Reports

**Rewritten SEO-Optimized Copy:**

- **URL:** `/services/social-media-marketing`
- **Title Tag:** "Social Media Marketing | Strategy & Management | Hoplytics"
- **Meta Description:** "Build a loyal audience and drive conversions with our social media marketing services. Strategy, content, paid ads, and monthly reporting across all platforms."
- **H1:** "Social Media Marketing That Builds Brands & Drives Sales"
- **Services Grid:** Profile Setup & Optimization, Content Calendar & Creation, Community Management, Paid Social Advertising (Meta, TikTok, LinkedIn), Influencer Collaboration, Analytics & Monthly Reports
- **CTA:** "Get a Free Social Media Audit"

---

### Story 3.5: PPC / Search Engine Marketing Service Page

- **URL:** `/services/paid-advertising`
- **Title Tag:** "PPC & Paid Advertising | Google Ads & Meta Ads | Hoplytics"
- **Meta Description:** "Stop wasting ad spend. Our PPC management delivers qualified leads at scale with Google Ads, Meta Ads, and LinkedIn Ads — tracked down to every dollar."
- **H1:** "Paid Advertising That Delivers Real, Trackable ROI"
- **CTA:** "Calculate Your Ad ROI" (links to ROI calculator)

---

### Story 3.6: Web Development Service Page

- **URL:** `/services/web-development`
- **Title Tag:** "Web Development | High-Performance WordPress Sites | Hoplytics"
- **Meta Description:** "Custom WordPress websites built for speed, SEO, and conversions. Block editor native, mobile-first, and optimized for Core Web Vitals."
- **H1:** "Web Development That's Built for Speed and Conversions"
- **CTA:** "Get a Free Website Audit"

---

### Story 3.7: Marketing Automation Service Page

- **URL:** `/services/marketing-automation`
- **Title Tag:** "Marketing Automation | HubSpot, n8n & Custom Workflows | Hoplytics"
- **Meta Description:** "Automate your marketing pipeline. From email sequences to lead scoring, we build systems that nurture prospects while you focus on closing."
- **H1:** "Marketing Automation That Works While You Sleep"
- **CTA:** "Book an Automation Consultation"

---

### Story 3.8: Blog & Insights Hub

As a **content consumer**,
I want to **browse, search, and filter blog posts by topic**,
So that **I can find relevant marketing insights quickly**.

**Acceptance Criteria:**

**Given** the existing Insights/blog page
**When** redesigned
**Then** posts are filterable by category (SEO, PPC, Social, Content, Analytics)
**And** each post has: estimated reading time, publication date, author bio, share buttons
**And** related posts section at the bottom
**And** Category archive pages with custom hero and SEO descriptions
**And** all posts use ArticleSchema JSON-LD

**Seed Blog Posts (expanded from existing):**
1. "6 Tips for Running Successful Facebook Ads in 2026" (rewrite)
2. "5 SEO Tips to Dominate Search Engines" (rewrite)
3. "5 Key Metrics to Measure Google Ads Performance" (rewrite)
4. "How to Check If Your Facebook Pixel Is Working" (NEW — ties to free tool)
5. "Website Audit Checklist: 25 Things to Fix Today" (NEW — ties to free tool)
6. "Core Web Vitals Explained: What Every Business Owner Needs to Know" (NEW)
7. "Content Marketing vs. Paid Ads: Which Is Right for Your Business?" (NEW)
8. "The Ultimate Guide to Google Tag Manager Setup" (NEW — ties to free tool)

---

## Epic 4: Service Pages & Portfolio

### Story 4.1: Case Studies Section

As a **potential client**,
I want to **see real results from past Hoplytics projects**,
So that **I have confidence in their ability to deliver**.

**Acceptance Criteria:**

**Given** the existing `project` CPT
**When** redesigned as case studies
**Then** each case study includes: Client Name, Industry, Challenge, Solution, Results (metrics), Testimonial
**And** results are displayed as stat cards (e.g., "+340% Conversions", "8.2x ROI")
**And** tagged by service type for filtering
**And** uses CaseStudy JSON-LD schema

---

### Story 4.2: Testimonials System

As a **visitor**,
I want to **see authenticated client reviews**,
So that **I trust Hoplytics' capabilities**.

**Acceptance Criteria:**

**Given** the existing `testimonial` CPT
**When** upgraded
**Then** testimonials display: avatar, name, company, role, star rating, quote
**And** appear as an animated carousel on the homepage and service pages
**And** includes an admin interface for managing testimonials
**And** uses Review JSON-LD schema

---

## Epic 5: Modern UI/UX Redesign

Complete visual overhaul of the theme for a premium, conversion-optimized experience.

### Story 5.1: Design System Overhaul

As a **designer**,
I want to **establish a cohesive design system**,
So that **all pages look and feel premium and consistent**.

**Acceptance Criteria:**

- **Typography:** Inter (body), Space Grotesk (headings), monospace for code/data
- **Color Palette:**
  - Dark mode (default): Deep navy (#0B0F19) background, electric blue (#3B82F6) primary, neon green (#10B981) accent
  - Light mode: Clean white (#FFFFFF) background, navy (#0F172A) primary
- **Spacing Scale:** 4px base unit (4, 8, 12, 16, 24, 32, 48, 64, 96, 128)
- **Border Radius:** Sharp (2px) for tech-futurist, rounded (12px) for corporate
- **Shadows:** 5-tier elevation system (sm, md, lg, xl, 2xl)
- **Grid:** 12-column CSS Grid + Flexbox hybrid, max-width 1280px
- **Breakpoints:** 320px (mobile), 640px (sm), 768px (md), 1024px (lg), 1280px (xl), 1536px (2xl)

---

### Story 5.2: Hero Section Redesign

As a **visitor**,
I want to **be instantly engaged by a visually stunning hero**,
So that **I stay on the site and explore**.

**Acceptance Criteria:**

- Animated gradient background with subtle particle/mesh effect
- Bold H1 with gradient text (primary → secondary)
- Typing animation for tagline variants: "...that grows revenue" / "...that scales brands" / "...that converts clicks"
- Two CTA buttons: Primary (filled gradient), Secondary (outlined)
- Floating stat cards animating into view (clients, ROI, revenue)
- Subtle scroll-down indicator (chevron bounce animation)
- Responsive: stacks vertically on mobile, full-width background

---

### Story 5.3: Navigation Redesign

As a **user**,
I want to **navigate the site effortlessly on any device**,
So that **I can find information quickly**.

**Acceptance Criteria:**

- Sticky header with blur backdrop (glassmorphism)
- Mega menu for "Services" dropdown (shows all 6 services with icons)
- "Free Tools" dropdown with tool previews
- Dark mode toggle in header
- Mobile: hamburger → full-screen overlay nav with smooth transition
- Active page indicator (underline animation)
- CTA button in header: "Get Started" (always visible)

---

### Story 5.4: Interactive Animations & Micro-Interactions

As a **visitor**,
I want to **experience subtle, delightful animations**,
So that **the site feels alive and premium**.

**Acceptance Criteria:**

- Scroll-triggered fade-in/slide-up for content sections (Intersection Observer)
- Hover effects on cards (lift + shadow), buttons (glow pulse), images (subtle zoom)
- Number counting animation on stat cards (0 → final value)
- Smooth page transitions (View Transitions API — already CSS-ready)
- Loading skeleton states for async content
- Progress bar on blog posts (reading progress)
- `prefers-reduced-motion: reduce` respected (already implemented)

---

### Story 5.5: Footer Redesign

As a **visitor**,
I want to **find contact info, links, and social profiles in the footer**,
So that **I can reach Hoplytics or explore more content**.

**Acceptance Criteria:**

- 4-column layout: Company, Services, Free Tools, Contact
- Newsletter signup form (Email + "Subscribe" CTA)
- Social media icon links (Facebook, Instagram, LinkedIn, Twitter/X, YouTube)
- Trust badges: Google Partner, Meta Partner, etc.
- Copyright line + Privacy Policy + Terms links
- Gradient top border matching brand

---

## Epic 6: Performance & Core Web Vitals

Ensure the theme achieves 95+ Lighthouse scores across all categories.

### Story 6.1: Critical CSS Inlining

As a **performance engineer**,
I want to **inline above-the-fold CSS**,
So that **the First Contentful Paint is under 1.5 seconds**.

**Acceptance Criteria:**

**Given** the Vite build pipeline
**When** building for production
**Then** above-the-fold CSS (hero, nav, first section) is inlined in `<head>`
**And** remaining CSS is loaded async via `<link rel="preload" as="style">`
**And** no render-blocking CSS files remain

---

### Story 6.2: Image Optimization Pipeline

As a **content editor**,
I want to **upload images that are automatically optimized**,
So that **I don't need to worry about image performance**.

**Acceptance Criteria:**

- WordPress auto-generates WebP/AVIF from uploaded JPEG/PNG
- `<picture>` element with WebP fallback
- Lazy loading on all images below the fold
- `fetchpriority="high"` on hero image (already implemented)
- Responsive `srcset` with appropriate sizes

---

## Epic 7: SEO Infrastructure

### Story 7.1: JSON-LD Structured Data

As a **search engine**,
I want to **read structured data from every page**,
So that **I can display rich results (snippets, breadcrumbs, FAQs)**.

**Acceptance Criteria:**

- Organization schema on every page (name, logo, sameAs social links)
- LocalBusiness schema on contact page
- Service schema on each service page
- FAQPage schema on pages with FAQ sections
- Article schema on blog posts
- BreadcrumbList schema site-wide
- Review schema with testimonials

---

### Story 7.2: Open Graph & Twitter Cards

As a **social media sharer**,
I want to **see rich previews when sharing Hoplytics links**,
So that **shared links look professional and get more clicks**.

**Acceptance Criteria:**

- `og:title`, `og:description`, `og:image` on every page
- `og:type` (website for pages, article for posts)
- `twitter:card` (summary_large_image)
- Custom OG images for service pages (1200×630px)
- Fallback OG image set in theme settings

---

## Epic 8: Analytics & Admin Dashboard

### Story 8.1: Tool Usage Analytics

As an **admin**,
I want to **see how many people use each free tool**,
So that **I can measure ROI of our free tools strategy**.

**Acceptance Criteria:**

- Admin dashboard widget showing: Total Audits Run, Pixel Checks, SEO Scores, Speed Tests
- Breakdown by date range (7d, 30d, 90d, all)
- Email capture conversion rate per tool
- Top scanned domains chart

---

### Story 8.2: Lead Management Dashboard

As a **sales team member**,
I want to **view and manage all leads in the WordPress admin**,
So that **I can follow up efficiently**.

**Acceptance Criteria:**

- Custom admin page `/wp-admin/admin.php?page=hoplytics-leads`
- Sortable/filterable table: Name, Email, Source Tool, Service Interest, Date, Status
- Lead statuses: New, Contacted, Qualified, Won, Lost
- Quick actions: Change Status, Send Follow-up Email, View Audit Report
- CSV export functionality
