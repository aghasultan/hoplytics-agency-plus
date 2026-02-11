# Hoplytics Agency Plus — Project Context

> **Purpose:** Single-file LLM context for AI-assisted development.
> **Version:** 3.0.0 | **WP:** 6.4+ | **PHP:** 7.4+ (strict types) | **Updated:** 2026-02-11

## Identity

Hoplytics Agency Plus is a custom-built WordPress hybrid theme for digital agency websites. It combines classic PHP template hierarchy with `theme.json` v2 block editor support. Zero plugin dependencies — all CRO tools, schema, forms, and admin branding are built-in.

**Origin:** Ground-up rewrite (Oct 2025) of a site that previously ran a third-party "Agency Plus" theme (WP Concern) with Elementor + 18 plugins. Legacy backup preserved in `old data/`.

## Architecture

**Pattern:** Monolith WordPress theme. `functions.php` bootstraps all modules from `inc/`.

```
functions.php → inc/setup.php          # Theme supports, nav menus, image sizes, widgets
              → inc/enqueue.php        # Assets: Google Fonts, CSS, Chart.js (conditional)
              → inc/custom-post-types.php  # 5 CPTs + 4 taxonomies + meta boxes
              → inc/cpt-testimonials.php   # Testimonial CPT
              → inc/customizer.php     # Style Kits, Header, Hero, Trusted By, Footer
              → inc/seo.php            # JSON-LD schema (6 types)
              → inc/white-label.php    # Custom login, dashboard, admin footer
              → inc/template-functions.php  # Body classes (style kit), pingback
              → inc/modules/roi-calculator.php       # Block + shortcode
              → inc/modules/seo-audit.php            # Shortcode + form handler
              → inc/modules/hero-form-handler.php    # Lead form POST handler
              → inc/modules/device-frame.php         # Visual component
              → inc/modules/demo-content-seeder.php  # Admin demo installer
```

## Data Model

### Custom Post Types

| CPT | Slug | Rewrite | Supports | Key Meta |
|---|---|---|---|---|
| Projects | `project` | `/case-studies/` | title, editor, thumbnail, excerpt, custom-fields | `_related_service_id` |
| Services | `service` | default | title, editor, thumbnail, page-attributes | — |
| Team Members | `team_member` | default | title, thumbnail, excerpt | — |
| Testimonials | `testimonial` | default | title, editor, thumbnail | `_related_service_id` |
| Careers | `career` | `/careers/` | title, editor | `location`, `job_type` |

### Taxonomies

| Taxonomy | Slug | Attached To | Hierarchical |
|---|---|---|---|
| Industry | `industry` | project | Yes |
| Tech Stack | `tech_stack` | project | No (tags) |
| Service Type | `service_type` | service | Yes |
| Department | `department` | team_member, career | Yes |

### Relationships
- Projects → Services: via `_related_service_id` post meta (meta box in editor)
- Testimonials → Services: via `_related_service_id` post meta

## Design System: Style Kits

3 switchable presets via Customizer → `body.style-kit-{name}` class → CSS Custom Properties cascade.

| Kit | BG | Primary | Accent | Headings Font | Body Font | Radius |
|---|---|---|---|---|---|---|
| `tech-futurist` | `#0B0F19` (dark) | `#3B82F6` | `#10B981` | Orbitron | Rajdhani | 2px sharp |
| `corporate-stabilizer` | `#FFFFFF` | `#0F172A` | `#2563EB` | Inter | Inter | 6-12px rounded |
| `creative-disruptor` | `#FFFAF0` | `#000000` | `#FF0080` | Space Grotesk | DM Sans | 0px brutalist |

**Files:** `assets/css/variables.css` (tokens) → `assets/css/main.css` (layout) → `assets/css/nav.css` → `style.css` (blocks)

## CRO Modules

