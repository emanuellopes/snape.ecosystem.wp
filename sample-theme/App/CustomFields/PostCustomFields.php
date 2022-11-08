<?php

namespace SampleThemeApp\CustomFields;

use Carbon_Fields\Container;
use Carbon_Fields\Field\Field;
use Snape\EcoSystemWP\CarbonFields\AbstractCarbonFieldsBase;

class PostCustomFields extends AbstractCarbonFieldsBase
{
    public function boot(): void
    {
        $this->carbonFieldsFactory->create(function () {
            Container::make('post_meta', 'custom_fields', 'Details')
                     ->where('post_type', '=', 'post')
                     ->add_fields(array(
                         Field::make('image', 'thumbnail-hero-image', 'Hero Desktop')
                              ->set_help_text('Add here the hero for Desktop'),
                         Field::make('image', 'thumbnail-hero-mobile-image', 'Hero Mobile')
                              ->set_help_text('Add here the hero for Mobile'),
                     ));
        });
    }
}
