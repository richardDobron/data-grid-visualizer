<?php

declare(strict_types=1);

namespace tests;

use dobron\DataGridVisualizer\Support\Config;
use Illuminate\Support\Facades\DB;

class FeatureTest extends TestCase
{
    public function testSimpleGrid(): void
    {
        $data = [];
        foreach (range(1900, 2020, 5) as $key => $birthYear) {
            for ($i = 0; $i <= $key; $i++) {
                $data[] = [
                    'birth_year' => $birthYear,
                ];
            }
        }

        Patient::insert($data);

        $gridVisualizer = Patient::query()->dataGridVisualizer([
            'visualize' => [
                'birth_year',
                function ($birthYear) {
                    if ($birthYear < 1930) {
                        return '#0e4429';
                    }

                    if ($birthYear < 1960) {
                        return '#006d32';
                    }

                    if ($birthYear < 1990) {
                        return '#26a641';
                    }

                    return '#39d353';
                }
            ],
        ]);

        $this->assertEquals($gridVisualizer, file_get_contents(__DIR__ . '/grid-output.svg'));
    }

    public function testWithoutEloquentAndData(): void
    {
        $this->withoutExceptionHandling();

        $gridVisualizer = DB::table('patients')->dataGridVisualizer([
            'visualize' => [
                'birth_year',
                '#ffffff'
            ],
        ]);

        $this->assertEquals($gridVisualizer, '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0"></svg>');
    }

    public function testCustomOptions(): void
    {
        $data = [
            1, 0, 0, 1, 1, 1, 0, 0,
            0, 1, 0, 0, 0, 1, 1, 1,
            1, 0, 0, 1, 1, 0, 1, 0,
            0, 1, 1, 1, 0, 0, 0, 0,
            1, 0, 0, 1, 1, 0, 1, 0,
            1, 1, 1, 0, 0, 1, 1, 1,
            0, 1, 0, 1, 0, 0, 1, 0,
            1, 1, 1, 0, 0, 1, 1, 1,
        ];

        Product::insert(array_map(function ($visible) {
            return ['visible' => $visible];
        }, $data));

        $gridVisualizer = Product::query()->dataGridVisualizer([
            'defaultColor' => '#2d333b',
            'gap' => 13,
            'size' => 10,
            'radius' => 2,
            'outline' => null,
            'perspective' => Config::PERSPECTIVE_HORIZONTAL,
            'visualize' => [
                'visible',
                function ($value) {
                    return $value
                        ? '#ffc800'
                        : '#800000';
                }
            ],
        ]);

        $this->assertEquals($gridVisualizer, file_get_contents(__DIR__ . '/grid-output2.svg'));
    }
}
