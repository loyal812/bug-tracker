<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /core/auth/auth.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Tracker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.5.0/dist/htmx.min.js"></script>
</head>

<body class="bg-gray-100 p-4">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Bug Tracker Dashboard</h1>
        <div id="bug-list" class=""></div>
        <div id="notification" class="mt-4"></div>
    </div>
</body>

</html>