<?php

namespace Snape\EcoSystemWP\Models;

use Timber\Image;
use Timber\Term;

class BaseTerm extends Term
{
    public string $slug;

    /**
     * This returns the saved title of the article,
     * This function doesn't work  if you want to preview the unsaved title.
     *
     * @return string the title of the article.
     */
    public function title(): string
    {
        return wp_specialchars_decode($this->name);
    }

    protected function getImageObject(int $image_id): ?Image
    {
        if (! $image_id) {
            return null;
        }

        return new Image($image_id);
    }
}
