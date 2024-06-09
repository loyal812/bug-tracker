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
    <script>
        document.addEventListener('htmx:configRequest', function(event) {
            if (document.activeElement && document.activeElement !== document.body) {
                event.detail.headers['HX-Trigger'] = 'htmx:no-request';
            }
        });

        document.addEventListener('htmx:afterRequest', function(event) {
            if (event.detail.requestConfig.headers['HX-Trigger'] === 'htmx:no-request') {
                event.preventDefault();
            }
        });

        function fetchBugs() {
            if (document.activeElement && document.activeElement !== document.body) {
                return;
            }
            fetch('/core/list_bugs.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    var bugList = document.getElementById('bug-list');
                    bugList.innerHTML = '';
                    data.forEach(bug => {
                        bugList.innerHTML += `
                            <div class="bg-white p-4 rounded shadow mb-2">
                                <form hx-post="/core/update_bug.php" hx-target="#notification">
                                <h2 class="text-xl font-bold">${bug.title}</h2>
                                <input type="hidden" name="title" value="${bug.title}">
                                <p>${bug.description}</p>
                                <p><strong>Urgency:</strong> ${bug.urgency}</p>
                                <p><strong>Status:</strong> ${bug.status}</p>
                                    <input type="hidden" name="id" value="${bug.id}">
                                    <label>Status</label>
                                    <select name="status" class="mt-1 p-2 border rounded w-full mb-2">
                                        <option value="open" ${bug.status === 'open' ? 'selected' : ''}>Open</option>
                                        <option value="in progress" ${bug.status === 'in progress' ? 'selected' : ''}>In Progress</option>
                                        <option value="closed" ${bug.status === 'closed' ? 'selected' : ''}>Closed</option>
                                    </select>
                                    <label>Comment</label>
                                    <textarea name="comment" class="mt-1 p-2 border rounded w-full mb-2"></textarea>
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update</button>
                                </form>
                            </div>
                        `;
                    });
                    htmx.process(bugList);
                })
                .catch(error => console.error('Error:', error));
        }

        fetchBugs();
        setInterval(fetchBugs, 5000);
    </script>
</body>

</html>