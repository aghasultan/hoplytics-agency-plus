from playwright.sync_api import sync_playwright, expect
import os

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    page = browser.new_page()

    # Load the local HTML file
    file_path = os.path.abspath("verification/test.html")
    page.goto(f"file://{file_path}")

    # Verify Scarcity Bar
    expect(page.locator("#scarcity-bar")).to_be_visible()
    expect(page.locator(".scarcity-text")).to_contain_text("November Slots: Only 2 Client Openings Remaining")

    # Verify ROI Calculator
    # Default values: Traffic 5000, Conv 2.5, CLV 1500
    # Calculation: 5000 * (2.5/100) = 125 conversions. 125 * 1500 = 187,500
    expect(page.locator(".roi-revenue")).to_contain_text("$187,500")

    # Change inputs
    page.locator(".roi-traffic").fill("10000")
    # Calculation: 10000 * (2.5/100) = 250 conversions. 250 * 1500 = 375,000
    expect(page.locator(".roi-revenue")).to_contain_text("$375,000")

    # Verify Testimonial Grid
    expect(page.locator(".testimonial-grid")).to_be_visible()
    expect(page.locator(".testimonial-card")).to_have_count(3)

    # Screenshot
    page.screenshot(path="verification/verification.png", full_page=True)

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
