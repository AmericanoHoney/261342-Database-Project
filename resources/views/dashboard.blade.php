<x-app-layout>
    {{-- Hero Section --}}
    <section class="relative">
        <div
            class="w-full bg-repeat bg-center"
            style="background-image: url('{{ asset('images/floral-hero.png') }}');"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="py-14 md:py-20 text-center">
                    <h1 class="text-8xl font-script text-gray-900 dark:text-gray-100 tracking-wide">
                        Flotalera   
                    </h1>
                    <p class="text-xl text-gray-700 dark:text-gray-200 font-light">
                        เรื่องของใจ ให้ดอกไม้เล่าแทน
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Swiper CSS/JS --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css" />
    <script defer src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>

    <section class="pt-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="swiper" id="promo-swiper">
                <div class="swiper-wrapper">

                    @foreach ($promotions as $p)
                        <div class="swiper-slide">
                            <figure class="rounded-md overflow-hidden shadow-sm">
                                <img
                                    src="{{ $p->photo_url }}"
                                    alt="{{ $p->name }}"
                                    class="w-full h-[150px] md:h-[250px] object-cover"
                                >
                            </figure>
                        </div>
                    @endforeach

                </div>

                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>
    </section>

    <section class="pt-10">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Top Seller</h2>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $prd)
                    <x-cards.product-card
                        :image="$prd->image_url"
                        :category="$prd->category->name ?? 'Unknown'"
                        :name="$prd->name"
                        :price="$prd->price"
                        :product-id="$prd->product_id"
                        :is-favorited="(bool) ($prd->is_favorited ?? false)"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
      new Swiper('#promo-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
        pagination: { el: '.swiper-pagination', clickable: true },
        loop: true,
        autoplay: { delay: 3500, disableOnInteraction: false },
      });
    });
    </script>

    <style>
        /* ทำให้ pagination เป็นสีชมพู */
        #promo-swiper .swiper-pagination-bullet {
            background-color: rgb(182 72 123); /* tailwind pink-600 */
            opacity: 0.5;
        }
        #promo-swiper .swiper-pagination-bullet-active {
            opacity: 1;
        }

        /* ขยับ pagination ลงล่าง */
        #promo-swiper .swiper-pagination {
            position: relative;
            margin-top: 1rem; /* เพิ่มช่องว่างจากรูป */
        }
    </style>
</x-app-layout>
