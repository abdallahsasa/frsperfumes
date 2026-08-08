@php
    $bgClass = 'bg-matte-black';
    if (is_array($perfume->season)) {
        if (in_array('summer', $perfume->season)) {
            $bgClass = 'bg-gradient-to-br from-cyan-900/40 to-blue-900/20 bg-[#161618]'; // Fresh/Summer
        } elseif (in_array('winter', $perfume->season)) {
            $bgClass = 'bg-gradient-to-br from-slate-800/50 to-indigo-900/20 bg-[#161618]'; // Cold/Winter
        } elseif (in_array('spring', $perfume->season)) {
            $bgClass = 'bg-gradient-to-br from-green-900/40 to-emerald-900/20 bg-[#161618]'; // Floral/Spring
        } elseif (in_array('autumn', $perfume->season)) {
            $bgClass = 'bg-gradient-to-br from-orange-900/40 to-red-900/20 bg-[#161618]'; // Warm/Autumn
        }
    }
@endphp
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 {{ $bgClass }} text-gray-200">
    <!-- Success Alert -->
    @if($successMessage)
        <div
            class="fixed bottom-5 right-5 z-50 bg-[#161618] border border-gold-400 text-white px-6 py-4 shadow-2xl rounded-sm flex items-center justify-between gap-4 animate-fade-in-up">
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="text-gold-400">✨</span>
                <span class="text-xs font-semibold tracking-wider uppercase">{{ $successMessage }}</span>
            </div>
            <button wire:click="$set('successMessage', '')" class="text-gray-400 hover:text-white">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <!-- LEFT COLUMN: Image Gallery & Accords -->
        <div class="space-y-8">
            <!-- Large Image and Thumbnails -->
            <div class="space-y-4">
                <div
                    class="relative w-full aspect-square bg-[#161618] border border-charcoal/60 rounded-sm overflow-hidden flex items-center justify-center p-8 group">
                    @if(!empty($activeImage))
                        <!-- Image with subtle hover zoom effect -->
                        <img src="{{ asset('uploads/' . $activeImage) }}" alt="{{ $perfume->name }}"
                            class="h-full w-full object-contain max-h-[450px] transition-transform duration-500 group-hover:scale-105">
                    @else
                        <svg class="h-24 w-24 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    @endif

                    @if($perfume->pre_order || $perfume->stock_status === 'pre_order')
                        <div class="absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10 flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-gold-500"></span>
                            </span>
                            <span class="text-[10px] font-bold tracking-[0.2em] uppercase bg-matte-black/80 backdrop-blur-md border border-gold-400 text-gold-400 px-3 py-1.5 rounded-sm shadow-xl">
                                {{ __('messages.pre_order') }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($perfume->images->count() > 1)
                    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-thin">
                        @foreach($perfume->images as $img)
                            <button wire:click="selectImage('{{ $img->image_path }}')"
                                class="flex-shrink-0 w-20 h-20 bg-[#161618] border {{ $activeImage === $img->image_path ? 'border-gold-400' : 'border-charcoal/60' }} hover:border-gold-400 p-2 rounded-sm transition-all overflow-hidden flex items-center justify-center">
                                <img src="{{ asset('uploads/' . $img->image_path) }}" alt="Thumbnail"
                                    class="h-full w-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Accords Chart (Fragrantica-style Bars) -->
            @if($perfume->accords->count() > 0)
                <div class="bg-[#161618] border border-charcoal/60 p-6 sm:p-8 rounded-sm space-y-6">
                    <h3
                        class="font-display font-bold text-white text-sm tracking-widest uppercase border-b border-charcoal/50 pb-4 flex items-center gap-2">
                        <span>📊</span>
                        <span>{{ __('messages.main_accords') }}</span>
                    </h3>
                    <div class="space-y-4">
                        @foreach($perfume->accords as $accord)
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-xs font-semibold">
                                    <span class="text-gray-300 tracking-wide">{{ $accord->name }}</span>
                                    <span class="text-gold-400 font-bold">{{ $accord->pivot->intensity }}%</span>
                                </div>
                                <div
                                    class="w-full bg-[#121212] h-4 rounded-sm overflow-hidden border border-charcoal/40 p-[2px]">
                                    <div class="h-full rounded-sm transition-all duration-1000 shadow-inner"
                                        style="background-color: {{ $accord->color_hex ?: '#d4af37' }}; width: {{ $accord->pivot->intensity }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Perfume Info, Pyramid & checkout details -->
        <div class="space-y-8">
            <!-- Title & Basic Info -->
            <div class="space-y-4">
                <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-bold block">
                    {{ $perfume->brand->name }}
                </span>
                <h1 class="font-display text-4xl sm:text-5xl font-bold text-white tracking-wide leading-tight">
                    {{ $perfume->name }}
                </h1>

                <div class="flex flex-wrap items-center gap-3 text-xs font-medium text-gray-300 pt-2">
                    <span
                        class="bg-gold-400/10 border border-gold-400/30 text-gold-400 px-3 py-1 rounded-sm uppercase tracking-widest">
                        {{ $perfume->concentration }}
                    </span>
                    <span class="bg-[#161618] border border-charcoal/60 px-3 py-1 rounded-sm">
                        {{ $perfume->size_ml }} ml
                    </span>
                    <span class="bg-[#161618] border border-charcoal/60 px-3 py-1 rounded-sm uppercase tracking-wider">
                        {{ __("messages.{$perfume->gender}") }}
                    </span>
                    <span class="bg-[#161618] border border-charcoal/60 px-3 py-1 rounded-sm">
                        {{ $perfume->stock_status === 'in_stock' ? __('messages.in_stock') : ($perfume->stock_status === 'pre_order' ? __('messages.pre_order') : __('messages.out_of_stock')) }}
                    </span>
                </div>
            </div>

            <!-- Price and Quantity area -->
            <div class="border-y border-charcoal/60 py-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                <!-- Prices -->
                <div class="space-y-1 text-center sm:text-left rtl:sm:text-right">
                    <span
                        class="text-[10px] text-gray-500 uppercase tracking-widest block">{{ __('messages.price') }}</span>
                    <div class="flex items-baseline space-x-3 rtl:space-x-reverse justify-center sm:justify-start">
                        <span
                            class="text-3xl font-extrabold text-gold-400">${{ number_format($perfume->price, 2) }}</span>
                        @if($perfume->old_price)
                            <span
                                class="text-base text-gray-500 line-through">${{ number_format($perfume->old_price, 2) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Quantity Controller & Add to Cart -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center border border-charcoal/60 bg-[#161618] rounded-sm">
                        <button wire:click="decrementQuantity"
                            class="px-3 py-2 text-gray-400 hover:text-white transition-colors">&minus;</button>
                        <span
                            class="px-4 py-2 text-xs font-bold text-white w-10 text-center select-none">{{ $quantity }}</span>
                        <button wire:click="incrementQuantity"
                            class="px-3 py-2 text-gray-400 hover:text-white transition-colors">&plus;</button>
                    </div>

                    @if($perfume->stock_status === 'out_of_stock')
                        <button disabled
                            class="bg-charcoal/50 text-gray-500 font-bold text-xs tracking-widest uppercase px-8 py-3.5 rounded-sm flex items-center gap-2 cursor-not-allowed">
                            <span>🚫</span>
                            <span>{{ app()->getLocale() === 'ar' ? 'نفذت الكمية' : 'Out of Stock' }}</span>
                        </button>
                    @else
                        <button wire:click="addToCart"
                            class="bg-gold-gradient text-black font-bold text-xs tracking-widest uppercase px-8 py-3.5 hover:opacity-90 active:scale-[0.98] transition-all rounded-sm flex items-center gap-2 shadow-lg">
                            <span>🛒</span>
                            <span>{{ $perfume->pre_order || $perfume->stock_status === 'pre_order' ? (app()->getLocale() === 'ar' ? 'اطلب مسبقاً' : 'Pre-order Now') : __('messages.add_to_cart') }}</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Golden Guarantee Box -->
            <div
                class="relative overflow-hidden border border-gold-400/35 bg-gold-400/5 p-6 rounded-sm space-y-3 shadow-xl">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gold-400/5 blur-xl rounded-full"></div>
                <div
                    class="flex items-center gap-2 text-gold-400 font-bold text-xs uppercase tracking-[0.15em] relative z-10">
                    <span>🛡️</span>
                    <span>{{ __('messages.guarantee') }}</span>
                </div>
                <h4 class="font-display font-semibold text-white text-sm relative z-10">
                    {{ __('messages.guarantee_title') }}
                </h4>
                <p class="text-gray-400 text-xs leading-relaxed font-light relative z-10">
                    {{ __('messages.guarantee_desc') }}
                </p>
            </div>

            <!-- Notes Pyramid (Visualized Fragrantica Pyramid) -->
            <div class="bg-[#161618] border border-charcoal/60 p-6 sm:p-8 rounded-sm space-y-6">
                <h3
                    class="font-display font-bold text-white text-sm tracking-widest uppercase border-b border-charcoal/50 pb-4 flex items-center gap-2">
                    <span>👃</span>
                    <span>{{ __('messages.notes_pyramid') }}</span>
                </h3>

                <!-- Pyramid Stack Layout -->
                <div class="space-y-4 pt-2">
                    <!-- Top Notes -->
                    <div class="relative overflow-hidden bg-gold-400/5 border border-gold-400/20 p-4 rounded-sm">
                        <div class="absolute top-0 left-0 w-2 h-full bg-gold-400/30"></div>
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-gold-400 tracking-widest uppercase block">
                                👑 {{ __('messages.top_notes') }}
                            </span>
                            <div class="flex flex-wrap gap-2">
                                @forelse($perfume->topNotes as $note)
                                    <span
                                        class="bg-matte-black/60 border border-charcoal/40 text-gray-300 text-xs px-3 py-1.5 rounded-sm hover:border-gold-400 transition-colors">
                                        {{ $note->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-500 font-light">None</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Heart Notes -->
                    <div class="relative overflow-hidden bg-gold-400/5 border border-gold-400/15 p-4 rounded-sm">
                        <div class="absolute top-0 left-0 w-2 h-full bg-gold-400/20"></div>
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-gold-400/80 tracking-widest uppercase block">
                                ❤️ {{ __('messages.middle_notes') }}
                            </span>
                            <div class="flex flex-wrap gap-2">
                                @forelse($perfume->middleNotes as $note)
                                    <span
                                        class="bg-matte-black/60 border border-charcoal/40 text-gray-300 text-xs px-3 py-1.5 rounded-sm hover:border-gold-400 transition-colors">
                                        {{ $note->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-500 font-light">None</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Base Notes -->
                    <div class="relative overflow-hidden bg-gold-400/5 border border-gold-400/10 p-4 rounded-sm">
                        <div class="absolute top-0 left-0 w-2 h-full bg-gold-400/10"></div>
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-gold-400/60 tracking-widest uppercase block">
                                🪵 {{ __('messages.base_notes') }}
                            </span>
                            <div class="flex flex-wrap gap-2">
                                @forelse($perfume->baseNotes as $note)
                                    <span
                                        class="bg-matte-black/60 border border-charcoal/40 text-gray-300 text-xs px-3 py-1.5 rounded-sm hover:border-gold-400 transition-colors">
                                        {{ $note->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-500 font-light">None</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats & Season/Occasion Grid -->
            <div class="bg-[#161618] border border-charcoal/60 p-6 sm:p-8 rounded-sm space-y-6">
                <h3
                    class="font-display font-bold text-white text-sm tracking-widest uppercase border-b border-charcoal/50 pb-4 flex items-center gap-2">
                    <span>ℹ️</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'تفاصيل عطرية' : 'Scent Specifications' }}</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs">
                    <!-- Year, Perfumer, Longevity, Sillage -->
                    <div class="space-y-4">
                        @if($perfume->year_launched)
                            <div class="flex justify-between border-b border-charcoal/40 pb-2">
                                <span
                                    class="text-gray-400 uppercase tracking-widest">{{ __('messages.year_launched') }}</span>
                                <span class="text-white font-bold">{{ $perfume->year_launched }}</span>
                            </div>
                        @endif
                        @if($perfume->perfumer)
                            <div class="flex justify-between border-b border-charcoal/40 pb-2">
                                <span class="text-gray-400 uppercase tracking-widest">{{ __('messages.perfumer') }}</span>
                                <span class="text-white font-bold">{{ $perfume->perfumer }}</span>
                            </div>
                        @endif
                        @if($perfume->longevity)
                            <div class="flex justify-between border-b border-charcoal/40 pb-2">
                                <span class="text-gray-400 uppercase tracking-widest">{{ __('messages.longevity') }}</span>
                                <span
                                    class="text-gold-400 font-bold uppercase tracking-wide">{{ str_replace('_', ' ', $perfume->longevity) }}</span>
                            </div>
                        @endif
                        @if($perfume->sillage)
                            <div class="flex justify-between border-b border-charcoal/40 pb-2">
                                <span class="text-gray-400 uppercase tracking-widest">{{ __('messages.sillage') }}</span>
                                <span class="text-gold-400 font-bold uppercase tracking-wide">{{ $perfume->sillage }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Season & Occasion -->
                    <div class="space-y-5">
                        @if($perfume->season)
                            <div class="space-y-2">
                                <span
                                    class="text-gray-400 uppercase tracking-widest block">{{ __('messages.season') }}</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($perfume->season as $season)
                                        <span
                                            class="bg-matte-black border border-charcoal/60 text-white px-3 py-1 rounded-sm uppercase tracking-widest text-[9px] font-bold">
                                            {{ $season }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($perfume->occasion)
                            <div class="space-y-2">
                                <span
                                    class="text-gray-400 uppercase tracking-widest block">{{ __('messages.occasion') }}</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($perfume->occasion as $occasion)
                                        <span
                                            class="bg-matte-black border border-charcoal/60 text-white px-3 py-1 rounded-sm uppercase tracking-widest text-[9px] font-bold">
                                            {{ $occasion }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description/Story Section -->
            <div class="space-y-4">
                <h3
                    class="font-display font-bold text-white text-sm tracking-widest uppercase border-b border-charcoal/50 pb-4 flex items-center gap-2">
                    <span>📖</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'قصة العطر' : 'The Fragrance Story' }}</span>
                </h3>
                <div class="prose prose-invert max-w-none text-gray-300 text-xs leading-relaxed font-light">
                    {!! $perfume->long_description !!}
                </div>
            </div>
        </div>
    </div>
</div>