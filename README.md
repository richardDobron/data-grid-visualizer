Laravel Data Visualizer
---
With Laravel Data Visualizer you can render data from a database as svg (or save as png).
One advantage is a better view of the stored data than a normal COUNT usage.

## Installing

```shell
$ composer require dobron/data-grid-visualizer
```

## Usage
### Model

```php
echo Patient::query()->dataGridVisualizer([
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
])
```

### Without Model
```php
DB::table('patients')->whereIn('birth_year', [1996, 2000])->dataGridVisualizer([
    'visualize' => [
        'birth_year',
        [
            1996 => '#800000'
            2000 => '#ffc800'
        ],
    ],
]);
```

### Render as PNG
```php
$query->dataGridVisualizer([...])->image();
```

### Save as PNG
```php
$query->dataGridVisualizer([...])->image('graph.png');
```

## Options

| Option  | Description                                                        | Default                   |
| ------- |------------------------------------------------------------------- | ------------------------- |
| defaultColor | Default grid color if none is defined.                        | #2d333b                   |
| gap          | Gap size in px.                                               | 13                        |
| size         | Size of grid in px.                                           | 10                        |
| radius       | Radius of the grid.                                           | 2                         |
| outline      | Outline color of the grid (optional).                         | rgba(255, 255, 255, 0.05) |
| perspective  | Data view perspective (horizontal/vertical).                  | horizontal                |
| visualize    | Visualization conditions as array [column name, condition].   | *none*                    |

## Examples

<img src="./images/visualization1.png">
<img src="./images/visualization2.png">

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Richard Dobroň][link-author]


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/richardDobron
