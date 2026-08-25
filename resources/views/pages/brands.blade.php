@extends('layout.app')

@section('title', 'Inventory | Brands')

@section('content')
   <div class="flex flex-col h-full w-full" x-data="brand">
        <h3 class="font-semibold text-2xl">Brands</h3>
        <div class="flex flex-row justify-between mb-4">
            <form action={{ route('brands') }} method="GET">
                <input type="text" name="search" placeholder="Search..."
                    class="border border-gray-300 rounded px-2 py-1" id="search-input"
                    value="{{ request('search', '') }}">

                <button type="submit"
                    class="inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700 ml-2">
                    <x-lucide-search class="h-4 w-4" />
                </button>
            </form>
            <button class="inline-flex items-center rounded bg-blue-600 px-4 py-2 font-bold text-white hover:bg-blue-700"
                @click="openItemModal">
                <x-lucide-plus class="mr-2 h-4 w-4" />
                <span>Add Item</span>
            </button>
        </div>
        <x-data-table :headers="[
            'Name' => [
                'key' => 'name',
                'type' => 'text',
            ],
        
            'Description' => [
                'key' => 'description',
                'type' => 'text',
            ],
            'Actions' => [
                'key' => 'action',
                'type' => 'action',
            ],
        ]" :rows="$brands">
            <x-slot name="action">
                <div class="flex flex-row gap-2">
                    <button @click="handleEditClick"
                        class="inline-flex items-center rounded bg-yellow-500 px-2 py-1 font-bold text-white hover:bg-yellow-600">
                        <x-lucide-edit class="h-4 w-4" />
                    </button>
                    <form method="POST" :action="'/brands/' + id" class="inline">
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
                {{ $brands->firstItem() ?? 0 }}
                –
                {{ $brands->lastItem() ?? 0 }}
                of
                {{ $brands->total() }}
            </span>
            {{-- Pagination --}}
            <div class="flex items-center gap-1">

                {{-- First page --}}
                @if ($brands->onFirstPage())
                    <span class="flex h-8 w-8 items-center justify-center rounded-md text-gray-300">
                        &laquo;
                    </span>
                @else
                    <a href="{{ $brands->url(1) }}"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                        &laquo;
                    </a>
                @endif


                {{-- Previous --}}
                @if ($brands->onFirstPage())
                    <span class="flex h-8 w-8 items-center justify-center rounded-md text-gray-300">
                        &lsaquo;
                    </span>
                @else
                    <a href="{{ $brands->previousPageUrl() }}"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                        &lsaquo;
                    </a>
                @endif


                {{-- Page numbers --}}
                @php
                    $current = $brands->currentPage();
                    $last = $brands->lastPage();

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
                        <a href="{{ $brands->url($page) }}"
                            class="flex h-8 min-w-8 items-center justify-center rounded-md
                       px-2 text-sm text-gray-600 hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endfor


                {{-- Next --}}
                @if ($brands->hasMorePages())
                    <a href="{{ $brands->nextPageUrl() }}"
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
                    <a href="{{ $brands->url($last) }}"
                        class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100">
                        &raquo;
                    </a>
                @endif

            </div>
        </div>
    </div>
@endsection