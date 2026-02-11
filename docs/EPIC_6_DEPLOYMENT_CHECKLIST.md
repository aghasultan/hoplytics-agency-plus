# Epic 6: Content Strategy & Publishing — Deployment Checklist

**Completed:** 2026-02-11  
**Branch:** `main`

---

## Stories Implemented

### ✅ Story 6.1 — Evergreen Blog Articles
- **Command:** `wp hoplytics seed-articles [--force]`
- **File:** `inc/cli.php` (added `seed_articles` method)
- Creates 3 long-form, evergreen articles:
  1. *"7 SEO Strategies That Still Work in {year}"* — 1,500+ words, SEO category
  2. *"The ROI of Social Media Marketing: Real Numbers From Real Campaigns"* — 1,200+ words, Articles category
  3. *"Google Ads Optimization: 5 Levers That Drive Down Cost Per Lead"* — 1,400+ words, Articles category
- Each article includes: proper excerpts, SEO meta descriptions, relevant categories, internal CTAs
- Duplicate-safe: skips existing articles unless `--force` is used

### ✅ Story 6.2 — Case Study Content
- **Pre-existing:** `wp hoplytics seed-cases [--force]`
- Already creates 3 case studies with metrics, testimonials, and results data

### ✅ Story 6.3 — Editorial Calendar
- **File:** `inc/editorial-calendar.php`
- Admin menu: **Editorial** (📅 icon) in the WP sidebar
- Features:
  - 12-month rolling calendar grid
  - Content types: Blog Post, Case Study, Guide, Newsletter, Video, Social
  - Status tracking: Idea → In Progress → Review → Published
  - Owner/assignee field per content item
  - Dynamic "Add Content" button (JS, no page reload)
  - Current month highlighted with "NOW" badge
  - Color-coded legend for types and statuses
  - Pre-seeded with a default 12-month content plan
- Security: Nonce verification, capability checks, input sanitization

### ✅ Story 6.4 — Newsletter Signup
- **Backend:** `inc/newsletter.php`
  - REST endpoint: `POST /wp-json/hoplytics/v1/newsletter/subscribe`
  - Custom Post Type: `hoplytics_subscriber` (admin-visible under "Newsletter" menu)
  - Admin columns: Email, Source, Status (active/unsubscribed), Date
  - Rate limiting: Max 5 subscriptions per IP per hour
  - Duplicate detection: Reactivates unsubscribed users, returns friendly message for existing
  - Admin email notification on new subscriptions
  - Dashboard widget: Total subscribers, weekly growth, latest 5 signups
- **Frontend:** `assets/js/forms.js`
  - Auto-discovers all `.newsletter-form` elements
  - Reads `data-source` attribute for source tracking
  - Loading state, success/error feedback, auto-clear after 5 seconds
- **Template:** `templates/archive.html`
  - Added `data-source="blog_archive"` to existing newsletter form
- **Wiring:** `functions.php`
  - Included `newsletter.php` and `editorial-calendar.php`

---

## Files Created
| File | Purpose |
|------|---------|
| `inc/newsletter.php` | Newsletter CPT, REST API, dashboard widget |
| `inc/editorial-calendar.php` | Admin editorial calendar page |

## Files Modified
| File | Change |
|------|--------|
| `inc/cli.php` | Added `seed-articles` command (docblock + method) |
| `assets/js/forms.js` | Added newsletter form handler |
| `templates/archive.html` | Added `data-source` attribute to newsletter form |
| `functions.php` | Included 2 new modules |

---

## Deployment Steps
1. **Upload** new and modified files to production
2. **Run** `wp hoplytics seed-articles --force` to publish evergreen articles
3. **Check** WP Admin → **Newsletter** menu (subscriber list)
4. **Check** WP Admin → **Editorial** menu (calendar page)
5. **Check** WP Admin → **Dashboard** → Newsletter widget
6. **Test** newsletter form on `/blog/` archive page
7. **Verify** articles appear on blog archive with proper categories

## Post-Deployment Verification
```bash
# Seed articles
wp hoplytics seed-articles --force

# Verify articles created
wp post list --post_type=post --fields=ID,post_title,post_status --format=table

# Test newsletter endpoint
curl -X POST https://hoplytics.com/wp-json/hoplytics/v1/newsletter/subscribe \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","source":"deployment_test"}'

# Check subscriber count
wp post list --post_type=hoplytics_subscriber --format=count
```
