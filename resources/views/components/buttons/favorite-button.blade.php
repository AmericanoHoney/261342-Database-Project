@props([
    'productId' => null,
    'isFavorited' => false, // boolean
    // เปลี่ยนพาธได้ตามต้องการ
    'iconOff' => asset('images/icon/like.png'),
    'iconOn'  => asset('images/icon/liked.png'),
])

@php $liked = (bool) $isFavorited; @endphp

<div
    x-data="favoriteButton({
        productId: {{ (int) $productId }},
        initiallyLiked: {{ $liked ? 'true' : 'false' }},
        toggleUrl: '{{ route('favourites.toggle', ['product' => $productId]) }}',
        csrf: '{{ csrf_token() }}',
        redirectToLogin: '{{ route('login') }}',
    })"
    class="w-10 h-10 flex items-center justify-center"
>
    <button
        x-on:click.prevent="toggle()"
        aria-label="Toggle favorite"
        class="w-10 h-10 grid place-items-center"
        :title="liked ? 'Remove from favorites' : 'Add to favorites'"
    >
        <img
            :src="liked ? '{{ $iconOn }}' : '{{ $iconOff }}'"
            alt="Favorite"
            class="w-8 h-8 transition-transform duration-200"
            :class="liked ? 'animate-heart-pop' : 'hover:scale-110'"
            x-effect="$el.classList.remove('animate-heart-pop'); if(liked){void $el.offsetWidth; $el.classList.add('animate-heart-pop');}"
            loading="lazy"
            width="32"
            height="32"
        />
    </button>
</div>

@once
    @push('scripts')
        <script>
            function favoriteButton({ productId, initiallyLiked, toggleUrl, csrf, redirectToLogin }) {
                return {
                    liked: initiallyLiked,
                    async toggle() {
                        try {
                            const res = await fetch(toggleUrl, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrf,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                },
                            });
                            if (res.status === 401) { window.location.href = redirectToLogin; return; }
                            if (!res.ok) throw new Error('Network error');
                            const json = await res.json();
                            this.liked = !!json.liked;
                        } catch (e) { console.error(e); }
                    }
                }
            }
        </script>
    @endpush
@endonce
