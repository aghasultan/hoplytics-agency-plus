<?php
/**
 * Editorial Calendar — Admin page for planning monthly content.
 *
 * Adds a top-level "Editorial Calendar" admin menu with a 12-month
 * content plan view. Stores the plan as a WordPress option.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

// ────────────────────────────────────────────────────────────────
//  ADMIN MENU & PAGE
// ────────────────────────────────────────────────────────────────

function hoplytics_editorial_menu(): void
{
    add_menu_page(
        __('Editorial Calendar', 'hoplytics'),
        __('Editorial', 'hoplytics'),
        'edit_posts',
        'hoplytics-editorial',
        'hoplytics_editorial_page',
        'dashicons-calendar-alt',
        27 // After "Comments"
    );
}
add_action('admin_menu', 'hoplytics_editorial_menu');

// ────────────────────────────────────────────────────────────────
//  SAVE HANDLER
// ────────────────────────────────────────────────────────────────

function hoplytics_editorial_save(): void
{
    if (
        !isset($_POST['hoplytics_editorial_nonce']) ||
        !wp_verify_nonce(sanitize_text_field($_POST['hoplytics_editorial_nonce']), 'hoplytics_save_editorial')
    ) {
        return;
    }

    if (!current_user_can('edit_posts')) {
        return;
    }

    $plan = [];

    if (isset($_POST['editorial']) && is_array($_POST['editorial'])) {
        foreach ($_POST['editorial'] as $month_key => $entries) {
            $month_key = sanitize_text_field($month_key);
            $plan[$month_key] = [];

            if (!is_array($entries)) {
                continue;
            }

            foreach ($entries as $entry) {
                $title  = sanitize_text_field($entry['title'] ?? '');
                $type   = sanitize_text_field($entry['type'] ?? 'blog');
                $status = sanitize_text_field($entry['status'] ?? 'idea');
                $owner  = sanitize_text_field($entry['owner'] ?? '');

                if (empty($title)) {
                    continue;
                }

                $plan[$month_key][] = [
                    'title'  => $title,
                    'type'   => $type,
                    'status' => $status,
                    'owner'  => $owner,
                ];
            }
        }
    }

    update_option('hoplytics_editorial_plan', $plan);

    add_action('admin_notices', function () {
        echo '<div class="notice notice-success is-dismissible"><p>✅ Editorial calendar saved!</p></div>';
    });
}
add_action('admin_init', 'hoplytics_editorial_save');

// ────────────────────────────────────────────────────────────────
//  DEFAULT PLAN SEEDER
// ────────────────────────────────────────────────────────────────

function hoplytics_get_default_editorial_plan(): array
{
    $months = [];
    $current_month = (int) date('n');
    $current_year  = (int) date('Y');

    $templates = [
        [
            ['title' => 'SEO Quick Wins for Small Businesses', 'type' => 'blog', 'status' => 'idea', 'owner' => ''],
            ['title' => 'Monthly Marketing Metrics Report', 'type' => 'case-study', 'status' => 'idea', 'owner' => ''],
            ['title' => 'Industry News Roundup', 'type' => 'newsletter', 'status' => 'idea', 'owner' => ''],
        ],
        [
            ['title' => 'Social Media Algorithm Updates', 'type' => 'blog', 'status' => 'idea', 'owner' => ''],
            ['title' => 'Client Spotlight: Campaign Results', 'type' => 'case-study', 'status' => 'idea', 'owner' => ''],
            ['title' => 'PPC Budget Guide', 'type' => 'guide', 'status' => 'idea', 'owner' => ''],
        ],
        [
            ['title' => 'Content Marketing Checklist', 'type' => 'blog', 'status' => 'idea', 'owner' => ''],
            ['title' => 'Free Tools Feature Announcement', 'type' => 'newsletter', 'status' => 'idea', 'owner' => ''],
            ['title' => 'Local SEO Best Practices', 'type' => 'guide', 'status' => 'idea', 'owner' => ''],
        ],
    ];

    for ($i = 0; $i < 12; $i++) {
        $month = (($current_month - 1 + $i) % 12) + 1;
        $year  = $current_year + (int) floor(($current_month - 1 + $i) / 12);
        $key   = sprintf('%d-%02d', $year, $month);

        $months[$key] = $templates[$i % 3];
    }

    return $months;
}

// ────────────────────────────────────────────────────────────────
//  RENDER PAGE
// ────────────────────────────────────────────────────────────────

function hoplytics_editorial_page(): void
{
    $plan = get_option('hoplytics_editorial_plan', null);

    if ($plan === null) {
        $plan = hoplytics_get_default_editorial_plan();
        update_option('hoplytics_editorial_plan', $plan);
    }

    $content_types = [
        'blog'       => ['label' => 'Blog Post', 'color' => '#3B82F6'],
        'case-study' => ['label' => 'Case Study', 'color' => '#10B981'],
        'guide'      => ['label' => 'Guide', 'color' => '#8B5CF6'],
        'newsletter' => ['label' => 'Newsletter', 'color' => '#F59E0B'],
        'video'      => ['label' => 'Video', 'color' => '#EF4444'],
        'social'     => ['label' => 'Social', 'color' => '#EC4899'],
    ];

    $statuses = [
        'idea'        => ['label' => 'Idea', 'color' => '#6B7280'],
        'in-progress' => ['label' => 'In Progress', 'color' => '#F59E0B'],
        'review'      => ['label' => 'Review', 'color' => '#3B82F6'],
        'published'   => ['label' => 'Published', 'color' => '#10B981'],
    ];

    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:0.5rem">
            📅 Editorial Calendar
            <span style="font-size:0.8rem;font-weight:400;color:#6B7280;margin-left:0.5rem">
                12-month content plan
            </span>
        </h1>

        <form method="post">
            <?php wp_nonce_field('hoplytics_save_editorial', 'hoplytics_editorial_nonce'); ?>

            <!-- Legend -->
            <div style="display:flex;gap:1rem;flex-wrap:wrap;margin:1.5rem 0;padding:1rem;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px">
                <strong style="margin-right:0.5rem">Types:</strong>
                <?php foreach ($content_types as $key => $type) : ?>
                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:0.85rem">
                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:<?php echo esc_attr($type['color']); ?>"></span>
                        <?php echo esc_html($type['label']); ?>
                    </span>
                <?php endforeach; ?>
                <span style="color:#e5e7eb">|</span>
                <strong>Status:</strong>
                <?php foreach ($statuses as $skey => $status) : ?>
                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:0.85rem">
                        <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:<?php echo esc_attr($status['color']); ?>"></span>
                        <?php echo esc_html($status['label']); ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:1rem;margin-top:1rem">
                <?php
                foreach ($plan as $month_key => $entries) :
                    $display_date = DateTime::createFromFormat('Y-m', $month_key);
                    $month_label = $display_date ? $display_date->format('F Y') : $month_key;
                    $is_current = $month_key === date('Y-m');
                ?>
                    <div style="background:#fff;border:1px solid <?php echo $is_current ? '#3B82F6' : '#e5e7eb'; ?>;border-radius:12px;padding:1.25rem;<?php echo $is_current ? 'box-shadow:0 0 0 2px rgba(59,130,246,0.2);' : ''; ?>">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
                            <h3 style="margin:0;font-size:1rem;font-weight:700">
                                <?php if ($is_current) : ?><span style="background:#3B82F6;color:#fff;padding:2px 8px;border-radius:4px;font-size:0.7rem;margin-right:6px">NOW</span><?php endif; ?>
                                <?php echo esc_html($month_label); ?>
                            </h3>
                            <span style="font-size:0.8rem;color:#6B7280"><?php echo count($entries); ?> items</span>
                        </div>

                        <div class="editorial-entries" data-month="<?php echo esc_attr($month_key); ?>">
                            <?php foreach ($entries as $idx => $entry) : ?>
                                <div class="editorial-entry" style="display:flex;gap:0.5rem;align-items:flex-start;margin-bottom:0.75rem;padding:0.75rem;background:#f9fafb;border-radius:8px;border:1px solid #f3f4f6">
                                    <div style="flex:1;display:flex;flex-direction:column;gap:0.4rem">
                                        <input type="text"
                                            name="editorial[<?php echo esc_attr($month_key); ?>][<?php echo $idx; ?>][title]"
                                            value="<?php echo esc_attr($entry['title']); ?>"
                                            placeholder="Content title..."
                                            style="border:1px solid #e5e7eb;border-radius:6px;padding:6px 8px;font-size:0.85rem;width:100%">
                                        <div style="display:flex;gap:0.4rem">
                                            <select name="editorial[<?php echo esc_attr($month_key); ?>][<?php echo $idx; ?>][type]"
                                                style="border:1px solid #e5e7eb;border-radius:6px;padding:4px 6px;font-size:0.8rem;flex:1">
                                                <?php foreach ($content_types as $tkey => $tval) : ?>
                                                    <option value="<?php echo esc_attr($tkey); ?>" <?php selected($entry['type'], $tkey); ?>>
                                                        <?php echo esc_html($tval['label']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <select name="editorial[<?php echo esc_attr($month_key); ?>][<?php echo $idx; ?>][status]"
                                                style="border:1px solid #e5e7eb;border-radius:6px;padding:4px 6px;font-size:0.8rem;flex:1">
                                                <?php foreach ($statuses as $skey2 => $sval) : ?>
                                                    <option value="<?php echo esc_attr($skey2); ?>" <?php selected($entry['status'], $skey2); ?>>
                                                        <?php echo esc_html($sval['label']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <input type="text"
                                            name="editorial[<?php echo esc_attr($month_key); ?>][<?php echo $idx; ?>][owner]"
                                            value="<?php echo esc_attr($entry['owner']); ?>"
                                            placeholder="Assigned to..."
                                            style="border:1px solid #e5e7eb;border-radius:6px;padding:4px 8px;font-size:0.8rem;width:100%">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="button" class="add-entry-btn"
                            data-month="<?php echo esc_attr($month_key); ?>"
                            style="background:none;border:1px dashed #d1d5db;border-radius:8px;padding:0.5rem;width:100%;cursor:pointer;color:#6B7280;font-size:0.8rem;transition:all 0.2s"
                            onmouseover="this.style.borderColor='#3B82F6';this.style.color='#3B82F6'"
                            onmouseout="this.style.borderColor='#d1d5db';this.style.color='#6B7280'">
                            + Add Content
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-top:2rem;display:flex;gap:1rem;align-items:center">
                <?php submit_button(__('Save Calendar', 'hoplytics'), 'primary', 'submit', false); ?>
                <span style="color:#6B7280;font-size:0.85rem">💡 Tip: Plan 3-4 pieces per month for consistent growth.</span>
            </div>
        </form>
    </div>

    <script>
    (function() {
        document.querySelectorAll('.add-entry-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const month = this.dataset.month;
                const container = this.previousElementSibling;
                const idx = container.children.length;

                const html = `
                    <div class="editorial-entry" style="display:flex;gap:0.5rem;align-items:flex-start;margin-bottom:0.75rem;padding:0.75rem;background:#f9fafb;border-radius:8px;border:1px solid #f3f4f6">
                        <div style="flex:1;display:flex;flex-direction:column;gap:0.4rem">
                            <input type="text"
                                name="editorial[${month}][${idx}][title]"
                                value=""
                                placeholder="Content title..."
                                style="border:1px solid #e5e7eb;border-radius:6px;padding:6px 8px;font-size:0.85rem;width:100%">
                            <div style="display:flex;gap:0.4rem">
                                <select name="editorial[${month}][${idx}][type]"
                                    style="border:1px solid #e5e7eb;border-radius:6px;padding:4px 6px;font-size:0.8rem;flex:1">
                                    <option value="blog">Blog Post</option>
                                    <option value="case-study">Case Study</option>
                                    <option value="guide">Guide</option>
                                    <option value="newsletter">Newsletter</option>
                                    <option value="video">Video</option>
                                    <option value="social">Social</option>
                                </select>
                                <select name="editorial[${month}][${idx}][status]"
                                    style="border:1px solid #e5e7eb;border-radius:6px;padding:4px 6px;font-size:0.8rem;flex:1">
                                    <option value="idea">Idea</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="review">Review</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            <input type="text"
                                name="editorial[${month}][${idx}][owner]"
                                value=""
                                placeholder="Assigned to..."
                                style="border:1px solid #e5e7eb;border-radius:6px;padding:4px 8px;font-size:0.8rem;width:100%">
                        </div>
                    </div>`;

                container.insertAdjacentHTML('beforeend', html);

                // Focus the new title input
                const newInput = container.lastElementChild.querySelector('input[type="text"]');
                if (newInput) newInput.focus();
            });
        });
    })();
    </script>
    <?php
}
