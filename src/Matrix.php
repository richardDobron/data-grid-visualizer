<?php

namespace dobron\DataGridVisualizer;

class Matrix
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getRows(): int
    {
        return count($this->data);
    }

    public function getColumns(): int
    {
        return count($this->data[0] ?? []);
    }

    public function getValue(int $rowIndex, int $columnIndex)
    {
        return $this->data[$rowIndex][$columnIndex] ?? null;
    }
}
