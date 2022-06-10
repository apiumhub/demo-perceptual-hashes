<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DirectoryLoader;
use App\PerceptualHash;

$catalog = (new DirectoryLoader('./img/catalog/*.jpg'))();

if (isset($_GET['image'])) {
    $catalog = (new PerceptualHash($catalog))(
        filename: $_GET['image'],
        sort: SORT_ASC
    );
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: application/json');

echo json_encode($catalog);
