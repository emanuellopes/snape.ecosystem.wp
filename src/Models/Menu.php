<?php

namespace Snape\EcoSystemWP\Models;

use Timber\Menu as TimberMenu;

class Menu extends TimberMenu
{
    public $MenuItemClass = MenuItem::class; // @phpstan-ignore-line
}
