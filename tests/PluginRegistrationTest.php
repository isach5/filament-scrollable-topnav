<?php

use Emuniq\FilamentScrollableTopnav\ScrollableTopnavPlugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentAsset;

it('registers when explicitly added to a panel', function () {
    $panel = Panel::make()->id('explicit')->path('explicit')
        ->plugin(ScrollableTopnavPlugin::make());

    expect($panel->getPlugin('scrollable-topnav'))
        ->toBeInstanceOf(ScrollableTopnavPlugin::class);
});

it('does not auto-register on every panel anymore', function () {
    $panel = Panel::make()->id('plain')->path('plain');

    expect($panel->getPlugins())->toBeArray()->toBeEmpty();
});

it('registers a CSS asset under the package namespace', function () {
    $styles = FilamentAsset::getStyles(['emuniq/filament-scrollable-topnav']);

    expect($styles)->toBeArray()->not->toBeEmpty();
});

it('registers a JS asset under the package namespace', function () {
    $scripts = FilamentAsset::getScripts(['emuniq/filament-scrollable-topnav']);

    expect($scripts)->toBeArray()->not->toBeEmpty();
});
