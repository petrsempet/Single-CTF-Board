<?php
$db = new SQLite3(__DIR__ . '/settings/answers.db');
$db->exec('DELETE FROM answers;');
echo 'Done';