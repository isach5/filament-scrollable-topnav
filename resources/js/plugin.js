(function () {
    if (window.__scrollableTopnavBound) return;
    window.__scrollableTopnavBound = true;

    var config = Object.assign(
        {
            edgeHints: true,
            wheelToScroll: true,
            autoScrollToFocus: true,
            scrollSnap: false,
        },
        window.scrollableTopnavConfig || {},
    );

    function updateHints(el) {
        if (!el || !config.edgeHints) return;
        var hasOverflow = el.scrollWidth > el.clientWidth + 1;
        var canLeft = hasOverflow && el.scrollLeft > 1;
        var canRight = hasOverflow && el.scrollLeft + el.clientWidth < el.scrollWidth - 1;
        el.dataset.canScrollLeft = canLeft ? '1' : '0';
        el.dataset.canScrollRight = canRight ? '1' : '0';
    }

    function bindNav(nav) {
        if (!nav || nav.__scrollableTopnavInit) return;
        nav.__scrollableTopnavInit = true;

        if (config.scrollSnap) nav.dataset.scrollSnap = '1';

        updateHints(nav);
        nav.addEventListener('scroll', function () { updateHints(nav); }, { passive: true });
        if ('ResizeObserver' in window) {
            new ResizeObserver(function () { updateHints(nav); }).observe(nav);
        }
    }

    function init() {
        document.querySelectorAll('.fi-topbar-nav-groups').forEach(bindNav);
    }

    if (config.wheelToScroll) {
        // Mouse wheels emit deltaY only; trackpads emit deltaX for horizontal swipes.
        // Redirect vertical intent to horizontal scroll only when the user isn't already scrolling sideways.
        document.addEventListener('wheel', function (event) {
            var el = event.target.closest && event.target.closest('.fi-topbar-nav-groups');
            if (!el) return;
            if (el.scrollWidth <= el.clientWidth) return;
            if (event.deltaY === 0) return;
            if (Math.abs(event.deltaX) > Math.abs(event.deltaY)) return;

            // Normalize across deltaMode: 0 = pixels, 1 = lines, 2 = pages.
            var delta = event.deltaY;
            if (event.deltaMode === 1) delta *= 16;
            else if (event.deltaMode === 2) delta *= el.clientWidth;

            el.scrollLeft += delta;
            event.preventDefault();
        }, { passive: false });
    }

    if (config.autoScrollToFocus) {
        document.addEventListener('focusin', function (event) {
            var item = event.target.closest && event.target.closest('.fi-topbar-nav-groups > *');
            if (!item || typeof item.scrollIntoView !== 'function') return;
            item.scrollIntoView({ block: 'nearest', inline: 'nearest' });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    document.addEventListener('livewire:navigated', init);
    window.addEventListener('resize', init);
})();
