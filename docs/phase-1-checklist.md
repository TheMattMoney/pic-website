# Phase 1 Checklist: Project Setup & Planning

This checklist is for Phase 1 of the Plastic Instruments Video Grid Website project. Complete each item before moving to the next phase. Negative prompts (what NOT to do) are included for clarity.

---

## ✅ Project Directory Structure
- [ ] Create a `docs/` folder for documentation and planning files.
- [ ] Create a `db/` folder for the SQLite database.
- [ ] Create a `scripts/` folder for all Python scripts.
- [ ] Ensure `public/` exists for all site files (HTML, assets, images, fonts).
- [ ] Ensure `public/assets/fonts/` exists for Atkinson font files.
- [ ] Ensure `public/archive/` exists for the archive placeholder page.
- [ ] Confirm `public/contact.html` exists for the contact page.
- [ ] Confirm `logo-xprnt.png` and `bk-one.png` are available in the appropriate location (usually `public/`).
- [ ] Confirm all directory and file names use lowercase and hyphens (no spaces or uppercase).
- [ ] DO NOT place scripts, database, or documentation files in the `public/` directory.

## ✅ Documentation
- [ ] Ensure `docs/project-plan.md` exists and is up-to-date with:
    - [ ] Design notes (navigation, fonts, background, parallax, etc.)
    - [ ] Implementation phases
    - [ ] SQLite schema example
    - [ ] Directory structure
    - [ ] References
- [ ] Ensure `README.md` is up-to-date and includes:
    - [ ] Stack and tech overview
    - [ ] Design and navigation summary
    - [ ] Usage instructions
    - [ ] Directory structure
    - [ ] Contributors
    - [ ] License
- [ ] DO NOT leave out any major design or implementation details from the documentation.

## ✅ SQLite Schema Planning
- [ ] Document the intended SQLite schema in `docs/project-plan.md`.
- [ ] Confirm the schema includes: video ID, title, description, thumbnail URL, published time, channel title.
- [ ] DO NOT create the actual database or tables yet (this is for planning only).

## ✅ Planning for Python Scripts
- [ ] Specify in the plan that all Python scripts go in `scripts/`.
- [ ] Name the main script `update_videos.py` (or similar) in the plan.
- [ ] DO NOT write or run the script yet (this is for planning only).

## ✅ Planning for Assets
- [ ] Confirm the plan specifies the use of Atkinson fonts, `logo-xprnt.png`, and `bk-one.png`.
- [ ] DO NOT use any unlicensed or unapproved assets.

## ✅ General
- [ ] Review the project plan for completeness and clarity.
- [ ] Ensure all negative prompts (what NOT to do) are considered and followed.
- [ ] DO NOT proceed to Phase 2 until every item on this checklist is complete and verified.

---

**Note:** Check off each item as you complete it. If any item is not applicable, note why before moving on. 