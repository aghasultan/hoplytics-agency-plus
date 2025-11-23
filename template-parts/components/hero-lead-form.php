<?php
/**
 * Component: Hero Lead Form
 *
 * A high-converting, glassmorphic lead generation form.
 * Replaces standard hero visuals for maximum ROI.
 * Multi-step implementation.
 *
 * @package Hoplytics
 */
?>
<div class="hero-lead-form-wrapper">
    <div class="hero-card">
        <div class="hero-card-header">
            <h3 class="hero-card-title"><?php esc_html_e('Get Your Free Growth Plan', 'hoplytics'); ?></h3>
            <p class="hero-card-subtitle"><?php esc_html_e('See exactly how we can scale your revenue.', 'hoplytics'); ?></p>
        </div>

        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="hero-form multi-step-form">
            <input type="hidden" name="action" value="hoplytics_hero_lead">
            <?php wp_nonce_field( 'hero_lead_form', 'hero_nonce' ); ?>

            <!-- Step 1 -->
            <div class="form-step" id="step-1">
                <div class="form-group">
                    <label for="hero-website"><?php esc_html_e('Website URL', 'hoplytics'); ?></label>
                    <input type="url" id="hero-website" name="website" placeholder="https://company.com" required>
                </div>
                <button type="button" class="btn btn-primary btn-block btn-glow next-step" onclick="document.getElementById('step-1').style.display='none'; document.getElementById('step-2').style.display='block';">
                    <?php esc_html_e('Next', 'hoplytics'); ?>
                </button>
            </div>

            <!-- Step 2 -->
            <div class="form-step" id="step-2" style="display:none;">
                <div class="form-group">
                    <label for="hero-name"><?php esc_html_e('Full Name', 'hoplytics'); ?></label>
                    <input type="text" id="hero-name" name="name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label for="hero-email"><?php esc_html_e('Work Email', 'hoplytics'); ?></label>
                    <input type="email" id="hero-email" name="email" placeholder="john@company.com" required>
                </div>
                <div class="form-group">
                    <label for="hero-service"><?php esc_html_e('I need help with...', 'hoplytics'); ?></label>
                    <select id="hero-service" name="service">
                        <option value="paid_ads"><?php esc_html_e('Paid Advertising (PPC/Social)', 'hoplytics'); ?></option>
                        <option value="seo"><?php esc_html_e('SEO & Organic Growth', 'hoplytics'); ?></option>
                        <option value="content"><?php esc_html_e('Content Marketing', 'hoplytics'); ?></option>
                        <option value="cro"><?php esc_html_e('Conversion Optimization', 'hoplytics'); ?></option>
                        <option value="full_stack"><?php esc_html_e('Full Stack Growth', 'hoplytics'); ?></option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-glow">
                    <?php esc_html_e('Get My Free Plan', 'hoplytics'); ?>
                </button>
                <button type="button" class="btn btn-link btn-block btn-sm text-muted" onclick="document.getElementById('step-2').style.display='none'; document.getElementById('step-1').style.display='block';">
                    <?php esc_html_e('Back', 'hoplytics'); ?>
                </button>
            </div>

            <div class="form-footer">
                <?php esc_html_e('No credit card required. 100% free audit.', 'hoplytics'); ?>
            </div>
        </form>
    </div>
</div>
