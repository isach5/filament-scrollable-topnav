<style>
    /* Critical CSS — prevents the brief double-row flash before plugin.css loads */
    .fi-topbar .fi-topbar-item-label,
    .fi-topbar .fi-topbar-item-btn,
    .fi-topbar-nav-groups .fi-topbar-item,
    .fi-topbar-nav-groups .fi-topbar-item-btn,
    .fi-topbar-nav-groups .fi-topbar-item-label {
        white-space: nowrap !important;
        word-break: keep-all !important;
        flex-shrink: 0 !important;
    }

    @media (min-width: 1024px) {
        .fi-topbar-nav-groups {
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .fi-topbar-nav-groups::-webkit-scrollbar {
            display: none;
        }
    }

    :root {
        --scrollable-topnav-fade: {{ $plugin->getFadeSize() }};
    }
</style>
<script>
    window.scrollableTopnavConfig = {
        edgeHints: {{ $plugin->getEdgeHints() ? 'true' : 'false' }},
        wheelToScroll: {{ $plugin->getWheelToScroll() ? 'true' : 'false' }},
        autoScrollToFocus: {{ $plugin->getAutoScrollToFocus() ? 'true' : 'false' }},
        scrollSnap: {{ $plugin->getScrollSnap() ? 'true' : 'false' }},
    };
</script>
