<?php namespace Kpolicar\BackendMenuPinnedPages\Behaviors;

use Backend;
use Kpolicar\BackendMenuPinnedPages\Helpers\BackendMenuHelpers;
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
        $this->setContextFromRequest();

        BackendAuth::user()->pinned_pages()->create([
            'path' => $backendPath,
            'icon' => $this->resolveIconFromSettingsManager() ?? $this->resolveIconFromMenu() ?? 'icon-files-o',
            'label' => e(post('label')),
        ]);

        return [
            '@#layout-mainmenu .js-pinned-pages' =>
                $this->makeLayoutPartial('~/plugins/kpolicar/backendmenupinnedpages/layouts/_mainmenu_pinned_items')
        ];
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

    protected function setContextFromRequest()
    {
        rescue(function () {
            $settingsContext = json_decode(post('settings_context'));
            SettingsManager::setContext($settingsContext->owner, $settingsContext->itemCode);
        });
        rescue(function () {
            $context = json_decode(post('context'));
            BackendMenu::setContext($context->owner, $context->mainMenuCode, $context->sideMenuCode);
        });
    }

    protected function resolveIconFromSettingsManager()
    {
        $items = collect(SettingsManager::instance()->listItems());
        $active = optional($items->flatten()->first(function ($item) {
            return SettingsManagerHelper::settingsMenuItemIsActive($item);
        }));

        return $active->icon;
    }

    protected function resolveIconFromMenu()
    {
        $activeMenuItem = optional(BackendMenu::getActiveMainMenuItem());
        if ($activeMenuItem->sideMenu) {
            if ($item = BackendMenuHelpers::getActiveSideMenuItem()) {
                return $item->icon;
            }
        }

        return $activeMenuItem->icon;
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
