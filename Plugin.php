<?php namespace Kpolicar\PersonalizedBackend;

use Backend;
use System\Classes\CombineAssets;
use System\Classes\PluginBase;
use Backend\Classes\Controller as BackendController;
use BackendAuth;

/**
 * PersonalizedBackend Plugin Information File
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
            'name'        => 'PersonalizedBackend',
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
                $controller->addCss('/plugins/kpolicar/personalizedbackend/assets/css/menu.css');
                $controller->addJs('/plugins/kpolicar/personalizedbackend/assets/js/menu.js', ['defer' => true]);
            }
        });
        \Event::listen('backend.layout.extendHead', function ($a) {
            return $a->makeLayoutPartial('~/plugins/kpolicar/personalizedbackend/layouts/_mainmenu_buttons');
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Kpolicar\PersonalizedBackend\Components\MyComponent' => 'myComponent',
        ];
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
            'kpolicar.personalizedbackend.some_permission' => [
                'tab' => 'PersonalizedBackend',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'personalizedbackend' => [
                'label'       => 'PersonalizedBackend',
                'url'         => Backend::url('kpolicar/personalizedbackend/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['kpolicar.personalizedbackend.*'],
                'order'       => 500,
            ],
        ];
    }
}
