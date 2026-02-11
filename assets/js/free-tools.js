/**
 * Free Tools Frontend — handles all tool UIs (audit, pixel check, SEO score).
 *
 * Uses fetch() to POST to REST API endpoints and renders results dynamically.
 *
 * @package Hoplytics
 */

(function () {
    'use strict';

    const API_BASE = window.hoplyticsApi?.restUrl || '/wp-json/hoplytics/v1';
    const NONCE = window.hoplyticsApi?.nonce || '';

    // ─── Utility Functions ───

    function $(sel, ctx = document) { return ctx.querySelector(sel); }
    function $$(sel, ctx = document) { return ctx.querySelectorAll(sel); }

    function getGradeColor(grade) {
        return { A: '#10B981', B: '#3B82F6', C: '#F59E0B', D: '#F97316', F: '#EF4444' }[grade] || '#6B7280';
    }

    function getStatusIcon(status) {
        return { pass: '✅', warning: '⚠️', critical: '❌', info: 'ℹ️' }[status] || '•';
    }

    function animateCounter(el, target, duration = 1500) {
        const start = 0;
        const startTime = performance.now();
        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(start + (target - start) * eased);
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    }

    async function postTool(endpoint, url) {
        const res = await fetch(`${API_BASE}/${endpoint}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': NONCE,
            },
            body: JSON.stringify({ url }),
        });
        return res.json();
    }

    // ─── Website Audit Tool ───

    function initAuditTool(container) {
        const form = $('form', container);
        const input = $('input[name="url"]', container);
        const results = $('.tool-results', container);
        const loading = $('.tool-loading', container);

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const url = input.value.trim();
            if (!url) return;

            loading.hidden = false;
            results.hidden = true;
            results.innerHTML = '';

            try {
                const data = await postTool('audit', url);

                if (!data.success) {
                    results.innerHTML = `<div class="tool-error">${data.message}</div>`;
                    results.hidden = false;
                    loading.hidden = true;
                    return;
                }

                results.innerHTML = renderAuditResults(data);
                results.hidden = false;
                loading.hidden = true;

                // Animate the score counter
                const scoreEl = $('.score-number', results);
                if (scoreEl) animateCounter(scoreEl, data.score);

            } catch (err) {
                results.innerHTML = '<div class="tool-error">Network error. Please try again.</div>';
                results.hidden = false;
                loading.hidden = true;
            }
        });
    }

    function renderAuditResults(data) {
        const gradeColor = getGradeColor(data.grade);

        let checksHtml = data.checks.map(check => `
			<div class="check-item check-${check.status}">
				<span class="check-icon">${getStatusIcon(check.status)}</span>
				<div class="check-details">
					<strong>${check.name}</strong>
					<span class="check-value">${check.value}</span>
					${check.detail ? `<span class="check-detail">${check.detail}</span>` : ''}
					${check.advice ? `<p class="check-advice">${check.advice}</p>` : ''}
				</div>
			</div>
		`).join('');

        return `
			<div class="audit-score-card">
				<div class="score-circle" style="--score-color: ${gradeColor}">
					<span class="score-number">0</span>
					<span class="score-label">/100</span>
				</div>
				<div class="score-grade" style="color: ${gradeColor}">Grade: ${data.grade}</div>
				<div class="score-summary">
					<span class="summary-critical">${data.summary.critical} Critical</span>
					<span class="summary-warning">${data.summary.warnings} Warnings</span>
					<span class="summary-pass">${data.summary.passed} Passed</span>
				</div>
			</div>
			<div class="audit-checks">${checksHtml}</div>
			<div class="audit-cta">
				<p>Want a professional to fix these issues?</p>
				<a href="/get-started" class="btn btn-primary">Get Expert Help →</a>
			</div>
		`;
    }

    // ─── Pixel Checker Tool ───

    function initPixelChecker(container) {
        const form = $('form', container);
        const input = $('input[name="url"]', container);
        const results = $('.tool-results', container);
        const loading = $('.tool-loading', container);

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const url = input.value.trim();
            if (!url) return;

            loading.hidden = false;
            results.hidden = true;

            try {
                const data = await postTool('pixel-check', url);

                if (!data.success) {
                    results.innerHTML = `<div class="tool-error">${data.message}</div>`;
                    results.hidden = false;
                    loading.hidden = true;
                    return;
                }

                results.innerHTML = renderPixelResults(data);
                results.hidden = false;
                loading.hidden = true;
            } catch (err) {
                results.innerHTML = '<div class="tool-error">Network error. Please try again.</div>';
                results.hidden = false;
                loading.hidden = true;
            }
        });
    }

    function renderPixelResults(data) {
        const detectedHtml = data.detected.map(t => `
			<div class="tracker-item tracker-found">
				<span class="tracker-icon">${t.icon}</span>
				<div class="tracker-info">
					<strong>${t.name}</strong>
					${t.id ? `<code class="tracker-id">${t.id}</code>` : ''}
				</div>
				<span class="tracker-badge badge-found">✅ Found</span>
			</div>
		`).join('');

        const missingHtml = data.missing.map(t => `
			<div class="tracker-item tracker-missing">
				<span class="tracker-icon">${t.icon}</span>
				<div class="tracker-info">
					<strong>${t.name}</strong>
					${t.guide_url ? `<a href="${t.guide_url}" class="tracker-guide">${t.guide_text}</a>` : ''}
				</div>
				<span class="tracker-badge badge-missing">❌ Not Found</span>
			</div>
		`).join('');

        const recsHtml = data.recommendations.length
            ? `<div class="pixel-recommendations">
				<h4>💡 Recommendations</h4>
				<ul>${data.recommendations.map(r => `<li>${r}</li>`).join('')}</ul>
			</div>`
            : '';

        return `
			<div class="pixel-summary">
				<div class="pixel-stat pixel-found">
					<span class="stat-number">${data.total_detected}</span>
					<span class="stat-label">Detected</span>
				</div>
				<div class="pixel-stat pixel-missing">
					<span class="stat-number">${data.total_missing}</span>
					<span class="stat-label">Missing</span>
				</div>
			</div>
			${detectedHtml ? `<h4>Tracking Pixels Found</h4>${detectedHtml}` : ''}
			${missingHtml ? `<h4>Not Detected</h4>${missingHtml}` : ''}
			${recsHtml}
			<div class="audit-cta">
				<p>Need help setting up tracking?</p>
				<a href="/get-started" class="btn btn-primary">Get Expert Setup →</a>
			</div>
		`;
    }

    // ─── SEO Score Tool ───

    function initSeoScore(container) {
        const form = $('form', container);
        const input = $('input[name="url"]', container);
        const results = $('.tool-results', container);
        const loading = $('.tool-loading', container);

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const url = input.value.trim();
            if (!url) return;

            loading.hidden = false;
            results.hidden = true;

            try {
                const data = await postTool('seo-score', url);

                if (!data.success) {
                    results.innerHTML = `<div class="tool-error">${data.message}</div>`;
                    results.hidden = false;
                    loading.hidden = true;
                    return;
                }

                results.innerHTML = renderSeoResults(data);
                results.hidden = false;
                loading.hidden = true;

                const scoreEl = $('.score-number', results);
                if (scoreEl) animateCounter(scoreEl, data.score);
            } catch (err) {
                results.innerHTML = '<div class="tool-error">Network error.</div>';
                results.hidden = false;
                loading.hidden = true;
            }
        });
    }

    function renderSeoResults(data) {
        const gradeColor = getGradeColor(data.grade);

        const itemsHtml = data.items.map(item => {
            const pct = item.max > 0 ? Math.round((item.score / item.max) * 100) : 0;
            const status = pct >= 80 ? 'pass' : (pct >= 50 ? 'warning' : 'critical');
            return `
				<div class="seo-item seo-${status}">
					<div class="seo-item-header">
						<span>${getStatusIcon(status)} <strong>${item.factor}</strong></span>
						<span class="seo-item-score">${item.score}/${item.max}</span>
					</div>
					<div class="seo-item-bar">
						<div class="seo-item-fill" style="width: ${pct}%; background: ${getGradeColor(pct >= 80 ? 'A' : (pct >= 50 ? 'C' : 'F'))}"></div>
					</div>
					<div class="seo-item-detail">
						<span>Current: ${item.current}</span>
						<span>Ideal: ${item.ideal}</span>
					</div>
				</div>
			`;
        }).join('');

        return `
			<div class="audit-score-card">
				<div class="score-circle" style="--score-color: ${gradeColor}">
					<span class="score-number">0</span>
					<span class="score-label">/100</span>
				</div>
				<div class="score-grade" style="color: ${gradeColor}">SEO Grade: ${data.grade}</div>
				<p class="score-words">${data.word_count.toLocaleString()} words analyzed</p>
			</div>
			<div class="seo-items">${itemsHtml}</div>
			<div class="audit-cta">
				<p>Want us to optimize your site's SEO?</p>
				<a href="/get-started" class="btn btn-primary">Get a Free SEO Consultation →</a>
			</div>
		`;
    }

    // ─── Speed Check Tool ───

    function initSpeedCheck(container) {
        const form = $('form', container);
        const input = $('input[name="url"]', container);
        const results = $('.tool-results', container);
        const loading = $('.tool-loading', container);

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const url = input.value.trim();
            if (!url) return;

            loading.hidden = false;
            results.hidden = true;

            try {
                const data = await postTool('speed-check', url);
                if (!data.success) {
                    results.innerHTML = `<div class="tool-error">${data.message}</div>`;
                } else {
                    results.innerHTML = renderSpeedResults(data);
                    const scoreEl = $('.score-number', results);
                    if (scoreEl) animateCounter(scoreEl, data.score);
                }
                results.hidden = false;
                loading.hidden = true;
            } catch (err) {
                results.innerHTML = '<div class="tool-error">Network error.</div>';
                results.hidden = false;
                loading.hidden = true;
            }
        });
    }

    function renderSpeedResults(data) {
        const gradeColor = getGradeColor(data.grade);
        const checksHtml = data.checks.map(c => `
            <div class="check-item check-${c.status}">
                <span class="check-icon">${getStatusIcon(c.status)}</span>
                <div class="check-details">
                    <strong>${c.name}</strong>
                    <span class="check-value">${c.value} <small style="color:#9CA3AF">(ideal: ${c.ideal})</small></span>
                    ${c.advice ? `<p class="check-advice">${c.advice}</p>` : ''}
                </div>
            </div>
        `).join('');

        return `
            <div class="audit-score-card">
                <div class="score-circle" style="--score-color: ${gradeColor}">
                    <span class="score-number">0</span>
                    <span class="score-label">/100</span>
                </div>
                <div class="score-grade" style="color: ${gradeColor}">${data.emoji} ${data.label}</div>
                <div class="score-summary">
                    <span>⏱ ${data.load_time}s</span>
                    <span>📦 ${data.page_size} KB</span>
                    <span>📁 ${data.resources.total} resources</span>
                </div>
            </div>
            <div class="audit-checks">${checksHtml}</div>
            <div class="audit-cta">
                <p>Want sub-2-second load times?</p>
                <a href="/services/web-development" class="btn btn-primary">Our Speed Optimization Service →</a>
            </div>
        `;
    }

    // ─── Social Check Tool ───

    function initSocialCheck(container) {
        const form = $('form', container);
        const input = $('input[name="url"]', container);
        const results = $('.tool-results', container);
        const loading = $('.tool-loading', container);

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const url = input.value.trim();
            if (!url) return;

            loading.hidden = false;
            results.hidden = true;

            try {
                const data = await postTool('social-check', url);
                if (!data.success) {
                    results.innerHTML = `<div class="tool-error">${data.message}</div>`;
                } else {
                    results.innerHTML = renderSocialResults(data);
                }
                results.hidden = false;
                loading.hidden = true;
            } catch (err) {
                results.innerHTML = '<div class="tool-error">Network error.</div>';
                results.hidden = false;
                loading.hidden = true;
            }
        });
    }

    function renderSocialResults(data) {
        const foundHtml = data.found.map(p => `
            <div class="tracker-item tracker-found">
                <span class="tracker-icon">${p.icon}</span>
                <div class="tracker-info">
                    <strong>${p.name}</strong>
                    ${p.url ? `<a href="${p.url}" target="_blank" class="tracker-guide">${p.url}</a>` : ''}
                </div>
                <span class="tracker-badge badge-found">✅ Linked</span>
            </div>
        `).join('');

        const missingHtml = data.missing.map(p => `
            <div class="tracker-item tracker-missing">
                <span class="tracker-icon">${p.icon}</span>
                <div class="tracker-info"><strong>${p.name}</strong></div>
                <span class="tracker-badge badge-missing">❌ Not Found</span>
            </div>
        `).join('');

        const extrasHtml = data.extras.map(e => `
            <div class="tracker-item ${e.found ? 'tracker-found' : 'tracker-missing'}">
                <span class="tracker-icon">${e.icon}</span>
                <div class="tracker-info"><strong>${e.name}</strong></div>
                <span class="tracker-badge ${e.found ? 'badge-found' : 'badge-missing'}">${e.found ? '✅' : '❌'}</span>
            </div>
        `).join('');

        const recsHtml = data.recommendations.length
            ? `<div class="pixel-recommendations"><h4>💡 Recommendations</h4><ul>${data.recommendations.map(r => `<li>${r}</li>`).join('')}</ul></div>`
            : '';

        return `
            <div class="pixel-summary">
                <div class="pixel-stat pixel-found">
                    <span class="stat-number">${data.platforms_found}</span>
                    <span class="stat-label">Platforms Found</span>
                </div>
                <div class="pixel-stat pixel-missing">
                    <span class="stat-number">${data.platforms_missing}</span>
                    <span class="stat-label">Missing</span>
                </div>
            </div>
            ${foundHtml ? `<h4>Social Profiles Found</h4>${foundHtml}` : ''}
            ${missingHtml ? `<h4>Not Detected</h4>${missingHtml}` : ''}
            ${extrasHtml ? `<h4>Content Marketing Signals</h4>${extrasHtml}` : ''}
            ${recsHtml}
            <div class="audit-cta">
                <p>Need help building your social presence?</p>
                <a href="/services/social-media-marketing" class="btn btn-primary">Social Media Services →</a>
            </div>
        `;
    }

    // ─── ROI Calculator Tool ───

    function initRoiCalculator(container) {
        const form = $('form', container);
        const results = $('.tool-results', container);
        const loading = $('.tool-loading', container);

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            loading.hidden = false;
            results.hidden = true;

            const formData = Object.fromEntries(new FormData(form));
            const payload = {
                monthly_spend: parseFloat(formData.monthly_spend) || 0,
                monthly_revenue: parseFloat(formData.monthly_revenue) || 0,
                conversion_rate: parseFloat(formData.conversion_rate) || 2.5,
                avg_deal_value: parseFloat(formData.avg_deal_value) || 500,
                monthly_traffic: parseInt(formData.monthly_traffic) || 1000,
                industry: formData.industry || 'general',
            };

            try {
                const res = await fetch(`${API_BASE}/roi-calculator`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': NONCE },
                    body: JSON.stringify(payload),
                });
                const data = await res.json();

                if (!data.success) {
                    results.innerHTML = `<div class="tool-error">${data.message || 'Error'}</div>`;
                } else {
                    results.innerHTML = renderRoiResults(data);
                }
                results.hidden = false;
                loading.hidden = true;
            } catch (err) {
                results.innerHTML = '<div class="tool-error">Network error.</div>';
                results.hidden = false;
                loading.hidden = true;
            }
        });
    }

    function renderRoiResults(data) {
        const fmt = n => '$' + Number(n).toLocaleString();
        const c = data.current;
        const p = data.projected;

        const insightsHtml = data.insights.map(i => `<li>${i}</li>`).join('');

        return `
            <div class="pixel-summary" style="margin-bottom:1.5rem">
                <div class="pixel-stat pixel-found">
                    <span class="stat-number">${c.roas}x</span>
                    <span class="stat-label">Current ROAS</span>
                </div>
                <div class="pixel-stat" style="background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(59,130,246,0.15));border-color:#10B981">
                    <span class="stat-number" style="color:#10B981">${p.roas}x</span>
                    <span class="stat-label">Projected ROAS</span>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem">
                <div class="is-style-card" style="padding:1.25rem;border-radius:12px">
                    <h4 style="margin:0 0 0.75rem;font-size:0.85rem;color:#9CA3AF;text-transform:uppercase">Current</h4>
                    <p>Revenue: <strong>${fmt(c.monthly_revenue)}/mo</strong></p>
                    <p>Leads: <strong>${c.leads}/mo</strong></p>
                    <p>CPA: <strong>${fmt(c.cpa)}</strong></p>
                    <p>ROI: <strong>${c.roi_percent}%</strong></p>
                </div>
                <div class="is-style-card" style="padding:1.25rem;border-radius:12px;border-color:#10B981">
                    <h4 style="margin:0 0 0.75rem;font-size:0.85rem;color:#10B981;text-transform:uppercase">Projected</h4>
                    <p>Revenue: <strong style="color:#10B981">${fmt(p.monthly_revenue)}/mo</strong></p>
                    <p>Leads: <strong style="color:#10B981">${p.leads}/mo</strong></p>
                    <p>CPA: <strong style="color:#10B981">${fmt(p.cpa)}</strong></p>
                    <p>ROI: <strong style="color:#10B981">${p.roi_percent}%</strong></p>
                </div>
            </div>
            <div class="is-style-card" style="padding:1.25rem;border-radius:12px;text-align:center;margin-bottom:1.5rem">
                <p style="color:#9CA3AF;margin:0 0 0.25rem;font-size:0.85rem">12-Month Revenue Gain</p>
                <p style="font-size:2rem;font-weight:800;color:#10B981;margin:0">${fmt(data.annual.gain)}</p>
            </div>
            ${insightsHtml ? `<div class="pixel-recommendations"><h4>📊 Insights</h4><ul>${insightsHtml}</ul></div>` : ''}
            <div class="audit-cta">
                <p>Want to achieve these numbers?</p>
                <a href="/get-started" class="btn btn-primary">Book Your Strategy Call →</a>
            </div>
        `;
    }

    // ─── Pricing Estimator Tool ───

    function initPricingEstimator(container) {
        const form = $('form', container);
        const results = $('.tool-results', container);
        const loading = $('.tool-loading', container);

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            loading.hidden = false;
            results.hidden = true;

            const formData = new FormData(form);
            const services = formData.getAll('services');
            const payload = {
                services,
                business_size: formData.get('business_size') || 'small',
                goals: formData.getAll('goals'),
                timeline: formData.get('timeline') || 'standard',
            };

            try {
                const res = await fetch(`${API_BASE}/pricing-estimate`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': NONCE },
                    body: JSON.stringify(payload),
                });
                const data = await res.json();

                if (!data.success) {
                    results.innerHTML = `<div class="tool-error">${data.message || 'Error'}</div>`;
                } else {
                    results.innerHTML = renderPricingResults(data);
                }
                results.hidden = false;
                loading.hidden = true;
            } catch (err) {
                results.innerHTML = '<div class="tool-error">Network error.</div>';
                results.hidden = false;
                loading.hidden = true;
            }
        });
    }

    function renderPricingResults(data) {
        const fmt = n => '$' + Number(n).toLocaleString();

        const itemsHtml = data.line_items.map(item => `
            <div class="tracker-item tracker-found" style="padding:0.75rem 1rem">
                <span class="tracker-icon">${item.icon}</span>
                <div class="tracker-info"><strong>${item.label}</strong></div>
                <span style="font-weight:600;color:var(--color-text)">${fmt(item.min)} – ${fmt(item.max)}/mo</span>
            </div>
        `).join('');

        const includedHtml = data.included.map(i => `<li>✅ ${i}</li>`).join('');

        return `
            <div class="audit-score-card" style="margin-bottom:1.5rem">
                <p style="color:#9CA3AF;margin:0 0 0.25rem;font-size:0.85rem;text-transform:uppercase">Estimated Monthly Investment</p>
                <div style="font-size:2rem;font-weight:800">
                    <span class="gradient-text">${fmt(data.total_min)} – ${fmt(data.total_max)}</span>
                </div>
                ${data.discount > 0 ? `<p style="color:#10B981;margin:0.5rem 0 0">🎉 ${data.discount}% bundle discount applied!</p>` : ''}
            </div>
            <h4>Service Breakdown</h4>
            ${itemsHtml}
            <div class="pixel-recommendations" style="margin-top:1.5rem">
                <h4>✅ What's Included</h4>
                <ul>${includedHtml}</ul>
            </div>
            <p style="color:#9CA3AF;font-size:0.85rem;font-style:italic;margin-top:1rem">${data.note}</p>
            <div class="audit-cta">
                <p>Ready for a custom proposal?</p>
                <a href="${data.cta_url}" class="btn btn-primary">Book Your Free Strategy Call →</a>
            </div>
        `;
    }

    // ─── Email Gate Modal ───

    function showEmailGate(toolName, onSuccess) {
        const existing = document.getElementById('hoplytics-email-gate');
        if (existing) existing.remove();

        const modal = document.createElement('div');
        modal.id = 'hoplytics-email-gate';
        modal.className = 'email-gate-overlay';
        modal.innerHTML = `
            <div class="email-gate-modal">
                <button class="email-gate-close" aria-label="Close">×</button>
                <h3>🔒 Unlock Your Full Report</h3>
                <p>Enter your email to get the complete ${toolName} results + a PDF copy sent to your inbox.</p>
                <form class="email-gate-form">
                    <input type="text" name="name" placeholder="Your name (optional)" />
                    <input type="email" name="email" required placeholder="your@email.com" />
                    <button type="submit" class="btn btn-primary" style="width:100%">Unlock Full Report →</button>
                </form>
                <p style="font-size:0.75rem;color:#6B7280;margin-top:0.75rem">No spam. Unsubscribe anytime.</p>
            </div>
        `;

        document.body.appendChild(modal);

        modal.querySelector('.email-gate-close').addEventListener('click', () => modal.remove());
        modal.addEventListener('click', (e) => { if (e.target === modal) modal.remove(); });

        modal.querySelector('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = modal.querySelector('input[name="email"]').value;
            const name = modal.querySelector('input[name="name"]').value;

            try {
                await fetch(`${API_BASE}/lead/capture`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': NONCE },
                    body: JSON.stringify({ email, name, source: 'tool_gate', tool: toolName }),
                });
                modal.remove();
                if (onSuccess) onSuccess();
            } catch {
                modal.remove();
                if (onSuccess) onSuccess();
            }
        });
    }

    // ─── Initialize All Tools ───

    document.addEventListener('DOMContentLoaded', () => {
        const tools = {
            '#hoplytics-website-audit': initAuditTool,
            '#hoplytics-pixel-checker': initPixelChecker,
            '#hoplytics-seo-score': initSeoScore,
            '#hoplytics-speed-check': initSpeedCheck,
            '#hoplytics-social-check': initSocialCheck,
            '#hoplytics-roi-calculator': initRoiCalculator,
            '#hoplytics-pricing-estimator': initPricingEstimator,
        };

        Object.entries(tools).forEach(([sel, init]) => {
            const el = $(sel);
            if (el) init(el);
        });
    });
})();
