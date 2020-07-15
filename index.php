<?php

declare(strict_types=1);

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

echo json_encode([
    'specificDataTypes' => $specificDataTypes,
    'informationData' => $informationData
]);



class Perceptron
{
    private float $eta;

    private int $iteration;

    private array $weights = [];

    private array $errors = [];

    public function __construct(float $eta = 0.01, int $iteration = 10)
    {
        $this->eta = $eta;
        $this->iteration = $iteration;
    }

    public function fit(array $informationData, array $targets): self
    {
        $this->weights = array_fill(0, count($informationData[0]) + 1, 0);

        for ($i = 0; $i < $this->iteration; $i++) {
            $error = 0;
            foreach (array_map(null, $informationData, $targets) as [$data, $target]) {
                $update = ($target - $this->predict($data)) * $this->eta;

                for ($j = 1; $j < count($this->weights); $j++) {
                    $this->weights[$j] += $data[$j - 1] * $update;
                }
                $this->weights[0] += $update;
                $error += $update !== 0.0 ? 1 : 0;
            }
            $this->errors[] = $error;
        }

        return $this;
    }

    public function predict(array $data): int
    {
        return $this->networkInput($data) >= 0 ? 1 : -1;
    }

    private function networkInput(array $data): float
    {
        return array_sum(array_map(fn($i, $j) => $i * $j, $data, array_slice($this->weights, 1, count($this->weights)))) + $this->weights[0];
    }
}

$perceptron = new Perceptron(0.1);
$perceptron->fit($informationData, $specificDataTypes);
dump($perceptron);

