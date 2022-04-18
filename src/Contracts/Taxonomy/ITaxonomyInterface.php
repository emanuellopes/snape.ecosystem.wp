<?php

namespace Snape\EcoSystemWP\Contracts\Taxonomy;

interface ITaxonomyInterface
{
    /**
     * Return the taxonomy slug.
     *
     * @return string
     */
    public function getSlug(): string;

    /**
     * Set taxonomy labels.
     *
     * @param  array  $labels
     *
     * @return ITaxonomyInterface
     */
    public function setLabels(array $labels): ITaxonomyInterface;

    /**
     * Return taxonomy labels.
     *
     * @return array
     */
    public function getLabels(): array;

    /**
     * Return a taxonomy label by name.
     *
     * @param  string  $name
     *
     * @return string
     */
    public function getLabel(string $name): string;

    /**
     * Set taxonomy arguments.
     *
     * @param  array  $args
     *
     * @return ITaxonomyInterface
     */
    public function setArguments(array $args): ITaxonomyInterface;

    /**
     * Return taxonomy arguments.
     *
     * @return array
     */
    public function getArguments(): array;

    /**
     * Return a taxonomy argument.
     *
     * @param  string  $property
     *
     * @return mixed
     */
    public function getArgument(string $property);

    /**
     * Set taxonomy objects.
     *
     * @param  array|string  $objects
     *
     * @return ITaxonomyInterface
     */
    public function setObjects($objects): ITaxonomyInterface;

    /**
     * Return taxonomy attached objects.
     *
     * @return array
     */
    public function getObjects(): array;
}
