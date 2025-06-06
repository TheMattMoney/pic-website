# Project Plan: Plastic Instruments Video Grid Website

## Overview
The goal is to create a home page that displays a grid of videos from the [Plastic Instruments Community YouTube channel](https://www.youtube.com/@PlasticInstrumentsCommunity/). Clicking a video leads to a detail page with an embedded video, description, and post time. Video data is fetched and cached using a Python script with yt-dlp, storing results in a local SQLite database (`db/videos.db`). The site reads from this database for fast, API-free performance.

---

# Design Notes

## Top Bar Navigation
- Horizontal navigation bar at the top of the page.
- `logo-xprnt.png` in the top left.
- Navigation links: Home, Archive, Contact (right of logo).
- Use Atkinson fonts for all text.

## Background
- Use `bk-one.png` as the default background image.
- If the page scrolls, implement a parallax effect for the background.

## General Style
- Color palette should complement the logo and background.
- Responsive design for desktop and mobile.

## Archive Page
- Archive is a placeholder for now, with a 'Coming Soon' message.

---

# Implementation Phases

## Phase 1: Project Setup & Planning
- Set up `docs/` folder and this project plan.
- Create `db/` directory for the SQLite database.
- Create `scripts/` directory for all Python scripts.
- Define and document the SQLite schema (see below).

## Phase 2: Data Collection & Caching
- Write a Python script (`scripts/update_videos.py`) using `yt-dlp` to fetch and cache video data from the YouTube channel.
- Store results in `db/videos.db` using the defined schema.
- Set up a cron job to run the script hourly (or as needed).
- Test that the script populates the database correctly.

### SQLite Schema Example
```sql
CREATE TABLE videos (
    id TEXT PRIMARY KEY,           -- YouTube video ID
    title TEXT NOT NULL,
    description TEXT,
    thumbnail_url TEXT,
    published_at TEXT,             -- ISO 8601 datetime string
    channel_title TEXT
);
```

## Phase 3: Home Page (Video Grid)
- Build the home page in PHP:
    - Read video data from the SQLite DB.
    - Display a grid of video thumbnails and titles.
    - Each video links to a detail page using a query string (e.g., `video.php?id=VIDEO_ID`).
- Ensure responsive design for desktop and mobile.
- Apply site fonts and consistent styling.

## Phase 4: Video Detail Page
- Build the video detail page in PHP:
    - Parse the video ID from the query string.
    - Embed the YouTube video (iframe, nearly full width, centered).
    - Show video description and published time below the embed.
    - Add a back link to the home page.
    - Ensure consistent site styling.

## Phase 5: Testing & Documentation
- Test the full workflow: data fetching, caching, and page rendering.
- Test fallback behavior if the database is unavailable or empty.
- Document usage, deployment, and maintenance steps in the README.

## Phase 6: Future Enhancements (Optional)
- Pagination or infinite scroll for large video lists.
- Search or filter by title/description.
- Download and serve thumbnails locally to avoid hotlinking.
- Analytics for video clicks/views.

---

## Lessons Learned & Changes
- Parallax background was switched to `bk-three.png` for better effect and accessibility.
- Navigation bar uses the logo as the home button for a cleaner UI.
- All database access uses the native PHP SQLite3 extension for performance and simplicity.
- All input/output is sanitized and error handling is robust.
- Unit and integration tests are provided for both Python and PHP components.
- Accessibility and responsiveness were prioritized throughout.

## Final SQLite Schema
```sql
CREATE TABLE videos (
    id TEXT PRIMARY KEY,           -- YouTube video ID
    title TEXT NOT NULL,
    description TEXT,
    thumbnail_url TEXT,
    published_at TEXT,             -- ISO 8601 datetime string
    channel_title TEXT
);
```

---

## References
- [yt-dlp Documentation](https://github.com/yt-dlp/yt-dlp)
- [SQLite Documentation](https://www.sqlite.org/docs.html)
- [Plastic Instruments Community YouTube Channel](https://www.youtube.com/@PlasticInstrumentsCommunity/) 