| Module | Type | Entry Point | Dependencies |
|---|---|---|---|
| ROI Calculator | Block `hoplytics/roi-calculator` + `[roi_calculator]` | `blocks/roi-calculator/` + `inc/modules/roi-calculator.php` | Chart.js 4.4.0 (CDN, conditional) |
| SEO Audit | `[seo_audit]` shortcode | `inc/modules/seo-audit.php` | — |
| Hero Lead Form | `admin-post.php` handler | `inc/modules/hero-form-handler.php` | — |
| Device Frame | Template component | `inc/modules/device-frame.php` | — |
| Demo Seeder | Admin action | `inc/modules/demo-content-seeder.php` | — |

**CRO Template Parts:** `template-parts/cro/` → comparison-table, lead-magnet-gate, pain-agitate-solution, social-proof-bar

## Schema / SEO

Native JSON-LD via `wp_head` hook (`inc/seo.php`):

| Context | Schema | Key Fields |
|---|---|---|
| Front/Contact | Organization + LocalBusiness | name, logo, contactPoint, address |
| Single Service | Service | name, provider, areaServed |
| Single Project | Article | headline, image, author, publisher, datePublished |
| Single Career | JobPosting | title, employmentType, location, validThrough |
| Archives | ItemList | position-ordered URLs |

## Template Map

| Template | Purpose |
|---|---|
| `front-page.php` | Hero, Trusted By, Services, ROI Calculator, CTA |
| `single-project.php` | Case study detail — metrics, gallery, related service |
| `archive-project.php` / `archive-service.php` | Grid listings |
| `page-careers.php` / `page-team.php` | Careers list, team grid |
| `page-landing.php` | Generic landing |
| `page-{service-slug}.php` | 4 service-specific pages (SEO, SEM, SMM, Content) |
| `template-parts/scarcity-bar.php` | Sticky urgency banner |

## Customizer Sections

| Section | Key Settings |
|---|---|
| Style Kits | `hoplytics_style_kit` → 3 choices |
| Header Options | CTA button text + URL |
| Front Page Hero | Headline, subheadline, 2 buttons (text+URL), hero image |
| Trusted By | Title + 5 logo image IDs |
| Footer Options | Tagline, email, phone |

## Form Handlers

Both use `admin-post.php` + nonce verification → `wp_mail()` to `admin_email` → redirect with success param.

| Form | Action | Fields |
|---|---|---|
| Hero Lead | `hoplytics_hero_lead` | name*, email*, website, service |
| SEO Audit | `hoplytics_seo_audit` | url*, email* |

## Conventions

| Convention | Pattern |
|---|---|
| Function prefix | `hoplytics_*` |
| Strict types | `declare(strict_types=1)` in every PHP file |
| ABSPATH guard | `defined('ABSPATH') \|\| exit;` in every PHP file |
| Version constant | `HOPLYTICS_VERSION` = `'3.0.0'` |
| Text domain | `hoplytics` |
| No build step | Plain CSS + vanilla JS, no bundler |
| Conditional loading | Chart.js only on pages with ROI calculator |

## Navigation Menus

- `menu-1` → Primary header
- `footer` → Footer company links
- `footer-services` → Footer services links

## Image Sizes

- `card-large`: 800×600 (cropped)
- `card-small`: 400×300 (cropped)
- `avatar`: 200×200 (cropped)

## External Dependencies

| Dependency | Source | Version |
|---|---|---|
| Chart.js | `cdn.jsdelivr.net` | 4.4.0 |
| Google Fonts | `fonts.googleapis.com` | Inter, Orbitron, Rajdhani, Space Grotesk, DM Sans |
| WordPress Core | Local | 6.4+ |

## Documentation

Full docs in `docs/`: [index](docs/index.md) · [overview](docs/project-overview.md) · [architecture](docs/architecture.md) · [source-tree](docs/source-tree-analysis.md) · [components](docs/component-inventory.md) · [dev-guide](docs/development-guide.md) · [history](docs/project-history.md)
