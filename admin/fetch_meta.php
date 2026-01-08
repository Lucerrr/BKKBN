<?php
// Matikan error reporting agar tidak merusak format JSON
error_reporting(0);
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

// Fungsi helper untuk mengambil konten menggunakan cURL
function get_url_content_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Ikuti redirect
    curl_setopt($ch, CURLOPT_ENCODING, ""); // Handle gzip/compressed response
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Abaikan sertifikat SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Timeout diperpanjang jadi 60 detik
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // Waktu tunggu koneksi 30 detik
    
    // Header lengkap agar terlihat seperti browser asli
    $headers = [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Language: id,en-US;q=0.7,en;q=0.3',
        'Connection: keep-alive',
        'Upgrade-Insecure-Requests: 1'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $data = curl_exec($ch);
    $error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($data === false) {
        return ['error' => $error];
    }
    
    if ($http_code >= 400) {
        return ['error' => "HTTP Error Code: $http_code"];
    }

    return $data;
}

// Ambil konten HTML
$html = get_url_content_curl($url);

if (is_array($html) && isset($html['error'])) {
    echo json_encode(['success' => false, 'error' => 'Gagal mengambil URL: ' . $html['error']]);
    exit;
}

if (!$html) {
    echo json_encode(['success' => false, 'error' => 'Konten kosong']);
    exit;
}

// Parsing menggunakan DOMDocument
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

// Ambil Content Berita Lengkap (Best Effort)
$content = '';
$xpath = new DOMXPath($doc);

// Daftar kemungkinan class/id container artikel berita Indonesia
$queries = [
    "//div[contains(@class, 'detail__body-text')]", // Detik
    "//div[contains(@class, 'read__content')]", // Kompas Group
    "//div[contains(@class, 'detail-text')]", // CNN Indonesia
    "//div[contains(@class, 'article-content')]", // Generic
    "//div[contains(@class, 'post-content')]", // WordPress standard
    "//div[contains(@class, 'entry-content')]", // WordPress standard
    "//article", // Semantic HTML5
    "//div[contains(@id, 'content')]" // Fallback generic
];

foreach ($queries as $query) {
    $nodes = $xpath->query($query);
    if ($nodes->length > 0) {
        $container = $nodes->item(0);
        
        // Coba ambil paragraf
        $paragraphs = $xpath->query(".//p", $container);
        
        if ($paragraphs->length > 0) {
            foreach ($paragraphs as $p) {
                // Bersihkan text
                $text = trim($p->nodeValue);
                if (strlen($text) > 20) {
                    $content .= $text . "\n\n";
                }
            }
        } else {
            $content = trim($container->nodeValue);
        }
        
        if (!empty($content)) break;
    }
}

// Jika content masih kosong, fallback ke description
if (empty($content)) {
    $content = $description;
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
    'content' => trim($content),
    'image' => $image
]);
?>