<?php

namespace SampleThemeApp\PostTypes;

use Snape\EcoSystemWP\Contracts\IPostTypeFactoryInterface;
use Snape\EcoSystemWP\Features\AbstractFeature;

class Book extends AbstractFeature
{
    private IPostTypeFactoryInterface $postTypeFactory;

    public function __construct(
        IPostTypeFactoryInterface $postTypeFactory
    ) {
        $this->postTypeFactory = $postTypeFactory;
        parent::__construct();
    }

    public function boot(): void
    {
        $this->postTypeFactory->make('book', 'Book', 'Books')
                              ->setArguments(array(
                                  'supports'     => array(
                                      'title',
//                                          'editor',
                                      'comments',
                                      'thumbnail',
                                      'excerpt',
                                  ),
                                  'show_in_rest' => false,
                              ));
    }
}
