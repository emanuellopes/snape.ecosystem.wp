<?php

namespace Snape\EcoSystemWP\Images;


class RegisterImages
{
    private array $sizes;

    public function __construct(array $sizes)
    {
        $this->sizes = $sizes;
        $this->registerImageSizes();
        $this->addImageSizesDashboard();
    }


    public function registerImageSizes(): void
    {
        remove_image_size('1536x1536');
        remove_image_size('2048x2048');
        add_action(
            'after_setup_theme',
            array($this, 'registerNewImagesSizesCallback'),
            15
        );
    }

    public function registerNewImagesSizesCallback(): void
    {
        foreach ($this->sizes as $size) {
            $name = $size['name'] ?? '';
            $size_name = $size['sizeName'] ?? '';
            $width = $size['width'] ?? 0;

            if ('full' === $name) {
                continue;
            }
            add_image_size($size_name, $width);
        }
    }

    public function addImageSizesDashboard(): void
    {
        add_filter('image_size_names_choose', array($this, 'listSizesBackend'));
    }

    /**
     * @param  string[]  $sizes
     *
     * @return string[]
     */
    public function listSizesBackend(array $sizes): array
    {
        $new_sizes = array();
        foreach ($this->sizes as $size) {
            $name = $size['name'] ?? '';
            $size_name = $size['sizeName'] ?? '';
            $new_sizes[$size_name] = $name;
        }

        return array_merge($sizes, $new_sizes);
    }
}
