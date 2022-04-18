<?php

namespace Snape\EcoSystemWP\PostType;

use League\Container\DefinitionContainerInterface;
use Snape\EcoSystemWP\Contracts\PostType\IPostTypeFactoryInterface;
use Snape\EcoSystemWP\Contracts\PostType\IPostTypeInterface;

class Factory implements IPostTypeFactoryInterface
{
    private DefinitionContainerInterface $container;

    public function __construct(DefinitionContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Return the default labels for CPT
     *
     * @param  string  $singular
     * @param  string  $plural
     *
     * @return array
     */
    private function getLabels(string $singular, string $plural): array
    {
        return array(
            'name' => $plural,
            'singular_name' => $singular,
            'add_new_item' => sprintf('Add New %s', $singular),
            'edit_item' => sprintf('Edit %s', $singular),
            'new_item' => sprintf('New %s', $singular),
            'view_item' => sprintf('View %s', $singular),
            'view_items' => sprintf('View %s', $plural),
            'search_items' => sprintf('Search %s', $plural),
            'not_found' => sprintf('No %s found', $plural),
            'not_found_in_trash' => sprintf('No %s found in Trash', $plural),
            'parent_item_colon' => sprintf('Parent %s:', $singular),
            'all_items' => sprintf('All %s', $plural),
            'archives' => sprintf('%s Archives', $singular),
            'attributes' => sprintf('%s Attributes', $singular),
            'insert_into_item' => sprintf(
                'Insert into %s',
                strtolower($singular)
            ),
            'uploaded_to_this_item' => sprintf(
                'Uploaded to this %s',
                strtolower($singular)
            ),
            'filter_items_list' => sprintf(
                'Filter %s list',
                strtolower($plural)
            ),
            'items_list_navigation' => sprintf('%s list navigation', $plural),
            'items_list' => sprintf('%s list', $plural),
        );
    }

    /**
     * Return the default arguments for register_post_type
     *
     * @return array
     */
    private function defaultArguments(): array
    {
        return array(
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_in_rest' => true,
            'supports' => array(
                'title',
                'editor',
                'comments',
                'revisions',
                'trackbacks',
                'author',
                'excerpt',
                'page-attributes',
                'thumbnail',
                'custom-fields',
                'post-formats',
            ),
        );
    }

    private function createPostTypeInstance(
        string $slug,
        string $singular,
        string $plural
    ): IPostTypeInterface {
        $post_type = new PostType($slug);
        $post_type->setLabels($this->getLabels($singular, $plural))
                  ->setArguments($this->defaultArguments());

        return $post_type;
    }

    /**
     * Register a new Custom post type in WordPress.
     *
     * @param  string  $slug
     * @param  string  $plural
     * @param  string  $singular
     *
     * @return IPostTypeInterface
     */
    public function make(
        string $slug,
        string $singular,
        string $plural,
        int $priority = 10
    ): IPostTypeInterface {
        if ($this->exists($slug)) {
            throw new \Exception("The post type [{$slug}] already exists.");
        }

        $post_type = $this->createPostTypeInstance($slug, $singular, $plural);

        $post_type->init($priority);

        $this->container->add("snape-ecosystemwp.posttype.{$slug}", $post_type);

        return $post_type;
    }

    /**
     * Update custom post type
     *
     * @param  string  $slug
     * @param  string  $singular
     * @param  string  $plural
     * @param  int  $priority
     *
     * @return IPostTypeInterface
     */
    public function update(
        string $slug,
        string $singular = '',
        string $plural = '',
        int $priority = 10
    ): IPostTypeInterface {
        $post_type = $this->createPostTypeInstance($slug, $singular, $plural);

        $post_type->update($priority);

        return $post_type;
    }


    /**
     * If a given post type exists
     *
     * @param  string  $slug
     *
     * @return bool
     */
    public function exists(string $slug): bool
    {
        return $this->container->has("snape-ecosystemwp.posttype.{$slug}")
               || (function_exists('post_type_exists')
                   && post_type_exists($slug));
    }

    /**
     * Get post type from container.
     *
     * @param  string  $slug
     *
     * @return mixed
     */
    public function get(string $slug)
    {
        $id = "snape-ecosystemwp.posttype.{$slug}";

        if (! $this->container->has($id)) {
            return null;
        }

        return $this->container->getNew($id);
    }
}
