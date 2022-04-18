<?php

namespace Snape\EcoSystemWP\Taxonomy;

use League\Container\DefinitionContainerInterface;
use Snape\EcoSystemWP\Contracts\Taxonomy\ITaxonomyFactoryInterface;
use Snape\EcoSystemWP\Contracts\Taxonomy\ITaxonomyInterface;

class Factory implements ITaxonomyFactoryInterface
{
    private DefinitionContainerInterface $container;

    public function __construct(DefinitionContainerInterface $container)
    {
        $this->container = $container;
    }

    private function getLabels( $singular, $plural ) {
        return array(
            'name'                       => $plural,
            'singular_name'              => $singular,
            'search_items'               => sprintf( 'Search %s', $plural ),
            'popular_items'              => sprintf( 'Popular %s', $plural ),
            'all_items'                  => sprintf( 'All %s', $plural ),
            'parent_item'                => sprintf( 'Parent %s', $singular ),
            'parent_item_colon'          => sprintf( 'Parent %s:', $singular ),
            'edit_item'                  => sprintf( 'Edit %s', $singular ),
            'view_item'                  => sprintf( 'View %s', $singular ),
            'update_item'                => sprintf( 'Update %s', $singular ),
            'add_new_item'               => sprintf( 'Add New %s', $singular ),
            'new_item_name'              => sprintf( 'New %s Name', $singular ),
            'separate_items_with_commas' => sprintf( 'Separate %s with commas', strtolower( $plural ) ),
            'add_or_remove_items'        => sprintf( 'Add or remove %s', strtolower( $plural ) ),
            'choose_from_most_used'      => sprintf( 'Choose from the most used %s', strtolower( $plural ) ),
            'not_found'                  => sprintf( 'No %s found', strtolower( $plural ) ),
            'no_terms'                   => sprintf( 'No %s', strtolower( $plural ) ),
            'items_list_navigation'      => sprintf( '%s list navigation', $plural ),
            'items_list'                 => sprintf( '%s list', $plural ),
            'most_used'                  => 'Most Used',
            'back_to_items'              => sprintf( 'Back to %s', $plural ),
        );
    }

    /**
     * Return the default arguments for register_post_type
     *
     * @return array
     */
    private function defaultArguments() {
        return array(
            'public'              => true,
            'hierarchical'        => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_in_rest'        => true,
        );
    }

    private function createTaxonomyInstance( $slug, $singular = '', $plural = '' ): ITaxonomyInterface {
        $taxonomy = new Taxonomy( $slug );
        $taxonomy->setLabels( $this->getLabels( $singular, $plural ) )->setArguments( $this->defaultArguments() );

        return $taxonomy;
    }

    public function make(
        string $slug,
        string $singular,
        string $plural,
        int $priority = 10
    ): ITaxonomyInterface {
        if ( $this->exists( $slug ) ) {
            throw new \Exception( "The post type [{$slug}] already exists." );
        }

        $taxonomy = $this->createTaxonomyInstance( $slug, $singular, $plural );

        $taxonomy->init( $priority );

        $this->container->add("snape-ecosystemwp.taxonomy.{$slug}", $taxonomy);

        return $taxonomy;
    }

    public function update(
        string $slug,
        string $singular = '',
        string $plural = '',
        int $priority = 10
    ): ITaxonomyInterface {
        $taxonomy = $this->createTaxonomyInstance( $slug, $singular, $plural );
        $taxonomy->update( $priority );

        return $taxonomy;
    }

    public function exists(string $slug): bool
    {
        return $this->container->has( "taxonomy.{$slug}" ) || ( function_exists( 'taxonomy_exists' ) && taxonomy_exists( $slug ) );
    }

    public function remove(
        string $slug,
        array $taxonomies = array(),
        int $priority = 10
    ) {
        $taxonomy = $this->createTaxonomyInstance( $slug );
        $taxonomy->unregister( $taxonomies, $priority );
    }
}
