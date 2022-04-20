<?php

namespace Snape\EcoSystemWP\CarbonFields;

trait RichTextTrait
{
    protected function richtextDefaultSettings($toolbars = array(), $other_settings = array()): array
    {
        return array(
            'media_buttons' => false,
            'quicktags' => array('buttons' => ','),
            'tinymce' => array_merge(
                $toolbars,
                $other_settings,
                array(
                    'wpautop' => false,
                )
            ),
        );
    }

    protected function simpleToolbar(): array
    {
        return array(
            'toolbar1' => 'bold,italic,underline,separator,link,unlink,undo,redo',
            'toolbar2' => '',
            'toolbar3' => '',
        );
    }
}
