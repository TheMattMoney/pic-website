# .chart File Format Specification

## Overview
The .chart file format is a text-based format used to store rhythm game chart data. It consists of multiple sections, each containing different types of data for the song, including metadata, timing information, and note data.

## File Structure
The file is divided into several major sections, each enclosed in square brackets and curly braces:

```
[SectionName]
{
    // Content
}
```

## Sections

### 1. [Song] Section
Contains song metadata and audio file paths.

#### Format
```
[Song]
{
    // Audio file paths
    MusicStream = "path/to/audio.mp3"
    GuitarStream = "path/to/guitar.mp3"
    BassStream = "path/to/bass.mp3"
    RhythmStream = "path/to/rhythm.mp3"
    KeysStream = "path/to/keys.mp3"
    DrumStream = "path/to/drums.mp3"
    Drum2Stream = "path/to/drums2.mp3"
    Drum3Stream = "path/to/drums3.mp3"
    Drum4Stream = "path/to/drums4.mp3"
    VocalStream = "path/to/vocals.mp3"
    CrowdStream = "path/to/crowd.mp3"
    
    // Song properties
    Offset = 0
    Resolution = 192
    Name = "Song Name"
    Artist = "Artist Name"
    Charter = "Charter Name"
}
```

### 2. [SyncTrack] Section
Contains timing information including BPM and time signature changes.

#### Format
```
[SyncTrack]
{
    // BPM changes
    {tick} = B {bpm_value}
    
    // Time signature changes
    {tick} = TS {numerator} {denominator}
}
```

#### Notes
- `tick`: Position in the song (integer)
- `bpm_value`: Beats per minute (float)
- `numerator`: Time signature top number (integer)
- `denominator`: Time signature bottom number (integer)

### 3. [Events] Section
Contains global events and sections.

#### Format
```
[Events]
{
    // Sections
    {tick} = E "section {section_name}"
    
    // Events
    {tick} = E "{event_text}"
}
```

#### Common Event Types
- `section`: Marks a section in the song (e.g., "section verse")
- `lyric`: Contains lyrics (e.g., "lyric This is a lyric")
- `phrase_start`: Marks the start of a vocal phrase
- `phrase_end`: Marks the end of a vocal phrase

### 4. Instrument Tracks
Each instrument has its own section for each difficulty level.

#### Format
```
[Instrument][Difficulty]
{
    // Notes
    {tick} = N {note_number} {length}
    
    // Star Power
    {tick} = S 2 {length}
    
    // Drum Rolls
    {tick} = S 64 {length}  // Standard
    {tick} = S 65 {length}  // Special
    
    // Chart Events
    {tick} = E {event_number}
}
```

#### Instrument Track Names
- `[ExpertSingle]` - Expert Guitar
- `[HardSingle]` - Hard Guitar
- `[MediumSingle]` - Medium Guitar
- `[EasySingle]` - Easy Guitar
- `[ExpertDoubleBass]` - Expert Bass
- `[ExpertDoubleRhythm]` - Expert Rhythm
- `[ExpertDrums]` - Expert Drums
- `[ExpertGHLGuitar]` - Expert GHL Guitar
- `[ExpertGHLBass]` - Expert GHL Bass
- `[ExpertGHLRhythm]` - Expert GHL Rhythm

#### Note Numbers

##### Guitar (5-fret)
- 0: Green
- 1: Red
- 2: Yellow
- 3: Blue
- 4: Orange
- 5: Open
- 6: Tap
- 7: Star Power
- 8: Force HOPO
- 9: Force Strum

##### Drums
- 0: Kick
- 1: Red
- 2: Yellow
- 3: Blue
- 4: Orange
- 5: Green
- 6: Double Kick
- 7: Star Power
- 8: Force HOPO
- 9: Force Strum

##### GHL (6-fret)
- 0: Black 1
- 1: Black 2
- 2: Black 3
- 3: White 1
- 4: White 2
- 5: White 3
- 6: Open
- 7: Star Power
- 8: Force HOPO
- 9: Force Strum

#### Special Note Flags
- Star Power: `S 2 {length}`
- Drum Roll (Standard): `S 64 {length}`
- Drum Roll (Special): `S 65 {length}`
- Chart Event: `E {event_number}`

## File Encoding
- The file should be saved in UTF-8 encoding
- Line endings can be either CRLF (\r\n) or LF (\n)
- All strings should be enclosed in double quotes

## Resolution and Timing
- The default resolution is 192 ticks per beat
- BPM values are stored as floating-point numbers
- Time signatures are stored as two integers (numerator/denominator)
- All timing is based on ticks, which are converted to seconds using the BPM

## Best Practices
1. Always include a [Song] section with at least the basic metadata
2. Include a [SyncTrack] section with at least one BPM marker
3. Use the [Events] section to mark important song sections
4. Keep note numbers consistent with the instrument type
5. Use appropriate difficulty levels for each track
6. Include Star Power sections where appropriate
7. Use proper drum roll types for drum tracks

## Example
```
[Song]
{
    Resolution = 192
    Offset = 0
    Name = "Example Song"
    Artist = "Example Artist"
    Charter = "Example Charter"
    MusicStream = "song.ogg"
}

[SyncTrack]
{
    0 = B 120
    0 = TS 4 4
}

[Events]
{
    0 = E "section intro"
    768 = E "section verse"
}

[ExpertSingle]
{
    0 = N 0 0
    192 = N 1 0
    384 = N 2 0
    576 = N 3 0
    768 = N 4 0
    960 = S 2 192
}
``` 