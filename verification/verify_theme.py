from playwright.sync_api import sync_playwright, expect
import os

def verify_theme_visuals():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load the mock HTML file
        cwd = os.getcwd()
        file_path = f"file://{cwd}/verification/mock-front-page.html"

        print(f"Navigating to {file_path}")
        page.goto(file_path)

        # 1. Verify Header CTA Button class application
        cta_btn = page.locator('.header-cta-btn')
        expect(cta_btn).to_be_visible()

        # 2. Verify Footer Grid
        footer_grid = page.locator('.footer-top-grid')
        expect(footer_grid).to_have_css('display', 'grid')

        # 3. Verify Services Header (New Cleaned Class)
        services_header = page.locator('.services-header')
        expect(services_header).to_be_visible()
        expect(services_header).to_have_css('text-align', 'center')

        # 4. Verify Service Links (New Cleaned Class)
        service_link = page.locator('.service-link').first
        expect(service_link).to_be_visible()
        expect(service_link).to_have_css('font-weight', '600')

        # Take a full page screenshot
        screenshot_path = f"{cwd}/verification/theme-verification-final.png"
        page.screenshot(path=screenshot_path, full_page=True)
        print(f"Screenshot saved to {screenshot_path}")

        browser.close()

if __name__ == "__main__":
    verify_theme_visuals()
