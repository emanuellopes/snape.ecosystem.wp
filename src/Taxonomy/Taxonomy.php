<?php

namespace Snape\EcoSystemWP\Taxonomy;

use Snape\EcoSystemWP\Contracts\Taxonomy\ITaxonomyInterface;

class Taxonomy implements ITaxonomyInterface
{
    /**
     * Taxonomy slug.
     *
     * @var string
     */
    protected string $slug;

    /**
     *
     * List of posts types or a single string.
     *
     * @var array
     */
    protected array $post_types = array();

    /**
     * Custom arguments for register_taxonomy.
     *
     * @var array
     */
    protected array $args = array();

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Return the taxonomy slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set taxonomy labels.
     *
     * @param  array  $labels
     *
     * @return ITaxonomyInterface
     */
    public function setLabels(array $labels): ITaxonomyInterface
    {
        if (isset($this->args['labels'])) {
            $this->args['labels'] = array_merge($this->args['labels'], $labels);
        } else {
            $this->args['labels'] = $labels;
        }

        return $this;
    }

    /**
     * Return taxonomy labels.
     *
     * @return array
     */
    public function getLabels(): array
    {
        return $this->args['labels'] ?? array();
    }

    /**
     * Return a taxonomy label by name.
     *
     * @param  string  $name
     *
     * @return string
     */
    public function getLabel(string $name): string
    {
        $labels = $this->getLabels();

        return $labels[ $name ] ?? '';
    }

    /**
     * Set taxonomy arguments.
     *
     * @param  array  $args
     *
     * @return ITaxonomyInterface
     */
    public function setArguments(array $args): ITaxonomyInterface
    {
        $this->args = array_merge($this->args, $args);

        return $this;
    }

    /**
     * Return taxonomy arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->args;
    }

    /**
     * Return a taxonomy argument.
     *
     * @param  string  $property
     *
     * @return mixed
     */
    public function getArgument(string $property)
    {
        $args = $this->getArguments();

        return $args[ $property ] ?? null;
    }

    /**
     * Register the taxonomy.
     *
     * @param  int  $priority
     *
     * @return ITaxonomyInterface
     */
    public function init(int $priority = 10): ITaxonomyInterface
    {
        add_action('init', array( $this, 'register' ), $priority);

        return $this;
    }

    /**
     * Register taxonomy hook callback.
     */
    public function register(): void
    {
        register_taxonomy($this->slug, $this->post_types, $this->getArguments());
        $this->bind();
    }

    /**
     * Bind the taxonomy to its custom post type|object. Make sure the taxonomy
     * can be found in 'parse_query' or 'pre_get_posts' filters.
     */
    protected function bind(): void
    {
        foreach ($this->post_types as $object) {
            register_taxonomy_for_object_type($this->slug, $object);
        }
    }

    /**
     * Set taxonomy objects.
     *
     * @param  array|string  $objects
     *
     * @return ITaxonomyInterface
     */
    public function setObjects($objects): ITaxonomyInterface
    {
        $this->post_types = array_unique(array_merge($this->post_types, (array) $objects));

        return $this;
    }

    /**
     * Return taxonomy attached objects.
     *
     * @return array
     */
    public function getObjects(): array
    {
        return $this->post_types;
    }

    public function update(int $priority = 10): ITaxonomyInterface
    {
        add_filter(
            'register_taxonomy_args',
            array( $this, 'updateCallback' ),
            $priority,
            2
        );

        return $this;
    }

    public function updateCallback(array $args, string $taxonomy_type): array
    {
        $args_new = array_merge($args, $this->getArguments());

        if ($taxonomy_type === $this->getSlug()) {
            add_action(
                'init',
                function () {
                    $this->bind();
                }
            );

            return $args_new;
        }

        return $args;
    }

    /**
     * Remove taxonomy from Post Type
     *
     * @param  array  $taxonomies
     * @param  int  $priority
     *
     */
    public function unregister(array $taxonomies = array(), int $priority = 10): void
    {
        if (! empty($taxonomies)) {
            $this->setObjects($taxonomies);
        }
        add_action(
            'init',
            function () {
                foreach ($this->getObjects() as $object) {
                    unregister_taxonomy_for_object_type($this->getSlug(), $object);
                }
            },
            $priority
        );
    }
}
