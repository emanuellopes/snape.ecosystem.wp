<?php

namespace Snape\EcoSystemWP\Controllers;

use Timber\Helper;
use Timber\Timber;

abstract class AbstractController
{
    private array $data;

    private float $start;

    abstract protected function getTemplate(): string;

    abstract protected function prepareContent(): void;

    public function __construct()
    {
        $this->data = Timber::get_context();
        $this->prepareContent();
        $this->start = Helper::start_timer();
    }

    public function measureSpeed(): void
    {
        $timer = Helper::stop_timer((int) $this->start);
        do_action('qm/debug', 'Page rendered in: ' . $timer); //phpcs:ignore
        Helper::error_log($timer);
    }

    /**
     * @param  string  $variable
     * @param  mixed  $data
     *
     * @return void
     */
    protected function addData(string $variable, $data): void
    {
        $this->data[$variable] = $data;
    }


    public function getData(): array
    {
        return $this->data;
    }

    public function getCacheTime(): int
    {
        return WP_DEBUG ? 0 : 600;
    }

    public function renderPage(): void
    {
        Timber::render($this->getTemplate(), $this->getData(), $this->getCacheTime());

        $this->measureSpeed();
    }

    public function goToHomePage(): void
    {
        wp_safe_redirect(home_url(), 301);
    }
}
