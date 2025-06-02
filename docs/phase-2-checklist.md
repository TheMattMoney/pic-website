# Phase 2 Checklist: Data Collection & Caching

This checklist is for Phase 2 of the Plastic Instruments Video Grid Website project. Complete each item before moving to the next phase. Negative prompts (what NOT to do), a unit and integration testing phase, and explicit success criteria are included.

---

## ✅ Python Script Development
- [ ] Write the main Python script (`scripts/update_videos.py`) to:
    - [ ] Use `yt-dlp` to fetch video data from the Plastic Instruments Community YouTube channel.
    - [ ] Parse and extract: video ID, title, description, thumbnail URL, published time, channel title.
    - [ ] Store/update this data in the SQLite database at `db/videos.db` using the planned schema.
- [ ] Ensure the script is well-documented and includes error handling.
- [ ] DO NOT hardcode sensitive data or paths; use config or environment variables where appropriate.
- [ ] DO NOT write to any directory outside `db/` for the database or `scripts/` for the script.

## ✅ Cron Job Setup (this will need to be done by the human sysadmin).
- [ ] Set up a cron job (or Windows Task Scheduler) to run `scripts/update_videos.py` at the desired interval (e.g., hourly).
- [ ] Ensure the cron job logs output and errors for debugging.
- [ ] DO NOT schedule the job more frequently than necessary (avoid API or scraping bans).

## ✅ SQLite Database
- [ ] Create the SQLite database at `db/videos.db` using the documented schema.
- [ ] Ensure the database file is readable and writable by both the Python script and the PHP site.
- [ ] DO NOT store the database in a public or web-accessible directory.

## ✅ Data Validation
- [ ] Validate that the script correctly fetches and stores all required fields for each video.
- [ ] Check for duplicate entries and ensure the script updates existing records as needed.
- [ ] DO NOT allow incomplete or malformed data into the database.

## ✅ Unit & Integration Testing
- [ ] Write unit tests for the Python script's core functions (fetching, parsing, database writing).
- [ ] Write integration tests to:
    - [ ] Run the script and verify the database is populated with real data.
    - [ ] Simulate API failures or network issues and verify fallback/error handling.
- [ ] Test the cron job/task scheduler to ensure it runs the script as expected.
- [ ] DO NOT skip tests or ignore test failures.

## ✅ Success Criteria
- [ ] The script reliably fetches and updates video data in `db/videos.db`.
- [ ] The database contains accurate, up-to-date, and complete video records.
- [ ] The cron job/task scheduler runs the script at the correct interval without errors.
- [ ] All unit and integration tests pass.
- [ ] No sensitive data is exposed or stored in public directories.
- [ ] The process is documented for future maintenance.

## ✅ General
- [ ] Review all code and documentation for clarity and completeness.
- [ ] Ensure all negative prompts (what NOT to do) are considered and followed.
- [ ] DO NOT proceed to Phase 3 until every item on this checklist is complete and verified.

---

**Note:** Check off each item as you complete it. If any item is not applicable, note why before moving on. 