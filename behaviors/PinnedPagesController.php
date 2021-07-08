<?php namespace Kpolicar\BackendMenuPinnedPages\Behaviors;

use Backend;
use Illuminate\Support\Collection;
use Kpolicar\BackendMenuPinnedPages\Helpers\SettingsManagerHelper;
use Request;
use System\Classes\SettingsManager;
use Validator;
use BackendAuth;
use BackendMenu;
use URL;
use Backend\Classes\ControllerBehavior;

class PinnedPagesController extends ControllerBehavior
{
    public function onPinPage()
    {
        $backendPath = $this->currentBackendPath();
        $context = json_decode(post('context'));

        BackendAuth::user()->pinned_pages()->create([
            'path' => $backendPath,
            'icon' => $this->parseIconFromSettingsManager($context) ?? $this->parseIconFromMainMenu() ?? 'icon-files-o',
            'label' => e(post('label')),
        ]);

        return [
            '@#layout-mainmenu .js-pinned-pages' =>
                $this->makeLayoutPartial('~/plugins/kpolicar/backendmenupinnedpages/layouts/_mainmenu_pinned_items')
        ];
    }

    protected function parseIconFromSettingsManager($context)
    {
        $items = collect(SettingsManager::instance()->listItems());
        $active = optional($items->flatten()->first(function ($item) use ($context) {
            return SettingsManagerHelper::settingsMenuItemIsActive($item, $context);
        }));

        return $active->icon;
    }

    protected function parseIconFromMainMenu()
    {
        $activeMenuItem = optional(BackendMenu::getActiveMainMenuItem());

        return $activeMenuItem->icon;
    }

    public function onPinPageRemove() {
        Validator::validate(
            post(),
            ['path' => 'nullable|string']
        );
        $backendPath = post('path', $this->currentBackendPath());

        BackendAuth::user()->pinned_pages()->where('path', $backendPath)->delete();

        return [
            'path' => $backendPath,
            'count' => BackendAuth::user()->pinned_pages->count(),
        ];
    }

    public function currentBackendPath()
    {
        return \Str::replaceFirst(
            URL::to(Backend::uri()).'/',
            '',
            URL::to(Request::path())
        );
    }

    public function isCurrentPathPinned()
    {
        return !!BackendAuth::user()->pinned_pages->firstWhere('path', $this->currentBackendPath());
    }
}
