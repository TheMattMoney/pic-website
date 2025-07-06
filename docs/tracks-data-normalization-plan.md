# tracks/ Data Normalization & Indexing Plan

## Overview
This document summarizes the current state of the `tracks/` directory, highlights data surprises, and presents key questions for SME (Subject Matter Expert) review before normalization and indexing.

---

## 1. Directory Structure (Observed Patterns)
- **Top-level:** Charter/artist or setlist folders.
- **Song folders:** Each contains at least:
  - `song.ini` (metadata)
  - `notes.chart` (chart data)
  - Audio file (various formats and naming)
  - Image file (various formats and naming, optional)
- **Occasional extras:** Some folders have additional files (e.g., `icon`, `playlist_track`, `background.jpg`, etc.)

---

## 2. `song.ini` Field Analysis
- **Section header:** `[Song]` (capitalized, not `[song]`)
- **Required fields:** `name`, `artist`, `album`, `genre`, `year`, `song_length`, `charter`
- **Difficulty fields:** Often only `diff_guitar` present; others (`diff_bass`, `diff_drums`, etc.) are sometimes missing or set to `-1`
- **Difficulty values:** Frequently out of spec (e.g., `diff_guitar = 14`)
- **Booleans:** Sometimes `0`/`1` instead of `true`/`false` (e.g., `modchart = 0`)
- **Extra fields:** Many files have fields not in the spec (e.g., `icon`, `album_track`, `playlist_track`, `delay`, `loading_phrase`, `rvtoken`)
- **Optional fields:** `preview_start_time` is common; `preview_end_time` is rare/missing
- **Whitespace:** Generally correct, but not always consistent

---

## 3. `notes.chart` File Structure
- **Sections:** `[Song]`, `[SyncTrack]`, `[Events]`, `[ExpertSingle]`, etc.
- **Metadata:** Redundant with `song.ini` but sometimes has different values (e.g., `Name`, `Artist`, `Album`, `Genre`)
- **Chart data:** Large, not relevant for metadata indexing, but may be useful for advanced features

---

## 4. Audio Files Analysis
- **Formats found:** `.ogg`, `.mp3`, `.opus`
- **Naming inconsistencies:**
  - `song.*` (most common)
  - `guitar.*` (separate guitar track)
  - `vocals.*` (separate vocals track)
  - Other names: `whatever_the_fuck.mp3`, `Blank-s.opus`, `steps.mp3`
- **File sizes:** Range from 0.0 KB to 36+ MB
- **Issues:**
  - Many folders have no audio files at all
  - Some have multiple audio files with unclear relationships
  - Duration metadata not consistently available
  - No standardized format or naming convention

---

## 5. Image Files Analysis
- **Formats found:** `.png`, `.jpg`, `.jpeg` (case-insensitive)
- **Naming inconsistencies:**
  - `album.png` (most common)
  - `album.jpg` (common)
  - `Album.png` (case variations)
  - `background.jpg` (additional background image)
  - Other names: various icon files, unrelated images
- **Dimensions:** Range from 28x28 to 1360x1360 pixels
- **Color modes:** RGB, RGBA, P (palette)
- **File sizes:** Range from 4.1 KB to 1.5+ MB
- **Issues:**
  - Many folders have no image files
  - Some have multiple images with unclear purposes
  - Some folders contain only unrelated images (e.g., icon packs)
  - No standardized format, dimensions, or naming convention

---

## 6. Surprises & Inconsistencies
- **Difficulty ratings**: Out of spec (values > 6)
- **Missing fields**: Many `song.ini` files lack some required fields from the spec
- **Extra fields**: Many fields not in the spec, but possibly useful for advanced features
- **Boolean fields**: Often stored as `0`/`1` instead of `true`/`false`
- **Section header case**: `[Song]` instead of `[song]`
- **Redundant/conflicting metadata**: Between `song.ini` and `notes.chart`
- **Asset availability**: Many folders missing audio and/or image files
- **Asset naming**: No standardized naming conventions for audio or image files
- **Asset formats**: Multiple formats with no clear preference or standardization
- **Asset quality**: Wide variation in image dimensions, audio file sizes, and quality

---

## Questions for SME Review

1. **Schema Normalization**
   - Should we strictly enforce the spec (e.g., clamp difficulty to -1..6, require all fields)?
   - How should we handle extra fields? (ignore, store, or flag for review)
   - Should we convert all booleans to `true`/`false`?
   - Is `[Song]` vs `[song]` a concern for our tooling?

2. **Missing/Out-of-Range Data**
   - What should we do if a required field is missing? (skip, warn, default value)
   - What about out-of-range difficulty values? (clamp, flag, or preserve as-is)

3. **Redundant Metadata**
   - Should we trust `song.ini` or `notes.chart` if they disagree?
   - Do we want to index any metadata from `notes.chart`?

4. **Audio File Normalization**
   - Should we standardize on a single format (e.g., `.opus` for quality, `.ogg` for compatibility)?
   - How should we handle multiple audio files (e.g., separate guitar/vocals tracks)?
   - What should we do with folders missing audio files?
   - Should we enforce a standard naming convention (e.g., `song.opus`)?

5. **Image File Normalization**
   - Should we standardize on a single format (e.g., `.png` for transparency, `.jpg` for photos)?
   - Should we enforce standard dimensions (e.g., 500x500, 1000x1000)?
   - How should we handle multiple images (e.g., album art + background)?
   - What should we do with folders missing image files?
   - Should we convert palette images to RGB/RGBA?

6. **Asset Quality Control**
   - Should we set minimum/maximum file size limits?
   - Should we enforce minimum image dimensions?
   - How should we handle corrupted or unreadable files?

7. **Indexing & Search**
   - Which fields are most important for search/filter (e.g., name, artist, genre, year, charter, difficulty)?
   - Should we index extra fields (e.g., `modchart`, `loading_phrase`, `rvtoken`)?
   - Should we index audio duration and image dimensions for filtering?

8. **Automation & Validation**
   - Should normalization be automatic, or should we flag files for manual review?
   - How should we handle future additions/changes to the folder structure?
   - Should we create a validation script that checks all assets before indexing?

---

## Sample Normalization/Indexing Plan (for SME Feedback)

1. **Parse all `song.ini` files**
2. **Normalize fields:**
   - Clamp difficulty to -1..6
   - Convert booleans to `true`/`false`
   - Fill missing required fields with defaults or flag
   - Store extra fields in a separate JSON blob
3. **Audio file processing:**
   - Standardize format to `.opus` (or preferred format)
   - Enforce naming convention (`song.opus`)
   - Extract duration and bitrate metadata
   - Flag folders with missing or multiple audio files
4. **Image file processing:**
   - Standardize format to `.png` (or preferred format)
   - Enforce naming convention (`album.png`)
   - Resize to standard dimensions (e.g., 500x500)
   - Convert palette images to RGB/RGBA
   - Flag folders with missing or multiple images
5. **Index key metadata for search**
6. **Flag files with major issues for manual review**
7. **Document all normalization rules and edge cases** 