<?php

namespace Snape\EcoSystemWP\Reset;

class Theme
{
    public function __construct()
    {
        $this->cleanWpTheme();
    }

    private function cleanWpTheme(): void
    {
        add_action('redirect_canonical', array($this, 'removeRedirectGuess404Permalink'));

        add_action('do_faviconico', array($this, 'wpFaviconRemover'));
        add_action('wp_enqueue_scripts', array($this, 'removeBlockCss'));

        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'wp_resource_hints', 2);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
    }

    public function removeRedirectGuess404Permalink($redirect_url)
    {
        if (is_404()) {
            return false;
        }

        return $redirect_url;
    }

    public function wpFaviconRemover(): void
    {
        exit;
    }

    public function removeBlockCss(): void
    {
        wp_dequeue_style('wp-block-library');
    }
}
