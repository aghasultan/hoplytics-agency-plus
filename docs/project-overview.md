# Hoplytics Agency Plus — Project Overview

> **Version:** 3.0.0 | **Platform:** WordPress 6.4+ | **PHP:** 7.4+ | **License:** GPL v2+

## Executive Summary

Hoplytics Agency Plus is a **hybrid WordPress theme** purpose-built for digital agencies specializing in high-ticket lead generation. It combines a traditional WordPress theme architecture with integrated CRO (Conversion Rate Optimization) tools, white-label admin experience, and deep schema markup — making it a full "AgencyOS" rather than a simple theme.

## Purpose & Target Audience

- **Primary:** Digital marketing agencies selling SEO, SEM, Social Media, and Content Marketing services
- **Use Case:** Agency website with portfolio showcase, service pages, team profiles, career listings, and conversion-focused lead capture
- **Differentiator:** Built-in ROI Calculator, SEO Audit tool, Scarcity Bar, and Style Kit theming system — no plugin dependencies for core CRO functionality

## Core Features

| Feature | Description |
|---|---|
| **Style Kits** | 3 switchable design presets (Tech-Futurist, Corporate-Stabilizer, Creative-Disruptor) via Customizer |
| **ROI Calculator** | Interactive block/shortcode with Chart.js visualization for real-time revenue projection |
| **SEO Audit** | Lead-capture form disguised as a free audit tool, emails admin on submission |
| **Scarcity Bar** | Sticky urgency banner for high-ticket slot availability |
| **JSON-LD Schema** | Organization, LocalBusiness, Service, Article, JobPosting, and ItemList schemas |
| **White-Label Admin** | Custom login screen, branded dashboard widget, cleaned admin UI |
| **Hero Lead Form** | Front-page contact form with nonce security, emailing admin |
| **Demo Content Seeder** | One-click demo content installation for service pages |
| **Device Frame** | Visual component for showcasing project screenshots |
| **CRO Template Parts** | Comparison table, lead magnet gate, pain-agitate-solution section, social proof bar |

## Custom Post Types & Taxonomies

| CPT | Slug | Archive | Taxonomies |
|---|---|---|---|
| Projects (Portfolio) | `project` → `/case-studies/` | ✅ | Industry, Tech Stack |
| Services | `service` | ✅ | Service Type |
| Team Members | `team_member` | ❌ | Department |
| Testimonials | `testimonial` | ✅ | — |
| Careers | `career` → `/careers/` | ✅ | Department |

## Technology Stack

| Category | Technology | Version |
|---|---|---|
| CMS | WordPress | 6.4+ |
| Language | PHP | 7.4+ (strict types) |
| Styling | CSS Custom Properties + Style Kits | — |
| Typography | Google Fonts (Inter, Orbitron, Rajdhani, Space Grotesk, DM Sans) | — |
| Charts | Chart.js (CDN) | 4.4.0 |
| Schema | JSON-LD (native) | — |
| Theme API | theme.json v2, Customizer API | — |

## Repository Type

**Monolith** — Single cohesive theme codebase deployed to `wp-content/themes/hoplytics-agency-plus/`.

## Project History

Hoplytics v3.0.0 is a **complete ground-up rewrite** of the original site, which ran on a third-party "Agency Plus" theme (v1.0.5 by WP Concern) with Elementor page builder and 18 plugin dependencies. The legacy site data is preserved in `old data/Warda_backup-Oct-02-2025-1/` (including a ~13MB MySQL dump).

See [Project History](./project-history.md) for the full evolution details and before/after comparison.
