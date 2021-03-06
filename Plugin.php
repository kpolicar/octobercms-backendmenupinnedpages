<?php namespace Kpolicar\BackendMenuPinnedPages;

use Event;
use Kpolicar\BackendMenuPinnedPages\Behaviors\PinnedPagesController;
use Kpolicar\BackendMenuPinnedPages\Models\PinnedPage;
use System\Classes\PluginBase;
use Backend\Classes\Controller as BackendController;
use Backend\Models\User as BackendUser;
use BackendAuth;

/**
 * BackendMenuPinnedPages Plugin Information File
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
            'name'        => 'kpolicar.backendmenupinnedpages::lang.plugin.name',
            'description' => 'kpolicar.backendmenupinnedpages::lang.plugin.description',
            'author'      => 'Klemen Janez Poličar',
            'icon'        => 'icon-thumb-tack'
        ];
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

        BackendController::extend(function($controller) {
            if (BackendAuth::check()) {
                $controller->extendClassWith(PinnedPagesController::class);
                $controller->addCss('/plugins/kpolicar/backendmenupinnedpages/assets/css/menu.css');
                $controller->addJs('/plugins/kpolicar/backendmenupinnedpages/assets/js/menu.js', ['defer' => true]);
            }
        });

        Event::listen('backend.layout.extendHead', function ($a) {
            if (BackendAuth::check()) {
                return $a->makeLayoutPartial('~/plugins/kpolicar/backendmenupinnedpages/layouts/_mainmenu_buttons');
            }
        });

        BackendUser::extend(function ($user) {
            $user->hasMany += ['pinned_pages' => PinnedPage::class];
        });
    }
}
