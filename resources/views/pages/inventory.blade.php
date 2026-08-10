@extends('layout.main')

@section('title')
    Inventory
@endsection



@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addItemButton = document.getElementById('add-item-button');
            const closeButton = document.getElementById('close-modal-button');
            const cancelBUtton = document.getElementById('cancel-add-item-button');
            const addItemModal = document.getElementById('add-item-modal');

            addItemButton.addEventListener('click', function() {
                addItemModal.classList.remove('hidden');
            });

            closeButton.addEventListener('click', function() {
                addItemModal.classList.add('hidden');
            });

            cancelBUtton.addEventListener('click', function() {
                addItemModal.classList.add('hidden');
            });
        });
    </script>

    <x-modal class="hidden" id="add-item-modal">
        <div class="flex flex-row justify-between items-center mb-4 gap-3">
            <h3 class="font-semibold text-base">Add Item</h3>
            <button id="close-modal-button">
                <x-lucide-x class="h-4 w-4" />
            </button>
        </div>
        <form>
            <div class="flex flex-col gap-3  w-2xs">
                <div class="flex flex-col gap-1">
                    <label for="name" class="text-sm font-medium">Name</label>
                    <input type="text" id="name" name="name" class="border border-gray-300 rounded px-2 py-1">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="sku" class="text-sm font-medium">SKU</label>
                    <input type="text" id="sku" name="sku" class="border border-gray-300 rounded px-2 py-1">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="description" class="text-sm font-medium">Description</label>
                    <textarea id="description" name="description" class="border border-gray-300 rounded px-2 py-1"></textarea>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="cost_price" class="text-sm font-medium">Cost Price</label>
                    <input type="number" step="0.01" id="cost_price" name="cost_price"
                        class="border border-gray-300 rounded px-2 py-1">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="selling_price" class="text-sm font-medium">Selling Price</label>
                    <input type="number" step="0.01" id="selling_price" name="selling_price"
                        class="border border-gray-300 rounded px-2 py-1">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="quantity" class="text-sm font-medium">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="border border-gray-300 rounded px-2 py-1">
                </div>
            </div>
            <div class="flex flex-row justify-end">
                <button type="button" id="cancel-add-item-button"
                    class="mt-4 inline-flex items-center rounded bg-gray-300 px-4 py-2 font-bold text-gray-700 hover:bg-gray-400 mr-2">
                    Cancel
                </button>
                <button type="submit"
                    class="mt-4 inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700">
                    Add Item
                </button>
            </div>
        </form>
    </x-modal>
    <h3 class="font-semibold text-2xl">Inventory</h3>
    <div class="flex flex-row justify-end mb-4">
        <button class="inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700"
            id="add-item-button">
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
    ]" :rows="$inventory" />
@endsection
