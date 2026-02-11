<?php
/**
 * Hoplytics functions and definitions
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Runtime PHP version guard.
 * Prevents fatal errors on hosts running PHP < 8.2 where enum syntax is unsupported.
 * The style.css "Requires PHP" header handles WP activation, but this catches edge cases.
 */
if (version_compare(PHP_VERSION, '8.2', '<')) {
	add_action('admin_notices', function (): void {
		$message = sprintf(
			/* translators: 1: Required PHP version 2: Current PHP version */
			__('<strong>Hoplytics</strong> requires PHP %1$s or higher. You are running PHP %2$s. Please upgrade your hosting.', 'hoplytics'),
			'8.2',
			PHP_VERSION
		);
		echo '<div class="notice notice-error"><p>' . wp_kses_post($message) . '</p></div>';
	});

	// Switch to a default theme to avoid a broken site
	switch_theme(WP_DEFAULT_THEME);
	return;
}

if (!defined('HOPLYTICS_VERSION')) {
	define('HOPLYTICS_VERSION', '3.1.0');
}

/**
 * Style Kit Enum — PHP 8.1+ backed enum for theme design presets.
 */
enum StyleKit: string
{
	case TechFuturist = 'tech-futurist';
	case CorporateStabilizer = 'corporate-stabilizer';
	case CreativeDisruptor = 'creative-disruptor';

	public function label(): string
	{
		return match ($this) {
			self::TechFuturist => __('Tech-Futurist (Dark, Neon)', 'hoplytics'),
			self::CorporateStabilizer => __('Corporate-Stabilizer (Clean, Muted)', 'hoplytics'),
			self::CreativeDisruptor => __('Creative-Disruptor (Bold, Kinetic)', 'hoplytics'),
		};
	}

	/**
	 * Get all kits as value => label array for Customizer.
	 *
	 * @return array<string, string>
	 */
	public static function choices(): array
	{
		$choices = [];
		foreach (self::cases() as $kit) {
			$choices[$kit->value] = $kit->label();
		}
		return $choices;
	}

	/**
	 * Sanitize callback for Customizer — validates against enum values.
	 */
	public static function sanitize(string $value): string
	{
		$kit = self::tryFrom($value);
		return $kit?->value ?? self::TechFuturist->value;
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

// Page Patterns (Service pages)
require $theme_dir . '/inc/page-patterns.php';

// Lead Capture & CRM
require $theme_dir . '/inc/lead-capture.php';

// Case Studies & Portfolio
require $theme_dir . '/inc/cpt-case-study.php';

// Analytics Dashboard
require $theme_dir . '/inc/admin-dashboard.php';
