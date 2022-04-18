<?php

namespace Snape\EcoSystemWP\Contracts\Taxonomy;

interface ITaxonomyFactoryInterface
{
    public function make(string $slug, string $singular, string $plural, int $priority = 10): ITaxonomyInterface;

    public function update(
        string $slug,
        string $singular = '',
        string $plural = '',
        int $priority = 10
    ): ITaxonomyInterface;

    public function exists(string $slug): bool;

    public function remove(string $slug, array $taxonomies = array(), int $priority = 10);
}
