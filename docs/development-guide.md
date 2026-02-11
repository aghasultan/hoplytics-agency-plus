# Development Guide

## Prerequisites

- WordPress 6.4 or higher
- PHP 7.4+ (theme uses `declare(strict_types=1)`)
- A running WordPress installation (local: Local by Flywheel, wp-env, MAMP, etc.)
- MySQL/MariaDB database

## Installation

1. Clone or copy the theme to your WordPress themes directory:
   ```bash
   cp -r hoplytics-agency-plus/ /path/to/wordpress/wp-content/themes/
   ```

2. Activate the theme in **Appearance → Themes** from WordPress admin.

3. When prompted on the dashboard, click **"Install Demo Content"** to seed service pages.

4. Set your **Reading Settings** → "Your homepage displays" → "A static page" and select your front page.

## Configuration

### Style Kit Selection
**Appearance → Customize → Style Kits**
Choose from:
- `tech-futurist` — Dark mode, neon accents (Orbitron + Rajdhani fonts)
- `corporate-stabilizer` — Clean white, professional (Inter font)
- `creative-disruptor` — Bold, brutalist, kinetic (Space Grotesk + DM Sans)

### Header & Hero
- **Header Options** → CTA button text and URL
- **Front Page Hero** → Headline, subheadline, 2 buttons, hero visual image

### Trusted By Section
- **Trusted By Section** → Title and up to 5 logo images

### Footer
- **Footer Options** → Tagline, contact email, contact phone

## Content Management

### Adding a Case Study (Project)
1. Go to **Projects → Add New**
2. Fill in title, content, excerpt, featured image
3. Assign **Industry** and **Tech Stack** taxonomies
4. Select a **Related Service** from the sidebar meta box
5. Publish — available at `/case-studies/your-project-slug/`

### Adding a Service
1. Go to **Services → Add New**
2. Fill in title, content, featured image
3. Services support parent/child hierarchy via **Page Attributes**
4. Assign **Service Type** taxonomy

### Adding Team Members
1. Go to **Team → Add New**
2. Title = Name, Excerpt = Bio, Featured Image = Photo
3. Assign **Department** taxonomy

### Adding Testimonials
1. Go to **Testimonials → Add New**
2. Title = Client Name, Editor = Quote, Featured Image = Client photo
3. Select a **Related Service** from the sidebar meta box

### Adding Career Listings
1. Go to **Careers → Add New**
2. Fill in title and job description
3. Custom fields: `location` and `job_type` (for schema)
4. Available at `/careers/`

## Using CRO Tools

### ROI Calculator
Add to any page via Gutenberg block (`hoplytics/roi-calculator`) or shortcode:
```
[roi_calculator]
```
Chart.js is conditionally loaded only on pages containing this block/shortcode.

### SEO Audit Form
Add to any page via shortcode:
```
[seo_audit]
```
Submissions are emailed to the site admin email.

### Scarcity Bar
Include in templates:
```php
get_template_part('template-parts/scarcity-bar');
```

## File Structure Conventions

| Convention | Example |
|---|---|
| Prefixed functions | `hoplytics_setup()`, `hoplytics_scripts()` |
| Nonce verification | `wp_verify_nonce()` on all form handlers |
| Strict types | `declare(strict_types=1)` in every PHP file |
| ABSPATH guard | `defined('ABSPATH') \|\| exit;` in every PHP file |
| Version constant | `HOPLYTICS_VERSION` = `3.0.0` |
| Text domain | `hoplytics` for all translatable strings |

## Environment Variables

No `.env` file needed. All configuration is managed via:
- WordPress `wp-config.php`
- Theme Customizer settings (stored in `wp_options` table)
- Post meta fields

## Build Process

No build step required — the theme uses plain CSS and vanilla JavaScript. No bundler, no preprocessor.

## Testing

No automated test suite is currently configured. Manual testing is done through:
- WordPress admin previews
- Browser testing across Style Kits
- Schema validation via Google Rich Results Test
