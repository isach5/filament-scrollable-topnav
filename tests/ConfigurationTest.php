<?php

use Emuniq\FilamentScrollableTopnav\ScrollableTopnavPlugin;

it('exposes builders for every config knob', function () {
    $plugin = ScrollableTopnavPlugin::make()
        ->fadeSize('48px')
        ->edgeHints(false)
        ->wheelToScroll(false)
        ->autoScrollToFocus(false)
        ->scrollSnap(true);

    expect($plugin->getFadeSize())->toBe('48px')
        ->and($plugin->getEdgeHints())->toBeFalse()
        ->and($plugin->getWheelToScroll())->toBeFalse()
        ->and($plugin->getAutoScrollToFocus())->toBeFalse()
        ->and($plugin->getScrollSnap())->toBeTrue();
});

it('uses sensible defaults when no builder is called', function () {
    $plugin = ScrollableTopnavPlugin::make();

    expect($plugin->getFadeSize())->toBe('36px')
        ->and($plugin->getEdgeHints())->toBeTrue()
        ->and($plugin->getWheelToScroll())->toBeTrue()
        ->and($plugin->getAutoScrollToFocus())->toBeTrue()
        ->and($plugin->getScrollSnap())->toBeFalse();
});

it('renders the inline view with critical anti-FOUC rules', function () {
    $plugin = ScrollableTopnavPlugin::make();

    $rendered = view('filament-scrollable-topnav::styles', ['plugin' => $plugin])->render();

    expect($rendered)
        ->toContain('fi-topbar-nav-groups')
        ->toContain('flex-wrap: nowrap')
        ->toContain('white-space: nowrap');
});

it('renders the configured fade size as a CSS variable', function () {
    $plugin = ScrollableTopnavPlugin::make()->fadeSize('64px');

    $rendered = view('filament-scrollable-topnav::styles', ['plugin' => $plugin])->render();

    expect($rendered)->toContain('--scrollable-topnav-fade: 64px');
});

it('serialises feature toggles into the runtime config script', function () {
    $plugin = ScrollableTopnavPlugin::make()
        ->wheelToScroll(false)
        ->autoScrollToFocus(false)
        ->scrollSnap(true);

    $rendered = view('filament-scrollable-topnav::styles', ['plugin' => $plugin])->render();

    expect($rendered)
        ->toContain('window.scrollableTopnavConfig')
        ->toContain('wheelToScroll: false')
        ->toContain('autoScrollToFocus: false')
        ->toContain('scrollSnap: true')
        ->toContain('edgeHints: true');
});
