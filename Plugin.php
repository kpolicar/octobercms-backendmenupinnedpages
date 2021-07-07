<?php namespace Kpolicar\BackendmenuPinnedPages;

use Backend;
use Kpolicar\BackendmenuPinnedPages\Behaviors\PinnedPagesController;
use Kpolicar\BackendmenuPinnedPages\Controllers\Index;
use Kpolicar\BackendmenuPinnedPages\Helpers\BackendMenuHelpers;
use Kpolicar\BackendMenuPinnedPages\Models\PinnedPage;
use System\Classes\CombineAssets;
use System\Classes\PluginBase;
use Backend\Classes\Controller as BackendController;
use Backend\Models\User as BackendUser;
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
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInBackend())
            return;

        BackendController::extend(function($controller)
        {
            $controller->extendClassWith(PinnedPagesController::class);

            if (BackendAuth::check()) {
                $controller->addCss('/plugins/kpolicar/backendmenupinnedpages/assets/css/menu.css');
                $controller->addJs('/plugins/kpolicar/backendmenupinnedpages/assets/js/menu.js', ['defer' => true]);
            }
        });
        \Event::listen('backend.layout.extendHead', function ($a) {
            return $a->makeLayoutPartial('~/plugins/kpolicar/backendmenupinnedpages/layouts/_mainmenu_buttons');
        });

        BackendUser::extend(function ($user) {
            $user->hasMany += ['pinned_pages' => PinnedPage::class];
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
