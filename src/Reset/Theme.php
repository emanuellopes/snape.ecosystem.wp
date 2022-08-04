<?php

namespace Snape\EcoSystemWP\Reset;

class Theme
{
    public function __construct()
    {
        $this->clean_wp_theme();
    }

    private function clean_wp_theme(): void
    {
        add_action('redirect_canonical', array($this, 'remove_redirect_guess_404_permalink'));

        add_action('do_faviconico', array($this, 'wp_favicon_remover'));
        add_action('wp_enqueue_scripts', array($this, 'remove_block_css'));

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

    public function remove_redirect_guess_404_permalink($redirect_url)
    {
        if (is_404()) {
            return false;
        }

        return $redirect_url;
    }

    public function wp_favicon_remover(): void
    {
        exit;
    }

    public function remove_block_css(): void
    {
        wp_dequeue_style('wp-block-library');
    }
}
