<div class="w-2xs h-full border-r border-r-gray-200 p-3">
    @foreach ($items as $item)
        <div @class([
            'w-full',
            'p-1',
            'bg-gray-200' => request()->routeIs($item['route']),
            'flex',
            'flex-row',
            'gap-2',
            'items-center',
            'rounded-sm',
            'pl-3',
            
        ])>
            <x-dynamic-component
                :component="'lucide-' . ($item['icon'] ?? 'file')"
                class="w-4 h-4"
            />
            <a href="{{ route($item['route']) }}" class="w-full block font-normal">
                {{ $item['label'] }}
            </a>
        </div>
    @endforeach
</div>