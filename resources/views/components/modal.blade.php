@props(['buttonText' => 'Abrir Modal', 'buttonClass' => null, 'title' => null, 'icon' => false])

<div x-data="{ isOpen: false }">
    <button type="button" @click="isOpen = true" class="@if($buttonClass) {{$buttonClass}} @else text-xs bg-green-500 text-white border-[1px] border-zinc-200 px-2 py-1 rounded-md font-bold @endif">
        @if($icon)
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#fff" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        @endif
        {{ $buttonText }}
    </button>
    <div
        x-show="isOpen"
        class="fixed inset-0 h-screen overflow-auto p-2 bg-gray-800 bg-opacity-50 flex items-start justify-center z-40"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        style="display: none;"
    >
        <div class="bg-white text-xs rounded-lg shadow-lg p-6 w-2/3 min-w-lg max-w-xl">
            <h2 class="text-xl font-semibold mb-4">
                {{ $title ?? 'Título por defecto' }}
            </h2>
            <div class="mb-4">
                {{ $slot }}
            </div>
            <button id="closeModal" type="button" @click="isOpen = false" class="w-full bg-red-500 text-white px-4 py-2 rounded-md">
                Cerrar Modal
            </button>
        </div>
    </div>
</div>
