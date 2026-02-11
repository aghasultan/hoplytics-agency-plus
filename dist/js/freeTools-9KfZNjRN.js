(function(){var h,$;const m=((h=window.hoplyticsApi)==null?void 0:h.restUrl)||"/wp-json/hoplytics/v1",v=(($=window.hoplyticsApi)==null?void 0:$.nonce)||"";function o(s,r=document){return r.querySelector(s)}function p(s){return{A:"#10B981",B:"#3B82F6",C:"#F59E0B",D:"#F97316",F:"#EF4444"}[s]||"#6B7280"}function g(s){return{pass:"✅",warning:"⚠️",critical:"❌",info:"ℹ️"}[s]||"•"}function f(s,r,n=1500){const t=performance.now();function a(c){const i=c-t,l=Math.min(i/n,1),u=1-Math.pow(1-l,3);s.textContent=Math.round(0+(r-0)*u),l<1&&requestAnimationFrame(a)}requestAnimationFrame(a)}async function d(s,r){return(await fetch(`${m}/${s}`,{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":v},body:JSON.stringify({url:r})})).json()}function y(s){const r=o("form",s),n=o('input[name="url"]',s),e=o(".tool-results",s),t=o(".tool-loading",s);r&&r.addEventListener("submit",async a=>{a.preventDefault();const c=n.value.trim();if(c){t.hidden=!1,e.hidden=!0,e.innerHTML="";try{const i=await d("audit",c);if(!i.success){e.innerHTML=`<div class="tool-error">${i.message}</div>`,e.hidden=!1,t.hidden=!0;return}e.innerHTML=b(i),e.hidden=!1,t.hidden=!0;const l=o(".score-number",e);l&&f(l,i.score)}catch{e.innerHTML='<div class="tool-error">Network error. Please try again.</div>',e.hidden=!1,t.hidden=!0}}})}function b(s){const r=p(s.grade);let n=s.checks.map(e=>`
			<div class="check-item check-${e.status}">
				<span class="check-icon">${g(e.status)}</span>
				<div class="check-details">
					<strong>${e.name}</strong>
					<span class="check-value">${e.value}</span>
					${e.detail?`<span class="check-detail">${e.detail}</span>`:""}
					${e.advice?`<p class="check-advice">${e.advice}</p>`:""}
				</div>
			</div>
		`).join("");return`
			<div class="audit-score-card">
				<div class="score-circle" style="--score-color: ${r}">
					<span class="score-number">0</span>
					<span class="score-label">/100</span>
				</div>
				<div class="score-grade" style="color: ${r}">Grade: ${s.grade}</div>
				<div class="score-summary">
					<span class="summary-critical">${s.summary.critical} Critical</span>
					<span class="summary-warning">${s.summary.warnings} Warnings</span>
					<span class="summary-pass">${s.summary.passed} Passed</span>
				</div>
			</div>
			<div class="audit-checks">${n}</div>
			<div class="audit-cta">
				<p>Want a professional to fix these issues?</p>
				<a href="/get-started" class="btn btn-primary">Get Expert Help →</a>
			</div>
		`}function k(s){const r=o("form",s),n=o('input[name="url"]',s),e=o(".tool-results",s),t=o(".tool-loading",s);r&&r.addEventListener("submit",async a=>{a.preventDefault();const c=n.value.trim();if(c){t.hidden=!1,e.hidden=!0;try{const i=await d("pixel-check",c);if(!i.success){e.innerHTML=`<div class="tool-error">${i.message}</div>`,e.hidden=!1,t.hidden=!0;return}e.innerHTML=x(i),e.hidden=!1,t.hidden=!0}catch{e.innerHTML='<div class="tool-error">Network error. Please try again.</div>',e.hidden=!1,t.hidden=!0}}})}function x(s){const r=s.detected.map(t=>`
			<div class="tracker-item tracker-found">
				<span class="tracker-icon">${t.icon}</span>
				<div class="tracker-info">
					<strong>${t.name}</strong>
					${t.id?`<code class="tracker-id">${t.id}</code>`:""}
				</div>
				<span class="tracker-badge badge-found">✅ Found</span>
			</div>
		`).join(""),n=s.missing.map(t=>`
			<div class="tracker-item tracker-missing">
				<span class="tracker-icon">${t.icon}</span>
				<div class="tracker-info">
					<strong>${t.name}</strong>
					${t.guide_url?`<a href="${t.guide_url}" class="tracker-guide">${t.guide_text}</a>`:""}
				</div>
				<span class="tracker-badge badge-missing">❌ Not Found</span>
			</div>
		`).join(""),e=s.recommendations.length?`<div class="pixel-recommendations">
				<h4>💡 Recommendations</h4>
				<ul>${s.recommendations.map(t=>`<li>${t}</li>`).join("")}</ul>
			</div>`:"";return`
			<div class="pixel-summary">
				<div class="pixel-stat pixel-found">
					<span class="stat-number">${s.total_detected}</span>
					<span class="stat-label">Detected</span>
				</div>
				<div class="pixel-stat pixel-missing">
					<span class="stat-number">${s.total_missing}</span>
					<span class="stat-label">Missing</span>
				</div>
			</div>
			${r?`<h4>Tracking Pixels Found</h4>${r}`:""}
			${n?`<h4>Not Detected</h4>${n}`:""}
			${e}
			<div class="audit-cta">
				<p>Need help setting up tracking?</p>
				<a href="/get-started" class="btn btn-primary">Get Expert Setup →</a>
			</div>
		`}function w(s){const r=o("form",s),n=o('input[name="url"]',s),e=o(".tool-results",s),t=o(".tool-loading",s);r&&r.addEventListener("submit",async a=>{a.preventDefault();const c=n.value.trim();if(c){t.hidden=!1,e.hidden=!0;try{const i=await d("seo-score",c);if(!i.success){e.innerHTML=`<div class="tool-error">${i.message}</div>`,e.hidden=!1,t.hidden=!0;return}e.innerHTML=L(i),e.hidden=!1,t.hidden=!0;const l=o(".score-number",e);l&&f(l,i.score)}catch{e.innerHTML='<div class="tool-error">Network error.</div>',e.hidden=!1,t.hidden=!0}}})}function L(s){const r=p(s.grade),n=s.items.map(e=>{const t=e.max>0?Math.round(e.score/e.max*100):0,a=t>=80?"pass":t>=50?"warning":"critical";return`
				<div class="seo-item seo-${a}">
					<div class="seo-item-header">
						<span>${g(a)} <strong>${e.factor}</strong></span>
						<span class="seo-item-score">${e.score}/${e.max}</span>
					</div>
					<div class="seo-item-bar">
						<div class="seo-item-fill" style="width: ${t}%; background: ${p(t>=80?"A":t>=50?"C":"F")}"></div>
					</div>
					<div class="seo-item-detail">
						<span>Current: ${e.current}</span>
						<span>Ideal: ${e.ideal}</span>
					</div>
				</div>
			`}).join("");return`
			<div class="audit-score-card">
				<div class="score-circle" style="--score-color: ${r}">
					<span class="score-number">0</span>
					<span class="score-label">/100</span>
				</div>
				<div class="score-grade" style="color: ${r}">SEO Grade: ${s.grade}</div>
				<p class="score-words">${s.word_count.toLocaleString()} words analyzed</p>
			</div>
			<div class="seo-items">${n}</div>
			<div class="audit-cta">
				<p>Want us to optimize your site's SEO?</p>
				<a href="/get-started" class="btn btn-primary">Get a Free SEO Consultation →</a>
			</div>
		`}function H(s){const r=o("form",s),n=o('input[name="url"]',s),e=o(".tool-results",s),t=o(".tool-loading",s);r&&r.addEventListener("submit",async a=>{a.preventDefault();const c=n.value.trim();if(c){t.hidden=!1,e.hidden=!0;try{const i=await d("speed-check",c);if(!i.success)e.innerHTML=`<div class="tool-error">${i.message}</div>`;else{e.innerHTML=S(i);const l=o(".score-number",e);l&&f(l,i.score)}e.hidden=!1,t.hidden=!0}catch{e.innerHTML='<div class="tool-error">Network error.</div>',e.hidden=!1,t.hidden=!0}}})}function S(s){const r=p(s.grade),n=s.checks.map(e=>`
            <div class="check-item check-${e.status}">
                <span class="check-icon">${g(e.status)}</span>
                <div class="check-details">
                    <strong>${e.name}</strong>
                    <span class="check-value">${e.value} <small style="color:#9CA3AF">(ideal: ${e.ideal})</small></span>
                    ${e.advice?`<p class="check-advice">${e.advice}</p>`:""}
                </div>
            </div>
        `).join("");return`
            <div class="audit-score-card">
                <div class="score-circle" style="--score-color: ${r}">
                    <span class="score-number">0</span>
                    <span class="score-label">/100</span>
                </div>
                <div class="score-grade" style="color: ${r}">${s.emoji} ${s.label}</div>
                <div class="score-summary">
                    <span>⏱ ${s.load_time}s</span>
                    <span>📦 ${s.page_size} KB</span>
                    <span>📁 ${s.resources.total} resources</span>
                </div>
            </div>
            <div class="audit-checks">${n}</div>
            <div class="audit-cta">
                <p>Want sub-2-second load times?</p>
                <a href="/services/web-development" class="btn btn-primary">Our Speed Optimization Service →</a>
            </div>
        `}function _(s){const r=o("form",s),n=o('input[name="url"]',s),e=o(".tool-results",s),t=o(".tool-loading",s);r&&r.addEventListener("submit",async a=>{a.preventDefault();const c=n.value.trim();if(c){t.hidden=!1,e.hidden=!0;try{const i=await d("social-check",c);i.success?e.innerHTML=M(i):e.innerHTML=`<div class="tool-error">${i.message}</div>`,e.hidden=!1,t.hidden=!0}catch{e.innerHTML='<div class="tool-error">Network error.</div>',e.hidden=!1,t.hidden=!0}}})}function M(s){const r=s.found.map(a=>`
            <div class="tracker-item tracker-found">
                <span class="tracker-icon">${a.icon}</span>
                <div class="tracker-info">
                    <strong>${a.name}</strong>
                    ${a.url?`<a href="${a.url}" target="_blank" class="tracker-guide">${a.url}</a>`:""}
                </div>
                <span class="tracker-badge badge-found">✅ Linked</span>
            </div>
        `).join(""),n=s.missing.map(a=>`
            <div class="tracker-item tracker-missing">
                <span class="tracker-icon">${a.icon}</span>
                <div class="tracker-info"><strong>${a.name}</strong></div>
                <span class="tracker-badge badge-missing">❌ Not Found</span>
            </div>
        `).join(""),e=s.extras.map(a=>`
            <div class="tracker-item ${a.found?"tracker-found":"tracker-missing"}">
                <span class="tracker-icon">${a.icon}</span>
                <div class="tracker-info"><strong>${a.name}</strong></div>
                <span class="tracker-badge ${a.found?"badge-found":"badge-missing"}">${a.found?"✅":"❌"}</span>
            </div>
        `).join(""),t=s.recommendations.length?`<div class="pixel-recommendations"><h4>💡 Recommendations</h4><ul>${s.recommendations.map(a=>`<li>${a}</li>`).join("")}</ul></div>`:"";return`
            <div class="pixel-summary">
                <div class="pixel-stat pixel-found">
                    <span class="stat-number">${s.platforms_found}</span>
                    <span class="stat-label">Platforms Found</span>
                </div>
                <div class="pixel-stat pixel-missing">
                    <span class="stat-number">${s.platforms_missing}</span>
                    <span class="stat-label">Missing</span>
                </div>
            </div>
            ${r?`<h4>Social Profiles Found</h4>${r}`:""}
            ${n?`<h4>Not Detected</h4>${n}`:""}
            ${e?`<h4>Content Marketing Signals</h4>${e}`:""}
            ${t}
            <div class="audit-cta">
                <p>Need help building your social presence?</p>
                <a href="/services/social-media-marketing" class="btn btn-primary">Social Media Services →</a>
            </div>
        `}function C(s){const r=o("form",s),n=o(".tool-results",s),e=o(".tool-loading",s);r&&r.addEventListener("submit",async t=>{t.preventDefault(),e.hidden=!1,n.hidden=!0;const a=Object.fromEntries(new FormData(r)),c={monthly_spend:parseFloat(a.monthly_spend)||0,monthly_revenue:parseFloat(a.monthly_revenue)||0,conversion_rate:parseFloat(a.conversion_rate)||2.5,avg_deal_value:parseFloat(a.avg_deal_value)||500,monthly_traffic:parseInt(a.monthly_traffic)||1e3,industry:a.industry||"general"};try{const l=await(await fetch(`${m}/roi-calculator`,{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":v},body:JSON.stringify(c)})).json();l.success?n.innerHTML=T(l):n.innerHTML=`<div class="tool-error">${l.message||"Error"}</div>`,n.hidden=!1,e.hidden=!0}catch{n.innerHTML='<div class="tool-error">Network error.</div>',n.hidden=!1,e.hidden=!0}})}function T(s){const r=a=>"$"+Number(a).toLocaleString(),n=s.current,e=s.projected,t=s.insights.map(a=>`<li>${a}</li>`).join("");return`
            <div class="pixel-summary" style="margin-bottom:1.5rem">
                <div class="pixel-stat pixel-found">
                    <span class="stat-number">${n.roas}x</span>
                    <span class="stat-label">Current ROAS</span>
                </div>
                <div class="pixel-stat" style="background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(59,130,246,0.15));border-color:#10B981">
                    <span class="stat-number" style="color:#10B981">${e.roas}x</span>
                    <span class="stat-label">Projected ROAS</span>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem">
                <div class="is-style-card" style="padding:1.25rem;border-radius:12px">
                    <h4 style="margin:0 0 0.75rem;font-size:0.85rem;color:#9CA3AF;text-transform:uppercase">Current</h4>
                    <p>Revenue: <strong>${r(n.monthly_revenue)}/mo</strong></p>
                    <p>Leads: <strong>${n.leads}/mo</strong></p>
                    <p>CPA: <strong>${r(n.cpa)}</strong></p>
                    <p>ROI: <strong>${n.roi_percent}%</strong></p>
                </div>
                <div class="is-style-card" style="padding:1.25rem;border-radius:12px;border-color:#10B981">
                    <h4 style="margin:0 0 0.75rem;font-size:0.85rem;color:#10B981;text-transform:uppercase">Projected</h4>
                    <p>Revenue: <strong style="color:#10B981">${r(e.monthly_revenue)}/mo</strong></p>
                    <p>Leads: <strong style="color:#10B981">${e.leads}/mo</strong></p>
                    <p>CPA: <strong style="color:#10B981">${r(e.cpa)}</strong></p>
                    <p>ROI: <strong style="color:#10B981">${e.roi_percent}%</strong></p>
                </div>
            </div>
            <div class="is-style-card" style="padding:1.25rem;border-radius:12px;text-align:center;margin-bottom:1.5rem">
                <p style="color:#9CA3AF;margin:0 0 0.25rem;font-size:0.85rem">12-Month Revenue Gain</p>
                <p style="font-size:2rem;font-weight:800;color:#10B981;margin:0">${r(s.annual.gain)}</p>
            </div>
            ${t?`<div class="pixel-recommendations"><h4>📊 Insights</h4><ul>${t}</ul></div>`:""}
            <div class="audit-cta">
                <p>Want to achieve these numbers?</p>
                <a href="/get-started" class="btn btn-primary">Book Your Strategy Call →</a>
            </div>
        `}function F(s){const r=o("form",s),n=o(".tool-results",s),e=o(".tool-loading",s);r&&r.addEventListener("submit",async t=>{t.preventDefault(),e.hidden=!1,n.hidden=!0;const a=new FormData(r),i={services:a.getAll("services"),business_size:a.get("business_size")||"small",goals:a.getAll("goals"),timeline:a.get("timeline")||"standard"};try{const u=await(await fetch(`${m}/pricing-estimate`,{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":v},body:JSON.stringify(i)})).json();u.success?n.innerHTML=j(u):n.innerHTML=`<div class="tool-error">${u.message||"Error"}</div>`,n.hidden=!1,e.hidden=!0}catch{n.innerHTML='<div class="tool-error">Network error.</div>',n.hidden=!1,e.hidden=!0}})}function j(s){const r=t=>"$"+Number(t).toLocaleString(),n=s.line_items.map(t=>`
            <div class="tracker-item tracker-found" style="padding:0.75rem 1rem">
                <span class="tracker-icon">${t.icon}</span>
                <div class="tracker-info"><strong>${t.label}</strong></div>
                <span style="font-weight:600;color:var(--color-text)">${r(t.min)} – ${r(t.max)}/mo</span>
            </div>
        `).join(""),e=s.included.map(t=>`<li>✅ ${t}</li>`).join("");return`
            <div class="audit-score-card" style="margin-bottom:1.5rem">
                <p style="color:#9CA3AF;margin:0 0 0.25rem;font-size:0.85rem;text-transform:uppercase">Estimated Monthly Investment</p>
                <div style="font-size:2rem;font-weight:800">
                    <span class="gradient-text">${r(s.total_min)} – ${r(s.total_max)}</span>
                </div>
                ${s.discount>0?`<p style="color:#10B981;margin:0.5rem 0 0">🎉 ${s.discount}% bundle discount applied!</p>`:""}
            </div>
            <h4>Service Breakdown</h4>
            ${n}
            <div class="pixel-recommendations" style="margin-top:1.5rem">
                <h4>✅ What's Included</h4>
                <ul>${e}</ul>
            </div>
            <p style="color:#9CA3AF;font-size:0.85rem;font-style:italic;margin-top:1rem">${s.note}</p>
            <div class="audit-cta">
                <p>Ready for a custom proposal?</p>
                <a href="${s.cta_url}" class="btn btn-primary">Book Your Free Strategy Call →</a>
            </div>
        `}document.addEventListener("DOMContentLoaded",()=>{Object.entries({"#hoplytics-website-audit":y,"#hoplytics-pixel-checker":k,"#hoplytics-seo-score":w,"#hoplytics-speed-check":H,"#hoplytics-social-check":_,"#hoplytics-roi-calculator":C,"#hoplytics-pricing-estimator":F}).forEach(([r,n])=>{const e=o(r);e&&n(e)})})})();
//# sourceMappingURL=freeTools-9KfZNjRN.js.map
