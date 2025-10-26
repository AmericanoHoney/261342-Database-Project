@props([
    'formId',
    'title' => 'Remove favorite?',
    'message' => 'Are you sure you want to delete this item?',
    'confirmText' => 'Yes',
    'cancelText' => 'No',
])

<div x-data="{ open: false }" class="relative">
    <div x-ref="trigger" x-on:click="open = true">
        {{ $trigger }}
    </div>

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[100] flex items-center justify-center px-4"
            x-on:keydown.escape.window="open = false"
        >
            <div
                class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                x-on:click="open = false"
            ></div>

            <div
                x-show="open"
                x-transition.scale
                class="relative w-full max-w-xs bg-white text-gray-900 rounded-[32px] px-8 py-10 text-center space-y-6 shadow-[0_25px_60px_-20px_rgba(15,23,42,0.45)]"
            >
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#FCE5E7]">
                    <img
                        src="{{ asset('images/rubbish_bin.svg') }}"
                        alt=""
                        class="h-9 w-9"
                        aria-hidden="true"
                    >
                </div>

                <div class="space-y-2">
                    <p class="text-lg font-semibold text-gray-900">{{ $title }}</p>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $message }}</p>
                </div>

                <div class="flex items-center justify-center gap-4 pt-2">
                    <button
                        type="button"
                        class="min-w-[90px] rounded-full border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition"
                        x-on:click="open = false"
                    >
                        {{ $cancelText }}
                    </button>
                    <button
                        type="button"
                        class="min-w-[90px] rounded-full bg-[#B6487B] px-4 py-2 text-sm font-semibold text-white hover:bg-[#1d3b56] transition"
                        x-on:click="
                            window.requestAnimationFrame(() => {
                                document.getElementById('{{ $formId }}')?.submit();
                                open = false;
                            });
                        "
                    >
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
