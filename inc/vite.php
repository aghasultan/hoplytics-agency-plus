<?php
/**
 * Vite Asset Helper — loads hashed assets from manifest.json in production,
 * raw assets in development.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Check if `dist/.vite/manifest.json` exists (i.e., production build).
 */
function hoplytics_is_production(): bool
{
    return file_exists(get_template_directory() . '/dist/.vite/manifest.json');
}

/**
 * Read and cache the Vite manifest.
 *
 * @return array<string, array{file: string, css?: string[], isEntry?: bool}>
 */
function hoplytics_vite_manifest(): array
{
    static $manifest = null;

    if ($manifest !== null) {
        return $manifest;
    }

    $path = get_template_directory() . '/dist/.vite/manifest.json';

    if (!file_exists($path)) {
        return $manifest = [];
    }

    $contents = file_get_contents($path);
    $manifest = $contents ? json_decode($contents, true, 512, JSON_THROW_ON_ERROR) : [];

    return $manifest;
}

/**
 * Enqueue a CSS file — uses hashed dist version in production, raw source in dev.
 *
 * @param string   $handle   WP enqueue handle.
 * @param string   $src      Source path relative to theme root (e.g., 'assets/css/main.css').
 * @param string[] $deps     Dependencies.
 */
function hoplytics_enqueue_style(string $handle, string $src, array $deps = []): void
{
    if (hoplytics_is_production()) {
        $manifest = hoplytics_vite_manifest();
        if (isset($manifest[$src])) {
            $url = get_template_directory_uri() . '/dist/' . $manifest[$src]['file'];
            wp_enqueue_style($handle, $url, $deps, null);
            return;
        }
    }

    // Development: load raw source
    wp_enqueue_style($handle, get_template_directory_uri() . '/' . $src, $deps, HOPLYTICS_VERSION);
}

/**
 * Enqueue a JS file — uses hashed dist version in production, raw source in dev.
 *
 * @param string   $handle    WP enqueue handle.
 * @param string   $src       Source path relative to theme root (e.g., 'assets/js/forms.js').
 * @param string[] $deps      Dependencies.
 * @param bool     $in_footer Load in footer.
 */
function hoplytics_enqueue_script(string $handle, string $src, array $deps = [], bool $in_footer = true): void
{
    if (hoplytics_is_production()) {
        $manifest = hoplytics_vite_manifest();
        if (isset($manifest[$src])) {
            $url = get_template_directory_uri() . '/dist/' . $manifest[$src]['file'];
            wp_enqueue_script($handle, $url, $deps, null, $in_footer);
            return;
        }
    }

    // Development: load raw source
    wp_enqueue_script($handle, get_template_directory_uri() . '/' . $src, $deps, HOPLYTICS_VERSION, $in_footer);
}
