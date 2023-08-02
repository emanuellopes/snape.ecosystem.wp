<?php

namespace SampleThemeApp;

use Snape\EcoSystemWP\Controllers\AbstractController;

class IndexController extends AbstractController
{
    protected function getTemplate(): string
    {
        return '@pages/home.twig';
    }

    protected function prepareContent(): void
    {
        $this->addData('myvariable', 'sample-content');
    }
}
