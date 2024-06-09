<?php
require './db/sqlite.php';

header('Content-Type: application/json'); // Ensure the response is in JSON format

try {
    $db = getDbConnection();
    $bugs = $db->query('SELECT * FROM bugs')->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($bugs);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
