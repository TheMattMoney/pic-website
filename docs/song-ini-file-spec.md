# song.ini File Format Specification

## Overview
The song.ini file is a configuration file used to store metadata and settings for rhythm game charts. It follows a simple key-value format with a single section.

## File Structure
The file consists of a single section header followed by key-value pairs:

```
[song]
key = value
```

## Required Fields

### Basic Metadata
```
name = Song Name
artist = Artist Name
album = Album Name
genre = Genre
year = Year
song_length = LengthInMilliseconds
charter = Charter Name
```

### Difficulty Ratings
```
diff_guitar = Difficulty
diff_rhythm = Difficulty
diff_bass = Difficulty
diff_drums = Difficulty
diff_keys = Difficulty
diff_guitarghl = Difficulty
diff_bassghl = Difficulty
diff_rhythmghl = Difficulty
diff_band = Difficulty
```

## Optional Fields

### Audio Settings
```
preview_start_time = StartTimeInMilliseconds
preview_end_time = EndTimeInMilliseconds
```

### Game-Specific Settings
```
modchart = true/false
video_start_time = StartTimeInSeconds
```

## Field Specifications

### Basic Metadata
- `name`: The name of the song (string)
- `artist`: The name of the artist/band (string)
- `album`: The name of the album (string)
- `genre`: The genre of the song (string)
- `year`: The year the song was released (string)
- `song_length`: Length of the song in milliseconds (integer)
- `charter`: Name of the person who created the chart (string)

### Difficulty Ratings
- Values range from -1 to 6
- -1: Uninitialized/Not set
- 0: Easy
- 1: Medium
- 2: Hard
- 3: Expert
- 4: Expert+
- 5: Expert++
- 6: Expert+++

### Audio Settings
- `preview_start_time`: Start time of the preview in milliseconds (integer)
- `preview_end_time`: End time of the preview in milliseconds (integer)

### Game-Specific Settings
- `modchart`: Whether the chart uses modchart features (boolean)
- `video_start_time`: Start time of the video in seconds (float)

## Format Rules

### Whitespace
- There should be a space before and after the equals sign for maximum compatibility
- Example: `name = Song Name` (not `name=Song Name`)

### String Values
- String values should not be enclosed in quotes
- Special characters are allowed
- UTF-8 encoding is recommended

### Numeric Values
- Integers should not have decimal points
- Floats should use period as decimal separator
- No thousand separators

### Boolean Values
- Use `true` or `false` (lowercase)
- No quotes around boolean values

## File Encoding
- UTF-8 encoding is recommended
- Line endings can be either CRLF (\r\n) or LF (\n)
- No BOM (Byte Order Mark) should be used

## Best Practices
1. Always include the basic metadata fields
2. Use appropriate difficulty ratings
3. Include preview times if available
4. Keep the file clean and well-formatted
5. Use consistent spacing around equals signs
6. Use appropriate file encoding
7. Include game-specific settings when applicable

## Example
```
[song]
name = Example Song
artist = Example Artist
album = Example Album
genre = Rock
year = 2024
song_length = 180000
charter = Example Charter
diff_guitar = 3
diff_rhythm = 2
diff_bass = 3
diff_drums = 4
diff_keys = 2
preview_start_time = 40000
preview_end_time = 50000
modchart = false
```

## Common Issues
1. Missing spaces around equals signs
2. Incorrect difficulty ratings
3. Missing required fields
4. Incorrect file encoding
5. Inconsistent line endings
6. Missing section header
7. Incorrect numeric formats

## Validation
When implementing a parser, ensure:
1. The [song] section header is present
2. Required fields are present
3. Difficulty ratings are within valid range
4. Numeric values are properly formatted
5. Boolean values are valid
6. String values are properly encoded
7. Whitespace rules are followed 
song_ini_spec.md
4 KB