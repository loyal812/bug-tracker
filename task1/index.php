<!-- index.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.5.0/dist/htmx.min.js"></script>
</head>

<body class="bg-gray-100 p-4">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Hello World</h1>
        <button class="bg-blue-500 text-white py-2 px-4 rounded" hx-get="/core/report_bug_form.php" hx-target="#bug-form">Report a Bug</button>
        <div id="bug-form"></div>
        <div id="notification" class="mt-6 text-9xl text-red-600 text-center font-bold">
        </div>
    </div>
</body>
</html>