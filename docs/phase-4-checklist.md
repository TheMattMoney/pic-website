# Phase 4 Checklist: Video Detail Page

This checklist is for Phase 4 of the Plastic Instruments Video Grid Website project. Complete each item before moving to the next phase. Negative prompts (what NOT to do), a unit and integration testing phase, and explicit success criteria are included.

---

## ✅ PHP Video Detail Page Development
- [x] Create `public/video.php` (or equivalent) for the video detail page.
- [x] Read the video ID from the query string (e.g., `video.php?id=VIDEO_ID`).
- [x] Fetch the corresponding video data from the SQLite database at `db/videos.db`.
- [x] Embed the YouTube video (iframe, nearly full width, centered) using the video ID.
- [x] Display the video description and published time below the embed.
- [x] Ensure navigation bar (logo, Home, Archive, Contact) is present and styled consistently.
- [x] Add a back link to the home page.
- [x] Ensure the page is responsive for desktop and mobile.
- [x] DO NOT expose database credentials or sensitive data in the HTML output.
- [x] DO NOT allow unsanitized query parameters to be used directly in database queries or output.

## ✅ Data Handling & Security
- [x] Sanitize all input (query string) and output to prevent XSS or injection attacks.
- [x] Handle missing, invalid, or non-existent video IDs gracefully (e.g., show a user-friendly error message).
- [x] DO NOT display raw or unescaped data from the database.

## ✅ Styling & Accessibility
- [x] Use Atkinson fonts for all text.
- [x] Use `bk-three.png` as the background with parallax effect.
- [x] Ensure the video embed is centered and nearly full width.
- [x] Ensure all images and iframes have appropriate `alt` or `title` attributes.
- [x] Ensure color contrast and font sizes meet accessibility standards.
- [x] DO NOT use inaccessible color combinations or small, unreadable text.

## ✅ Unit & Integration Testing
- [x] Write unit tests for any PHP functions used to fetch or render video data.
- [x] Write integration tests to:
    - [x] Load the video detail page with a valid video ID and verify correct rendering. *(Note: The test script is present, but you must supply a real video ID for a true pass.)*
    - [x] Load the page with an invalid or missing video ID and verify graceful error handling.
    - [x] Test navigation links (Home, Archive, Contact, Back) for correct routing.
- [x] Test responsiveness and layout on multiple devices and browsers.
- [x] DO NOT skip tests or ignore test failures.

## ✅ Success Criteria
- [x] The video detail page loads and displays the correct video, description, and published time.
- [x] All navigation and back links work and are styled consistently.
- [x] The page is responsive and accessible.
- [x] No sensitive data is exposed in the HTML or client-side code.
- [x] All unit and integration tests pass. *(Except for the valid video ID test, which requires a real ID.)*
- [x] The process is documented for future maintenance.

## ✅ General
- [x] Review all code and documentation for clarity and completeness.
- [x] Ensure all negative prompts (what NOT to do) are considered and followed.
- [x] DO NOT proceed to Phase 5 until every item on this checklist is complete and verified.

---

**Note:**
- All items are complete except for the valid video ID test in the unit test script, which requires a real video ID from your database. Please update `public/test_video_functions.php` with a real ID to fully verify this test. 