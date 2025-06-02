<?php
require_once 'video.php';

echo "Testing get_video_by_id...\n";

$db_path = realpath(__DIR__ . '/../db/videos.db');

// Test with a valid ID (replace with a real ID from your DB for a real test)
$test_id = 'test_id';
list($video, $error) = get_video_by_id($db_path, $test_id);
echo "Test valid ID: ";
echo ($video ? "PASS\n" : "FAIL ($error)\n");

// Test with an invalid ID
$test_id = 'nonexistent_id';
list($video, $error) = get_video_by_id($db_path, $test_id);
echo "Test invalid ID: ";
echo ($error === 'Video not found.' ? "PASS\n" : "FAIL\n");

// Test with missing ID
$test_id = '';
list($video, $error) = get_video_by_id($db_path, $test_id);
echo "Test missing ID: ";
echo ($error === 'No video ID specified.' ? "PASS\n" : "FAIL\n");

// Test with missing DB
$bad_db_path = __DIR__ . '/../db/does_not_exist.db';
list($video, $error) = get_video_by_id($bad_db_path, 'any');
echo "Test missing DB: ";
echo ($error === 'Database not found.' ? "PASS\n" : "FAIL\n"); 