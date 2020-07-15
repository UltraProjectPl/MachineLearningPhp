<?php

declare(strict_types=1);

use App\Perceptron;

require_once('vendor/autoload.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

//$content = file_get_contents('https://archive.ics.uci.edu/ml/machine-learning-databases/iris/iris.data');
$content = file_get_contents('./iris.csv');
$rows = explode("\n", $content);

$data = [];

foreach ($rows as $row) {
    if ('' === $row) {
        continue;
    }

    $data[] = str_getcsv($row);
}

// Species of Iris
$specificDataTypes = array_column(array_slice($data,0, 100), 4);
$specificDataTypes = array_map(fn (string $specie) => $specie === 'Iris-versicolor' ? 1 : -1, $specificDataTypes);

$informationData =  array_slice($data, 0, 100);
$informationData = array_map(null, array_column($informationData, 0), array_column($informationData, 2));
//
//echo json_encode([
//    'specificDataTypes' => $specificDataTypes,
//    'informationData' => $informationData
//]);

$perceptron = new Perceptron(0.1);
$perceptron->fit($informationData, $specificDataTypes);
dump($perceptron);

