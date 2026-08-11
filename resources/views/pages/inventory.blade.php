@extends('layout.main')

@section('title')
    Inventory
@endsection



@section('content')
    <script>
        function clearForm() {
            document.getElementById('image-upload').value = '';
            document.getElementById('image-preview').src = '';
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('image-placeholder').classList.remove('hidden');
            document.getElementById('image-delete').classList.add('hidden');
            document.getElementById('name').value = '';
            document.getElementById('sku').value = '';
            document.getElementById('cost_price').value = '';
            document.getElementById('selling_price').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('description').value = '';
        }
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('image-upload');
            const dropzone = document.getElementById('image-dropzone');
            const placeholder = document.getElementById('image-placeholder');
            const preview = document.getElementById('image-preview');
            const deleteButton = document.getElementById('image-delete');

            const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

            function validateImage(file) {
                if (!file) {
                    return false;
                }

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    return false;
                }

                if (file.size > MAX_FILE_SIZE) {
                    alert('Image must be 2 MB or smaller.');
                    return false;
                }

                return true;
            }

            function showImage(file) {
                if (!validateImage(file)) {
                    clearImage();
                    return;
                }

                const imageUrl = URL.createObjectURL(file);

                preview.src = imageUrl;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');

                deleteButton.classList.remove('hidden');
                deleteButton.classList.add('flex');
                document.getElementById('remove-image').value = '0';
            }

            function clearImage() {
                input.value = '';

                preview.src = '';
                preview.classList.add('hidden');

                placeholder.classList.remove('hidden');

                deleteButton.classList.add('hidden');
                deleteButton.classList.remove('flex');
                document.getElementById('remove-image').value = '1';
            }

            input.addEventListener('change', function() {
                const file = this.files[0];

                if (!validateImage(file)) {
                    clearImage();
                    return;
                }

                showImage(file);
            });

            dropzone.addEventListener('dragover', function(event) {
                event.preventDefault();
                dropzone.classList.add('bg-gray-200');
            });

            dropzone.addEventListener('dragleave', function() {
                dropzone.classList.remove('bg-gray-200');
            });

            dropzone.addEventListener('drop', function(event) {
                event.preventDefault();
                dropzone.classList.remove('bg-gray-200');

                const file = event.dataTransfer.files[0];

                if (!validateImage(file)) {
                    clearImage();
                    return;
                }

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;

                showImage(file);
            });

            deleteButton.addEventListener('click', function() {
                clearImage();
            });
            async function handleDeleteRow(itemId, row) {
                const response = await fetch(`/inventory/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),

                        'Accept': 'application/json',
                    },
                });

                if (response.ok) {
                    row.remove();
                    console.log('Item deleted');
                } else {
                    console.error('Failed to delete item');
                }
            }
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const itemId = row.getAttribute('name');
                    handleDeleteRow(itemId, row);
                });
            });
            const updateButtons = document.querySelectorAll('.update-button');
            updateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    console.log('Update button clicked');
                    const row = this.closest('tr');
                    const itemId = row.getAttribute('name');
                    const itemData = {
                        name: row.querySelector('[data-key="name"]').getAttribute('data-value'),
                        sku: row.querySelector('[data-key="sku"]').getAttribute('data-value'),
                        cost_price: row.querySelector('[data-key="cost_price"]').getAttribute('data-value'),
                        selling_price: row.querySelector('[data-key="selling_price"]').getAttribute('data-value'),
                        quantity: row.querySelector('[data-key="quantity"]').getAttribute('data-value'),
                        description: row.querySelector('[data-key="description"]').getAttribute('data-value'),
                        image: row.querySelector('[data-key="image"]').getAttribute('data-value'),
                    };
  
                    document.getElementById('name').value = itemData.name;
                    document.getElementById('sku').value = itemData.sku;
                    document.getElementById('cost_price').value = itemData.cost_price; 
                    document.getElementById('selling_price').value = itemData.selling_price;
                    document.getElementById('quantity').value = itemData.quantity;
                    document.getElementById('description').value = itemData.description;
                    if (itemData.image) {
                        document.getElementById('image-preview').src = itemData.image;
                        document.getElementById('image-preview').classList.remove('hidden');
                        document.getElementById('image-placeholder').classList.add('hidden');
                        document.getElementById('image-delete').classList.remove('hidden');
                    } else {
                        document.getElementById('image-preview').src = '';
                        document.getElementById('image-preview').classList.add('hidden');
                        document.getElementById('image-placeholder').classList.remove('hidden');
                        document.getElementById('image-delete').classList.add('hidden');    
                    }
                    
                    const form = document.getElementById('item-form');
                    updateModalTitle('add-item-modal', 'Update Item');
                    form.action = `/inventory/${itemId}/edit`;
                    document.getElementById('submit-button').textContent = 'Update Item';
                    openModal('add-item-modal');
                });
            });
        });
    </script>

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
    <div class="flex flex-row justify-end mb-4">
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
