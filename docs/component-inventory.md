# Component Inventory

## Template Hierarchy

### Page Templates

| Template | WP Condition | Purpose |
|---|---|---|
| `front-page.php` | `is_front_page()` | Hero, Trusted By logos, Services showcase, ROI Calculator, CTA |
| `home.php` | `is_home()` | Blog post listing (excludes CPTs from main query) |
| `single.php` | `is_singular('post')` | Blog post single view |
| `single-project.php` | `is_singular('project')` | Case study detail — metrics, gallery, related service |
| `archive-project.php` | `is_post_type_archive('project')` | Case studies grid |
| `archive-service.php` | `is_post_type_archive('service')` | Services listing |
| `page-careers.php` | Page slug: `careers` | Career listings |
| `page-team.php` | Page slug: `team` | Team member grid |
| `page-landing.php` | Page template selection | Generic landing page |
| `page-content-marketing-services.php` | Page slug | Content Marketing service |
| `page-search-engine-marketing.php` | Page slug | SEM service |
| `page-search-engine-optimization.php` | Page slug | SEO service (with SEO audit form) |
| `page-social-media-marketing.php` | Page slug | Social Media service |
| `index.php` | Fallback | Default fallback template |

### Template Parts

| Part | Path | Usage |
|---|---|---|
| Scarcity Bar | `template-parts/scarcity-bar.php` | Sticky urgency banner (included in header/front-page) |
| Content Card | `template-parts/content-card.php` | Generic card layout for loops |
| Testimonial Grid | `template-parts/block-testimonial-grid.php` | Grid display of testimonial CPT |

### CRO Template Parts

| Part | Path | Purpose |
|---|---|---|
| Comparison Table | `template-parts/cro/comparison-table.php` | Feature comparison (agency vs competitor) |
| Lead Magnet Gate | `template-parts/cro/lead-magnet-gate.php` | Gated content capture |
| Pain-Agitate-Solution | `template-parts/cro/pain-agitate-solution.php` | PAS copywriting framework section |
| Social Proof Bar | `template-parts/cro/social-proof-bar.php` | Statistics/social proof display |

## CRO Modules (PHP)

| Module | File | Type | Trigger |
|---|---|---|---|
| ROI Calculator | `inc/modules/roi-calculator.php` | Block + Shortcode `[roi_calculator]` | Front-page, landing pages |
| SEO Audit | `inc/modules/seo-audit.php` | Shortcode `[seo_audit]` | SEO service page |
| Hero Form Handler | `inc/modules/hero-form-handler.php` | `admin-post.php` handler | Front-page hero |
| Device Frame | `inc/modules/device-frame.php` | Template component | Portfolio/case studies |
| Demo Content Seeder | `inc/modules/demo-content-seeder.php` | Admin action | Dashboard admin notice |

## Blocks

| Block | Namespace | Path |
|---|---|---|
| ROI Calculator | `hoplytics/roi-calculator` | `blocks/roi-calculator/` |

## Shortcodes

| Shortcode | Handler | Output |
|---|---|---|
| `[roi_calculator]` | `inc/modules/roi-calculator.php` | Interactive ROI calculation with Chart.js |
| `[seo_audit]` | `inc/modules/seo-audit.php` | SEO audit request form |

## CSS Components

| File | Size | Responsibility |
|---|---|---|
| `variables.css` | 2.6KB | Design tokens, 3 Style Kit variants |
| `main.css` | 15.9KB | Layout grid, typography, card styles, utility classes, forms, buttons |
| `nav.css` | 7.5KB | Header navigation, mobile hamburger, dropdown menus |
| `hero-form.css` | 3.0KB | Hero section lead capture form styling |
| `style.css` | 4.2KB | ROI calculator block, testimonial grid, scarcity bar, bento grid |

## JavaScript Components

| File | Size | Responsibility |
|---|---|---|
| `main.js` | 2.8KB | Mobile menu toggle, smooth scroll, UI interactions |
| `roi-calculator.js` | 2.9KB | ROI calculation logic, Chart.js chart rendering, range/number sync |
