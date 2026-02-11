/**
 * Vite Build Configuration — Hoplytics Theme.
 *
 * Produces minified CSS/JS bundles in `dist/` with content-hashed filenames
 * for cache-busting. A manifest.json maps source → hashed filenames for
 * PHP-side asset resolution.
 */

import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
    // Dev server for preview
    server: {
        port: 3000,
        open: '/preview.html',
    },
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        manifest: true,          // Generates dist/.vite/manifest.json
        sourcemap: true,         // Source maps for debugging
        rollupOptions: {
            input: {
                // CSS entrypoints
                main: path.resolve(__dirname, 'assets/css/main.css'),
                variables: path.resolve(__dirname, 'assets/css/variables.css'),

                // JS entrypoints
                forms: path.resolve(__dirname, 'assets/js/forms.js'),
                darkMode: path.resolve(__dirname, 'assets/js/dark-mode-toggle.js'),
                freeTools: path.resolve(__dirname, 'assets/js/free-tools.js'),
                animations: path.resolve(__dirname, 'assets/js/animations.js'),
                freeToolsCss: path.resolve(__dirname, 'assets/css/free-tools.css'),
                designSystem: path.resolve(__dirname, 'assets/css/design-system.css'),
                contactForm: path.resolve(__dirname, 'assets/css/contact-form.css'),
                headerNav: path.resolve(__dirname, 'assets/css/header-nav.css'),
            },
            output: {
                // Hashed filenames for cache-busting
                entryFileNames: 'js/[name]-[hash].js',
                chunkFileNames: 'js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name?.endsWith('.css')) {
                        return 'css/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
        // Minification
        cssMinify: true,
        minify: 'esbuild',
    },
    css: {
        devSourcemap: true,
    },
});
