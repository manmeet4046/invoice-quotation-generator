<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="bg-red-100 dark:bg-gray-900">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>