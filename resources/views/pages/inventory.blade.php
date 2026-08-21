@extends('layout.app')

@section('title', 'Inventory')

@section('content')
    <div class="flex flex-col h-full w-full" x-data="itemModal">

        <x-modal openState="itemModalOpen" closeModal="itemModalClose" x-show="itemModalOpen">
            <form enctype="multipart/form-data" id="item-form" method="POST"
                :action="isEdit ? `/inventory/${id}` : '/inventory'">
                @csrf
                <div class="flex flex-col gap-3 w-fit">
                    <div class="flex flex-col gap-1">
                        <label for="name" class="text-sm font-medium">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" class="border border-gray-300 rounded px-2 py-1"
                            placeholder="Enter item name" x-model="itemInput.name">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="sku" class="text-sm font-medium">SKU<span class="text-red-500">*</span></label>
                        <input type="text" id="sku" name="sku" class="border border-gray-300 rounded px-2 py-1"
                            placeholder="Enter item SKU" x-model="itemInput.sku">
                    </div>

                    <div class="flex flex-row gap-3">
                        <div class="flex flex-col gap-1">
                            <label for="cost_price" class="text-sm font-medium">Cost Price<span
                                    class="text-red-500">*</span></label>
                            <input type="number" step="0.01" id="cost_price" name="cost_price"
                                class="border border-gray-300 rounded px-2 py-1" placeholder="Enter cost price"
                                x-model="itemInput.cost_price">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="selling_price" class="text-sm font-medium">Selling Price<span
                                    class="text-red-500">*</span></label>
                            <input type="number" step="0.01" id="selling_price" name="selling_price"
                                class="border border-gray-300 rounded px-2 py-1" placeholder="Enter selling price"
                                x-model="itemInput.selling_price">
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="quantity" class="text-sm font-medium">Quantity<span
                                class="text-red-500">*</span></label>
                        <input type="number" id="quantity" name="quantity"
                            class="border border-gray-300 rounded px-2 py-1" placeholder="Enter quantity"
                            x-model="itemInput.quantity">
                    </div>
                    <div class="flex flex-col gap-2">
                        <input type="hidden" name="remove_image" id="remove-image" value="0">
                        <label for="image-upload" class="text-sm font-medium">Image</label>
                        <div class="relative w-40 h-40" @dragover.prevent @drop.prevent="handleDrop($event)">
                            <label for="image-upload" id="image-dropzone"
                                class="w-full h-full border-2 border-dashed border-gray-300 rounded-lg
           bg-gray-100 hover:bg-gray-200 cursor-pointer
           flex items-center justify-center overflow-hidden
           transition">
                                <span id="image-placeholder" class="text-5xl font-light text-gray-400"
                                    x-show="itemInput.image === ''">
                                    +
                                </span>

                                <img id="image-preview" :src="itemInput.image" alt="Image preview"
                                    class="w-full h-full object-cover" x-show="itemInput.image !== ''">
                            </label>

                            <button type="button" id="image-delete" x-show="itemInput.image !== ''"
                                class="absolute top-1 right-1
                   p-2 rounded-full
                   bg-red-500 hover:bg-red-600
                   text-white
                   shadow"
                                @click="clearImage">
                                <x-lucide-trash-2 class="w-4 h-4" />
                            </button>
                        </div>

                        <input type="file" id="image-upload" name="image" accept="image/*" class="hidden"
                            @change="handleImage($event)">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="description" class="text-sm font-medium">Description</label>
                        <textarea id="description" name="description" class="border border-gray-300 rounded px-2 py-1 h-32 resize-none"
                            placeholder="Enter item description" x-model="itemInput.description"></textarea>
                    </div>
                </div>
                <div class="flex flex-row justify-end">
                    <button type="button" @click="closeModal"
                        class="mt-4 inline-flex items-center rounded bg-gray-300 px-4 py-2 font-bold text-gray-700 hover:bg-gray-400 mr-2">
                        Cancel
                    </button>
                    <button type="submit"
                        class="mt-4 inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700"
                        id="submit-button" x-text="title">

                    </button>
                </div>
            </form>
        </x-modal>

        <h3 class="font-semibold text-2xl">Inventory</h3>
        <div class="flex flex-row justify-between mb-4">
            <form action="/inventory" method="GET">
                <input type="text" name="search" placeholder="Search..."
                    class="border border-gray-300 rounded px-2 py-1" id="search-input">

                <button type="submit"
                    class="inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700 ml-2">
                    <x-lucide-search class="h-4 w-4" />
                </button>
            </form>
            <button class="inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700"
                @click="itemModalOpen = true">
                <x-lucide-plus class="mr-2 h-4 w-4" />
                <span>Add Item</span>
            </button>
        </div>
        <x-data-table :headers="[
            'Name' => [
                'key' => 'name',
                'type' => 'text',
            ],
        
            'Image' => [
                'key' => 'image',
                'type' => 'image',
            ],
        
            'SKU' => [
                'key' => 'sku',
                'type' => 'text',
            ],
        
            'Description' => [
                'key' => 'description',
                'type' => 'text',
            ],
        
            'Cost Price' => [
                'key' => 'cost_price',
                'type' => 'price',
            ],
        
            'Selling Price' => [
                'key' => 'selling_price',
                'type' => 'price',
            ],
        
            'Quantity' => [
                'key' => 'quantity',
                'type' => 'number',
            ],
            'Actions' => [
                'key' => 'action',
                'type' => 'action',
            ],
        ]" :rows="$inventory">
            <x-slot name="action">
                <div class="flex flex-row gap-2">
                    <button @click="handleEditClick"
                        class="inline-flex items-center rounded bg-yellow-500 px-2 py-1 font-bold text-white hover:bg-yellow-600">
                        <x-lucide-edit class="h-4 w-4" />
                    </button>
                    <form method="POST" :action="'/inventory/' + id" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" @click="handleDeleteClick"
                            class="inline-flex items-center rounded bg-red-500 px-2 py-1 font-bold text-white hover:bg-red-600">
                            <x-lucide-trash class="h-4 w-4" />
                        </button>
                    </form>
                </div>
            </x-slot>
        </x-data-table>
        <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3">

            {{-- Left: Page length --}}
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>Rows per page</span>

                <select onchange="window.location.href = this.value"
                    class="rounded-md border-gray-300 bg-white py-1.5 pl-3 pr-8 text-sm
                   focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach ([10, 25, 50, 100] as $length)
                        <option
                            value="{{ request()->fullUrlWithQuery([
                                'page_length' => $length,
                                'page' => 1,
                            ]) }}"
                            @selected(request('page_length', 10) == $length)>
                            {{ $length }}
                        </option>
                    @endforeach
                </select>
            </div>

            <span class="whitespace-nowrap">
                {{ $inventory->firstItem() ?? 0 }}
                –
                {{ $inventory->lastItem() ?? 0 }}
                of
                {{ $inventory->total() }}
            </span>
            {{-- Pagination --}}
            <div class="flex items-center gap-1">

                {{-- First page --}}
                @if ($inventory->onFirstPage())
                    <span class="flex h-8 w-8 items-center justify-center rounded-md text-gray-300">
                        &laquo;
                    </span>
                @else
                    <a href="{{ $inventory->url(1) }}"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                        &laquo;
                    </a>
                @endif


                {{-- Previous --}}
                @if ($inventory->onFirstPage())
                    <span class="flex h-8 w-8 items-center justify-center rounded-md text-gray-300">
                        &lsaquo;
                    </span>
                @else
                    <a href="{{ $inventory->previousPageUrl() }}"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                        &lsaquo;
                    </a>
                @endif


                {{-- Page numbers --}}
                @php
                    $current = $inventory->currentPage();
                    $last = $inventory->lastPage();

                    // Maximum of 4 page buttons
                    $start = max(1, min($current - 1, $last - 3));
                    $end = min($last, $start + 3);
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $current)
                        <span
                            class="flex h-8 min-w-8 items-center justify-center rounded-md
                       text-sm font-medium text-white bg-blue-600 px-4 py-2  hover:bg-blue-700">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $inventory->url($page) }}"
                            class="flex h-8 min-w-8 items-center justify-center rounded-md
                       px-2 text-sm text-gray-600 hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endfor


                {{-- Next --}}
                @if ($inventory->hasMorePages())
                    <a href="{{ $inventory->nextPageUrl() }}"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                        &rsaquo;
                    </a>
                @else
                    <span class="flex h-8 w-8 items-center justify-center rounded-md text-gray-300">
                        &rsaquo;
                    </span>
                @endif


                {{-- Last page --}}
                @if ($current == $last)
                    <span class="flex h-8 w-8 items-center justify-center rounded-md text-gray-300">
                        &raquo;
                    </span>
                @else
                    <a href="{{ $inventory->url($last) }}"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                        &raquo;
                    </a>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ Vite::asset('resources/js/inventory/item-modal.js') }}"></script>

    <script type="module">
        const itemCount = "{{ $count }}";
    </script>
@endpush
