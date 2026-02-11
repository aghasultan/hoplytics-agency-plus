# Hoplytics i18n

This directory contains translation files for the Hoplytics theme.

## Generating the .pot file

```bash
# Via npm (recommended)
npm run i18n:pot

# Via WP-CLI directly
wp i18n make-pot . languages/hoplytics.pot --domain=hoplytics --exclude=node_modules,dist,_archive,vendor
```

## Translation workflow

1. Generate `.pot` file using the command above
2. Create `.po` files for each locale (e.g., `hoplytics-es_ES.po`)
3. Compile `.po` → `.mo` using: `wp i18n make-mo languages/`
4. WordPress will auto-load translations based on the site locale
