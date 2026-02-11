# Project History & Evolution

> This document captures the transformation from the original third-party theme to the current custom-built Hoplytics v3.0.0 theme.

## Timeline

| Date | Milestone |
|---|---|
| Pre-Oct 2025 | Original site running on third-party "Agency Plus" theme |
| October 2, 2025 | Full cPanel backup taken ("Warda_backup") — last snapshot of old site |
| Oct 2025 – Present | Complete ground-up rewrite to Hoplytics v3.0.0 |

## Original Stack (Pre-Oct 2025)

The original `hoplytics.com` site ran on a completely different architecture:

### Theme
- **Name:** Agency Plus v1.0.5
- **Author:** WP Concern / iThemer
- **Base:** Underscores (`_s`) starter theme
- **CSS:** 3,552-line monolithic `style.css` (73KB) with embedded normalize.css
- **Typography:** `Alegreya Sans` (body) + `Lora` (headings)
- **Icons:** Font Awesome 5.13
- **Navigation:** jQuery MeanMenu plugin
- **WooCommerce:** Full support with product gallery lightbox, slider, zoom

### Plugin Dependencies (18 plugins)

| Plugin | Purpose |
|---|---|
| **Elementor** | Page builder (primary layout tool) |
| **ElementsKit Lite** | Elementor addons |
| **Essential Addons for Elementor** | Additional Elementor widgets |
| **Header Footer Elementor** | Custom header/footer via Elementor |
| **Premium Addons for Elementor** | More Elementor widgets |
| **Post Grid Elementor Addon** | Post grid layouts |
| **Blocks Animation** | Block animations |
| **Animated Typing Effect** | Text animation |
| **WPForms Lite** | Contact forms |
| **Styler for WPForms** | Form styling |
| **Yoast SEO (wordpress-seo)** | SEO management |
| **Google Analytics for WP** | Analytics |
| **Google Site Kit** | Google integration |
| **WP Super Cache** | Page caching |
| **WP Mail SMTP** | Email deliverability |
| **Simple 301 Redirects** | URL redirects |
| **Custom Sidebars** | Widget area management |
| **Akismet** | Spam protection |

### Infrastructure
- **Hosting:** DirectAdmin/cPanel (LiteSpeed web server)
- **Database:** MySQL (`hoplytics_wp.sql` — ~13MB dump)
- **Caching:** WP Super Cache + LiteSpeed cache
- **Email:** IMAP email accounts on domain

## What Changed (v3.0.0 Rewrite)

### Architecture Transformation

```diff
- Third-party theme (Agency Plus by WP Concern)
+ Custom-built Hoplytics theme (in-house)

- Elementor page builder for all layouts
+ Native WordPress template hierarchy + theme.json v2

- 18 plugin dependencies
+ Zero plugin dependencies (all features built-in)

- jQuery + jQuery MeanMenu
+ Vanilla JavaScript (no jQuery dependency)

- Monolithic 73KB style.css
+ Modular CSS: variables.css + main.css + nav.css (total ~30KB)

- Single font pair (Alegreya Sans + Lora)
+ 3 Style Kits with 5 Google Font families

- Yoast SEO plugin for schema
+ Native JSON-LD schema for 6 schema types

- WPForms for contact forms
+ Built-in form handlers (Hero Lead Form, SEO Audit)

- No custom post types
+ 5 CPTs (project, service, team_member, testimonial, career)

- WooCommerce support
+ Removed (not needed for agency site)

- Font Awesome icons
+ No icon library dependency (using CSS/SVG)
```

### Key Design Decisions

1. **Eliminated Elementor**: Moved all page layouts to native PHP templates, reducing page load and removing ~25MB of plugin code
2. **Built-in CRO tools**: ROI Calculator, SEO Audit, Scarcity Bar — no third-party plugins needed
3. **Style Kit system**: 3 switchable design presets via CSS Custom Properties instead of Elementor's theme builder
4. **White-label admin**: Custom login, branded dashboard — previously required separate plugin
5. **Content model**: Formalized 5 CPTs with taxonomies and relationship meta boxes instead of relying on generic posts

## Backup Location

The original site backup is preserved at:
```
old data/Warda_backup-Oct-02-2025-1/
├── backup/
│   ├── hoplytics_wp.sql         # Full database dump (~13MB)
│   ├── hoplytics_wp.conf        # WP configuration
│   └── user.conf                # Server user configuration
├── domains/hoplytics.com/
│   └── public_html/             # Full WordPress installation
│       └── wp-content/
│           ├── themes/agency-plus/    # ← Original theme
│           ├── plugins/               # ← 18 plugins
│           └── uploads/               # ← Media library
└── imap/                        # Email data
```
