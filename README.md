# Plastic Instruments Video Grid Website

## Overview
A responsive, accessible website for the Plastic Instruments Community, displaying a grid of YouTube videos with detail pages, using a local SQLite database for fast, API-free performance.

## Features
- Home page: Video grid, thumbnails, titles, links to detail pages
- Video detail page: Embedded YouTube video, description, published time
- Archive and Contact pages
- Parallax background, Atkinson fonts, modern design
- All data cached locally via Python script using yt-dlp
- Fully responsive and accessible

## Requirements
- Python 3.8+
- PHP 7.4+
- SQLite3 (PHP extension)
- yt-dlp (Python package)
- Windows 10/11 (tested)

## Directory Structure
- `public/` — All public-facing web files (index.php, video.php, contact.html, images, assets)
- `db/` — SQLite database (`videos.db`)
- `scripts/` — Python scripts for data fetching and tests
- `docs/` — Project plans, checklists, documentation

## Usage
1. **Fetch/update video data:**
   - Run `python scripts/update_videos.py` to fetch latest videos and update `db/videos.db`.
2. **Run tests:**
   - Python: `python scripts/test_update_videos.py`
   - PHP: `php public/test_video_functions.php`
3. **Serve the site:**
   - Use a local PHP server or deploy to any PHP-capable host.

## Troubleshooting & Maintenance
- If the database is missing or empty, the site will show a user-friendly error.
- If yt-dlp fails (network/API issues), check your internet connection and try again.
- To add new features, update the Python script and PHP pages as needed.
- All code is documented and checklists are up-to-date in `docs/`.

## Stack
- Python (yt-dlp, sqlite3)
- PHP (native SQLite3 extension)
- HTML/CSS/JS (no frameworks)

## Accessibility
- All images and iframes have alt/title attributes
- Color contrast and font sizes meet accessibility standards
- Keyboard navigation supported

## Maintenance Notes
- Update `scripts/update_videos.py` as YouTube or yt-dlp changes
- Review and re-run tests after any major change
- See `docs/` for project plan, schema, and checklists

## Contact
- See `public/contact.html` for contact info and social links

---

For more details, see `docs/project-plan.md` and the phase checklists in `docs/`.

## Design & Navigation
- **Top bar navigation** with logo (`logo-xprnt.png` left), and links to Home, Archive, and Contact
- **Background** uses `bk-one.png` with a parallax effect if the page scrolls
- **Fonts**: All text uses Atkinson Bold/Regular
- **Archive**: Placeholder page with "Coming Soon"
- **Contact**: Page with a simple form and social links

## Directory Structure
- `public/` — Main site files (HTML, assets, fonts, images)
- `public/assets/fonts/` — Atkinson font files
- `public/archive/` — Archive placeholder page
- `scripts/` — Python scripts for data fetching/caching
- `db/` — SQLite database for video data
- `docs/` — Project plan and design notes

## Contributors
- Thingerthing
- MattMoney
- Mark Rizzn Hopkins

## License
This website and its content are licensed under the [Creative Commons Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)](https://creativecommons.org/licenses/by-sa/4.0/). 