@extends('layout.main')

@section('title')
    Inventory
@endsection

@push('scripts')
    @vite(['resources/js/inventory/image-picker.js', 'resources/js/inventory/inventory-handler.js'])
@endpush

@section('content')
    <x-modal class="hidden" id="add-item-modal" data-dispose="clearForm" title="Add Item">
        <form enctype="multipart/form-data" id="item-form" action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-3 w-fit">
                <div class="flex flex-col gap-1">
                    <label for="name" class="text-sm font-medium">Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" class="border border-gray-300 rounded px-2 py-1"
                        placeholder="Enter item name">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="sku" class="text-sm font-medium">SKU<span class="text-red-500">*</span></label>
                    <input type="text" id="sku" name="sku" class="border border-gray-300 rounded px-2 py-1"
                        placeholder="Enter item SKU">
                </div>

                <div class="flex flex-row gap-3">
                    <div class="flex flex-col gap-1">
                        <label for="cost_price" class="text-sm font-medium">Cost Price<span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="cost_price" name="cost_price"
                            class="border border-gray-300 rounded px-2 py-1" placeholder="Enter cost price">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="selling_price" class="text-sm font-medium">Selling Price<span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="selling_price" name="selling_price"
                            class="border border-gray-300 rounded px-2 py-1" placeholder="Enter selling price">
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="quantity" class="text-sm font-medium">Quantity<span class="text-red-500">*</span></label>
                    <input type="number" id="quantity" name="quantity" class="border border-gray-300 rounded px-2 py-1"
                        placeholder="Enter quantity">
                </div>
                <div class="flex flex-col gap-2">
                    <input type="hidden" name="remove_image" id="remove-image" value="0">
                    <label for="image-upload" class="text-sm font-medium">Image</label>
                    <div class="relative w-40 h-40">
                        <label for="image-upload" id="image-dropzone"
                            class="w-full h-full border-2 border-dashed border-gray-300 rounded-lg
                   bg-gray-100 hover:bg-gray-200 cursor-pointer
                   flex items-center justify-center overflow-hidden
                   transition">
                            <span id="image-placeholder" class="text-5xl font-light text-gray-400">
                                +
                            </span>

                            <img id="image-preview" src="" alt="Image preview"
                                class="hidden w-full h-full object-cover">
                        </label>

                        <button type="button" id="image-delete"
                            class="hidden absolute top-1 right-1
                   p-2 rounded-full
                   bg-red-500 hover:bg-red-600
                   text-white
                   shadow">
                            <x-lucide-trash-2 class="w-4 h-4" />
                        </button>
                    </div>

                    <input type="file" id="image-upload" name="image" accept="image/*" class="hidden">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="description" class="text-sm font-medium">Description</label>
                    <textarea id="description" name="description" class="border border-gray-300 rounded px-2 py-1 h-32 resize-none"
                        placeholder="Enter item description"></textarea>
                </div>
            </div>
            <div class="flex flex-row justify-end">
                <button type="button" data-modal-close="add-item-modal" data-dispose="clearForm"
                    class="mt-4 inline-flex items-center rounded bg-gray-300 px-4 py-2 font-bold text-gray-700 hover:bg-gray-400 mr-2">
                    Cancel
                </button>
                <button type="submit"
                    class="mt-4 inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700"
                    id="submit-button">
                    Add Item
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
            data-modal-open="add-item-modal">
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
                <button
                    class="inline-flex items-center rounded bg-yellow-500 px-2 py-1 font-bold text-white hover:bg-yellow-600 update-button">
                    <x-lucide-edit class="h-4 w-4" />
                </button>
                <button
                    class="inline-flex items-center rounded bg-red-500 px-2 py-1 font-bold text-white hover:bg-red-600 delete-button">
                    <x-lucide-trash class="h-4 w-4" />
                </button>
            </div>
        </x-slot>
    </x-data-table>
@endsection
