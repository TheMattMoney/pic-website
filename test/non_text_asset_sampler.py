#!/usr/bin/env python3
"""
Non-text Asset Sampler for tracks/ Directory

This script samples song folders in the tracks/ directory and reports on the presence,
format, and properties of audio and image files. It provides detailed analysis for
normalization planning.
"""

import os
import sys
from pathlib import Path
from PIL import Image
import mimetypes
import json
from collections import defaultdict, Counter

# Try to import audio metadata libraries
try:
    import mutagen
    AUDIO_SUPPORT = True
except ImportError:
    AUDIO_SUPPORT = False
    print("Warning: mutagen not installed. Audio duration/bitrate will not be extracted.")
    print("Install with: pip install mutagen")

def get_audio_metadata(file_path):
    """Extract audio metadata using mutagen."""
    if not AUDIO_SUPPORT:
        return None
    
    try:
        audio = mutagen.File(file_path)
        if audio is None:
            return None
        
        metadata = {}
        
        # Duration
        if hasattr(audio, 'info') and hasattr(audio.info, 'length'):
            metadata['duration'] = audio.info.length
        elif hasattr(audio, 'length'):
            metadata['duration'] = audio.length
        
        # Bitrate
        if hasattr(audio, 'info') and hasattr(audio.info, 'bitrate'):
            metadata['bitrate'] = audio.info.bitrate
        elif hasattr(audio, 'bitrate'):
            metadata['bitrate'] = audio.bitrate
        
        # Sample rate
        if hasattr(audio, 'info') and hasattr(audio.info, 'sample_rate'):
            metadata['sample_rate'] = audio.info.sample_rate
        elif hasattr(audio, 'sample_rate'):
            metadata['sample_rate'] = audio.sample_rate
        
        return metadata
    except Exception as e:
        return None

def analyze_image_file(file_path):
    """Analyze an image file and return its properties."""
    try:
        with Image.open(file_path) as img:
            # Get basic properties
            width, height = img.size
            mode = img.mode
            format_name = img.format
            
            # Get file size
            file_size = os.path.getsize(file_path)
            
            return {
                'width': width,
                'height': height,
                'mode': mode,
                'format': format_name,
                'size_bytes': file_size,
                'size_kb': file_size / 1024
            }
    except Exception as e:
        return {'error': str(e)}

def analyze_audio_file(file_path):
    """Analyze an audio file and return its properties."""
    try:
        # Get file size
        file_size = os.path.getsize(file_path)
        
        # Get basic info
        info = {
            'size_bytes': file_size,
            'size_kb': file_size / 1024,
            'extension': Path(file_path).suffix.lower()
        }
        
        # Get metadata if available
        metadata = get_audio_metadata(file_path)
        if metadata:
            info.update(metadata)
        
        return info
    except Exception as e:
        return {'error': str(e)}

def find_media_files(folder_path):
    """Find all audio and image files in a folder."""
    audio_extensions = {'.mp3', '.ogg', '.opus', '.wav', '.flac', '.m4a', '.aac'}
    image_extensions = {'.png', '.jpg', '.jpeg', '.gif', '.bmp', '.tiff', '.webp'}
    
    audio_files = []
    image_files = []
    
    try:
        for file_path in Path(folder_path).iterdir():
            if file_path.is_file():
                ext = file_path.suffix.lower()
                if ext in audio_extensions:
                    audio_files.append(file_path)
                elif ext in image_extensions:
                    image_files.append(file_path)
    except Exception as e:
        print(f"Error reading folder {folder_path}: {e}")
    
    return audio_files, image_files

