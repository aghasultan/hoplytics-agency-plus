from playwright.sync_api import sync_playwright
import os

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    page = browser.new_page()

    # Get absolute path to the file
    file_path = os.path.abspath("verification/front-page-simulation.html")
    page.goto(f"file://{file_path}")

    # Check for text content
    if page.get_by_text("We Build Digital Ecosystems.").is_visible():
        print("Hero headline found.")
    else:
        print("Hero headline NOT found.")

    if page.get_by_text("Services").is_visible():
        print("Services header found.")

    if page.get_by_text("Engineering Logs").is_visible():
        print("Insights header found.")

    # Screenshot
    page.screenshot(path="verification/front-page-screenshot.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
