@use('Illuminate\Support\Facades\Storage')

<div class="w-full overflow-x-auto" x-data="{
    imageViewerOpen: false,
    image: '',
    closeModal() {
        this.imageViewerOpen = false;
        this.image = '';
        this.title = 'Add Item'
    },
    openViewer(event) {
        this.imageViewerOpen = true;
        this.image = event.target.src;
        this.title = '';
    }

}">

    <x-modal x-show="imageViewerOpen" modal-title="">
        <x-slot>
            <div class="flex p-4">
                <img :src="image" class="max-h-[80vh] max-w-[80vw] h-auto w-auto object-contain rounded-xl">
            </div>
        </x-slot>
    </x-modal>
    <table class="w-full table-auto">
        <thead class="text-[13px] font-medium text-slate-500/70">
            <tr>
                @foreach ($headers as $label => $column)
                    @php
                        $type = $column['type'] ?? 'text';
                        $isHidden = ($column['hidden'] ?? false) || $type === 'hidden';
                    @endphp

                    <th @class([
                        'whitespace-nowrap bg-slate-100 px-5 py-2 text-left first:rounded-l first:pl-3 last:rounded-r last:pr-3',
                        'hidden' => $isHidden,
                    ])>
                        {{ $label }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody class="text-sm font-normal">
            @forelse ($rows as $item)
                <tr class="border-b border-slate-200 last:border-none" name="{{ $item->id }}">
                    @foreach ($headers as $label => $column)
                        @php
                            $value = data_get($item, $column['key']);
                            $type = $column['type'] ?? 'text';
                            $isHidden = ($column['hidden'] ?? false) || $type === 'hidden';
                        @endphp

                        <td @class([
                            'whitespace-nowrap px-5 py-3 first:pl-3 last:pr-3',
                            'hidden' => $isHidden,
                        ]) data-key="{{ $column['key'] }}"
                            data-value="{{ $type === 'image' && $value ? Storage::url($value) : ($type === 'image' ? '' : $value) }}">
                            @switch($type)
                                @case('text')
                                    {{ $value ?? '...' }}
                                @break

                                @case('image')
                                    @if ($value)
                                        <div class="group relative w-fit">
                                            <img src="{{ Storage::url($value) }}" alt="{{ $label }}"
                                                class="size-10 rounded-lg border border-slate-600 object-cover"
                                                @click="openViewer($event)">

                                        </div>
                                    @else
                                        <div
                                            class="flex size-10 items-center justify-center rounded-lg border border-slate-600 bg-slate-100 text-center text-xs text-slate-400">
                                            No
                                            <br>
                                            image
                                        </div>
                                    @endif
                                @break

                                @case('price')
                                    ₱{{ number_format((float) $value, 2) }}
                                @break

                                @case('number')
                                    {{ number_format((int) $value) }}
                                @break

                                @case('date')
                                    {{ $value ? \Carbon\Carbon::parse($value)->format('M d, Y') : '-' }}
                                @break

                                @case('datetime')
                                    {{ $value ? \Carbon\Carbon::parse($value)->format('M d, Y h:i A') : '-' }}
                                @break

                                @case('badge')
                                    <span
                                        class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-normal text-slate-600">
                                        {{ $value }}
                                    </span>
                                @break

                                @case('boolean')
                                    @if ($value)
                                        <span class="text-green-600">
                                            Yes
                                        </span>
                                    @else
                                        <span class="text-red-600">
                                            No
                                        </span>
                                    @endif
                                @break
                                @case('action')
                                    {{ $action }}
                                @break

                                @default
                                    {{ $value }}
                            @endswitch
                        </td>
                    @endforeach
                </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) }}" class="px-5 py-10 text-center text-sm text-slate-400">
                            No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
