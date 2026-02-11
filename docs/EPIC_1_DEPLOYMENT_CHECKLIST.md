# Epic 1 — Deployment Checklist

**Status:** Code Complete ✅ | Deployment: Pending ⏳  
**Commit:** `8ed38d7`  
**Branch:** `main`  

---

## What Was Built

| File | Type | Purpose |
|------|------|---------|
| `page-services.php` | PHP Template | Services hub with 4 service cards, process steps, free tools CTA |
| `page-about.php` | PHP Template | About page with story, values, comparison, and CTAs |
| `templates/page-services.html` | FSE Block Template | Block editor equivalent of the Services hub |
| `templates/page-about.html` | FSE Block Template | Block editor equivalent of the About page |
| `theme.json` | Config | Registered all 5 custom templates |
| `docs/SITE_AUDIT_REPORT.md` | Documentation | Full audit with all 6 epics and story breakdowns |

---

## WordPress Admin Steps Required

### Step 1: Create the "Services" page (if not already done)

The `/services/` page already exists in WordPress (Page ID: 181) but has empty content. You need to:

1. Go to **Pages → All Pages** in WordPress admin
2. Edit the "Services" page
3. In the **Page Attributes** panel (right sidebar), set the Template to **"Services Hub"**
4. Save/Update the page

> **Alternative:** If using the block editor, the page will pick up the `page-services.html` block template. The PHP template (`page-services.php`) acts as a fallback and works via WordPress's template hierarchy — if the page slug is `services`, it automatically loads `page-services.php`.

### Step 2: Create the "About" page

The `/about/` page does NOT exist in WordPress yet. You need to:

1. Go to **Pages → Add New**
2. Title: **About**
3. Slug: **about** (should auto-generate)
4. Set Template to **"About Us"** in Page Attributes
5. Leave the content area empty (the template handles everything)
6. Publish

### Step 3: Create the "Free Tools" page

The `/free-tools/` page does NOT exist in WordPress yet, but the template (`page-free-tools.html`) and full API backend (`inc/tools-api.php`) are already in the codebase. You need to:

1. Go to **Pages → Add New**
2. Title: **Free Marketing Tools**
3. Slug: **free-tools**
4. Set Template to **"Free Marketing Tools"** in Page Attributes
5. Leave the content area empty (the template handles everything)
6. Publish

### Step 4: Update Navigation Menu

1. Go to **Appearance → Menus** (or the Customizer)
2. Add the new pages to the primary navigation:
   - **Services** → link to `/services/`
   - **About** → link to `/about/`
   - **Free Tools** → link to `/free-tools/`
3. Ensure there are no broken links remaining
4. Save

### Step 5: Verify (Post-Deployment)

After completing steps 1–4, verify each URL returns 200 OK:

- [ ] `https://hoplytics.com/services/` → Services Hub content shown
- [ ] `https://hoplytics.com/about/` → About page content shown
- [ ] `https://hoplytics.com/free-tools/` → Free Tools page with 7 working tools
- [ ] All navigation links work (no 404s)
- [ ] Mobile responsiveness confirmed

---

## Epic 2: Quick Wins (Can Be Done in WP Admin)

These don't require code changes:

| Task | Where | Time |
|------|-------|------|
| Delete "Sample Post 2" | Posts → Trash it | 30 sec |
| Delete "Sample Post 3" | Posts → Trash it | 30 sec |
| Fix "Lets Connect" → "Let's Connect" | Pages → Edit "Lets Connect" → Update title | 30 sec |
| Update Case Studies page | Pages → Edit → Replace "Coming soon" with a CTA directing to `/get-started/` | 5 min |
| Update blog post titles | Posts → Edit each → Remove "in 2021" from titles, update content | 15 min |

---

## What's Already Handled By the Codebase

The codebase already has infrastructure for several items from the audit:

| Feature | Already In Codebase? | File |
|---------|---------------------|------|
| Custom 404 page | ✅ Yes | `templates/404.html` |
| Free Tools (7 tools) | ✅ Yes | `inc/tools-api.php`, `templates/page-free-tools.html` |
| Case Study CPT | ✅ Yes | `inc/cpt-case-study.php` |
| Case Study archive | ✅ Yes | `templates/archive-case_study.html` |
| Structured data | ✅ Yes | `inc/structured-data.php` |
| SEO infrastructure | ✅ Yes | `inc/seo.php` |
| Lead capture forms | ✅ Yes | `inc/lead-capture.php` |
| Block patterns | ✅ Yes | `inc/page-patterns.php` |

The gap between the codebase and production is **deployment, not development**. The theme needs to be activated and the pages created in WordPress admin.
