<?php
require './db/sqlite.php';
require '../vendor/autoload.php';


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $urgency = $_POST['urgency'];

    $db = getDbConnection();
    $stmt = $db->prepare('INSERT INTO bugs (title, description, urgency) VALUES (?, ?, ?)');
    $stmt->execute([$title, $description, $urgency]);

    echo 'Thank you!';
}
