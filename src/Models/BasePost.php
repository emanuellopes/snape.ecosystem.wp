<?php

namespace Snape\EcoSystemWP\Models;

use Timber\Image;
use Timber\Post;

class BasePost extends Post
{
    /**
     * @param  int  $image_id
     *
     * @return Image|null
     */
    protected function getImageObject(int $image_id): ?Image
    {
        if (! $image_id) {
            return null;
        }

        return new Image($image_id);
    }

    /**
     * This returns the saved title of the article,
     * This function doesn't work  if you want to preview the unsaved title.
     *
     * @return string the title of the article.
     */
    public function title(): string
    {
        remove_filter('the_title', 'wptexturize');
        remove_filter('the_title', 'convert_chars');
        $title = apply_filters('the_title', $this->post_title, $this->ID); // @phpstan-ignore-line
        add_filter('the_title', 'wptexturize');
        add_filter('the_title', 'convert_chars');

        return $title;
    }
}
