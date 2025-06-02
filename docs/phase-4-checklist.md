# Phase 4 Checklist: Video Detail Page

This checklist is for Phase 4 of the Plastic Instruments Video Grid Website project. Complete each item before moving to the next phase. Negative prompts (what NOT to do), a unit and integration testing phase, and explicit success criteria are included.

---

## ✅ PHP Video Detail Page Development
- [ ] Create `public/video.php` (or equivalent) for the video detail page.
- [ ] Read the video ID from the query string (e.g., `video.php?id=VIDEO_ID`).
- [ ] Fetch the corresponding video data from the SQLite database at `db/videos.db`.
- [ ] Embed the YouTube video (iframe, nearly full width, centered) using the video ID.
- [ ] Display the video description and published time below the embed.
- [ ] Ensure navigation bar (logo, Home, Archive, Contact) is present and styled consistently.
- [ ] Add a back link to the home page.
- [ ] Ensure the page is responsive for desktop and mobile.
- [ ] DO NOT expose database credentials or sensitive data in the HTML output.
- [ ] DO NOT allow unsanitized query parameters to be used directly in database queries or output.

## ✅ Data Handling & Security
- [ ] Sanitize all input (query string) and output to prevent XSS or injection attacks.
- [ ] Handle missing, invalid, or non-existent video IDs gracefully (e.g., show a user-friendly error message).
- [ ] DO NOT display raw or unescaped data from the database.

## ✅ Styling & Accessibility
- [ ] Use Atkinson fonts for all text.
- [ ] Use `bk-one.png` as the background with parallax effect.
- [ ] Ensure the video embed is centered and nearly full width.
- [ ] Ensure all images and iframes have appropriate `alt` or `title` attributes.
- [ ] Ensure color contrast and font sizes meet accessibility standards.
- [ ] DO NOT use inaccessible color combinations or small, unreadable text.

## ✅ Unit & Integration Testing
- [ ] Write unit tests for any PHP functions used to fetch or render video data.
- [ ] Write integration tests to:
    - [ ] Load the video detail page with a valid video ID and verify correct rendering.
    - [ ] Load the page with an invalid or missing video ID and verify graceful error handling.
    - [ ] Test navigation links (Home, Archive, Contact, Back) for correct routing.
- [ ] Test responsiveness and layout on multiple devices and browsers.
- [ ] DO NOT skip tests or ignore test failures.

## ✅ Success Criteria
- [ ] The video detail page loads and displays the correct video, description, and published time.
- [ ] All navigation and back links work and are styled consistently.
- [ ] The page is responsive and accessible.
- [ ] No sensitive data is exposed in the HTML or client-side code.
- [ ] All unit and integration tests pass.
- [ ] The process is documented for future maintenance.

## ✅ General
- [ ] Review all code and documentation for clarity and completeness.
- [ ] Ensure all negative prompts (what NOT to do) are considered and followed.
- [ ] DO NOT proceed to Phase 5 until every item on this checklist is complete and verified.

---

**Note:** Check off each item as you complete it. If any item is not applicable, note why before moving on. 