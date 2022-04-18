<?php

namespace Snape\EcoSystemWP\Contracts;

interface IPostTypeFactoryInterface
{
    public function make( $slug, $singular, $plural, $priority = 10 ): IPostTypeInterface;

    public function update( $slug, $singular = '', $plural = '', $priority = 10 ): IPostTypeInterface;

    public function exists( string $slug ): bool;
}
