<?php

namespace dobron\DataGridVisualizer\Support;

class Config
{
    /**
     * @var array
     */
    protected $options = [
        'defaultColor' => '#2d333b',
        'gap' => 13,
        'size' => 10,
        'radius' => 2,
        'outline' => 'rgba(255, 255, 255, 0.05)',
        'perspective' => self::PERSPECTIVE_HORIZONTAL,
        'visualize' => [],
    ];

    public const PERSPECTIVE_HORIZONTAL = 'horizontal';
    public const PERSPECTIVE_VERTICAL = 'vertical';

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @return string
     */
    public function getDefaultColor(): string
    {
        return $this->options['defaultColor'];
    }

    /**
     * @return int
     */
    public function getGap(): int
    {
        return $this->options['gap'];
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->options['size'];
    }

    /**
     * @return int
     */
    public function getRadius(): int
    {
        return $this->options['radius'];
    }

    /**
     * @return null|string
     */
    public function getOutline(): ?string
    {
        return $this->options['outline'];
    }

    /**
     * @return string
     */
    public function getPerspective(): string
    {
        return $this->options['perspective'];
    }

    /**
     * @return array
     */
    public function getVisualize(): array
    {
        return $this->options['visualize'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setOption(string $key, $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function mergeOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
