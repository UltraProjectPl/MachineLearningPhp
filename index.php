<?php

declare(strict_types=1);

$content = file_get_contents('https://archive.ics.uci.edu/ml/machine-learning-databases/iris/iris.data');
$rows = explode("\n", $content);

$data = [];

foreach ($rows as $row) {
    $data[] = str_getcsv($row);
}

print_r($data);