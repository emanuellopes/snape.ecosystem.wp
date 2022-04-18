<?php

namespace Snape\EcoSystemWP\PostType;

use Snape\EcoSystemWP\Contracts\PostType\IPostTypeInterface;
use WP_Error;
use WP_Post_Type;

class PostType implements IPostTypeInterface
{
    /**
     * Post type slug name.
     *
     * @var string
     */
    protected string $slug;

    /**
     * Post type arguments.
     *
     * @var array
     */
    protected array $args;

    /**
     * WP_post instance.
     *
     * @var WP_Post_Type|WP_Error
     */
    protected $instance;


    public function __construct(string $slug)
    {
        $this->slug = $slug;
        $this->args = array();
    }

    /**
     * Set the post type labels.
     *
     * @param  array  $labels
     *
     * @return IPostTypeInterface
     */
    public function setLabels(array $labels): IPostTypeInterface
    {
        if (isset($this->args['labels'])) {
            $this->args['labels'] = array_merge($this->args['labels'], $labels);
        } else {
            $this->args['labels'] = $labels;
        }

        return $this;
    }

    /**
     * Return the post type labels.
     *
     * @return array
     */
    public function getLabels(): array
    {
        return $this->args['labels'] ?? array();
    }

    /**
     * Return a defined label value.
     *
     * @param  string  $name  Key of label.
     *
     * @return string
     */
    public function getLabel(string $name): string
    {
        $labels = $this->getLabels();

        return $labels[$name] ?? '';
    }

    /**
     * Set the post type arguments.
     *
     * @param  array  $args
     *
     * @return IPostTypeInterface
     */
    public function setArguments(array $args): IPostTypeInterface
    {
        $this->args = array_merge($this->args, $args);

        return $this;
    }

    /**
     * Return the post type arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->args;
    }

    /**
     * Return a post type argument.
     *
     * @param  string  $property
     *
     * @return mixed|null
     */
    public function getArgument(string $property)
    {
        $args = $this->getArguments();

        return $args[$property] ?? null;
    }

    /**
     * Return the WordPress WP_Post_Type instance.
     *
     * @return WP_Error|WP_Post_Type
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Return the post type slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Return the post type slug.
     * Aliased method for getSlug.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getSlug();
    }

    /**
     * Register the post type.
     *
     * @param  int  $priority
     *
     * @return IPostTypeInterface
     */
    public function init($priority = 10): IPostTypeInterface
    {
        add_action('init', array($this, 'register'), $priority);

        return $this;
    }

    /**
     * Register post type hook callback.
     */
    public function register(): void
    {
        $this->instance = register_post_type($this->slug, $this->getArguments());
    }

    /**
     * Set the post type title input placeholder.
     *
     * @param  string  $title
     *
     * @return IPostTypeInterface
     */
    public function setTitlePlaceholder(string $title): IPostTypeInterface
    {
        add_filter(
            'enter_title_here',
            function ($default, \WP_Post $post) use ($title) {
                if ($this->slug === $post->post_type) {
                    return $title;
                }

                return $default;
            },
            10,
            2
        );

        return $this;
    }

    /**
     * Update Post type already registered.
     *
     * @param  int  $priority
     *
     * @return IPostTypeInterface
     */
    public function update(
        int $priority = 10
    ): IPostTypeInterface {
        add_filter(
            'register_post_type_args',
            array($this, 'updateCallback'),
            $priority,
            2
        );

        return $this;
    }

    public function updateCallback(array $args, string $post_type): array
    {
        $args_new = array_merge($args, $this->getArguments());
        if ($post_type === $this->getSlug()) {
            add_action(
                'init',
                function () {
                    $this->addSupports();
                }
            );

            return $args_new;
        }

        return $args;
    }

    /**
     * Get Supported features in post type.
     *
     * @return array
     */
    private function getSupports(): array
    {
        $args = $this->getArguments();

        return $args['supports'] ?? array();
    }

    /**
     * Remove all supports from post type
     */
    private function removeSupports(): void
    {
        global $_wp_post_type_features;

        unset($_wp_post_type_features[$this->getSlug()]);
    }

    /**
     * Add post type custom support title, editor, thumbnail etc...
     */
    private function addSupports(): void
    {
        $supports = $this->getSupports();
        if (! empty($supports)) {
            $this->removeSupports();
            foreach ($supports as $feature => $args) {
                if (is_array($args)) {
                    add_post_type_support($this->getSlug(), $feature, $args);
                } else {
                    add_post_type_support($this->getSlug(), $args);
                }
            }
        }
    }
}
