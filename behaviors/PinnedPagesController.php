<?php namespace Kpolicar\BackendmenuPinnedPages\Behaviors;

use Backend;
use Request;
use Validator;
use BackendAuth;
use BackendMenu;
use URL;
use Backend\Classes\ControllerBehavior;

class PinnedPagesController extends ControllerBehavior
{
    public function onPinPage()
    {
        $backendPath = \Str::replaceFirst(
            URL::to(Backend::uri()).'/',
            '',
            URL::to(Request::path())
        );
        $activeMenuItem = optional(BackendMenu::getActiveMainMenuItem());

        BackendAuth::user()->pinned_pages()->create([
            'path' => $backendPath,
            'icon' => $activeMenuItem->icon ?: 'icon-files-o',
            'label' => $activeMenuItem->label ? e(trans($activeMenuItem->label)) : 'Default title',
        ]);

        return [
            '#layout-mainmenu .js-pinned-pages' =>
                $this->makeLayoutPartial('~/plugins/kpolicar/backendmenupinnedpages/layouts/_mainmenu_pinned_items')
        ];
    }

    public function onPinPageRemove() {
        Validator::validate(
            post(),
            ['path' => 'required|string']
        );
        BackendAuth::user()->pinned_pages()->where('path', post('path'))->delete();
    }
}
