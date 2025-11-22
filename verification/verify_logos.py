from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()

    # Open the mock HTML file
    import os
    file_path = os.path.abspath("verification/mock-verification.html")
    page.goto(f"file://{file_path}")

    # Verify Header Logo
    header_logo = page.locator(".site-header .site-logo-link img")
    expect(header_logo).to_be_visible()
    # Check if source contains the correct filename
    src = header_logo.get_attribute("src")
    assert "logo-horizontal.png" in src

    # Verify Footer Logo
    footer_logo = page.locator(".footer-brand .footer-logo")
    expect(footer_logo).to_be_visible()
    src_footer = footer_logo.get_attribute("src")
    assert "logo-horizontal.png" in src_footer

    # Verify Login Logo (Background Image)
    login_logo = page.locator(".login-logo")
    expect(login_logo).to_be_visible()
    # Get computed style to verify background image
    bg_image = login_logo.evaluate("element => window.getComputedStyle(element).backgroundImage")
    assert "logo-horizontal.png" in bg_image

    # Take a full page screenshot
    page.screenshot(path="verification/logo-verification.png", full_page=True)

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
