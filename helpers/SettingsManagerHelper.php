<?php namespace Kpolicar\BackendMenuPinnedPages\Helpers;

use BackendAuth;
use BackendMenu;

class SettingsManagerHelper
{
    public static function settingsMenuItemIsActive($item)
    {
        $context = \System\Classes\SettingsManager::instance()->getContext();
        return strtolower($item->owner) == $context->owner && strtolower($item->code) == $context->itemCode;
    }
}
