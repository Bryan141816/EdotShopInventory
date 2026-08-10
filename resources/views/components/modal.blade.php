<div
    {{ $attributes->merge([
        'class' => 'h-screen w-screen flex justify-center items-center bg-gray-500/60 absolute top-0 left-0',
    ]) }}>
    <div class="flex flex-col p-3 bg-white rounded-2xl">
        {{ $slot }}
    </div>
</div>
