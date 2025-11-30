from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load the HTML file
        file_path = os.path.abspath("verification/bento-test.html")
        page.goto(f"file://{file_path}")

        # Take Desktop Screenshot
        page.set_viewport_size({"width": 1280, "height": 800})
        page.screenshot(path="verification/bento_desktop.png")
        print("Desktop screenshot saved.")

        # Take Mobile Screenshot
        page.set_viewport_size({"width": 375, "height": 812})
        page.screenshot(path="verification/bento_mobile.png")
        print("Mobile screenshot saved.")

        browser.close()

if __name__ == "__main__":
    run()
