    @if (session('success'))
        <div
            x-data="{ show: false }"
            x-init="
                requestAnimationFrame(() => show = true);
                setTimeout(() => show = false, 3000);
            "
            x-show="show"
            x-cloak
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-5 right-5 z-50 w-80 overflow-hidden rounded-lg bg-green-500 text-white shadow-lg"
        >
            <div class="p-4">
                {{ session('success') }}
            </div>

            <!-- Timer bar -->
            <div
                class="h-1 origin-left animate-[timer_3s_linear_forwards] bg-white/70"
            ></div>
        </div>
    @endif

    @if ($errors->any())
        <div
            x-data="{ show: false }"
            x-init="
                requestAnimationFrame(() => show = true);
                setTimeout(() => show = false, 3000);
            "
            x-show="show"
            x-cloak
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-5 right-5 z-50 w-80 overflow-hidden rounded-lg bg-red-500 text-white shadow-lg"
        >
            <div class="p-4">
                {{ $errors->first() }}
            </div>

            <div
                class="h-1 origin-left animate-[timer_3s_linear_forwards] bg-white/70"
            ></div>
        </div>
    @endif