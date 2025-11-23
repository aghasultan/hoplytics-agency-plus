from playwright.sync_api import sync_playwright, expect
import os

def verify_frontend():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load the local HTML file
        file_path = os.path.abspath("verification/test.html")
        page.goto(f"file://{file_path}")

        print("Page loaded.")

        # 1. Verify Hero Form Multi-step
        print("Verifying Hero Form...")
        # Initial state: Step 1 visible, Step 2 hidden
        expect(page.locator("#step-1")).to_be_visible()
        expect(page.locator("#step-2")).not_to_be_visible()

        # Fill URL and Click Next
        page.fill("#hero-website", "https://example.com")
        page.click("text=Next")

        # State 2: Step 1 hidden, Step 2 visible
        expect(page.locator("#step-1")).not_to_be_visible()
        expect(page.locator("#step-2")).to_be_visible()
        print("Hero Form Multi-step verified.")

        # 2. Verify ROI Calculator Real-time Update
        print("Verifying ROI Calculator...")
        # Initial values
        # Budget=5000, CPC=2.5, Conv=3.5, AOV=150
        # Clicks = 2000, Convs = 70, Rev = 10500

        # Wait for initial calculation (JS runs on load)
        expect(page.locator("#roi-revenue")).to_contain_text("$10,500")

        # Change Budget to 10000 -> Should double revenue to $21,000
        page.fill("#roi-budget", "10000")
        # Trigger input event if needed, but fill usually does it.

        expect(page.locator("#roi-revenue")).to_contain_text("$21,000")
        print("ROI Calculator Real-time update verified.")

        # 3. Verify Visuals (Screenshot)
        # Scroll to top
        page.mouse.wheel(0, -10000)
        page.wait_for_timeout(500)

        print("Taking screenshot...")
        page.screenshot(path="verification/verification.png", full_page=True)
        print("Screenshot saved to verification/verification.png")

        browser.close()

if __name__ == "__main__":
    verify_frontend()
