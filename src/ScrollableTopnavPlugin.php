<?php

namespace Emuniq\FilamentScrollableTopnav;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

class ScrollableTopnavPlugin implements Plugin
{
    protected string $fadeSize = '36px';

    protected bool $edgeHints = true;

    protected bool $wheelToScroll = true;

    protected bool $autoScrollToFocus = true;

    protected bool $scrollSnap = false;

    public function getId(): string
    {
        return 'scrollable-topnav';
    }

    public function fadeSize(string $size): static
    {
        $this->fadeSize = $size;

        return $this;
    }

    public function edgeHints(bool $enabled = true): static
    {
        $this->edgeHints = $enabled;

        return $this;
    }

    public function wheelToScroll(bool $enabled = true): static
    {
        $this->wheelToScroll = $enabled;

        return $this;
    }

    public function autoScrollToFocus(bool $enabled = true): static
    {
        $this->autoScrollToFocus = $enabled;

        return $this;
    }

    public function scrollSnap(bool $enabled = true): static
    {
        $this->scrollSnap = $enabled;

        return $this;
    }

    public function getFadeSize(): string
    {
        return $this->fadeSize;
    }

    public function getEdgeHints(): bool
    {
        return $this->edgeHints;
    }

    public function getWheelToScroll(): bool
    {
        return $this->wheelToScroll;
    }

    public function getAutoScrollToFocus(): bool
    {
        return $this->autoScrollToFocus;
    }

    public function getScrollSnap(): bool
    {
        return $this->scrollSnap;
    }

    public function register(Panel $panel): void
    {
        $panel->renderHook(
            PanelsRenderHook::HEAD_END,
            fn () => view('filament-scrollable-topnav::styles', [
                'plugin' => $this,
            ])
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}
