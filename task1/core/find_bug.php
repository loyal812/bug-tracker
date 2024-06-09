<?php
require './db/sqlite.php';
require '../vendor/autoload.php';

header('Content-Type: application/json');

try {
    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    // Get the compare parameter from POST request
    if (!isset($data['compare'])) {
        throw new Exception('Missing parameter: compare');
    }
    $compare = $data['compare'];

    // Get database connection
    $db = getDbConnection();

    // Prepare and execute the SQL statement
    $stmt = $db->prepare('SELECT * FROM comments WHERE title = ?');
    $stmt->execute([$compare]);
    $bugs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($bugs);
} catch (PDOException $e) {
    // Return PDO errors as JSON
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    // Return general errors as JSON
    echo json_encode(['error' => $e->getMessage()]);
}
