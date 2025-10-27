@props([
    'src',
    'alt' => '',
])
    <div class="overflow-hidden rounded-[36px] h-[560px] w-[400px]">
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            class="h-full w-full object-cover"
        >
</div>
