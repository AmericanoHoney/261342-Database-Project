@props([
    'src',
    'alt' => '',
])

<div {{ $attributes->class('rounded-[42px] bg-white p-3 shadow-[0_30px_60px_rgba(0,0,0,0.08)]') }}>
    <div class="overflow-hidden rounded-[36px]">
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            class="h-full w-full object-cover"
        >
    </div>
</div>
