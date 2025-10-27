@props([
    'src',
    'alt' => '',
])
    <div class="overflow-hidden rounded-[36px]">
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            class="h-full w-full object-cover"
        >
</div>
