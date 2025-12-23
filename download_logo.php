<?php
$urls = [
    'https://upload.wikimedia.org/wikipedia/commons/b/b3/Lambang_Kabupaten_Muna_Barat.png',
    'https://kominfo.munabarat.go.id/wp-content/uploads/2022/10/cropped-logo-mubar-1.png'
];

$target = 'c:/xamppp/htdocs/BKKBN/assets/img/logo-muna-barat.png';
$dir = dirname($target);
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

foreach ($urls as $url) {
    echo "Trying $url ...\n";
    $content = @file_get_contents($url);
    if ($content) {
        file_put_contents($target, $content);
        echo "Success downloading to $target\n";
        exit(0);
    } else {
        echo "Failed to download from $url\n";
    }
}
echo "All attempts failed.\n";
exit(1);
?>