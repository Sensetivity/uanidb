<x-filament-panels::page>
    <style>
        .fi-page-content > div { max-width: none !important; }
        .fi-in-image .fi-in-image-item {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }
        .fi-in-text .prose {
            max-width: none;
            line-height: 1.75;
        }
    </style>

    {{ $this->content }}
</x-filament-panels::page>
