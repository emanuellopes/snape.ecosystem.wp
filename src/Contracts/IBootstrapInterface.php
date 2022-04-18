<?php

namespace Snape\EcoSystemWP\Contracts;

/**
 * All Bootstrap files should implement this interface BootstrapInterface
 *
 * @package Endor\Bootstrappers
 */
interface IBootstrapInterface
{
    public function bootstrap(IApplicationInterface $application): void;
}
