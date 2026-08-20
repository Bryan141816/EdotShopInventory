<div {{ $attributes->merge([
    'class' => 'fixed inset-0 flex justify-center items-center bg-gray-500/60 z-50',
]) }}
    x-cloak {{-- Background: fade --}} x-transition:enter="transition-opacity ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @mousedown.self="closeModal">
    <div class="flex flex-col p-3 bg-white rounded-2xl max-h-[90%]" {{-- Content: pop up --}}
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90 translate-y-3"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 translate-y-3" @click.stop>
        <div class="flex flex-row justify-between items-center mb-4 gap-3">
            <h3 class="font-semibold text-base" x-text="title"></h3>

            <button data-modal-close="{{ $attributes->get('id') }}" @click="closeModal">
                <x-lucide-x class="h-4 w-4" />
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
