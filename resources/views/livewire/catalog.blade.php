<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <!-- Catalog Header -->
    <div class="text-center space-y-4 mb-12">
        <h1 class="font-display text-3xl sm:text-5xl font-bold text-white tracking-wide uppercase">
            {{ app()->getLocale() === 'ar' ? 'المجموعة العطرية' : 'The Fragrance Catalog' }}
        </h1>
        <div class="h-[1px] w-24 bg-gold-400 mx-auto"></div>
        <p class="text-gray-400 text-sm max-w-md mx-auto font-light">
            {{ app()->getLocale() === 'ar' ? 'اختر عطرك المفضل من تشكيلتنا النخبوية من العطور العالمية' : 'Select your signature scent from our elite curation of luxury fragrances.' }}
        </p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-1/4 space-y-6 lg:sticky lg:top-28 h-fit bg-[#161618] border border-charcoal p-6 rounded-sm">
            <div class="flex items-center justify-between border-b border-charcoal pb-4">
                <h2 class="font-display font-semibold text-white tracking-wider text-base uppercase">
                    {{ __('messages.filter_by') }}
                </h2>
                <button wire:click="resetFilters" class="text-[10px] tracking-widest text-gold-400/70 hover:text-gold-400 uppercase font-semibold transition-colors">
                    {{ app()->getLocale() === 'ar' ? 'إعادة تعيين' : 'Reset All' }}
                </button>
            </div>

            <!-- Search Bar -->
            <div class="space-y-2">
                <label class="text-xs uppercase text-gray-400 tracking-wider font-semibold">
                    {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
                </label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('messages.search_placeholder') }}" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-4 py-3 rounded-sm outline-none transition-colors">
                </div>
            </div>

            <!-- Brand Filter -->
            <div class="space-y-2">
                <label class="text-xs uppercase text-gray-400 tracking-wider font-semibold">
                    {{ app()->getLocale() === 'ar' ? 'الماركة' : 'Brand' }}
                </label>
                <select wire:model.live="selectedBrand" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-4 py-3 rounded-sm outline-none transition-colors">
                    <option value="">{{ __('messages.all_brands') }}</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->slug }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Gender Filter -->
            <div class="space-y-2">
                <label class="text-xs uppercase text-gray-400 tracking-wider font-semibold">
                    {{ __('messages.gender') }}
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <button wire:click="$set('selectedGender', '')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === '' ? 'border-gold-400 bg-gold-400/5 text-gold-400' : 'border-charcoal text-gray-400 hover:text-white' }} rounded-sm transition-all">
                        {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
                    </button>
                    <button wire:click="$set('selectedGender', 'male')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'male' ? 'border-gold-400 bg-gold-400/5 text-gold-400' : 'border-charcoal text-gray-400 hover:text-white' }} rounded-sm transition-all">
                        {{ __('messages.male') }}
                    </button>
                    <button wire:click="$set('selectedGender', 'female')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'female' ? 'border-gold-400 bg-gold-400/5 text-gold-400' : 'border-charcoal text-gray-400 hover:text-white' }} rounded-sm transition-all">
                        {{ __('messages.female') }}
                    </button>
                    <button wire:click="$set('selectedGender', 'unisex')" class="py-2.5 px-3 text-center text-[10px] font-semibold tracking-wider uppercase border {{ $selectedGender === 'unisex' ? 'border-gold-400 bg-gold-400/5 text-gold-400' : 'border-charcoal text-gray-400 hover:text-white' }} rounded-sm transition-all">
                        {{ __('messages.unisex') }}
                    </button>
                </div>
            </div>

            <!-- Concentration Filter -->
            <div class="space-y-2">
                <label class="text-xs uppercase text-gray-400 tracking-wider font-semibold">
                    {{ __('messages.concentration') }}
                </label>
                <select wire:model.live="selectedConcentration" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-4 py-3 rounded-sm outline-none transition-colors">
                    <option value="">{{ app()->getLocale() === 'ar' ? 'كل التركيزات' : 'All Concentrations' }}</option>
                    <option value="EDC">Eau de Cologne (EDC)</option>
                    <option value="EDT">Eau de Toilette (EDT)</option>
                    <option value="EDP">Eau de Parfum (EDP)</option>
                    <option value="Parfum">Parfum</option>
                    <option value="Extrait">Extrait de Parfum</option>
                </select>
            </div>
        </aside>

        <!-- Product Grid Content -->
        <section class="w-full lg:w-3/4 space-y-6">
            <!-- Top bar (Results count & Sorting) -->
            <div class="flex flex-col sm:flex-row items-center justify-between border-b border-charcoal pb-4 gap-4">
                <p class="text-xs text-gray-400">
                    {!! app()->getLocale() === 'ar' 
                        ? "تم العثور على <span class='font-semibold text-gold-400'>". count($perfumes) ."</span> عطر" 
                        : "Showing <span class='font-semibold text-gold-400'>". count($perfumes) ."</span> exquisite fragrances" !!}
                </p>
                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full sm:w-auto">
                    <label class="text-xs text-gray-400 whitespace-nowrap">{{ __('messages.sort_by') }}</label>
                    <select wire:model.live="sortBy" class="bg-[#161618] border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2 rounded-sm outline-none transition-colors w-full sm:w-auto">
                        <option value="featured">{{ __('messages.featured') }}</option>
                        <option value="price_asc">{{ __('messages.price_low_high') }}</option>
                        <option value="price_desc">{{ __('messages.price_high_low') }}</option>
                        <option value="year_desc">{{ __('messages.newest') }}</option>
                    </select>
                </div>
            </div>

            <!-- Grid -->
            @if(count($perfumes) > 0)
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8 animate-fade-in">
                    @foreach($perfumes as $perfume)
                        @php
                            $cardBg = 'bg-[#161618]';
                            if (is_array($perfume->season)) {
                                if (in_array('summer', $perfume->season)) {
                                    $cardBg = 'bg-gradient-to-br from-cyan-900/40 to-blue-900/20 bg-[#161618] border border-cyan-900/30 hover:border-cyan-500/50';
                                } elseif (in_array('winter', $perfume->season)) {
                                    $cardBg = 'bg-gradient-to-br from-slate-800/50 to-indigo-900/30 bg-[#161618] border border-slate-700/50 hover:border-indigo-400/50';
                                } elseif (in_array('spring', $perfume->season)) {
                                    $cardBg = 'bg-gradient-to-br from-green-900/40 to-emerald-900/20 bg-[#161618] border border-green-900/30 hover:border-emerald-500/50';
                                } elseif (in_array('autumn', $perfume->season)) {
                                    $cardBg = 'bg-gradient-to-br from-orange-900/40 to-red-900/20 bg-[#161618] border border-orange-900/30 hover:border-orange-500/50';
                                }
                            }
                        @endphp
                        <div class="group relative flex flex-col justify-between {{ $cardBg }} transition-all duration-300 p-4 rounded-sm">
                            <!-- Image Area -->
                            <div class="relative w-full aspect-square bg-transparent overflow-hidden mb-4 p-4 flex items-center justify-center">
                                @if($perfume->images->count() > 0)
                                    <img src="{{ asset('uploads/' . $perfume->images->first()->image_path) }}" alt="{{ $perfume->name }}" class="h-full w-full object-contain object-center scale-95 group-hover:scale-100 transition-transform duration-500">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-matte-black text-gray-700">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                    </div>
                                @endif

                                @if($perfume->pre_order || $perfume->stock_status === 'pre_order')
                                    <div class="absolute top-2 left-2 rtl:left-auto rtl:right-2 z-10 flex items-center gap-1.5">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-gold-500"></span>
                                        </span>
                                        <span class="text-[8px] font-bold tracking-[0.2em] uppercase bg-matte-black/90 backdrop-blur-sm border border-gold-400 text-gold-400 px-2 py-1 rounded-sm shadow-lg">
                                            {{ __('messages.pre_order') }}
                                        </span>
                                    </div>
                                @endif

                                @if($perfume->gender)
                                    <span class="absolute bottom-2 left-2 rtl:left-auto rtl:right-2 text-[9px] font-bold tracking-widest uppercase bg-[#121212]/80 text-gray-300 px-2.5 py-1 rounded-sm border border-charcoal">
                                        {{ __("messages.{$perfume->gender}") }}
                                    </span>
                                @endif
                            </div>

                            <!-- Meta Area -->
                            <div class="space-y-2 flex-grow flex flex-col justify-between">
                                <div>
                                    <p class="text-[10px] tracking-widest uppercase text-gold-400/70 font-semibold">
                                        {{ $perfume->brand->name }}
                                    </p>
                                    <h3 class="font-display font-bold text-white text-base tracking-wide group-hover:text-gold-400 transition-colors">
                                        <a href="{{ route('perfume.show', $perfume->slug) }}">
                                            {{ $perfume->name }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-gray-400 font-light mt-1 line-clamp-2">
                                        {{ $perfume->short_description }}
                                    </p>
                                </div>

                                <!-- Price and Button Area -->
                                <div class="pt-4 border-t border-charcoal mt-auto">
                                    <div class="flex items-baseline justify-between mb-4">
                                        <div class="flex items-baseline space-x-2 rtl:space-x-reverse">
                                            <span class="text-base font-bold text-gold-400">${{ number_format($perfume->price, 2) }}</span>
                                            @if($perfume->old_price)
                                                <span class="text-xs text-gray-500 line-through">${{ number_format($perfume->old_price, 2) }}</span>
                                            @endif
                                        </div>
                                        <span class="text-[9px] font-semibold bg-charcoal text-gray-400 px-2 py-0.5 rounded-sm uppercase tracking-wider">
                                            {{ $perfume->concentration }}
                                        </span>
                                    </div>
                                    
                                    @if($perfume->stock_status === 'out_of_stock')
                                        <div class="block w-full border border-charcoal bg-charcoal/30 text-center font-semibold text-[10px] tracking-widest uppercase text-gray-500 py-2.5 rounded-sm cursor-not-allowed">
                                            {{ app()->getLocale() === 'ar' ? 'نفذت الكمية' : 'Out of Stock' }}
                                        </div>
                                    @else
                                        <a href="{{ route('perfume.show', $perfume->slug) }}" class="block w-full border border-gold-400/30 hover:border-gold-400/80 text-center font-semibold text-[10px] tracking-widest uppercase text-white hover:text-black hover:bg-gold-gradient py-2.5 transition-all duration-300 rounded-sm">
                                            {{ $perfume->pre_order || $perfume->stock_status === 'pre_order' ? (app()->getLocale() === 'ar' ? 'اطلب مسبقاً' : 'Pre-order') : __('messages.view_details') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Results -->
                <div class="border border-charcoal bg-[#161618] rounded-sm py-20 px-4 text-center space-y-4">
                    <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="font-display text-lg font-bold text-white tracking-wide">
                        {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على نتائج' : 'No Fragrances Found' }}
                    </h3>
                    <p class="text-gray-400 text-xs font-light max-w-sm mx-auto">
                        {{ app()->getLocale() === 'ar' ? 'يرجى مراجعة تصفية البحث أو إعادة تعيين الفلاتر للبدء من جديد.' : 'Try adjusting your search query, or clear your filters to start over.' }}
                    </p>
                    <button wire:click="resetFilters" class="inline-block bg-gold-gradient text-black font-semibold text-[10px] tracking-widest uppercase px-6 py-2.5 rounded-sm hover:opacity-90 transition-opacity">
                        {{ app()->getLocale() === 'ar' ? 'عرض جميع العطور' : 'View All Fragrances' }}
                    </button>
                </div>
            @endif
        </section>
    </div>
</div>
