<?php

namespace dobron\DataGridVisualizer;

use Imagick;

class Svg
{
    /**
     * @var string
     */
    protected $content;
    /**
     * @var array
     */
    protected $attributes;

    public function __construct(string $content, array $attributes = [])
    {
        $this->content = $content;
        $this->attributes = $attributes;
    }

    public function __toString()
    {
        $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\"";
        foreach ($this->attributes as $attribute => $value) {
            if (!$value) {
                continue;
            }

            $svg .= " " . $attribute . "=\"" . htmlspecialchars($value, ENT_QUOTES) . "\"";
        }

        $svg .= ">" . $this->content . "</svg>";
        return $svg;
    }


    public function image(?string $filename = null)
    {
        $svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . $this;

        $image = new Imagick();
        $image->setImageFormat("png32");
        $image->readImageBlob($svg);

        if ($filename) {
            return $image->writeImage($filename);
        }

        header("Content-type: image/png");

        return $image->getImageBlob();
    }
}
