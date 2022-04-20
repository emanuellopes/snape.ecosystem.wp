<?php
namespace SampleThemeApp\Bootstrap;

use Snape\EcoSystemWP\Features\AbstractEnqueueFiles;

class EnqueueFiles extends AbstractEnqueueFiles
{

    public function getBodyScopeClass(): string
    {
        return 'sample-scope-css';
    }

    public function boot(): void
    {
        //Enqueue here the files
        $this->removeGutenbergEnqueueFiles();
    }
}
