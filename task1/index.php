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
<script>
    var sts = "";

    function fetchBugs() {
        if (document.getElementById("id_title") != null) {
            var id_title = document.getElementById("id_title").value;
            fetch('/core/find_bug.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        compare: id_title,
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    var not = document.getElementById('notification');
                    if (data.length != 0) {
                        var com = data[data.length - 1];
                        if (com.status != sts) alert("Status : " + com.status + "\n" + "Comment : " + com.comment);
                        sts = com.status;
                        not.innerHTML = `<div class="bg-white p-4"><p class="text-4xl">Comment</p><p class="text-xl text-black mt-6">${com.comment}</p></div>`;
                    }
                    htmx.process(not);
                })
                .catch(error => console.error('Error:', error));
        }
    }

    fetchBugs();
    setInterval(fetchBugs, 5000);
</script>

</html>