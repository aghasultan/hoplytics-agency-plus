# Hoplytics Agency Plus — Documentation Index

> **Generated:** 2026-02-11 | **Scan Mode:** Initial Scan (Deep) | **Version:** 3.0.0

## Project Overview

- **Type:** Monolith — WordPress Hybrid Theme
- **Primary Language:** PHP 7.4+ (strict types)
- **Architecture:** Classic template hierarchy + theme.json v2
- **Purpose:** High-ticket lead generation agency website with integrated CRO tools

### Quick Reference

| Property | Value |
|---|---|
| **Theme Version** | 3.0.0 |
| **WordPress** | 6.4+ |
| **CSS System** | Custom Properties + 3 Style Kits |
| **Schema** | JSON-LD (6 schema types) |
| **CPTs** | 5 (project, service, team_member, testimonial, career) |
| **Taxonomies** | 4 (industry, tech_stack, service_type, department) |
| **CRO Modules** | 5 (ROI Calculator, SEO Audit, Hero Form, Device Frame, Demo Seeder) |
| **Entry Point** | `functions.php` → includes `inc/*.php` |

## Generated Documentation

- [Project Overview](./project-overview.md) — Features, tech stack, purpose
- [Architecture](./architecture.md) — System design, data model, style kits, schema, asset pipeline
- [Source Tree Analysis](./source-tree-analysis.md) — Annotated directory structure
- [Component Inventory](./component-inventory.md) — Templates, CRO modules, blocks, CSS/JS
- [Development Guide](./development-guide.md) — Installation, configuration, content management
- [Project History](./project-history.md) — Evolution from original Agency Plus theme (Oct 2025 backup) to v3.0.0
- **[Project Context](./project-context.md)** — ⚡ LLM-optimized single-file context for AI agents

## Existing Documentation

- [README.md](../README.md) — Brief feature overview

## Getting Started

### For Understanding the Codebase
1. Start with [Project Overview](./project-overview.md) for the big picture
2. Read [Architecture](./architecture.md) for technical decisions and data model
3. Reference [Component Inventory](./component-inventory.md) when working on specific areas

### For Setting Up Development
1. Follow the [Development Guide](./development-guide.md) for installation
2. Use [Source Tree Analysis](./source-tree-analysis.md) to navigate the codebase

### For AI-Assisted Development
This documentation serves as the ground truth for AI agents. When planning new features:
- Check the **CPT & Taxonomy data model** in Architecture to understand existing structures
- Review **Style Kit variables** in Architecture before adding new CSS
- Follow the **file structure conventions** in Development Guide (prefixed functions, strict types, ABSPATH guards)
- Use the **Component Inventory** to identify reusable template parts and modules
