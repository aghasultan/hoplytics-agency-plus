<?php
/**
 * Hoplytics functions and definitions
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

if (!defined('HOPLYTICS_VERSION')) {
	define('HOPLYTICS_VERSION', '3.1.0');
}

/**
 * Style Kit — PHP 7.4+ compatible class for theme design presets.
 */
class StyleKit
{
	const TECH_FUTURIST = 'tech-futurist';
	const CORPORATE_STABILIZER = 'corporate-stabilizer';
	const CREATIVE_DISRUPTOR = 'creative-disruptor';

	/**
	 * Get label for a kit value.
	 *
	 * @param string $value
	 * @return string
	 */
	public static function label(string $value): string
	{
		$labels = [
			self::TECH_FUTURIST => __('Tech-Futurist (Dark, Neon)', 'hoplytics'),
			self::CORPORATE_STABILIZER => __('Corporate-Stabilizer (Clean, Muted)', 'hoplytics'),
			self::CREATIVE_DISRUPTOR => __('Creative-Disruptor (Bold, Kinetic)', 'hoplytics'),
		];
		return $labels[$value] ?? $labels[self::TECH_FUTURIST];
	}

	/**
	 * Get all kits as value => label array for Customizer.
	 *
	 * @return array<string, string>
	 */
	public static function choices(): array
	{
		return [
			self::TECH_FUTURIST => self::label(self::TECH_FUTURIST),
			self::CORPORATE_STABILIZER => self::label(self::CORPORATE_STABILIZER),
			self::CREATIVE_DISRUPTOR => self::label(self::CREATIVE_DISRUPTOR),
		];
	}

	/**
	 * Sanitize callback for Customizer — validates against known values.
	 *
	 * @param string $value
	 * @return string
	 */
	public static function sanitize(string $value): string
	{
		$valid = [self::TECH_FUTURIST, self::CORPORATE_STABILIZER, self::CREATIVE_DISRUPTOR];
		return in_array($value, $valid, true) ? $value : self::TECH_FUTURIST;
	}
}

/**
 * Helper to get the site logo URL (Customizer or Fallback).
 */
function hoplytics_get_logo_url(): string
{
	$custom_logo_id = get_theme_mod('custom_logo');
	if ($custom_logo_id) {
		$image = wp_get_attachment_image_src($custom_logo_id, 'full');
		if (is_array($image)) {
			return $image[0];
		}
	}
	return get_template_directory_uri() . '/assets/images/logo-horizontal.png';
}

/**
 * @deprecated Use hoplytics_get_logo_url() instead.
 */
function hoplytics_get_local_logo_url(): string
{
	return hoplytics_get_logo_url();
}

// --- Core Module Includes ---

$theme_dir = get_template_directory();

require $theme_dir . '/inc/vite.php';
require $theme_dir . '/inc/setup.php';
require $theme_dir . '/inc/enqueue.php';
require $theme_dir . '/inc/white-label.php';
require $theme_dir . '/inc/customizer.php';
require $theme_dir . '/inc/custom-post-types.php';
require $theme_dir . '/inc/cpt-testimonials.php';
require $theme_dir . '/inc/seo.php';
require $theme_dir . '/inc/template-functions.php';

// CRO Modules
require $theme_dir . '/inc/modules/roi-calculator.php';
require $theme_dir . '/inc/modules/seo-audit.php';
require $theme_dir . '/inc/modules/hero-form-handler.php';
require $theme_dir . '/inc/modules/device-frame.php';
require $theme_dir . '/inc/modules/demo-content-seeder.php';

// Modern WordPress APIs (v3.1+)
require $theme_dir . '/inc/block-bindings.php';
require $theme_dir . '/inc/performance.php';
require $theme_dir . '/inc/rest-api.php';

// Block Editor Enhancements
require $theme_dir . '/inc/block-styles.php';
require $theme_dir . '/inc/block-variations.php';

// WP-CLI Commands
require $theme_dir . '/inc/cli.php';

// Free Tools (Website Audit, Pixel Checker, SEO Score)
require $theme_dir . '/inc/tools-api.php';
require $theme_dir . '/inc/cpt-site-audit.php';

// SEO Infrastructure
require $theme_dir . '/inc/structured-data.php';
require $theme_dir . '/inc/seo-meta.php';
require $theme_dir . '/inc/sitemap.php';

// Page Patterns (Service pages)
require $theme_dir . '/inc/page-patterns.php';

// Lead Capture & CRM
require $theme_dir . '/inc/lead-capture.php';

// Case Studies & Portfolio
require $theme_dir . '/inc/cpt-case-study.php';

// Analytics Dashboard
require $theme_dir . '/inc/admin-dashboard.php';
