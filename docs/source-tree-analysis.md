# Source Tree Analysis

## Directory Structure

```
hoplytics-agency-plus/
├── functions.php              # ★ Theme bootstrap — includes all inc/ modules
├── style.css                  # Theme header + ROI Calculator, Testimonial Grid, Scarcity Bar, Bento Grid styles
├── theme.json                 # WP theme.json v2 — color palette, layout widths, dark mode
├── index.php                  # Fallback template
├── front-page.php             # ★ Front Page — Hero, Trusted By, Services, CTA sections
├── home.php                   # Blog listing page
├── header.php                 # Site header — nav, logo, CTA button, mobile menu
├── footer.php                 # Site footer — contact info, menus, copyright
├── single.php                 # Single blog post template
├── single-project.php         # ★ Single case study — metrics, related service, Gallery
├── archive-project.php        # Case studies archive grid
├── archive-service.php        # Services archive listing
├── page-careers.php           # Careers listing page
├── page-team.php              # Team members grid page
├── page-landing.php           # Landing page template
├── page-content-marketing-services.php   # Content Marketing service page
├── page-search-engine-marketing.php      # SEM service page
├── page-search-engine-optimization.php   # SEO service page (w/ SEO audit form)
├── page-social-media-marketing.php       # Social Media service page
├── screenshot.png             # Theme screenshot for WP admin
│
├── inc/                       # ★ Core PHP modules
│   ├── setup.php              # Theme supports, nav menus, image sizes, widgets, admin notices
│   ├── enqueue.php            # Script/style registration — Google Fonts, CSS, Chart.js (conditional)
│   ├── custom-post-types.php  # 4 CPTs (project, service, team_member, career) + 4 taxonomies + meta boxes
│   ├── cpt-testimonials.php   # Testimonial CPT registration
│   ├── customizer.php         # Style Kits, Header, Hero, Trusted By, Footer — Customizer sections
│   ├── seo.php                # JSON-LD schema for 6 schema types
│   ├── white-label.php        # Login branding, dashboard widget, admin footer
│   ├── template-functions.php # Body classes (style kit injection), pingback
│   └── modules/               # CRO & interactive modules
│       ├── roi-calculator.php       # ROI Calculator block/shortcode registration
│       ├── seo-audit.php            # SEO Audit form shortcode + handler
│       ├── hero-form-handler.php    # Hero lead form POST handler
│       ├── device-frame.php         # Device frame visual component
│       └── demo-content-seeder.php  # One-click demo content installer
│
├── template-parts/            # Reusable template fragments
│   ├── scarcity-bar.php       # Sticky urgency banner
│   ├── content-card.php       # Generic content card display
│   ├── block-testimonial-grid.php   # Testimonial grid template
│   ├── components/
│   │   └── ...                # Shared UI components
│   └── cro/                   # ★ Conversion Rate Optimization sections
│       ├── comparison-table.php       # Feature comparison table
│       ├── lead-magnet-gate.php       # Gated content capture
│       ├── pain-agitate-solution.php  # PAS copywriting section
│       └── social-proof-bar.php       # Social proof statistics
│
├── blocks/                    # Custom Gutenberg block
│   └── roi-calculator/        # ROI Calculator block (3 files)
│
├── patterns/                  # Block patterns
│   └── ...
│
├── templates/                 # Full Site Editing templates
│   └── ...
│
├── assets/
│   ├── css/
│   │   ├── variables.css      # ★ CSS Custom Properties — 3 Style Kits
│   │   ├── main.css           # Core layout, typography, components (~16KB)
│   │   ├── nav.css            # Navigation & mobile menu styles
│   │   └── hero-form.css      # Hero lead form styles
│   ├── js/
│   │   ├── main.js            # Mobile menu, smooth scroll, interactions
│   │   └── roi-calculator.js  # ROI Calculator logic & Chart.js rendering
│   └── images/
│       └── ...                # Logo, placeholders, brand assets
│
├── verification/              # Verification/testing files
├── _archive/                  # Archived/legacy files (80 items)
├── _bmad/                     # BMad framework configuration
└── _bmad-output/              # BMad output artifacts (empty)
```

## Critical Folders

| Folder | Purpose |
|---|---|
| `inc/` | All PHP logic — theme setup, CPTs, customizer, SEO, white-labeling, CRO modules |
| `inc/modules/` | Interactive CRO tools — ROI calculator, SEO audit, hero form, device frame |
| `template-parts/cro/` | Conversion-focused template fragments — comparison table, lead magnet, PAS, social proof |
| `assets/css/` | Design system — CSS variables with 3 Style Kit variants |
| `blocks/` | Custom Gutenberg block (ROI Calculator) |

## Entry Points

| Entry Point | Purpose |
|---|---|
| `functions.php` | Theme bootstrap — includes all modules from `inc/` |
| `front-page.php` | Front page template with hero, services, CTA |
| `style.css` | Theme metadata header (required by WordPress) |
| `theme.json` | Block editor configuration, color palette, layout |
