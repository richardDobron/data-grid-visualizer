<?php

namespace dobron\DataGridVisualizer;

use dobron\DataGridVisualizer\Support\Config;
use Illuminate\Support\Collection;

class DataGridVisualizer
{
    /**
     * @var Collection
     */
    private $data;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Collection $data, array $config)
    {
        $this->data = $data;
        $this->config = new Config($config);
    }

    public function prepareMatrixData(): Matrix
    {
        $total = $this->data->count();
        $squareSide = ceil(sqrt($total));
        $gridSize = pow($squareSide, 2);
        $missing = [];

        if ($gridSize > $total) {
            $missing = array_fill($total, $gridSize - $total, $this->config->getDefaultColor());
        }

        [$key, $visualizer] = $this->config->getVisualize();

        return new Matrix($this->data->map(function ($model) use ($key, $visualizer) {
            $value = $model->{$key};

            if (is_callable($visualizer)) {
                $color = $visualizer($value);
            } elseif (is_array($visualizer)) {
                $color = $visualizer[$value] ?? null;
            } elseif (is_string($visualizer)) {
                $color = $visualizer;
            }

            return $color ?? $this->config->getDefaultColor();
        })->concat($missing)->chunk($squareSide)->map(function ($item) {
            return $item->values();
        })->toArray());
    }

    public function renderSvg(Matrix $matrix): Svg
    {
        $horizontal = $this->config->getPerspective() === Config::PERSPECTIVE_HORIZONTAL;
        $radius = $this->config->getRadius();
        $size = $this->config->getSize();
        $gap = $this->config->getGap();
        $w = $matrix->getColumns();
        $h = $matrix->getRows();

        $args = ["viewBox" => "0 0 " . ($w * $gap) . " " . ($h * $gap)];
        $svg = '';

        for ($y = 0; $y < $h; $y++) {
            $svg .= '<g transform="translate(' . ($y * $gap) . ', 0)">';

            for ($x = 0; $x < $w; $x++) {
                $svg .= '<rect';
                $attributes = [
                    'width' => $size,
                    'height' => $size,
                    'x' => $h - $y,
                    'y' => $x * $gap,
                    'rx' => $radius,
                    'ry' => $radius,
                    'fill' => $horizontal
                        ? $matrix->getValue($x, $y)
                        : $matrix->getValue($y, $x),
                    'style' => (
                        ($outline = $this->config->getOutline())
                        ? "outline: 1px solid $outline;outline-offset: -1px"
                        : null
                    ),
                ];

                foreach ($attributes as $attribute => $value) {
                    if (!$value) {
                        continue;
                    }

                    $svg .= " " . $attribute . "=\"" . htmlspecialchars($value, ENT_QUOTES) . "\"";
                }

                $svg .= '></rect>';
            }

            $svg .= '</g>';
        }

        return new Svg($svg, $args);
    }

    /**
     * @return string|Svg
     */
    public function render()
    {
        return $this->renderSvg($this->prepareMatrixData());
    }
}
