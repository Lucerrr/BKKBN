<?php
header('Content-Type: application/json');

if (!isset($_GET['url'])) {
    echo json_encode(['success' => false, 'error' => 'URL tidak ditemukan']);
    exit;
}

$url = $_GET['url'];

// Validasi URL sederhana
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo json_encode(['success' => false, 'error' => 'URL tidak valid']);
    exit;
}

// Ambil konten HTML
$options = [
    'http' => [
        'method' => "GET",
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($options);
$html = @file_get_contents($url, false, $context);

if (!$html) {
    echo json_encode(['success' => false, 'error' => 'Gagal mengambil konten URL']);
    exit;
}

// Parsing sederhana menggunakan DOMDocument
$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes = $doc->getElementsByTagName('title');

// Ambil Title
$title = $nodes->length > 0 ? $nodes->item(0)->nodeValue : '';

// Ambil Description (Meta)
$description = '';
$metas = $doc->getElementsByTagName('meta');
for ($i = 0; $i < $metas->length; $i++) {
    $meta = $metas->item($i);
    if ($meta->getAttribute('name') == 'description') {
        $description = $meta->getAttribute('content');
    }
    // Fallback ke og:description jika description kosong
    if (empty($description) && $meta->getAttribute('property') == 'og:description') {
        $description = $meta->getAttribute('content');
    }
}

// Ambil Gambar (OG:Image)
$image = '';
for ($i = 0; $i < $metas->length; $i++) {
    $meta = $metas->item($i);
    if ($meta->getAttribute('property') == 'og:image') {
        $image = $meta->getAttribute('content');
        break;
    }
}

echo json_encode([
    'success' => true,
    'title' => trim($title),
    'description' => trim($description),
    'image' => $image
]);
?>