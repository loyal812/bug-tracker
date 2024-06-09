<?php
session_start();
require '../db/sqlite.php';
require '../../bootstrap.php';

$CLIENT_ID = $_ENV['CLIENT_ID']; // Replace with your Client ID
$CLIENT_SECRET = $_ENV['CLIENT_SECRET']; // Replace with your Client Secret
$redirectURL = $_ENV['APP_URL'] . '/core/auth/callback.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Exchange code for an access token
    $tokenURL = 'https://github.com/login/oauth/access_token';
    $postData = [
        'client_id' => $CLIENT_ID,
        'client_secret' => $CLIENT_SECRET,
        'code' => $code,
        'redirect_uri' => $redirectURL
    ];

    $opts = [
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($postData)
        ]
    ];

    $context  = stream_context_create($opts);
    $response = file_get_contents($tokenURL, false, $context);
    parse_str($response, $token);

    if (isset($token['access_token'])) {
        $accessToken = $token['access_token'];

        // Fetch user info from GitHub
        $userAPIURL = 'https://api.github.com/user';
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP',
                    "Authorization: token $accessToken"
                ]
            ]
        ];

        $context = stream_context_create($opts);
        $userData = json_decode(file_get_contents($userAPIURL, false, $context), true);

        if (isset($userData['id'])) {
            $email = isset($userData['email']) ? $userData['email'] : null;

            // Save or update user in the database
            $db = getDbConnection();
            $stmt = $db->prepare('SELECT * FROM users WHERE github_id = ?');
            $stmt->execute([$userData['id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['user'] = $user;
            } else {
                $stmt = $db->prepare('INSERT INTO users (github_id, name, email) VALUES (?, ?, ?)');
                $stmt->execute([$userData['id'], $userData['name'], ""]);
                $_SESSION['user'] = [
                    'id' => $db->lastInsertId(),
                    'github_id' => $userData['id'],
                    'name' => $userData['name'],
                    'email' => ""
                ];
            }

            // Redirect to the dashboard
            header('Location: /dashboard.php');
            exit;
        }
    }

    // Handle errors
    echo 'Error during OAuth process';
} else {
    // If no code parameter is present, redirect to the authorization URL
    $authURL = "https://github.com/login/oauth/authorize?client_id=$CLIENT_ID&redirect_uri=$redirectURL&scope=user";
    header("Location: $authURL");
    exit;
}
