import unittest
from unittest.mock import patch, MagicMock
import update_videos
import sqlite3

class TestUpdateVideos(unittest.TestCase):
    @patch('update_videos.yt_dlp.YoutubeDL')
    def test_get_video_entries_success(self, mock_yt):
        mock_ydl = MagicMock()
        mock_yt.return_value.__enter__.return_value = mock_ydl
        mock_ydl.extract_info.return_value = {
            'entries': [{'id': 'abc123'}],
            'uploader': 'Test Channel'
        }
        entries, uploader = update_videos.get_video_entries('dummy_url')
        self.assertEqual(len(entries), 1)
        self.assertEqual(uploader, 'Test Channel')

    @patch('update_videos.yt_dlp.YoutubeDL')
    def test_get_video_entries_error(self, mock_yt):
        mock_ydl = MagicMock()
        mock_yt.return_value.__enter__.return_value = mock_ydl
        mock_ydl.extract_info.side_effect = Exception('fail')
        entries, uploader = update_videos.get_video_entries('dummy_url')
        self.assertEqual(entries, [])
        self.assertIsNone(uploader)

    @patch('update_videos.yt_dlp.YoutubeDL')
    def test_fetch_video_details_success(self, mock_yt):
        mock_ydl = MagicMock()
        mock_yt.return_value.__enter__.return_value = mock_ydl
        mock_ydl.extract_info.return_value = {'id': 'abc123', 'title': 'Test'}
        info = update_videos.fetch_video_details('abc123')
        self.assertEqual(info['id'], 'abc123')
        self.assertEqual(info['title'], 'Test')

    @patch('update_videos.yt_dlp.YoutubeDL')
    def test_fetch_video_details_error(self, mock_yt):
        mock_ydl = MagicMock()
        mock_yt.return_value.__enter__.return_value = mock_ydl
        mock_ydl.extract_info.side_effect = Exception('fail')
        info = update_videos.fetch_video_details('abc123')
        self.assertIsNone(info)

    def test_upsert_video(self):
        conn = sqlite3.connect(':memory:')
        update_videos.init_db(conn)
        video = {
            'id': 'abc123',
            'title': 'Test',
            'description': 'desc',
            'thumbnail_url': 'url',
            'published_at': '2024-01-01T00:00:00',
            'channel_title': 'Test Channel'
        }
        update_videos.upsert_video(conn, video)
        cur = conn.execute('SELECT * FROM videos WHERE id=?', ('abc123',))
        row = cur.fetchone()
        self.assertIsNotNone(row)
        self.assertEqual(row[0], 'abc123')
        self.assertEqual(row[1], 'Test')
        # Test update
        video['title'] = 'Updated'
        update_videos.upsert_video(conn, video)
        cur = conn.execute('SELECT * FROM videos WHERE id=?', ('abc123',))
        row = cur.fetchone()
        self.assertEqual(row[1], 'Updated')
        conn.close()

if __name__ == '__main__':
    unittest.main() 