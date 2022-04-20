<?php

namespace Snape\EcoSystemWP\Models;

use Timber\MenuItem as TimberMenuItem;

class MenuItem extends TimberMenuItem
{
    public string $slug;

    /**
     * @return int| bool
     */
    public function isSelected()
    {
        $obj_id = get_queried_object_id();

        $url = ! empty(get_permalink($obj_id)) ? get_permalink($obj_id) : '';

        $current_url = str_replace(get_site_url(), '', $url);

        return strpos($current_url, $this->slug);
    }
}
