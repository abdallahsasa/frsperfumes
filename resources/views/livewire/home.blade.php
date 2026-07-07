<div class="space-y-24 pb-24 bg-matte-black text-gray-200">
    <!-- New Luxury Static Hero Section -->
    <div class="relative w-full h-[90vh] md:h-screen min-h-[600px] flex items-center bg-[#09090a] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('uploads/banners/luxury_hero_bg.png') }}" alt="Luxury Perfume"
                class="w-full h-full object-cover object-center lg:object-right">
            <!-- Dark Gradient Overlay for Typography Readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/50 to-transparent"></div>
            <!-- Subtle Vignette -->
            <div class="absolute inset-0 bg-black/20" style="box-shadow: inset 0 0 150px rgba(0,0,0,0.8);"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 flex items-center">
            <div class="max-w-2xl text-left rtl:text-right space-y-6 animate-fade-in-up"
                style="animation-duration: 1.5s; animation-fill-mode: both;">
                <span
                    class="inline-block text-gold-400 tracking-[0.3em] text-[10px] sm:text-xs font-bold uppercase border-l-2 rtl:border-l-0 rtl:border-r-2 border-gold-400 pl-3 rtl:pl-0 rtl:pr-3 mb-2 opacity-0 animate-fade-in-up"
                    style="animation-delay: 0.3s; animation-fill-mode: forwards;">
                    {{ app()->getLocale() === 'ar' ? 'العطور الفاخرة المميزة' : 'EXQUISITE NICHE COLLECTION' }}
                </span>

                <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-bold text-white tracking-wide leading-tight drop-shadow-2xl opacity-0 animate-fade-in-up"
                    style="animation-delay: 0.6s; animation-fill-mode: forwards;">
                    {{ app()->getLocale() === 'ar' ? 'اكتشف عبيرك الفريد' : 'Discover Your Olfactory Masterpiece' }}
                </h1>

                <p class="text-gray-300 text-sm sm:text-lg font-light tracking-wide leading-relaxed drop-shadow-md opacity-0 animate-fade-in-up"
                    style="animation-delay: 0.9s; animation-fill-mode: forwards;">
                    {{ app()->getLocale() === 'ar' ? 'مجموعة منتقاة بدقة من أفخم النوتات العطرية والماركات العالمية' : 'A carefully curated selection of the world\'s most sophisticated scent profiles and master perfumers.' }}
                </p>

                <div class="pt-8 opacity-0 animate-fade-in-up"
                    style="animation-delay: 1.2s; animation-fill-mode: forwards;">
                    <a href="{{ route('shop') }}"
                        class="group relative inline-flex items-center justify-center bg-transparent border border-gold-400 text-white font-semibold text-[10px] sm:text-xs tracking-[0.2em] uppercase px-10 py-4 transition-all duration-500 overflow-hidden rounded-sm hover:text-black">
                        <!-- Gold Fill Hover Effect -->
                        <div
                            class="absolute inset-0 bg-gold-400 transform scale-x-0 origin-left rtl:origin-right group-hover:scale-x-100 transition-transform duration-500 ease-out z-0">
                        </div>
                        <span
                            class="relative z-10">{{ app()->getLocale() === 'ar' ? 'تسوق المجموعة' : 'Explore the Shop' }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 z-10 opacity-0 animate-fade-in-up"
            style="animation-delay: 1.8s; animation-fill-mode: forwards;">
            <span
                class="text-gold-400/70 text-[9px] uppercase tracking-[0.25em]">{{ app()->getLocale() === 'ar' ? 'اكتشف المزيد' : 'Scroll to Discover' }}</span>
            <div class="w-[1px] h-8 bg-gradient-to-b from-gold-400/70 to-transparent"></div>
        </div>
    </div>

    <!-- Golden Guarantee Badge Callout Section -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div
            class="relative overflow-hidden border border-gold-400/20 bg-gradient-to-br from-[#161618] to-[#0f0f10] p-8 md:p-14 shadow-2xl rounded-sm">
            <div class="absolute top-0 right-0 h-56 w-56 bg-gold-400/5 blur-3xl rounded-full"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
                <div class="space-y-5 max-w-3xl text-center lg:text-left rtl:lg:text-right">
                    <div
                        class="flex items-center justify-center lg:justify-start gap-2 text-gold-400 font-bold text-xs uppercase tracking-[0.2em]">
                        <span>🛡️</span>
                        <span>{{ __('messages.guarantee') }}</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-white tracking-wide leading-tight">
                        {{ __('messages.guarantee_title') }}
                    </h2>
                    <p class="text-gray-400 text-sm font-light leading-relaxed">
                        {{ __('messages.guarantee_desc') }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <div
                        class="flex flex-col items-center justify-center border border-gold-400/35 rounded-full h-32 w-32 bg-[#121212] border-dashed animate-spin-slow">
                        <span
                            class="text-gold-400 text-center font-display text-xs font-bold uppercase tracking-widest leading-none">
                            100%<br>
                            {{ app()->getLocale() === 'ar' ? 'مضمون' : 'Guaranteed' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Curated Best Sellers (Featured Perfumes Redesigned) -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="flex flex-col sm:flex-row items-center justify-between border-b border-charcoal/60 pb-6">
            <div class="text-center sm:text-left rtl:sm:text-right space-y-1">
                <span class="text-xs uppercase tracking-[0.25em] text-gold-400 font-semibold block">
                    {{ app()->getLocale() === 'ar' ? 'العطور الأكثر طلباً' : 'EXCLUSIVE BEST SELLERS' }}
                </span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-white tracking-wide">
                    {{ app()->getLocale() === 'ar' ? 'مجموعتنا المميزة' : 'Curated Masterpieces' }}
                </h2>
            </div>
            <a href="{{ route('shop') }}"
                class="mt-4 sm:mt-0 text-xs font-semibold tracking-widest text-gold-400 uppercase hover:underline flex items-center gap-1">
                <span>{{ app()->getLocale() === 'ar' ? 'عرض كل العطور' : 'View Full Catalog' }}</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-y-12 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($featuredPerfumes as $perfume)
                <div
                    class="group relative flex flex-col justify-between bg-[#161618] hover:shadow-2xl transition-all duration-300 p-5 rounded-sm">
                    <!-- Image Area -->
                    <div
                        class="relative w-full aspect-square bg-transparent overflow-hidden mb-6 flex items-center justify-center p-4">
                        @if($perfume->images->count() > 0)
                            <img src="{{ asset('uploads/' . $perfume->images->first()->image_path) }}"
                                alt="{{ $perfume->name }}"
                                class="h-full w-full object-contain object-center scale-95 group-hover:scale-100 transition-transform duration-500">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-matte-black text-gray-700">
                                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>
                        @endif

                        @if($perfume->stock_status === 'out_of_stock')
                            <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] z-10 flex items-center justify-center">
                                <span
                                    class="bg-charcoal/80 border border-charcoal text-gray-300 text-[10px] font-bold tracking-widest uppercase px-4 py-1.5 rounded-sm shadow-xl transform -rotate-12">
                                    {{ app()->getLocale() === 'ar' ? 'نفذت الكمية' : 'Out of Stock' }}
                                </span>
                            </div>
                        @elseif($perfume->pre_order || $perfume->stock_status === 'pre_order')
                            <div class="absolute top-3 left-3 rtl:left-auto rtl:right-3 z-10 flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-gold-500"></span>
                                </span>
                                <span
                                    class="text-[8px] font-bold tracking-[0.2em] uppercase bg-matte-black/90 backdrop-blur-sm border border-gold-400 text-gold-400 px-2.5 py-1 rounded-sm shadow-lg">
                                    {{ __('messages.pre_order') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Meta Area -->
                    <div class="space-y-3 flex-grow flex flex-col justify-between">
                        <div>
                            <p class="text-[9px] tracking-widest uppercase text-gold-400 font-semibold block">
                                {{ $perfume->brand->name }}
                            </p>
                            <h3
                                class="font-display font-bold text-white text-lg tracking-wide group-hover:text-gold-400 transition-colors">
                                <a href="{{ route('perfume.show', $perfume->slug) }}">
                                    {{ $perfume->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-400 font-light mt-1.5 line-clamp-2 leading-relaxed">
                                {{ $perfume->short_description }}
                            </p>
                        </div>

                        <!-- Price and Button Area -->
                        <div class="pt-5 border-t border-charcoal/50 mt-auto">
                            <div class="flex items-baseline justify-between mb-5">
                                <div class="flex items-baseline space-x-2.5 rtl:space-x-reverse">
                                    <span
                                        class="text-lg font-bold text-gold-400">${{ number_format($perfume->price, 2) }}</span>
                                    @if($perfume->old_price)
                                        <span
                                            class="text-xs text-gray-500 line-through">${{ number_format($perfume->old_price, 2) }}</span>
                                    @endif
                                </div>
                                <span
                                    class="text-[8px] font-bold tracking-widest bg-charcoal text-gray-300 px-2.5 py-1 rounded-sm uppercase">
                                    {{ $perfume->concentration }}
                                </span>
                            </div>

                            <a href="{{ route('perfume.show', $perfume->slug) }}"
                                class="block w-full border border-gold-400/20 hover:border-gold-400 text-center font-semibold text-[9px] tracking-widest uppercase text-white hover:text-black hover:bg-gold-gradient py-3.5 transition-all duration-300 rounded-sm shadow-md">
                                {{ app()->getLocale() === 'ar' ? 'تفاصيل العطر الفاخر' : 'View Scent Profile' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Brands Scroll -->
    @if($brands->count() > 0)
        <div class="bg-[#0b0b0c] py-16 border-y border-charcoal/60">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h3 class="text-xs uppercase tracking-[0.25em] text-gold-400 font-bold mb-2">
                        {{ app()->getLocale() === 'ar' ? 'دور العطور العالمية' : 'EXQUISITE FRAGRANCE HOUSES' }}
                    </h3>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24">
                    @foreach($brands as $brand)
                        <div class="text-center group">
                            <a href="{{ route('shop', ['brand' => $brand->slug]) }}" class="block">
                                <span
                                    class="font-display text-xl sm:text-3xl font-bold text-gray-500 group-hover:text-gold-400 transition-colors uppercase tracking-widest">
                                    {{ $brand->name }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Fragrance Secrets & Tips Slideshow (Interactive Carousel) -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-12">
            <span class="text-gold-400 tracking-[0.25em] text-[10px] sm:text-xs font-bold uppercase block">
                {{ app()->getLocale() === 'ar' ? 'دليل و أسرار العطور' : 'FRAGRANCE TIPS & SECRETS' }}
            </span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-white tracking-wide">
                {{ app()->getLocale() === 'ar' ? 'كيف تجعل عطرك يدوم أطول؟' : 'Olfactory Mastery Tips' }}
            </h2>
            <div class="h-[1px] w-20 bg-gold-400 mx-auto"></div>
        </div>

        <!-- Carousel (Alpine.js) -->
        <div x-data="{ activeTip: 0, tipsCount: 3 }"
            class="relative overflow-hidden bg-[#161618] border border-charcoal p-6 sm:p-10 rounded-sm shadow-2xl">
            <!-- Slides Container -->
            <div class="relative min-h-[350px] flex items-center">
                <!-- Slide 1 -->
                <div x-show="activeTip === 0" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-x-8 rtl:-translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="w-full flex flex-col md:flex-row gap-8 items-center" style="display: none;">
                    <div
                        class="w-full md:w-1/2 aspect-[4/3] bg-[#0c0c0d] overflow-hidden rounded-sm border border-charcoal">
                        <img src="{{ asset('uploads/tips/tip1.jpg') }}" alt="Pulse Points"
                            class="h-full w-full object-cover">
                    </div>
                    <div class="w-full md:w-1/2 space-y-4 text-center md:text-left rtl:md:text-right">
                        <span class="text-gold-400 text-[10px] font-bold tracking-widest uppercase">Tip #01</span>
                        <h3 class="font-display text-2xl font-bold text-white tracking-wide">
                            {{ app()->getLocale() === 'ar' ? 'الرش على نقاط النبض' : 'Apply on Pulse Points' }}
                        </h3>
                        <p class="text-gray-400 text-sm font-light leading-relaxed">
                            {{ app()->getLocale() === 'ar'
    ? 'رش العطر على معصميك، ورقبتك، وخلف أذنيك. تنبعث الحرارة الطبيعية من هذه النقاط طوال اليوم، مما يساعد على نشر وتثبيت جزيئات العطر بشكل مستمر وتدريجي.'
    : 'Spray your fragrance on your wrists, neck, and behind your ears. The natural warmth of these blood-vessel pulse points diffuses the perfume continuously throughout the day.' }}
                        </p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div x-show="activeTip === 1" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-x-8 rtl:-translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="w-full flex flex-col md:flex-row gap-8 items-center" style="display: none;">
                    <div
                        class="w-full md:w-1/2 aspect-[4/3] bg-[#0c0c0d] overflow-hidden rounded-sm border border-charcoal">
                        <img src="{{ asset('uploads/tips/tip2.jpg') }}" alt="Don't Rub Wrists"
                            class="h-full w-full object-cover">
                    </div>
                    <div class="w-full md:w-1/2 space-y-4 text-center md:text-left rtl:md:text-right">
                        <span class="text-gold-400 text-[10px] font-bold tracking-widest uppercase">Tip #02</span>
                        <h3 class="font-display text-2xl font-bold text-white tracking-wide">
                            {{ app()->getLocale() === 'ar' ? 'لا تفرك معصميك أبداً' : 'Never Rub Your Wrists' }}
                        </h3>
                        <p class="text-gray-400 text-sm font-light leading-relaxed">
                            {{ app()->getLocale() === 'ar'
    ? 'بعد رش العطر على المعصمين، تجنب فركهما معاً. الفرك يولد حرارة مفرطة تؤدي إلى تكسير جزيئات العطر الحساسة وتبخير نوتات القمة الافتتاحية بشكل سريع، مما يغير هويته.'
    : 'Avoid rubbing your wrists together after spraying. Doing so generates friction-heat which breaks down the delicate top-note molecules, altering the composition and shortening longevity.' }}
                        </p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div x-show="activeTip === 2" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-x-8 rtl:-translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="w-full flex flex-col md:flex-row gap-8 items-center" style="display: none;">
                    <div
                        class="w-full md:w-1/2 aspect-[4/3] bg-[#0c0c0d] overflow-hidden rounded-sm border border-charcoal">
                        <img src="{{ asset('uploads/tips/tip3.jpg') }}" alt="Store properly"
                            class="h-full w-full object-cover">
                    </div>
                    <div class="w-full md:w-1/2 space-y-4 text-center md:text-left rtl:md:text-right">
                        <span class="text-gold-400 text-[10px] font-bold tracking-widest uppercase">Tip #03</span>
                        <h3 class="font-display text-2xl font-bold text-white tracking-wide">
                            {{ app()->getLocale() === 'ar' ? 'التخزين الصحيح في مكان مظلم وبارد' : 'Store in Cool, Dark Place' }}
                        </h3>
                        <p class="text-gray-400 text-sm font-light leading-relaxed">
                            {{ app()->getLocale() === 'ar'
    ? 'تحب العطور الأماكن المستقرة. احفظ زجاجاتك بعيداً عن أشعة الشمس المباشرة، وحرارة ورطوبة الحمامات. الاحتفاظ بها في خزانة مظلمة وباردة يحمي جودة وسلامة الزيوت العطرية الثمينة.'
    : 'Store your perfume collection away from direct sunlight, fluctuations in temperature, and bathroom humidity. A cool, dark wardrobe or dresser is key to preserving the chemical structure of natural oils.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex items-center justify-between mt-8 border-t border-charcoal/50 pt-6">
                <!-- Navigation Dots -->
                <div class="flex space-x-2.5 rtl:space-x-reverse">
                    <template x-for="i in Array.from({length: tipsCount})">
                        <button @click="activeTip = Array.from(Array.from({length: tipsCount})).indexOf(i)"
                            :class="activeTip === Array.from(Array.from({length: tipsCount})).indexOf(i) ? 'bg-gold-400 w-6' : 'bg-gray-600 w-2'"
                            class="h-2 rounded-full transition-all duration-300 outline-none"></button>
                    </template>
                </div>

                <!-- Navigation Arrows -->
                <div class="flex space-x-2 rtl:space-x-reverse text-gold-400">
                    <button @click="activeTip = (activeTip === 0) ? tipsCount - 1 : activeTip - 1"
                        class="border border-gold-400/35 hover:border-gold-400 p-2 hover:bg-gold-400/5 transition-all rounded-sm">
                        <svg class="h-4 w-4 transform rotate-180 rtl:rotate-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button @click="activeTip = (activeTip + 1) % tipsCount"
                        class="border border-gold-400/35 hover:border-gold-400 p-2 hover:bg-gold-400/5 transition-all rounded-sm">
                        <svg class="h-4 w-4 transform rtl:rotate-180" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>