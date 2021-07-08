<?php namespace Kpolicar\BackendmenuPinnedPages\Helpers;

use BackendAuth;
use BackendMenu;

class BackendMenuHelpers
{
    public static function getActiveSideMenuItem()
    {
        foreach (BackendMenu::listSideMenuItems() as $item) {
            if (BackendMenu::isSideMenuItemActive($item)) {
                return $item;
            }
        }

        return null;
    }
}
