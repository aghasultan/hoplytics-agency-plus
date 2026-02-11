# Epic 3 — SEO & Technical Foundations Deployment Checklist

**Status:** Code Complete ✅ | Deployment: Pending ⏳  
**Commit:** `024f82a`  
**Branch:** `main`  

---

## What Was Built

### New Files Created

| File | Purpose |
|------|---------|
| `inc/seo-meta.php` | Meta descriptions, canonical URLs, robots meta, admin meta box |
| `inc/sitemap.php` | WordPress core sitemap customization |

### Files Modified

| File | Change |
|------|--------|
| `inc/structured-data.php` | +3 new Schema types (CaseStudy, ProfessionalService, WebSite) |
| `inc/cli.php` | +`wp hoplytics seo-check` command |
| `functions.php` | Added `require` for seo-meta.php and sitemap.php |

---

## Feature Breakdown

### 3.1 — Meta Descriptions
Every page now outputs a `<meta name="description">` tag with this priority:
1. Custom field `_hoplytics_meta_description` (editable in admin)
2. Post/page excerpt  
3. Pre-written defaults for 11 key pages
4. Site tagline (last fallback)

**Pre-written for:** services, about, free-tools, get-started, social-media-marketing, search-engine-marketing, search-engine-optimization, content-marketing-services, case-studies, insights, privacy-policy

### 3.2 — Canonical URLs
- WordPress core handles singulars
- New module covers: archives, taxonomies, front page, blog page

### 3.3 — Robots Meta
Automatically adds `<meta name="robots" content="noindex, follow">` for:
- Search results pages
- 404 pages
- Paginated archives (page 2+)
- Tag archives (thin content)
- Posts/pages with `_hoplytics_noindex` flag

### 3.4 — Admin SEO Meta Box
Available on: Posts, Pages, Case Studies
- Meta description textarea with live character count (colour-coded)
- Noindex checkbox to exclude specific content from search
- Nonce-verified, capability-checked saves

### 3.5 — Schema.org Structured Data (JSON-LD)

| Schema Type | Where | What It Does |
|-------------|-------|-------------|
| `Organization` | All pages | Company info, social links, contact |
| `BreadcrumbList` | Non-home pages | Navigation breadcrumbs |
| `Article` | Blog posts | Headline, author, dates, publisher |
| `CaseStudy` *(new)* | Case study CPT | Client, testimonial, review rating |
| `ProfessionalService` *(new)* | Service pages | Service details, offers |
| `WebSite` *(new)* | Home page | Sitelinks search box for Google |

### 3.6 — Sitemap Enhancements
Customizes WordPress's built-in `/wp-sitemap.xml`:
- Removes attachment pages (thin content)
- Removes `post_format` and `post_tag` taxonomies
- Excludes noindex-flagged posts
- Adds `lastmod` dates for better crawl prioritization
- Sets max 5000 URLs per page (single-page sitemaps for small sites)

### 3.7 — SEO Audit CLI
```bash
wp hoplytics seo-check
```
Checks every published post/page/case study for:
- ✅ Meta description or excerpt present
- ✅ Title length (10-60 chars)
- ✅ Featured image (for posts/case studies)
- ✅ Content depth (300+ words for posts)
- ✅ Noindex flag awareness
- ✅ Infrastructure files present

---

## Deployment Steps

```bash
# 1. Pull the latest code
cd /path/to/wp-content/themes/hoplytics-agency-plus
git pull origin main

# 2. Clear caches
wp hoplytics flush

# 3. Run SEO audit to see baseline
wp hoplytics seo-check

# 4. (Optional) Add custom meta descriptions where needed
#    Go to WordPress Admin → Edit any post/page →
#    Find "SEO Meta Description" box → Add description
```

---

## Verification Checklist

### Meta Tags (view page source)
- [ ] Home page has `<meta name="description" content="Hoplytics is a performance-driven...">`
- [ ] Blog posts have meta description from excerpt
- [ ] Service pages have unique, pre-written descriptions
- [ ] Search results page has `<meta name="robots" content="noindex, follow">`
- [ ] 404 page has noindex robots tag

### Structured Data (test with Google Rich Results)
- [ ] Home: Organization + WebSite schema present
- [ ] Blog post: Article schema present
- [ ] Case study: Article schema with review present
- [ ] Service page: ProfessionalService schema present
- [ ] Non-home pages: BreadcrumbList schema present

### Sitemap
- [ ] `/wp-sitemap.xml` loads correctly
- [ ] No attachment pages in sitemap
- [ ] No tag archives in sitemap
- [ ] Entries have `<lastmod>` dates

### Admin
- [ ] SEO Meta Description box visible on post editor
- [ ] Character counter updates in real-time
- [ ] Noindex checkbox saves correctly

### Tools
- [ ] `wp hoplytics seo-check` runs without errors
- [ ] Reports accurate SEO score
