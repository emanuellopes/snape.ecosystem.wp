<?php

namespace Snape\EcoSystemWP\Features;

use League\Config\ConfigurationInterface;

abstract class AbstractEnqueueFiles extends AbstractFeature
{
    public function __construct(ConfigurationInterface $config)
    {
        parent::__construct($config);
        $this->addAdminBodyScope();
    }

    abstract public function getBodyScopeClass(): string;

    private function addAdminBodyScope(): void
    {
        add_filter(
            'admin_body_class',
            function ($classes) {
                $classes .= $this->getBodyScopeClass();

                return $classes;
            }
        );
    }

    protected function removeGutenbergEnqueueFiles(): void
    {
        add_action('wp_enqueue_scripts', function () {
            // remove unused styles
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
        });
    }
}
