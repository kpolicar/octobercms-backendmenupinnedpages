<?php namespace Kpolicar\BackendmenuPinnedPages;

use Backend;
use System\Classes\CombineAssets;
use System\Classes\PluginBase;
use Backend\Classes\Controller as BackendController;
use BackendAuth;

/**
 * BackendmenuPinnedPages Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'BackendmenuPinnedPages',
            'description' => 'No description provided yet...',
            'author'      => 'Kpolicar',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        BackendController::extend(function($controller)
        {
            if (BackendAuth::check()) {
                $controller->addCss('/plugins/kpolicar/backendmenupinnedpages/assets/css/menu.css');
                $controller->addJs('/plugins/kpolicar/backendmenupinnedpages/assets/js/menu.js', ['defer' => true]);
            }
        });
        \Event::listen('backend.layout.extendHead', function ($a) {
            return $a->makeLayoutPartial('~/plugins/kpolicar/backendmenupinnedpages/layouts/_mainmenu_buttons');
        });
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'kpolicar.backendmenupinnedpages.some_permission' => [
                'tab' => 'Backendmenupinnedpages',
                'label' => 'Some permission'
            ],
        ];
    }
}
