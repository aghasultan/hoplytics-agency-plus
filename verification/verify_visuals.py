from playwright.sync_api import Page, expect, sync_playwright
import os

def verify_visuals(page: Page):
    # Load the local HTML file
    filepath = os.path.abspath("verification/test.html")
    page.goto(f"file://{filepath}")

    # 1. Verify Comparison Table Icons
    icon = page.locator(".comparison-icon").first
    expect(icon).to_be_visible()
    bbox = icon.bounding_box()
    assert bbox['width'] == 28
    assert bbox['height'] == 28

    # 2. Verify Hero Form
    hero_card = page.locator(".hero-card")
    expect(hero_card).to_have_css("background-color", "rgba(20, 20, 30, 0.8)")
    expect(hero_card).to_have_css("backdrop-filter", "blur(10px)")

    label = page.locator(".hero-form label").first
    expect(label).to_have_css("color", "rgb(226, 232, 240)") # #e2e8f0

    # Verify Input Fields
    input_field = page.locator(".hero-form input").first
    expect(input_field).to_have_css("color", "rgb(255, 255, 255)")
    expect(input_field).to_have_css("background-color", "rgba(0, 0, 0, 0.3)")

    # 3. Verify ROI Calculator Container
    roi_canvas = page.locator(".roi-results canvas")
    expect(roi_canvas).to_have_css("background-color", "rgba(255, 255, 255, 0.03)")
    expect(roi_canvas).to_have_css("border-radius", "4px")

    # 4. Verify Service Placeholder
    placeholder = page.locator(".service-placeholder")
    expect(placeholder).to_be_visible()
    expect(placeholder).to_have_css("border-style", "dashed")
    expect(placeholder).to_have_css("min-height", "200px")

    # Take screenshot
    page.screenshot(path="verification/visual_check.png", full_page=True)

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        try:
            verify_visuals(page)
            print("Verification successful!")
        except Exception as e:
            print(f"Verification failed: {e}")
            # Take screenshot anyway for debug
            page.screenshot(path="verification/debug_failure.png")
        finally:
            browser.close()
