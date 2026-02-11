<?php
/**
 * Analytics Dashboard — Admin page for leads, tool usage, and performance stats.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Register the admin dashboard page.
 */
function hoplytics_register_dashboard_page(): void
{
    add_menu_page(
        __('Hoplytics Dashboard', 'hoplytics'),
        __('Hoplytics', 'hoplytics'),
        'manage_options',
        'hoplytics-dashboard',
        'hoplytics_render_dashboard',
        'dashicons-chart-line',
        3
    );
}
add_action('admin_menu', 'hoplytics_register_dashboard_page');

/**
 * Enqueue dashboard admin styles.
 */
function hoplytics_dashboard_styles(string $hook): void
{
    if ($hook !== 'toplevel_page_hoplytics-dashboard')
        return;

    wp_enqueue_style('hoplytics-dashboard', get_template_directory_uri() . '/assets/css/admin-dashboard.css', [], '4.0.0');
}
add_action('admin_enqueue_scripts', 'hoplytics_dashboard_styles');

/**
 * Render the dashboard page.
 */
function hoplytics_render_dashboard(): void
{
    // Gather stats
    $total_leads = wp_count_posts('hoplytics_lead')->private ?? 0;
    $total_audits = wp_count_posts('site_audit')->private ?? 0;
    $total_case_studies = wp_count_posts('case_study')->publish ?? 0;

    // Leads this week
    $week_leads = new WP_Query([
        'post_type' => 'hoplytics_lead',
        'post_status' => 'private',
        'posts_per_page' => -1,
        'date_query' => [['after' => '1 week ago']],
        'fields' => 'ids',
    ]);
    $leads_this_week = $week_leads->found_posts;

    // Top sources
    $all_leads = get_posts([
        'post_type' => 'hoplytics_lead',
        'post_status' => 'private',
        'posts_per_page' => -1,
        'fields' => 'ids',
    ]);
    $sources = [];
    foreach ($all_leads as $lid) {
        $src = get_post_meta($lid, '_lead_source', true) ?: 'unknown';
        $sources[$src] = ($sources[$src] ?? 0) + 1;
    }
    arsort($sources);

    // Average lead score
    $total_score = 0;
    foreach ($all_leads as $lid) {
        $total_score += (int) get_post_meta($lid, '_lead_score', true);
    }
    $avg_score = count($all_leads) > 0 ? round($total_score / count($all_leads)) : 0;

    // Recent leads (last 10)
    $recent_leads = get_posts([
        'post_type' => 'hoplytics_lead',
        'post_status' => 'private',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    // Top services requested
    $services = [];
    foreach ($all_leads as $lid) {
        $svc = get_post_meta($lid, '_lead_service', true);
        if ($svc) {
            $services[$svc] = ($services[$svc] ?? 0) + 1;
        }
    }
    arsort($services);

    ?>
    <div class="wrap hoplytics-dashboard">
        <h1>📊 Hoplytics Dashboard</h1>
        <p class="description">Real-time overview of leads, tool usage, and performance.</p>

        <div class="dashboard-grid">
            <!-- KPI Cards -->
            <div class="kpi-card">
                <div class="kpi-icon">👥</div>
                <div class="kpi-value">
                    <?php echo esc_html((string) $total_leads); ?>
                </div>
                <div class="kpi-label">Total Leads</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon">📈</div>
                <div class="kpi-value">
                    <?php echo esc_html((string) $leads_this_week); ?>
                </div>
                <div class="kpi-label">Leads This Week</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon">🎯</div>
                <div class="kpi-value">
                    <?php echo esc_html((string) $avg_score); ?>
                </div>
                <div class="kpi-label">Avg Lead Score</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon">🔍</div>
                <div class="kpi-value">
                    <?php echo esc_html((string) $total_audits); ?>
                </div>
                <div class="kpi-label">Site Audits Run</div>
            </div>
        </div>

        <div class="dashboard-panels">
            <!-- Recent Leads -->
            <div class="panel panel-wide">
                <h2>🔥 Recent Leads</h2>
                <table class="wp-list-table widefat striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Source</th>
                            <th>Service</th>
                            <th>Score</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_leads as $lead): ?>
                            <tr>
                                <td><strong>
                                        <?php echo esc_html(get_the_title($lead)); ?>
                                    </strong></td>
                                <td><a href="mailto:<?php echo esc_attr(get_post_meta($lead->ID, '_lead_email', true)); ?>">
                                        <?php echo esc_html(get_post_meta($lead->ID, '_lead_email', true)); ?>
                                    </a></td>
                                <td><span class="source-badge">
                                        <?php echo esc_html(get_post_meta($lead->ID, '_lead_source', true)); ?>
                                    </span></td>
                                <td>
                                    <?php echo esc_html(get_post_meta($lead->ID, '_lead_service', true) ?: '—'); ?>
                                </td>
                                <td><strong>
                                        <?php echo esc_html(get_post_meta($lead->ID, '_lead_score', true)); ?>
                                    </strong></td>
                                <td>
                                    <?php echo esc_html(get_the_date('M j, g:i A', $lead)); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recent_leads)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:2rem;color:#999">No leads yet. Share your free
                                    tools to start capturing leads!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Lead Sources -->
            <div class="panel">
                <h2>📡 Lead Sources</h2>
                <?php if ($sources): ?>
                    <ul class="source-list">
                        <?php foreach (array_slice($sources, 0, 6) as $source => $count): ?>
                            <li>
                                <span class="source-name">
                                    <?php echo esc_html(ucwords(str_replace('_', ' ', $source))); ?>
                                </span>
                                <span class="source-count">
                                    <?php echo esc_html((string) $count); ?>
                                </span>
                                <div class="source-bar">
                                    <div class="source-fill"
                                        style="width: <?php echo esc_attr((string) round(($count / max(array_values($sources))) * 100)); ?>%">
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="color:#999;text-align:center;padding:1rem">No data yet</p>
                <?php endif; ?>
            </div>

            <!-- Services Breakdown -->
            <div class="panel">
                <h2>🎯 Services Requested</h2>
                <?php if ($services): ?>
                    <ul class="source-list">
                        <?php foreach (array_slice($services, 0, 6) as $svc => $count): ?>
                            <li>
                                <span class="source-name">
                                    <?php echo esc_html(ucwords(str_replace(['_', '-'], ' ', $svc))); ?>
                                </span>
                                <span class="source-count">
                                    <?php echo esc_html((string) $count); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="color:#999;text-align:center;padding:1rem">No data yet</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="dashboard-footer">
            <p>Hoplytics v4.0 — <a href="<?php echo esc_url(admin_url('edit.php?post_type=hoplytics_lead')); ?>">View
                    All Leads</a> · <a href="<?php echo esc_url(admin_url('edit.php?post_type=site_audit')); ?>">View
                    All Audits</a> · <a href="<?php echo esc_url(admin_url('edit.php?post_type=case_study')); ?>">Case
                    Studies</a></p>
        </div>
    </div>
    <?php
}
