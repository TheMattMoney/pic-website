#!/usr/bin/env python3
"""
update_videos.py
Fetches video data from the Plastic Instruments Community YouTube channel using yt-dlp,
parses required fields, and stores/updates them in db/videos.db using the planned schema.

- Uses config/env for paths (no hardcoded sensitive data)
- Error handling included
- Only writes to db/ and scripts/
"""
import os
import sqlite3
import yt_dlp
import sys
from datetime import datetime

# Configurable paths (use env vars or defaults)
DB_PATH = os.environ.get('PI_DB_PATH', os.path.join(os.path.dirname(__file__), '..', 'db', 'videos.db'))
CHANNEL_URL = os.environ.get('PI_CHANNEL_URL', 'https://www.youtube.com/@PlasticInstrumentsCommunity')

# SQLite schema (for reference)
SCHEMA = '''
CREATE TABLE IF NOT EXISTS videos (
    id TEXT PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT,
    thumbnail_url TEXT,
    published_at TEXT,
    channel_title TEXT
);
'''

def get_video_entries(channel_url):
    ydl_opts = {
        'extract_flat': True,
        'quiet': True,
        'skip_download': True,
        'forcejson': True,
        'dump_single_json': True,
    }
    with yt_dlp.YoutubeDL(ydl_opts) as ydl:
        try:
            info = ydl.extract_info(channel_url, download=False)
            # info['entries'] is a list of video dicts
            return info.get('entries', []), info.get('uploader', None)
        except Exception as e:
            print(f"Error fetching channel data: {e}", file=sys.stderr)
            return [], None

def fetch_video_details(video_id):
    url = f"https://www.youtube.com/watch?v={video_id}"
    ydl_opts = {
        'quiet': True,
        'skip_download': True,
        'forcejson': True,
    }
    with yt_dlp.YoutubeDL(ydl_opts) as ydl:
        try:
            info = ydl.extract_info(url, download=False)
            return info
        except Exception as e:
            print(f"Error fetching video {video_id}: {e}", file=sys.stderr)
            return None

def init_db(conn):
    with conn:
        conn.execute(SCHEMA)

def upsert_video(conn, video):
    with conn:
        conn.execute('''
            INSERT INTO videos (id, title, description, thumbnail_url, published_at, channel_title)
            VALUES (?, ?, ?, ?, ?, ?)
            ON CONFLICT(id) DO UPDATE SET
                title=excluded.title,
                description=excluded.description,
                thumbnail_url=excluded.thumbnail_url,
                published_at=excluded.published_at,
                channel_title=excluded.channel_title;
        ''', (
            video['id'],
            video['title'],
            video.get('description', ''),
            video.get('thumbnail_url', ''),
            video.get('published_at', ''),
            video.get('channel_title', '')
        ))

def main():
    # Connect to DB
    conn = sqlite3.connect(DB_PATH)
    init_db(conn)

    # Fetch video list
    entries, channel_title = get_video_entries(CHANNEL_URL)
    if not entries:
        print("No videos found or failed to fetch channel.", file=sys.stderr)
        sys.exit(1)

    for entry in entries:
        video_id = entry.get('id')
        if not video_id:
            continue
        details = fetch_video_details(video_id)
        if not details:
            continue
        video = {
            'id': details.get('id'),
            'title': details.get('title', ''),
            'description': details.get('description', ''),
            'thumbnail_url': details.get('thumbnail', ''),
            'published_at': details.get('upload_date'),
            'channel_title': details.get('channel', channel_title or '')
        }
        # Convert upload_date to ISO 8601 if present
        if video['published_at']:
            try:
                dt = datetime.strptime(video['published_at'], '%Y%m%d')
                video['published_at'] = dt.isoformat()
            except Exception:
                pass
        upsert_video(conn, video)
        print(f"Updated: {video['id']} - {video['title']}")
    conn.close()

if __name__ == '__main__':
    main() 