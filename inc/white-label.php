<?php
/**
 * White Labeling functions.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Custom Login Logo
 */
function hoplytics_login_logo(): void
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo esc_url(hoplytics_get_local_logo_url()); ?>);
            height: 80px;
            width: 300px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'hoplytics_login_logo');

/**
 * Change Login Logo URL
 */
function hoplytics_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'hoplytics_login_logo_url');

/**
 * Remove WordPress Dashboard Widgets
 */
function hoplytics_remove_dashboard_widgets()
{
    remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress.com Blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'side'); // Other WordPress News
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Press
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); // Recent Drafts
}
add_action('wp_dashboard_setup', 'hoplytics_remove_dashboard_widgets');

/**
 * Remove Welcome Panel
 */
remove_action('welcome_panel', 'wp_welcome_panel');

/**
 * Add Custom Dashboard Widget
 */
function hoplytics_add_dashboard_widgets()
{
    wp_add_dashboard_widget(
        'hoplytics_dashboard_widget', // Widget slug.
        'Welcome to Your Agency Dashboard', // Title.
        'hoplytics_dashboard_widget_function' // Display function.
    );
}
add_action('wp_dashboard_setup', 'hoplytics_add_dashboard_widgets');

/**
 * Render Custom Dashboard Widget
 */
function hoplytics_dashboard_widget_function()
{
    echo '<p>' . esc_html__('Welcome to your high-performance agency website. Manage your portfolio, services, and leads from the sidebar.', 'hoplytics') . '</p>';
    echo '<a href="' . esc_url(admin_url('edit.php?post_type=project')) . '" class="button button-primary">' . esc_html__('Manage Projects', 'hoplytics') . '</a> ';
    echo '<a href="' . esc_url(admin_url('edit.php?post_type=service')) . '" class="button">' . esc_html__('Manage Services', 'hoplytics') . '</a>';
}

/**
 * Custom Admin Footer Text
 */
function hoplytics_admin_footer_text()
{
    echo wp_kses_post('Powered by <a href="https://hoplytics.com" target="_blank" rel="noopener noreferrer">Hoplytics AgencyOS</a>.');
}
add_filter('admin_footer_text', 'hoplytics_admin_footer_text');
