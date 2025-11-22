from playwright.sync_api import sync_playwright
import os

def verify_theme(page):
    # 1. Load the mock page
    file_path = os.path.abspath("verification/mock-front-page.html")
    page.goto(f"file://{file_path}")

    # 2. Verify Title and Header
    page.wait_for_selector("header.site-header")
    assert page.title() == "Hoplytics - Front Page Verification"
    print("Header and Title Verified.")

    # 3. Test ROI Calculator Interaction
    # Click the button
    page.click("#roi-calculate-btn")

    # Wait for results to appear (JS logic adds display: block)
    page.wait_for_selector("#roi-text-results", state="visible")

    # Verify Calculation: 5000 budget / 2.5 CPC = 2000 Clicks
    # 2000 * 3.5% (0.035) = 70 Conversions
    # 70 * 150 AOV = $10,500 Revenue
    revenue_text = page.text_content("#roi-revenue")
    assert "$10,500" in revenue_text
    print(f"ROI Calculator Verified: Revenue is {revenue_text}")

    # 4. Test Style Kit Switching (Visual Check)
    # Capture Default (Tech-Futurist)
    page.screenshot(path="verification/theme-verification-tech.png")

    # Switch Class to Corporate-Stabilizer via JS
    page.evaluate("document.body.className = 'home page style-kit-corporate-stabilizer'")
    page.wait_for_timeout(500) # Allow render
    page.screenshot(path="verification/theme-verification-corporate.png")

    # Switch Class to Creative-Disruptor via JS
    page.evaluate("document.body.className = 'home page style-kit-creative-disruptor'")
    page.wait_for_timeout(500)
    page.screenshot(path="verification/theme-verification-creative.png")

    print("Style Kit Screenshots Captured.")

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page()
        verify_theme(page)
        browser.close()
