<?php namespace Kpolicar\BackendMenuPinnedPages\Helpers;

use BackendAuth;
use BackendMenu;
use System\Classes\SettingsManager;

class SettingsManagerHelper
{
    public static function settingsMenuItemIsActive($item)
    {
        $context = SettingsManager::instance()->getContext();
        return strtolower($item->owner) == $context->owner && strtolower($item->code) == $context->itemCode;
    }
}
