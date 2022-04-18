<?php

namespace Snape\EcoSystemWP\Reset;

class TinyMCE
{
    public function __construct()
    {
        add_filter('tiny_mce_before_init', array($this, 'tinymcePasteAsText'));
    }

    public function tinymcePasteAsText(array $init): array
    {
        $init['paste_as_text'] = true;

        return $init;
    }
}
