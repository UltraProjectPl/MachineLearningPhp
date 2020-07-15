<?php
declare(strict_types=1);

namespace App;


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
        $this->initializeEmptyWeights();

        for ($i = 0; $i < $this->iteration; $i++) {
            $error = 0;

            /**
             * @var array $data
             * @var int  $target
             */
            foreach (array_map(null, $informationData, $targets) as [$data, $target]) {
                $update = $this->calcUpdateValue($target, $data);

                $this->updateWeights($update, $data);

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
        $weightsWithoutFirst = array_slice($this->weights, 1, count($this->weights));

        $weightsAfterCalc = array_map(fn($i, $j) => $i * $j, $data, $weightsWithoutFirst);
        return array_sum($weightsAfterCalc) + $this->weights[0];
    }

    private function calcUpdateValue(int $target, array $data): float
    {
        return ($target - $this->predict($data)) * $this->eta;
    }

    private function updateWeights(float $update, array $data): void
    {
        for ($j = 1; $j < count($this->weights); $j++) {
            $this->weights[$j] += $data[$j - 1] * $update;
        }
        $this->weights[0] += $update;
    }

    private function initializeEmptyWeights(int $dataSize): void
    {
        $this->weights = array_fill(0, $dataSize + 1, 0);
    }
}
