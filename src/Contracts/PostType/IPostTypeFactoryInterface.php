<?php

namespace Snape\EcoSystemWP\Contracts\PostType;

interface IPostTypeFactoryInterface
{
    public function make(string $slug, string $singular, string $plural, int $priority = 10): IPostTypeInterface;

    public function update(
        string $slug,
        string $singular = '',
        string $plural = '',
        int $priority = 10
    ): IPostTypeInterface;

    public function exists(string $slug): bool;
}
