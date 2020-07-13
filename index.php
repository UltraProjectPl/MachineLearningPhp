<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$content = file_get_contents('https://archive.ics.uci.edu/ml/machine-learning-databases/iris/iris.data');
$rows = explode("\n", $content);

$data = [];

foreach ($rows as $row) {
    $data[] = str_getcsv($row);
}

// Species of Iris
$specificDataTypes = array_column(array_slice($data,0, 100), 4);
$specificDataTypes = array_map(fn (string $specie) => $specie === 'Iris-versicolor' ? 1 : -1, $specificDataTypes);

$informationData =  array_slice($data, 100);
$informationData = array_map(null, array_column($informationData, 0), array_column($informationData, 2));
