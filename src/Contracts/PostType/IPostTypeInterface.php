<?php

namespace Snape\EcoSystemWP\Contracts\PostType;

interface IPostTypeInterface
{
    /**
     * Set the post type labels.
     *
     * @param array $labels
     *
     * @return IPostTypeInterface
     */
    public function setLabels(array $labels): IPostTypeInterface;

    /**
     * Return the post type labels.
     *
     * @return array
     */
    public function getLabels(): array;

    /**
     * Return a defined label value.
     *
     * @param string $name
     *
     * @return string
     */
    public function getLabel(string $name): string;

    /**
     * Set the post type arguments.
     *
     * @param array $args
     *
     * @return IPostTypeInterface
     */
    public function setArguments(array $args): IPostTypeInterface;

    /**
     * Return the post type arguments.
     *
     * @return array
     */
    public function getArguments(): array;

    /**
     * Return a post type argument.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function getArgument(string $property);

    /**
     * Return the WordPress WP_Post_Type instance.
     *
     * @return \WP_Post_Type|null
     */
    public function getInstance();

    /**
     * Set the post type title input placeholder.
     *
     * @param string $title
     *
     * @return IPostTypeInterface
     */
    public function setTitlePlaceholder(string $title): IPostTypeInterface;

    /**
     * Return the post type slug.
     *
     * @return string
     */
    public function getSlug(): string;

    /**
     * Return the post type slug.
     * Aliased method for getSlug.
     *
     * @return string
     */
    public function getName(): string;
}
