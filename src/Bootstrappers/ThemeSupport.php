<?php

namespace Snape\EcoSystemWP\Bootstrappers;

use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IBootstrapInterface;

class ThemeSupport implements IBootstrapInterface
{
    public function bootstrap(IApplicationInterface $application): void
    {
        $supports = $application->getContainer()->getConfig()->get('app.theme.supports');

        if (empty($supports)) {
            return;
        }

        /** @var array $supports */
        /** @var string $supportName */
        foreach ($supports as $supportName => $args) {
            if (is_array($args)) {
                add_theme_support($supportName, $args);
                continue;
            }

            if (is_bool($args) && $args === true) {
                add_theme_support($supportName);
            }
        }
    }
}
