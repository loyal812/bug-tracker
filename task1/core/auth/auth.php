<?php
session_start();
require '../../vendor/autoload.php';
require '../../bootstrap.php';

$CLIENT_ID = $_ENV['CLIENT_ID']; // Replace with your Client ID
$CLIENT_SECRET = $_ENV['CLIENT_SECRET']; // Replace with your Client Secret
$redirectURL = $_ENV['APP_URL'] . '/core/auth/callback.php';

if (!isset($_GET['code'])) {
    $url = "https://github.com/login/oauth/authorize?client_id=$CLIENT_ID&redirect_uri=$redirectURL&scope=user";
    header("Location: $url");
    exit;
}

$code = $_GET['code'];
$tokenURL = 'https://github.com/login/oauth/access_token';
$data = [
    'client_id' => $CLIENT_ID,
    'client_secret' => $CLIENT_SECRET,
    'code' => $code
];

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($data)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($tokenURL, false, $context);
parse_str($response, $token);

$accessToken = $token['access_token'];
$userData = json_decode(file_get_contents("https://api.github.com/user?access_token=$accessToken"), true);

$_SESSION['user'] = $userData;
header('Location: /dashboard.php');
exit;
