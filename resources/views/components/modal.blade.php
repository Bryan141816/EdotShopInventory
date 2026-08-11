<div
    {{ $attributes->merge([
        'class' => 'h-screen w-screen flex justify-center items-center bg-gray-500/60 absolute top-0 left-0 z-50',
    ]) }}>
    <div class="flex flex-col p-3 bg-white rounded-2xl">
        <div class="flex flex-row justify-between items-center mb-4 gap-3">
            <h3 class="font-semibold text-base">{{ $title }}</h3>
            <button data-modal-close="{{ $attributes->get('id') }}" data-dispose="{{ $attributes->get('data-dispose') }}">
                <x-lucide-x class="h-4 w-4" />
            </button>
        </div>
        {{ $slot }}
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
    function updateModalTitle(modalId, newTitle) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const titleElement = modal.querySelector('h3');
            if (titleElement) {
                titleElement.textContent = newTitle;
            }
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-modal-close]').forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-close');
                closeModal(modalId);
                const functionName = this.getAttribute('data-dispose');
                if (functionName && typeof window[functionName] === 'function') {
                    console.log('Function name:', functionName);
                    window[functionName]();
                }
            });
        });

        document.querySelectorAll('[data-modal-open]').forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-open');
                openModal(modalId);
            });
        });
    });
</script>
