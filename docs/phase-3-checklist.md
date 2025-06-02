# Phase 3 Checklist: Home Page (Video Grid)

This checklist is for Phase 3 of the Plastic Instruments Video Grid Website project. Complete each item before moving to the next phase. Negative prompts (what NOT to do), a unit and integration testing phase, and explicit success criteria are included.

---

## ✅ PHP Home Page Development
- [ ] Create `public/index.php` (or update the main home page to PHP if needed).
- [ ] Read video data from the SQLite database at `db/videos.db`.
- [ ] Display a grid of video thumbnails and titles, styled to match the site (Atkinson fonts, background, parallax, etc.).
- [ ] Each video links to a detail page using a query string (e.g., `video.php?id=VIDEO_ID`).
- [ ] Ensure navigation bar (logo, Home, Archive, Contact) is present and styled consistently.
- [ ] Ensure the page is responsive for desktop and mobile.
- [ ] DO NOT expose database credentials or sensitive data in the HTML output.
- [ ] DO NOT use inline JavaScript for critical functionality (keep logic in PHP and CSS for this phase).

## ✅ Data Handling & Security
- [ ] Sanitize all data output to prevent XSS or injection attacks.
- [ ] Handle missing or malformed video data gracefully (e.g., show a placeholder or error message).
- [ ] DO NOT display raw or unescaped data from the database.

## ✅ Styling & Accessibility
- [ ] Use Atkinson fonts for all text.
- [ ] Use `bk-one.png` as the background with parallax effect.
- [ ] Ensure all images have appropriate `alt` text.
- [ ] Ensure color contrast and font sizes meet accessibility standards.
- [ ] DO NOT use inaccessible color combinations or small, unreadable text.

## ✅ Unit & Integration Testing
- [ ] Write unit tests for any PHP functions used to fetch or render video data.
- [ ] Write integration tests to:
    - [ ] Load the home page and verify the video grid displays correctly with real data.
    - [ ] Test navigation links (Home, Archive, Contact) for correct routing.
    - [ ] Simulate empty or corrupted database and verify graceful error handling.
- [ ] Test responsiveness and layout on multiple devices and browsers.
- [ ] DO NOT skip tests or ignore test failures.

## ✅ Success Criteria
- [ ] The home page loads and displays a grid of videos from the database.
- [ ] All navigation links work and are styled consistently.
- [ ] The page is responsive and accessible.
- [ ] No sensitive data is exposed in the HTML or client-side code.
- [ ] All unit and integration tests pass.
- [ ] The process is documented for future maintenance.

## ✅ General
- [ ] Review all code and documentation for clarity and completeness.
- [ ] Ensure all negative prompts (what NOT to do) are considered and followed.
- [ ] DO NOT proceed to Phase 4 until every item on this checklist is complete and verified.

---

**Note:** Check off each item as you complete it. If any item is not applicable, note why before moving on. 