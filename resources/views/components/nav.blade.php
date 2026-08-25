<div class="w-2xs h-full border-r border-r-gray-200 p-3">
    @foreach ($items as $item)
        @php
            $hasChildren = !empty($item['children']);
            $hasActiveChild = $hasChildren && collect($item['children'])->contains(
                fn ($child) => request()->routeIs($child['route']),
            );
        @endphp

        <div x-data="{ open: {{ $hasActiveChild ? 'true' : 'false' }} }" class="w-full">
            @if ($hasChildren)
                <button type="button" @click="open = !open" @class([
                    'w-full',
                    'p-1',
                    'flex',
                    'flex-row',
                    'gap-2',
                    'items-center',
                    'rounded-sm',
                    'pl-3',
                    'text-left',
                    'bg-gray-200' => $hasActiveChild,
                ])>
                    <x-dynamic-component :component="'lucide-' . ($item['icon'] ?? 'folder')" class="w-4 h-4" />
                    <span class="w-full font-normal">{{ $item['label'] }}</span>
                    <x-lucide-chevron-down class="h-4 w-4 transition-transform" x-bind:class="{ 'rotate-180': open }" />
                </button>

                <div x-cloak x-show="open" x-transition class="mt-1 flex flex-col gap-1 pl-6">
                    @foreach ($item['children'] as $child)
                        <a href="{{ route($child['route']) }}" @class([
                            'flex',
                            'items-center',
                            'gap-2',
                            'rounded-sm',
                            'p-1',
                            'pl-3',
                            'font-normal',
                            'hover:bg-gray-100',
                            'bg-gray-200' => request()->routeIs($child['route']),
                        ])>
                            <x-dynamic-component :component="'lucide-' . ($child['icon'] ?? 'file')" class="h-4 w-4" />
                            <span>{{ $child['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <a href="{{ route($item['route']) }}" @class([
                    'flex',
                    'w-full',
                    'flex-row',
                    'items-center',
                    'gap-2',
                    'rounded-sm',
                    'p-1',
                    'pl-3',
                    'font-normal',
                    'hover:bg-gray-100',
                    'bg-gray-200' => request()->routeIs($item['route']),
                ])>
                    <x-dynamic-component :component="'lucide-' . ($item['icon'] ?? 'file')" class="h-4 w-4" />
                    <span>{{ $item['label'] }}</span>
                </a>
            @endif
        </div>
    @endforeach
</div>
