<?php

namespace SampleThemeApp\Taxonomies;

use Snape\EcoSystemWP\Contracts\Taxonomy\ITaxonomyFactoryInterface;
use Snape\EcoSystemWP\Features\AbstractFeature;

class BookCategory extends AbstractFeature
{

    private ITaxonomyFactoryInterface $taxonomy;

    public function __construct(ITaxonomyFactoryInterface $taxonomy)
    {
        $this->taxonomy = $taxonomy;
        parent::__construct();
    }

    public function boot(): void
    {
        $this->taxonomy->make('book-category', 'Category', 'Categories')
                       ->setArguments(array('hierarchical' => false))
                       ->setObjects(array('book'));
    }
}
