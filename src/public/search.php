<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DirectoryLoader;
use App\PerceptualHash;

$catalog = (new DirectoryLoader('./img/catalog/*.jpg'))();

if (isset($_FILES['image']) && is_array($_FILES['image']) && isset($_FILES['image']['error']) && $_FILES['image']['error'] === 0) {
    $catalog = (new PerceptualHash($catalog))(
        filename: $_FILES['image']['tmp_name'],
        sort: SORT_ASC
    );
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: application/json');

echo json_encode($catalog->list);
