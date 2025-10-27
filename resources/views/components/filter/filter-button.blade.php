@props([
    'label' => 'Filter',
    'options' => [
        'Flower Bouquets',
        'Flower Baskets',
        'Dried Flowers',
        'Single Blossom',
    ],
])

@php
    $dropdownOptions = array_values(array_filter($options, fn ($value) => !blank($value)));
    $displayLabel = $slot->isEmpty()
        ? $label
        : trim(strip_tags($slot));
@endphp

<div
    x-data="{
        open: false,
        selected: null,
        label: @js($displayLabel),
        options: @js($dropdownOptions),
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        },
        select(option) {
            this.selected = option;
            this.close();
            this.$dispatch('filter-selected', { option });
        },
        displayLabel() {
            return this.selected ?? this.label;
        }
    }"
    @click.outside="close()"
    @keydown.escape.window="close()"
    class="relative inline-block"
>
    <button
        type="button"
        {{ $attributes->merge([
            'class' => 'group inline-flex h-[42px] min-w-[170px] items-center justify-between gap-2.5 px-4 bg-white border border-[#B6487B] rounded-[12px] shadow-sm text-sm font-medium text-gray-900 hover:border-[#8D2A5E] focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#B6487B]',
        ]) }}
        @click="toggle()"
        :aria-expanded="open"
        aria-haspopup="listbox"
    >
        <span class="whitespace-nowrap tracking-widest" x-text="displayLabel()">
            {{ $slot->isEmpty() ? $label : $slot }}
        </span>
        <img
            src="{{ asset('images/down.svg') }}"
            alt=""
            class="h-5 w-5 transition-transform duration-150 group-hover:translate-y-0.5"
            :class="{ 'rotate-180': open }"
            aria-hidden="true"
        >
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute left-0 z-10 mt-2 w-full min-w-[170px] rounded-[12px] border border-gray-200 bg-white py-1 shadow-lg"
        role="listbox"
    >
        <template x-if="options.length === 0">
            <p class="px-4 py-2 text-sm text-gray-500">No filters available</p>
        </template>

        <template x-for="option in options" :key="option">
            <button
                type="button"
                class="flex w-full items-center justify-between px-4 py-2 text-left text-sm tracking-widest text-gray-700 hover:bg-[#F1C1D8] focus:outline-none"
                :class="{ 'bg-[#B6487B]/10 text-[#B6487B]': selected === option }"
                @click.stop="select(option)"
            >
                <span x-text="option"></span>
                <svg
                    x-show="selected === option"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    class="h-4 w-4"
                >
                    <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 0 1.42l-7.01 7.01a1 1 0 0 1-1.42 0l-3.5-3.5a1 1 0 0 1 1.414-1.42L8.99 11.3l6.296-6.296a1 1 0 0 1 1.418 0Z" clip-rule="evenodd" />
                </svg>
            </button>
        </template>
    </div>
</div>
