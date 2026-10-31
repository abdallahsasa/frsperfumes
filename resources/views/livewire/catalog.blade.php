<div x-data="{ mobileFiltersOpen: false }" class="relative min-h-screen pb-24 text-gray-200">
    <!-- Toast Notification for Quick Add to Cart -->
    @if($successMessage)
        <div x-data="{ show: true }"
             x-init="setTimeout(() => { show = false; $wire.set('successMessage', ''); }, 3500)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed bottom-6 right-6 rtl:right-auto rtl:left-6 z-50 bg-[#161618]/95 backdrop-blur-md border border-gold-400 text-white px-5 py-4 shadow-[0_15px_40px_rgba(0,0,0,0.8)] rounded-sm flex items-center gap-4">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gold-400/15 border border-gold-400/40 text-gold-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold tracking-wider uppercase text-gold-400">
                    {{ app()->getLocale() === 'ar' ? 'تمت الإضافة بنجاح' : 'Added to Bag' }}
                </p>
                <p class="text-[11px] text-gray-300 mt-0.5">{{ $successMessage }}</p>
            </div>
            <a href="{{ route('cart') }}" class="text-[10px] font-bold uppercase tracking-widest text-black bg-gold-gradient px-3 py-1.5 rounded-sm hover:opacity-90 transition-opacity">
                {{ __('messages.cart') }}
            </a>
            <button wire:click="$set('successMessage', '')" class="text-gray-400 hover:text-white transition-colors text-lg leading-none">&times;</button>
        </div>
    @endif

    <!-- Luxury Hero Header Section -->
    <div class="relative overflow-hidden border-b border-white/[0.07] bg-gradient-to-b from-[#14120d]/90 via-[#0e0e10] to-transparent pt-12 pb-10 sm:pt-16 sm:pb-14 mb-8 sm:mb-12">
        <!-- Ambient Radial Glow -->
        <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 h-72 w-[36rem] max-w-full rounded-full bg-gold-400/[0.07] blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center space-y-5">
            <!-- Overline Badge -->
            <div class="inline-flex items-center gap-3">
                <span class="h-[1px] w-8 bg-gradient-to-r from-transparent to-gold-400/70"></span>
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.3em] text-gold-400">
                    {{ app()->getLocale() === 'ar' ? 'تشكيلة العطور النخبوية' : 'HAUTE PARFUMERIE ARCHIVE' }}
                </span>
                <span class="h-[1px] w-8 bg-gradient-to-l from-transparent to-gold-400/70"></span>
            </div>

            <!-- Main Display Title -->
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-bold text-white tracking-wide">
                {{ app()->getLocale() === 'ar' ? 'المجموعة العطرية' : 'The Fragrance Catalog' }}
            </h1>

            <!-- Editorial Subtitle -->
            <p class="text-gray-400 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
                {{ app()->getLocale() === 'ar'
                    ? 'اختر عطرك المفضل من تشكيلتنا النخبوية من العطور العالمية — كل زجاجة مرفقة بعينة تجربة مجانية 1 مل ضمن الضمان الذهبي.'
                    : 'Select your signature scent from our elite curation of niche and designer masterpieces — each bottle includes a complimentary 1ml tester under our Golden Guarantee.' }}
            </p>

            <!-- Quick Gender Filter Tabs in Hero -->
            <div class="pt-3 flex flex-wrap items-center justify-center gap-2 sm:gap-3">
                @php
                    $genderTabs = [
                        '' => app()->getLocale() === 'ar' ? 'كل العطور' : 'All Scents',
                        'unisex' => __('messages.unisex'),
                        'male' => __('messages.male'),
                        'female' => __('messages.female'),
                    ];
                @endphp
                @foreach($genderTabs as $genderKey => $genderLabel)
                    <button wire:click="$set('selectedGender', '{{ $genderKey }}')"
                            class="px-4 sm:px-5 py-2 text-[10px] sm:text-xs font-semibold uppercase tracking-[0.18em] rounded-sm border transition-all duration-300 {{ $selectedGender === $genderKey ? 'bg-gold-gradient text-black border-transparent shadow-[0_0_20px_rgba(212,175,55,0.25)] font-bold' : 'bg-[#151518]/80 border-white/10 text-gray-300 hover:border-gold-400/50 hover:text-gold-400' }}">
                        {{ $genderLabel }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Mobile Search, Filter Drawer Trigger & Sort Bar (< lg) -->
        <div class="lg:hidden space-y-3 mb-6">
            <!-- Mobile Quick Search Input -->
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 flex items-center pl-3.5 rtl:pl-0 rtl:pr-3.5 text-gray-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </span>
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="{{ __('messages.search_placeholder') }}"
                       class="w-full bg-[#151518] border border-white/10 focus:border-gold-400/60 text-white text-xs pl-10 pr-9 rtl:pl-9 rtl:pr-10 py-3 rounded-sm outline-none transition-colors placeholder:text-gray-500">
                @if(!empty($search))
                    <button wire:click="$set('search', '')"
                            class="absolute inset-y-0 right-0 rtl:right-auto rtl:left-0 flex items-center pr-3 rtl:pr-0 rtl:pl-3 text-gray-400 hover:text-white">
                        &times;
                    </button>
                @endif
            </div>

            <!-- Mobile Filter Button + Sort Dropdown Row -->
            <div class="grid grid-cols-2 gap-3">
                <button @click="mobileFiltersOpen = true"
                        type="button"
                        class="flex items-center justify-center gap-2 bg-[#151518] border {{ $activeFilterCount > 0 ? 'border-gold-400/60 text-gold-400' : 'border-white/10 text-white' }} px-4 py-3 rounded-sm text-xs font-semibold uppercase tracking-widest transition-all">
                    <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span>{{ __('messages.filter_by') }}</span>
                    @if($activeFilterCount > 0)
                        <span class="inline-flex items-center justify-center h-4 min-w-[1rem] px-1 rounded-full bg-gold-400 text-black text-[10px] font-bold">
                            {{ $activeFilterCount }}
                        </span>
                    @endif
                </button>

                <div class="relative">
                    <select wire:model.live="sortBy"
                            aria-label="{{ __('messages.sort_by') }}"
                            class="w-full h-full bg-[#151518] border border-white/10 focus:border-gold-400/60 text-white text-xs px-3.5 py-3 rounded-sm outline-none transition-colors appearance-none">
                        <option value="featured">{{ __('messages.featured') }}</option>
                        <option value="price_asc">{{ __('messages.price_low_high') }}</option>
                        <option value="price_desc">{{ __('messages.price_high_low') }}</option>
                        <option value="year_desc">{{ __('messages.newest') }}</option>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-0 rtl:right-auto rtl:left-0 flex items-center pr-3 rtl:pr-0 rtl:pl-3 text-gold-400">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <!-- Mobile Slide-Over Filter Drawer -->
        <div x-show="mobileFiltersOpen"
             style="display: none;"
             class="fixed inset-0 z-50 lg:hidden"
             role="dialog"
             aria-modal="true">
            <!-- Backdrop -->
            <div x-show="mobileFiltersOpen"
                 x-transition:enter="transition-opacity ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileFiltersOpen = false"
                 class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

            <!-- Slide-Over Panel -->
            <div class="fixed inset-y-0 left-0 rtl:left-auto rtl:right-0 flex max-w-full">
                <div x-show="mobileFiltersOpen"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="-translate-x-full rtl:translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-200"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full rtl:translate-x-full"
                     class="w-screen max-w-xs sm:max-w-sm bg-[#121215] border-r rtl:border-r-0 rtl:border-l border-gold-400/20 flex flex-col justify-between shadow-2xl">

                    <!-- Drawer Header -->
                    <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                            <h2 class="font-display font-bold text-white tracking-wider text-base uppercase">
                                {{ __('messages.filter_by') }}
                            </h2>
                        </div>
                        <button @click="mobileFiltersOpen = false" class="p-1.5 text-gray-400 hover:text-gold-400 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Drawer Scrollable Body -->
                    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6">
                        <!-- Brand Filter -->
                        <div class="space-y-2.5">
                            <label class="text-[11px] uppercase text-gold-400/90 tracking-[0.2em] font-semibold block">
                                {{ app()->getLocale() === 'ar' ? 'دار العطور (الماركة)' : 'Fragrance House' }}
                            </label>
                            <select wire:model.live="selectedBrand" class="w-full bg-[#1a1a1e] border border-white/10 focus:border-gold-400/60 text-white text-xs px-4 py-3 rounded-sm outline-none transition-colors">
                                <option value="">{{ __('messages.all_brands') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->slug }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div class="space-y-2.5">
                            <label class="text-[11px] uppercase text-gold-400/90 tracking-[0.2em] font-semibold block">
                                {{ __('messages.gender') }}
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <button wire:click="$set('selectedGender', '')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === '' ? 'border-gold-400 bg-gold-400/10 text-gold-400' : 'border-white/10 bg-[#1a1a1e] text-gray-400 hover:text-white' }} rounded-sm transition-all">
                                    {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
                                </button>
                                <button wire:click="$set('selectedGender', 'male')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'male' ? 'border-gold-400 bg-gold-400/10 text-gold-400' : 'border-white/10 bg-[#1a1a1e] text-gray-400 hover:text-white' }} rounded-sm transition-all">
                                    {{ __('messages.male') }}
                                </button>
                                <button wire:click="$set('selectedGender', 'female')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'female' ? 'border-gold-400 bg-gold-400/10 text-gold-400' : 'border-white/10 bg-[#1a1a1e] text-gray-400 hover:text-white' }} rounded-sm transition-all">
                                    {{ __('messages.female') }}
                                </button>
                                <button wire:click="$set('selectedGender', 'unisex')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'unisex' ? 'border-gold-400 bg-gold-400/10 text-gold-400' : 'border-white/10 bg-[#1a1a1e] text-gray-400 hover:text-white' }} rounded-sm transition-all">
                                    {{ __('messages.unisex') }}
                                </button>
                            </div>
                        </div>

                        <!-- Season Filter -->
                        <div class="space-y-2.5">
                            <label class="text-[11px] uppercase text-gold-400/90 tracking-[0.2em] font-semibold block">
                                {{ __('messages.season') }}
                            </label>
                            @php
                                $seasonsList = [
                                    'summer' => ['label' => app()->getLocale() === 'ar' ? 'صيفي' : 'Summer', 'dot' => 'bg-cyan-400'],
                                    'winter' => ['label' => app()->getLocale() === 'ar' ? 'شتوي' : 'Winter', 'dot' => 'bg-indigo-400'],
                                    'spring' => ['label' => app()->getLocale() === 'ar' ? 'ربيعي' : 'Spring', 'dot' => 'bg-emerald-400'],
                                    'autumn' => ['label' => app()->getLocale() === 'ar' ? 'خريفي' : 'Autumn', 'dot' => 'bg-amber-400'],
                                ];
                            @endphp
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($seasonsList as $sKey => $sData)
                                    <button wire:click="$set('selectedSeason', '{{ $selectedSeason === $sKey ? '' : $sKey }}')"
                                            class="flex items-center justify-center gap-2 py-2.5 px-3 text-[10px] font-semibold tracking-wider uppercase border {{ $selectedSeason === $sKey ? 'border-gold-400 bg-gold-400/10 text-gold-400' : 'border-white/10 bg-[#1a1a1e] text-gray-400 hover:text-white' }} rounded-sm transition-all">
                                        <span class="h-2 w-2 rounded-full {{ $sData['dot'] }}"></span>
                                        <span>{{ $sData['label'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Concentration Filter -->
                        <div class="space-y-2.5">
                            <label class="text-[11px] uppercase text-gold-400/90 tracking-[0.2em] font-semibold block">
                                {{ __('messages.concentration') }}
                            </label>
                            <select wire:model.live="selectedConcentration" class="w-full bg-[#1a1a1e] border border-white/10 focus:border-gold-400/60 text-white text-xs px-4 py-3 rounded-sm outline-none transition-colors">
                                <option value="">{{ app()->getLocale() === 'ar' ? 'كل التركيزات' : 'All Concentrations' }}</option>
                                <option value="EDC">Eau de Cologne (EDC)</option>
                                <option value="EDT">Eau de Toilette (EDT)</option>
                                <option value="EDP">Eau de Parfum (EDP)</option>
                                <option value="Parfum">Parfum</option>
                                <option value="Extrait">Extrait de Parfum</option>
                            </select>
                        </div>
                    </div>

                    <!-- Drawer Footer -->
                    <div class="p-6 border-t border-white/10 bg-[#0e0e10] grid grid-cols-2 gap-3">
                        <button wire:click="resetFilters"
                                type="button"
                                class="py-3 px-4 border border-white/15 text-gray-300 hover:text-white hover:border-white/30 text-[10px] font-bold uppercase tracking-widest rounded-sm transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'إعادة تعيين' : 'Reset All' }}
                        </button>
                        <button @click="mobileFiltersOpen = false"
                                type="button"
                                class="py-3 px-4 bg-gold-gradient text-black text-[10px] font-bold uppercase tracking-widest rounded-sm shadow-lg">
                            {{ app()->getLocale() === 'ar' ? 'عرض (' . count($perfumes) . ')' : 'Show (' . count($perfumes) . ')' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Layout: Sidebar + Product Grid -->
        <div class="flex flex-col lg:flex-row gap-8 xl:gap-10 items-start">
            <!-- Desktop Sticky Filter Sidebar -->
            <aside class="hidden lg:block lg:w-72 xl:w-80 flex-shrink-0 lg:sticky lg:top-32 space-y-6 bg-[#141417]/95 backdrop-blur-md border border-white/[0.08] p-6 rounded-sm shadow-[0_20px_50px_rgba(0,0,0,0.6)]">
                <!-- Filter Header -->
                <div class="flex items-center justify-between border-b border-white/[0.08] pb-4">
                    <div class="flex items-center gap-2.5">
                        <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <h2 class="font-display font-bold text-white tracking-wider text-sm uppercase">
                            {{ __('messages.filter_by') }}
                        </h2>
                    </div>
                    @if($activeFilterCount > 0)
                        <button wire:click="resetFilters" class="text-[10px] tracking-widest text-gold-400 hover:underline uppercase font-bold transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'مسح الكل' : 'Reset All' }}
                        </button>
                    @endif
                </div>

                <!-- Search Input -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase text-gold-400/80 tracking-[0.2em] font-semibold block">
                        {{ app()->getLocale() === 'ar' ? 'البحث السريع' : 'Search Archive' }}
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 flex items-center pl-3.5 rtl:pl-0 rtl:pr-3.5 text-gray-500">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="{{ __('messages.search_placeholder') }}"
                               class="w-full bg-[#0e0e10] border border-white/10 focus:border-gold-400/60 text-white text-xs pl-9 pr-8 rtl:pl-8 rtl:pr-9 py-3 rounded-sm outline-none transition-colors placeholder:text-gray-500">
                        @if(!empty($search))
                            <button wire:click="$set('search', '')"
                                    class="absolute inset-y-0 right-0 rtl:right-auto rtl:left-0 flex items-center pr-3 rtl:pr-0 rtl:pl-3 text-gray-400 hover:text-white">
                                &times;
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase text-gold-400/80 tracking-[0.2em] font-semibold block">
                        {{ app()->getLocale() === 'ar' ? 'الماركة العالمية' : 'Fragrance House' }}
                    </label>
                    <div class="relative">
                        <select wire:model.live="selectedBrand" class="w-full bg-[#0e0e10] border border-white/10 focus:border-gold-400/60 text-white text-xs px-3.5 py-3 rounded-sm outline-none transition-colors appearance-none">
                            <option value="">{{ __('messages.all_brands') }}</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->slug }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-0 rtl:right-auto rtl:left-0 flex items-center pr-3 rtl:pr-0 rtl:pl-3 text-gold-400/70">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Gender Filter -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase text-gold-400/80 tracking-[0.2em] font-semibold block">
                        {{ __('messages.gender') }}
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <button wire:click="$set('selectedGender', '')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === '' ? 'border-gold-400 bg-gold-400/10 text-gold-400 shadow-[0_0_15px_rgba(212,175,55,0.12)]' : 'border-white/10 bg-[#0e0e10] text-gray-400 hover:border-white/25 hover:text-white' }} rounded-sm transition-all">
                            {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
                        </button>
                        <button wire:click="$set('selectedGender', 'male')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'male' ? 'border-gold-400 bg-gold-400/10 text-gold-400 shadow-[0_0_15px_rgba(212,175,55,0.12)]' : 'border-white/10 bg-[#0e0e10] text-gray-400 hover:border-white/25 hover:text-white' }} rounded-sm transition-all">
                            {{ __('messages.male') }}
                        </button>
                        <button wire:click="$set('selectedGender', 'female')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'female' ? 'border-gold-400 bg-gold-400/10 text-gold-400 shadow-[0_0_15px_rgba(212,175,55,0.12)]' : 'border-white/10 bg-[#0e0e10] text-gray-400 hover:border-white/25 hover:text-white' }} rounded-sm transition-all">
                            {{ __('messages.female') }}
                        </button>
                        <button wire:click="$set('selectedGender', 'unisex')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'unisex' ? 'border-gold-400 bg-gold-400/10 text-gold-400 shadow-[0_0_15px_rgba(212,175,55,0.12)]' : 'border-white/10 bg-[#0e0e10] text-gray-400 hover:border-white/25 hover:text-white' }} rounded-sm transition-all">
                            {{ __('messages.unisex') }}
                        </button>
                    </div>
                </div>

                <!-- Season Filter (Matches Seasonal Card Accents) -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-[10px] uppercase text-gold-400/80 tracking-[0.2em] font-semibold">
                            {{ __('messages.season') }}
                        </label>
                        @if(!empty($selectedSeason))
                            <button wire:click="$set('selectedSeason', '')" class="text-[9px] text-gray-400 hover:text-gold-400 uppercase tracking-wider">
                                {{ app()->getLocale() === 'ar' ? 'الكل' : 'Clear' }}
                            </button>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($seasonsList as $sKey => $sData)
                            <button wire:click="$set('selectedSeason', '{{ $selectedSeason === $sKey ? '' : $sKey }}')"
                                    class="flex items-center justify-center gap-2 py-2.5 px-3 text-[10px] font-semibold tracking-wider uppercase border {{ $selectedSeason === $sKey ? 'border-gold-400 bg-gold-400/10 text-gold-400 shadow-[0_0_15px_rgba(212,175,55,0.12)]' : 'border-white/10 bg-[#0e0e10] text-gray-400 hover:border-white/25 hover:text-white' }} rounded-sm transition-all">
                                <span class="h-2 w-2 rounded-full {{ $sData['dot'] }}"></span>
                                <span>{{ $sData['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Concentration Filter -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase text-gold-400/80 tracking-[0.2em] font-semibold block">
                        {{ __('messages.concentration') }}
                    </label>
                    <div class="relative">
                        <select wire:model.live="selectedConcentration" class="w-full bg-[#0e0e10] border border-white/10 focus:border-gold-400/60 text-white text-xs px-3.5 py-3 rounded-sm outline-none transition-colors appearance-none">
                            <option value="">{{ app()->getLocale() === 'ar' ? 'كل التركيزات' : 'All Concentrations' }}</option>
                            <option value="EDC">Eau de Cologne (EDC)</option>
                            <option value="EDT">Eau de Toilette (EDT)</option>
                            <option value="EDP">Eau de Parfum (EDP)</option>
                            <option value="Parfum">Parfum</option>
                            <option value="Extrait">Extrait de Parfum</option>
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-0 rtl:right-auto rtl:left-0 flex items-center pr-3 rtl:pr-0 rtl:pl-3 text-gold-400/70">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Golden Guarantee Mini Callout -->
                <div class="pt-2">
                    <div class="rounded-sm border border-gold-400/25 bg-gradient-to-br from-gold-400/[0.08] to-transparent p-4 space-y-1.5">
                        <div class="flex items-center gap-2 text-gold-400 text-[10px] font-bold uppercase tracking-widest">
                            <span>✨</span>
                            <span>{{ __('messages.guarantee') }}</span>
                        </div>
                        <p class="text-[11px] text-gray-400 font-light leading-relaxed">
                            {{ app()->getLocale() === 'ar'
                                ? 'عينة 1 مل مجانية مع كل زجاجة لتجربة العطر قبل فتح العبوة الأساسية.'
                                : 'Includes a free 1ml sample vial with every bottle so you can test before unsealing.' }}
                        </p>
                    </div>
                </div>
            </aside>

            <!-- Product Grid Section -->
            <section class="w-full flex-1 space-y-6">
                <!-- Top Control Bar (Results Count, Active Filter Chips & Desktop Sort) -->
                <div class="bg-[#141417]/80 border border-white/[0.07] px-5 py-4 rounded-sm space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <p class="text-xs text-gray-300">
                                {!! app()->getLocale() === 'ar'
                                    ? "عرض <span class='font-bold text-gold-400'>" . count($perfumes) . "</span> عطر فاخر"
                                    : "Showing <span class='font-bold text-gold-400'>" . count($perfumes) . "</span> exquisite fragrances" !!}
                            </p>
                            <!-- Subtle Livewire Loading Spinner -->
                            <div wire:loading.delay class="flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-gold-400">
                                <svg class="animate-spin h-3.5 w-3.5 text-gold-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Desktop Sort Selector -->
                        <div class="hidden lg:flex items-center gap-3">
                            <label class="text-[11px] uppercase tracking-widest text-gray-400 whitespace-nowrap">
                                {{ __('messages.sort_by') }}
                            </label>
                            <div class="relative">
                                <select wire:model.live="sortBy" class="bg-[#0e0e10] border border-white/10 focus:border-gold-400/60 text-white text-xs pl-3.5 pr-8 rtl:pl-8 rtl:pr-3.5 py-2 rounded-sm outline-none transition-colors appearance-none">
                                    <option value="featured">{{ __('messages.featured') }}</option>
                                    <option value="price_asc">{{ __('messages.price_low_high') }}</option>
                                    <option value="price_desc">{{ __('messages.price_high_low') }}</option>
                                    <option value="year_desc">{{ __('messages.newest') }}</option>
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-0 rtl:right-auto rtl:left-0 flex items-center pr-2.5 rtl:pr-0 rtl:pl-2.5 text-gold-400/70">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filter Pills -->
                    @if($activeFilterCount > 0)
                        <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-white/[0.06]">
                            <span class="text-[10px] uppercase tracking-widest text-gray-500">
                                {{ app()->getLocale() === 'ar' ? 'الفلاتر النشطة:' : 'Active:' }}
                            </span>

                            @if(!empty($search))
                                <button wire:click="$set('search', '')" class="inline-flex items-center gap-1.5 bg-gold-400/10 border border-gold-400/30 hover:border-gold-400 text-gold-400 text-[10px] font-semibold px-2.5 py-1 rounded-sm transition-colors">
                                    <span>"{{ $search }}"</span>
                                    <span class="text-xs leading-none">&times;</span>
                                </button>
                            @endif

                            @if(!empty($selectedBrand))
                                @php
                                    $activeBrandObj = $brands->firstWhere('slug', $selectedBrand);
                                @endphp
                                <button wire:click="$set('selectedBrand', '')" class="inline-flex items-center gap-1.5 bg-gold-400/10 border border-gold-400/30 hover:border-gold-400 text-gold-400 text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-sm transition-colors">
                                    <span>{{ $activeBrandObj ? $activeBrandObj->name : $selectedBrand }}</span>
                                    <span class="text-xs leading-none">&times;</span>
                                </button>
                            @endif

                            @if(!empty($selectedGender))
                                <button wire:click="$set('selectedGender', '')" class="inline-flex items-center gap-1.5 bg-gold-400/10 border border-gold-400/30 hover:border-gold-400 text-gold-400 text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-sm transition-colors">
                                    <span>{{ __("messages.{$selectedGender}") }}</span>
                                    <span class="text-xs leading-none">&times;</span>
                                </button>
                            @endif

                            @if(!empty($selectedSeason) && isset($seasonsList[$selectedSeason]))
                                <button wire:click="$set('selectedSeason', '')" class="inline-flex items-center gap-1.5 bg-gold-400/10 border border-gold-400/30 hover:border-gold-400 text-gold-400 text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-sm transition-colors">
                                    <span>{{ $seasonsList[$selectedSeason]['label'] }}</span>
                                    <span class="text-xs leading-none">&times;</span>
                                </button>
                            @endif

                            @if(!empty($selectedConcentration))
                                <button wire:click="$set('selectedConcentration', '')" class="inline-flex items-center gap-1.5 bg-gold-400/10 border border-gold-400/30 hover:border-gold-400 text-gold-400 text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-sm transition-colors">
                                    <span>{{ $selectedConcentration }}</span>
                                    <span class="text-xs leading-none">&times;</span>
                                </button>
                            @endif

                            <button wire:click="resetFilters" class="text-[10px] text-gray-400 hover:text-white underline uppercase tracking-widest ml-auto rtl:ml-0 rtl:mr-auto">
                                {{ app()->getLocale() === 'ar' ? 'مسح الكل' : 'Clear All' }}
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Product Grid -->
                @if(count($perfumes) > 0)
                    <div wire:loading.class="opacity-60" class="grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-2 xl:grid-cols-3 transition-opacity duration-300">
                        @foreach($perfumes as $perfume)
                            @php
                                // Subtle seasonal color accents paired with luxury gold/charcoal borders
                                $cardBg = 'bg-gradient-to-b from-[#17171a] to-[#121215] border border-white/[0.08] hover:border-gold-400/50';
                                $glowColor = 'bg-gold-400/[0.06]';
                                $seasonBadge = null;

                                if (is_array($perfume->season)) {
                                    if (in_array('summer', $perfume->season)) {
                                        $cardBg = 'bg-gradient-to-br from-cyan-950/40 via-[#151518] to-blue-950/25 border border-cyan-500/20 hover:border-gold-400/60';
                                        $glowColor = 'bg-cyan-400/[0.08]';
                                        $seasonBadge = ['label' => app()->getLocale() === 'ar' ? 'صيفي' : 'Summer', 'dot' => 'bg-cyan-400'];
                                    } elseif (in_array('winter', $perfume->season)) {
                                        $cardBg = 'bg-gradient-to-br from-slate-800/45 via-[#151518] to-indigo-950/30 border border-indigo-400/20 hover:border-gold-400/60';
                                        $glowColor = 'bg-indigo-400/[0.08]';
                                        $seasonBadge = ['label' => app()->getLocale() === 'ar' ? 'شتوي' : 'Winter', 'dot' => 'bg-indigo-400'];
                                    } elseif (in_array('spring', $perfume->season)) {
                                        $cardBg = 'bg-gradient-to-br from-emerald-950/40 via-[#151518] to-green-950/25 border border-emerald-500/20 hover:border-gold-400/60';
                                        $glowColor = 'bg-emerald-400/[0.08]';
                                        $seasonBadge = ['label' => app()->getLocale() === 'ar' ? 'ربيعي' : 'Spring', 'dot' => 'bg-emerald-400'];
                                    } elseif (in_array('autumn', $perfume->season)) {
                                        $cardBg = 'bg-gradient-to-br from-amber-950/40 via-[#151518] to-red-950/25 border border-amber-500/20 hover:border-gold-400/60';
                                        $glowColor = 'bg-amber-400/[0.08]';
                                        $seasonBadge = ['label' => app()->getLocale() === 'ar' ? 'خريفي' : 'Autumn', 'dot' => 'bg-amber-400'];
                                    }
                                }

                                $discountPercent = null;
                                if ($perfume->old_price && $perfume->old_price > $perfume->price) {
                                    $discountPercent = round((($perfume->old_price - $perfume->price) / $perfume->old_price) * 100);
                                }
                            @endphp

                            <article wire:key="perfume-card-{{ $perfume->id }}"
                                     class="group relative flex flex-col justify-between {{ $cardBg }} rounded-sm p-5 transition-all duration-500 hover:-translate-y-1.5 hover:shadow-[0_22px_45px_-12px_rgba(0,0,0,0.85)] overflow-hidden">

                                <!-- Top Metallic Gold Shimmer Line on Hover -->
                                <div class="pointer-events-none absolute inset-x-0 top-0 h-[1px] bg-gradient-to-r from-transparent via-gold-400/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <!-- Clickable Product Image Area -->
                                <a href="{{ route('perfume.show', $perfume->slug) }}"
                                   class="relative block w-full aspect-square overflow-hidden mb-5 p-5 flex items-center justify-center rounded-sm bg-black/20 border border-white/[0.03]">
                                    <!-- Ambient Bottle Spotlight -->
                                    <div class="pointer-events-none absolute inset-6 rounded-full {{ $glowColor }} blur-2xl opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500"></div>

                                    @if($perfume->images->count() > 0)
                                        <img src="{{ asset('uploads/' . $perfume->images->first()->image_path) }}"
                                             alt="{{ $perfume->name }}"
                                             loading="lazy"
                                             class="relative z-10 h-full w-full object-contain object-center scale-95 group-hover:scale-105 transition-transform duration-700 ease-out drop-shadow-[0_12px_20px_rgba(0,0,0,0.6)]">
                                    @else
                                        <div class="relative z-10 flex h-full w-full items-center justify-center text-gray-700">
                                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Out of Stock Overlay -->
                                    @if($perfume->stock_status === 'out_of_stock')
                                        <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px] z-20 flex items-center justify-center">
                                            <span class="bg-[#121215]/95 border border-white/15 text-gray-300 text-[10px] font-bold tracking-[0.2em] uppercase px-4 py-1.5 rounded-sm shadow-xl">
                                                {{ app()->getLocale() === 'ar' ? 'نفذت الكمية' : 'Out of Stock' }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Top-Left Status Badges (Pre-order / Discount) -->
                                    <div class="absolute top-2.5 left-2.5 rtl:left-auto rtl:right-2.5 z-20 flex flex-col items-start gap-1.5">
                                        @if($perfume->pre_order || $perfume->stock_status === 'pre_order')
                                            <div class="flex items-center gap-1.5 bg-matte-black/90 backdrop-blur-md border border-gold-400/70 px-2.5 py-1 rounded-sm shadow-lg">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-gold-500"></span>
                                                </span>
                                                <span class="text-[8px] font-bold tracking-[0.2em] uppercase text-gold-400">
                                                    {{ __('messages.pre_order') }}
                                                </span>
                                            </div>
                                        @endif

                                        @if($discountPercent)
                                            <span class="text-[9px] font-bold tracking-wider uppercase bg-gold-gradient text-black px-2 py-0.5 rounded-sm shadow-md">
                                                -{{ $discountPercent }}%
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Top-Right Season Indicator Pill -->
                                    @if($seasonBadge)
                                        <span class="absolute top-2.5 right-2.5 rtl:right-auto rtl:left-2.5 z-20 inline-flex items-center gap-1.5 text-[8px] font-semibold tracking-widest uppercase bg-[#121215]/85 backdrop-blur-sm text-gray-300 px-2 py-1 rounded-sm border border-white/10">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $seasonBadge['dot'] }}"></span>
                                            <span>{{ $seasonBadge['label'] }}</span>
                                        </span>
                                    @endif

                                    <!-- Bottom Metadata Bar on Image -->
                                    <div class="absolute bottom-2.5 inset-x-2.5 z-20 flex items-center justify-between pointer-events-none">
                                        @if($perfume->gender)
                                            <span class="text-[8px] font-bold tracking-[0.18em] uppercase bg-[#121215]/90 backdrop-blur-sm text-gray-300 px-2.5 py-1 rounded-sm border border-white/10">
                                                {{ __("messages.{$perfume->gender}") }}
                                            </span>
                                        @else
                                            <span></span>
                                        @endif

                                        @if($perfume->size_ml)
                                            <span class="text-[8px] font-semibold tracking-widest uppercase bg-[#121215]/90 backdrop-blur-sm text-gray-400 px-2 py-1 rounded-sm border border-white/10">
                                                {{ $perfume->size_ml }} ML
                                            </span>
                                        @endif
                                    </div>
                                </a>

                                <!-- Perfume Meta & Description -->
                                <div class="space-y-2.5 flex-grow flex flex-col justify-between">
                                    <div class="space-y-1.5">
                                        <!-- Brand & Concentration Row -->
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="text-[10px] tracking-[0.22em] uppercase text-gold-400 font-bold truncate">
                                                {{ $perfume->brand->name }}
                                            </p>
                                            <span class="flex-shrink-0 text-[8px] font-bold bg-white/[0.06] border border-white/10 text-gray-300 px-2 py-0.5 rounded-sm uppercase tracking-widest">
                                                {{ $perfume->concentration }}
                                            </span>
                                        </div>

                                        <!-- Perfume Title -->
                                        <h3 class="font-display font-bold text-white text-lg tracking-wide group-hover:text-gold-400 transition-colors leading-snug">
                                            <a href="{{ route('perfume.show', $perfume->slug) }}" class="line-clamp-1">
                                                {{ $perfume->name }}
                                            </a>
                                        </h3>

                                        <!-- Inspired By / Dupe Badge if available -->
                                        @if($perfume->dupe)
                                            <p class="text-[10px] text-gold-400/80 bg-gold-400/[0.06] border border-gold-400/20 px-2 py-0.5 rounded-sm inline-block truncate max-w-full">
                                                {{ app()->getLocale() === 'ar' ? 'مستوحى من: ' : 'Inspired by: ' }}
                                                <span class="font-semibold text-gray-200">{{ $perfume->dupe->name }}</span>
                                            </p>
                                        @endif

                                        <!-- Short Description -->
                                        <p class="text-xs text-gray-400 font-light line-clamp-2 leading-relaxed pt-0.5">
                                            {{ $perfume->short_description }}
                                        </p>
                                    </div>

                                    <!-- Price & Action Area -->
                                    <div class="pt-4 border-t border-white/[0.08] mt-4 space-y-3.5">
                                        <div class="flex items-baseline justify-between">
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-lg font-extrabold text-gold-400 tracking-tight">
                                                    ${{ number_format($perfume->price, 2) }}
                                                </span>
                                                @if($perfume->old_price)
                                                    <span class="text-xs text-gray-500 line-through">
                                                        ${{ number_format($perfume->old_price, 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($perfume->longevity)
                                                <span class="text-[9px] text-gray-400 uppercase tracking-wider">
                                                    ⚡ {{ str_replace('_', ' ', $perfume->longevity) }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($perfume->stock_status === 'out_of_stock')
                                            <div class="block w-full border border-white/10 bg-white/[0.03] text-center font-semibold text-[10px] tracking-[0.2em] uppercase text-gray-500 py-3 rounded-sm cursor-not-allowed">
                                                {{ app()->getLocale() === 'ar' ? 'نفذت الكمية' : 'Out of Stock' }}
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('perfume.show', $perfume->slug) }}"
                                                   class="flex-1 border border-gold-400/35 hover:border-gold-400 text-center font-bold text-[10px] tracking-[0.2em] uppercase text-white hover:text-black hover:bg-gold-gradient py-3 transition-all duration-300 rounded-sm shadow-sm">
                                                    {{ $perfume->pre_order || $perfume->stock_status === 'pre_order' ? (app()->getLocale() === 'ar' ? 'اطلب مسبقاً' : 'Pre-order') : __('messages.view_details') }}
                                                </a>

                                                <button wire:click="quickAddToCart({{ $perfume->id }})"
                                                        wire:loading.attr="disabled"
                                                        wire:target="quickAddToCart({{ $perfume->id }})"
                                                        title="{{ __('messages.add_to_cart') }}"
                                                        aria-label="{{ __('messages.add_to_cart') }}"
                                                        class="flex-shrink-0 h-[38px] w-[42px] flex items-center justify-center border border-gold-400/35 hover:border-gold-400 bg-gold-400/10 hover:bg-gold-gradient text-gold-400 hover:text-black rounded-sm transition-all duration-300">
                                                    <svg wire:loading.remove wire:target="quickAddToCart({{ $perfume->id }})" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                    </svg>
                                                    <svg wire:loading wire:target="quickAddToCart({{ $perfume->id }})" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <!-- Luxury Empty State -->
                    <div class="border border-white/10 bg-[#141417]/90 rounded-sm py-20 px-6 text-center space-y-5 shadow-2xl">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border border-gold-400/30 bg-gold-400/5 text-gold-400">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-display text-xl font-bold text-white tracking-wide">
                                {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على عطور مطابقة' : 'No Matching Fragrances Found' }}
                            </h3>
                            <p class="text-gray-400 text-xs font-light max-w-sm mx-auto leading-relaxed">
                                {{ app()->getLocale() === 'ar'
                                    ? 'لم نتمكن من العثور على عطور تطابق خيارات التصفية الحالية. جرب تعديل البحث أو إعادة تعيين الفلاتر.'
                                    : 'We couldn\'t find any fragrances matching your current selection. Try adjusting your search or clearing your active filters.' }}
                            </p>
                        </div>
                        <button wire:click="resetFilters"
                                class="inline-flex items-center gap-2 bg-gold-gradient text-black font-bold text-[10px] tracking-[0.2em] uppercase px-7 py-3 rounded-sm hover:opacity-90 transition-opacity shadow-lg">
                            <span>{{ app()->getLocale() === 'ar' ? 'عرض جميع العطور' : 'Reset & View All Fragrances' }}</span>
                        </button>
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>
