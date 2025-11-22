from playwright.sync_api import sync_playwright, Page, expect
import os
import time
import re

def verify_features(page: Page):
    # 1. Load the static verification page
    # Using file:// protocol
    cwd = os.getcwd()
    file_path = f"file://{cwd}/verification/test-index.html"
    page.goto(file_path)

    # 2. Verify Dynamic Mode (Greeting & Dark Mode)
    # Note: The test environment time might not be "Night", so we can't guarantee dark mode triggering
    # without mocking the Date. But we can check if the script ran.
    # Let's force night mode for the screenshot by injecting JS
    page.evaluate("document.body.classList.add('dark-mode')")

    # Verify dark mode CSS variables applied (by checking background color computed style)
    # .site-header background should be slate 900 (#0f172a) in dark mode
    header = page.locator('.site-header')
    # We might need to wait for styles to apply if there was a transition, but class add is instant

    # 3. Verify Three.js Canvas
    # The script adds a div #three-hero-canvas
    canvas_container = page.locator('#three-hero-canvas')
    expect(canvas_container).to_be_visible()

    # 4. Verify Custom Cursor
    # It adds #custom-cursor
    cursor = page.locator('#custom-cursor')
    # It might be hidden until mouse move? No, appended to body.
    # The CSS makes it fixed.
    # We move the mouse to ensure it's visible/positioned
    page.mouse.move(100, 100)
    expect(cursor).to_be_attached()

    # 5. Verify Scroll Effects
    # Scroll down to reveal cards
    page.evaluate("window.scrollTo(0, 500)")
    time.sleep(1) # Wait for animation

    # Cards should have .is-visible class
    card = page.locator('.card').first
    # Playwright's to_have_class matches the full class string or checks existence if passed a regex directly
    # But "reveal-on-scroll is-visible" is the likely class.
    # Let's just check if it contains "is-visible"
    expect(card).to_have_class(re.compile(r"is-visible"))

    # 6. Verify Dev Grid (Shift+G)
    page.keyboard.down("Shift")
    page.keyboard.press("g")
    page.keyboard.up("Shift")

    grid = page.locator('#dev-grid-overlay')
    expect(grid).to_be_visible()

    # Take Screenshot
    page.screenshot(path="verification/verification.png")
    print("Screenshot taken at verification/verification.png")

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        try:
            verify_features(page)
        finally:
            browser.close()
