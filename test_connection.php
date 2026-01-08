<?php
echo "PHP Version: " . phpversion() . "\n";
echo "allow_url_fopen: " . (ini_get('allow_url_fopen') ? 'On' : 'Off') . "\n";
echo "openssl extension: " . (extension_loaded('openssl') ? 'Loaded' : 'Not Loaded') . "\n";

$url = "https://www.google.com";
$options = [
    'http' => [
        'method' => "GET",
        'header' => "User-Agent: Mozilla/5.0\r\n"
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
    ]
];
$context = stream_context_create($options);

echo "Testing connection to $url ...\n";
$content = @file_get_contents($url, false, $context);

if ($content) {
    echo "Success: Fetched " . strlen($content) . " bytes.\n";
} else {
    echo "Failed to fetch URL.\n";
    $error = error_get_last();
    echo "Error: " . ($error['message'] ?? 'Unknown error') . "\n";
}
?>