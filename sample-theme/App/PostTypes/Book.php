<?php

namespace SampleThemeApp\PostTypes;

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;
use Snape\EcoSystemWP\Contracts\ICarbonFieldsFactoryInterface;
use Snape\EcoSystemWP\Contracts\PostType\IPostTypeFactoryInterface;
use Snape\EcoSystemWP\Features\AbstractFeature;

class Book extends AbstractFeature
{
    private IPostTypeFactoryInterface $postTypeFactory;
    private ICarbonFieldsFactoryInterface $carbonFieldsFactory;

    public function __construct(
        IPostTypeFactoryInterface $postTypeFactory,
        ICarbonFieldsFactoryInterface $carbonFieldsFactory
    ) {
        $this->postTypeFactory = $postTypeFactory;
        $this->carbonFieldsFactory = $carbonFieldsFactory;
        parent::__construct();
    }

    public function boot(): void
    {
        $this->postTypeFactory->make('book', 'Book', 'Books')
                              ->setArguments(array(
                                  'supports' => array(
                                      'title',
                                      'thumbnail',
                                      'excerpt',
                                  ),
                                  'show_in_rest' => false,
                              ));

        $this->carbonFieldsFactory->create(function () {
            Container::make('post_meta', 'Form')
                     ->where('post_type', '=', 'book')
                     ->add_fields(array(
                         Field::make('text', 'freetext', __('free text')),
                     ));
        });
    }
}
