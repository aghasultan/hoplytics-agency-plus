# Epic 2 — Content Cleanup Deployment Checklist

**Status:** Code Complete ✅ | Deployment: Pending ⏳  
**Commit:** `51b6988`  
**Branch:** `main`  

---

## What Was Built (Code Changes)

| File | Change | Purpose |
|------|--------|---------|
| `inc/cli.php` | +3 new WP-CLI commands | `cleanup`, `seed-cases`, `create-pages` |
| `header.php` | Fixed fallback navigation | All links now point to real page URLs |
| `footer.php` | Fixed footer service links | Replaced broken `#` anchors with real URLs |

---

## New WP-CLI Commands

### 1. `wp hoplytics cleanup` — Content Cleanup
Autommates all Epic 2 content fixes in one command:

```bash
# Preview what will change (safe, no modifications)
wp hoplytics cleanup --dry-run

# Execute the cleanup
wp hoplytics cleanup --force
```

**What it does:**
- ✅ Deletes posts matching "Sample Post", "Hello World" patterns
- ✅ Fixes "Lets Connect" → "Let's Connect" typo
- ✅ Strips year references ("in 2021", "in 2022", etc.) from blog titles
- ✅ Replaces Case Studies "Coming soon" content with a proper CTA

### 2. `wp hoplytics seed-cases` — Seed Demo Case Studies
Creates 3 realistic case studies with full metrics:

```bash
wp hoplytics seed-cases --force
```

**Case studies created:**
| Client | Industry | Key Metric |
|--------|----------|------------|
| InsureMax Financial | Life Insurance | 340% more exclusive leads |
| UrbanFit Studios | Fitness & Wellness | $127K revenue from social |
| NexaTech Solutions | SaaS / Technology | 42 page-1 keyword rankings |

Each case study includes: client info, challenge, solution, 3 KPI metrics, and a client testimonial.

### 3. `wp hoplytics create-pages` — Create Missing Pages
Creates About, Free Tools, and Services pages with correct templates:

```bash
wp hoplytics create-pages --force
```

---

## Deployment Order

SSH into the production server and run these commands in order:

```bash
# 1. Pull the latest code
cd /path/to/wp-content/themes/hoplytics-agency-plus
git pull origin main

# 2. Preview the cleanup (optional, safe)
wp hoplytics cleanup --dry-run

# 3. Run the cleanup
wp hoplytics cleanup --force

# 4. Create missing pages with templates
wp hoplytics create-pages --force

# 5. Seed demo case studies
wp hoplytics seed-cases --force

# 6. Flush caches
wp hoplytics flush
```

---

## Manual Steps (If WP-CLI is NOT Available)

If you can't use WP-CLI, do these manually in WordPress admin:

| # | Task | Where | Time |
|---|------|-------|------|
| 1 | Delete "Sample Post 2" | Posts → Trash | 30 sec |
| 2 | Delete "Sample Post 3" | Posts → Trash | 30 sec |
| 3 | Fix "Lets Connect" → "Let's Connect" | Pages → Edit title → Update | 30 sec |
| 4 | Remove "in 2021" from blog titles | Posts → Edit each → Update | 5 min |
| 5 | Update Case Studies page | Pages → Edit → Replace content | 5 min |
| 6 | Create "About" page (slug: `about`) | Pages → Add New → Publish | 2 min |
| 7 | Create "Free Tools" page (slug: `free-tools`) | Pages → Add New → Publish | 2 min |

---

## Verification Checklist

After deployment, verify:

- [ ] No "Sample Post" entries remain in Posts
- [ ] "Let's Connect" page title has apostrophe
- [ ] Blog post titles have no year references
- [ ] Case Studies page shows CTA (not "Coming soon")
- [ ] `/about/` returns 200 with About content
- [ ] `/free-tools/` returns 200 with tools grid
- [ ] `/services/` returns 200 with services hub
- [ ] Header nav links all work (no `#` anchors)
- [ ] Footer service links all work (no `#` anchors)
- [ ] At least 3 case studies appear at `/case-studies/`