def sample_tracks_directory(tracks_path, sample_size=50):
    """Sample song folders in the tracks directory."""
    tracks_path = Path(tracks_path)
    
    if not tracks_path.exists():
        print(f"Error: {tracks_path} does not exist")
        return
    
    # Find all song folders (folders containing song.ini)
    song_folders = []
    for root, dirs, files in os.walk(tracks_path):
        if 'song.ini' in files:
            song_folders.append(Path(root))
    
    print(f"Found {len(song_folders)} song folders")
    
    # Sample folders
    if len(song_folders) <= sample_size:
        sampled_folders = song_folders
    else:
        import random
        sampled_folders = random.sample(song_folders, sample_size)
    
    # Analysis results
    audio_stats = defaultdict(list)
    image_stats = defaultdict(list)
    folder_stats = {
        'total_folders': len(sampled_folders),
        'folders_with_audio': 0,
        'folders_with_images': 0,
        'folders_with_both': 0,
        'folders_with_neither': 0
    }
    
    print(f"\nAnalyzing {len(sampled_folders)} folders...\n")
    
    for folder in sampled_folders:
        relative_path = folder.relative_to(tracks_path)
        print(f"Folder: {relative_path}")
        
        audio_files, image_files = find_media_files(folder)
        
        # Audio analysis
        if audio_files:
            folder_stats['folders_with_audio'] += 1
            for audio_file in audio_files:
                info = analyze_audio_file(audio_file)
                info['filename'] = audio_file.name
                info['folder'] = str(relative_path)
                audio_stats[audio_file.suffix.lower()].append(info)
                print(f"  Audio: {audio_file.name} | {info['size_kb']:.1f} KB", end="")
                if 'duration' in info:
                    print(f" | Duration: {info['duration']:.1f}s", end="")
                if 'bitrate' in info:
                    print(f" | Bitrate: {info['bitrate']} kbps", end="")
                print()
        else:
            print("  [!] No audio files found!")
        
        # Image analysis
        if image_files:
            folder_stats['folders_with_images'] += 1
            for image_file in image_files:
                info = analyze_image_file(image_file)
                info['filename'] = image_file.name
                info['folder'] = str(relative_path)
                image_stats[image_file.suffix.lower()].append(info)
                print(f"  Image: {image_file.name} | {info['size_kb']:.1f} KB | ({info['width']}, {info['height']}) | {info['mode']}")
        else:
            print("  [!] No image files found!")
        
        # Update combined stats
        if audio_files and image_files:
            folder_stats['folders_with_both'] += 1
        elif not audio_files and not image_files:
            folder_stats['folders_with_neither'] += 1
        
        print()
    
    # Generate summary report
    print("=" * 80)
    print("SUMMARY REPORT")
    print("=" * 80)
    
    print(f"\nFolder Statistics:")
    print(f"  Total folders analyzed: {folder_stats['total_folders']}")
    print(f"  Folders with audio: {folder_stats['folders_with_audio']} ({folder_stats['folders_with_audio']/folder_stats['total_folders']*100:.1f}%)")
    print(f"  Folders with images: {folder_stats['folders_with_images']} ({folder_stats['folders_with_images']/folder_stats['total_folders']*100:.1f}%)")
    print(f"  Folders with both: {folder_stats['folders_with_both']} ({folder_stats['folders_with_both']/folder_stats['total_folders']*100:.1f}%)")
    print(f"  Folders with neither: {folder_stats['folders_with_neither']} ({folder_stats['folders_with_neither']/folder_stats['total_folders']*100:.1f}%)")
    
    print(f"\nAudio File Analysis:")
    if audio_stats:
        for ext, files in audio_stats.items():
            print(f"  {ext.upper()}: {len(files)} files")
            if files:
                sizes = [f['size_kb'] for f in files if 'size_kb' in f]
                if sizes:
                    print(f"    Size range: {min(sizes):.1f} - {max(sizes):.1f} KB")
                    print(f"    Average size: {sum(sizes)/len(sizes):.1f} KB")
                
                durations = [f['duration'] for f in files if 'duration' in f]
                if durations:
                    print(f"    Duration range: {min(durations):.1f} - {max(durations):.1f} seconds")
                    print(f"    Average duration: {sum(durations)/len(durations):.1f} seconds")
    else:
        print("  No audio files found")
    
    print(f"\nImage File Analysis:")
    if image_stats:
        for ext, files in image_stats.items():
            print(f"  {ext.upper()}: {len(files)} files")
            if files:
                sizes = [f['size_kb'] for f in files if 'size_kb' in f]
                if sizes:
                    print(f"    Size range: {min(sizes):.1f} - {max(sizes):.1f} KB")
                    print(f"    Average size: {sum(sizes)/len(sizes):.1f} KB")
                
                dimensions = [(f['width'], f['height']) for f in files if 'width' in f and 'height' in f]
                if dimensions:
                    min_dim = min(dimensions, key=lambda x: x[0] * x[1])
                    max_dim = max(dimensions, key=lambda x: x[0] * x[1])
                    print(f"    Dimension range: {min_dim[0]}x{min_dim[1]} - {max_dim[0]}x{max_dim[1]}")
                
                modes = Counter(f['mode'] for f in files if 'mode' in f)
                print(f"    Color modes: {dict(modes)}")
    else:
        print("  No image files found")
    
    # Save detailed results to JSON
    results = {
        'folder_stats': folder_stats,
        'audio_stats': dict(audio_stats),
        'image_stats': dict(image_stats),
        'timestamp': str(Path.cwd())
    }
    
    output_file = Path('test') / 'asset_analysis_results.json'
    with open(output_file, 'w') as f:
        json.dump(results, f, indent=2, default=str)
    
    print(f"\nDetailed results saved to: {output_file}")

if __name__ == "__main__":
    tracks_path = "archive/tracks"
    sample_size = 50
    
    if len(sys.argv) > 1:
        tracks_path = sys.argv[1]
    if len(sys.argv) > 2:
        sample_size = int(sys.argv[2])
    
    sample_tracks_directory(tracks_path, sample_size) 