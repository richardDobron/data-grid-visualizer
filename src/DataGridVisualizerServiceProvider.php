<?php

namespace dobron\DataGridVisualizer;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DataGridVisualizerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Illuminate\Database\Query\Builder::macro('dataGridVisualizer', function ($options) {
            $visualizer = new DataGridVisualizer($this->select(DB::raw($options['visualize'][0]))->get(), $options);
            return $visualizer->render();
        });

        \Illuminate\Database\Eloquent\Builder::macro('dataGridVisualizer', function ($options) {
            return $this->getQuery()->dataGridVisualizer($options);
        });
    }
}
