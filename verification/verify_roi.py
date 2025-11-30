from playwright.sync_api import sync_playwright, expect
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load the local HTML file
        file_path = os.path.abspath("verification/test.html")
        page.goto(f"file://{file_path}")

        # Check title
        expect(page).to_have_title("ROI Calculator Block Verification")

        # --- Instance 1 Verification ---
        # Default values: Ad Spend=5000, Close Rate=20, Deal Value=1000
        # Calc: (5000 / 50) * (20 / 100) * 1000 = 100 * 0.2 * 1000 = 20,000

        roi1 = page.locator(".wp-block-hoplytics-roi-calculator").first
        revenue1 = roi1.locator(".roi-revenue-display")

        # Verify initial calculation
        expect(revenue1).to_contain_text("$20,000")

        # Change values
        # Set Ad Spend to 10000
        roi1.locator(".roi-ad-spend-number").fill("10000")
        roi1.locator(".roi-ad-spend-number").dispatch_event("input")

        # Calc: (10000 / 50) * 0.2 * 1000 = 200 * 0.2 * 1000 = 40,000
        expect(revenue1).to_contain_text("$40,000")

        # --- Instance 2 Verification (Scoping Check) ---
        # Default values in HTML: Ad Spend=10000, Close Rate=50, Deal Value=2000
        # Calc: (10000 / 50) * (50 / 100) * 2000 = 200 * 0.5 * 2000 = 100 * 2000 = 200,000

        roi2 = page.locator(".wp-block-hoplytics-roi-calculator").nth(1)
        revenue2 = roi2.locator(".roi-revenue-display")

        expect(revenue2).to_contain_text("$200,000")

        # Verify that changing Instance 1 does not affect Instance 2
        roi1.locator(".roi-deal-value").fill("500")
        roi1.locator(".roi-deal-value").dispatch_event("input")
        # Instance 1 New Calc: (10000 / 50) * 0.2 * 500 = 200 * 0.2 * 500 = 20,000
        expect(revenue1).to_contain_text("$20,000")

        # Instance 2 should remain same
        expect(revenue2).to_contain_text("$200,000")

        # Screenshot
        page.screenshot(path="verification/roi_calculator_verified.png")
        print("Verification successful!")

        browser.close()

if __name__ == "__main__":
    run()
