<?php
require './db/sqlite.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $comment = $_POST['comment'] ?? null;
        $title = $_POST['title'];

        $db = getDbConnection();
        $stmt = $db->prepare('UPDATE bugs SET status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);

        if ($comment) {
            $stmt = $db->prepare('INSERT INTO comments (bug_id, comment ,title ,status) VALUES (?, ?, ?, ?)');
            $stmt->execute([$id, $comment, $title, $status]);
        }

        echo "Bug status updated!";
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
