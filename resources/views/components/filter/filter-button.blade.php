@props([
    'label' => 'Filter',
])

<button {{ $attributes->merge([
    'type' => 'button',
    'class' => 'group inline-flex h-[64px] w-[201px] items-center justify-between gap-6 px-6 bg-white border border-gray-300 rounded-[12px] shadow-sm text-base font-medium text-gray-900 hover:border-gray-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#B6487B]',
]) }}>
    <span>{{ $slot->isEmpty() ? $label : $slot }}</span>
    <img
        src="{{ asset('images/down.svg') }}"
        alt=""
        class="h-3.5 w-3.5 transition-transform duration-150 group-hover:translate-y-0.5"
        aria-hidden="true"
    >
</button>
