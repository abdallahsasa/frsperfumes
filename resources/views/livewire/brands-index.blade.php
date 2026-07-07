<div class="bg-matte-black text-gray-200 min-h-screen pt-32 pb-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center space-y-4 mb-16 animate-fade-in-up">
            <span class="text-gold-400 tracking-[0.3em] text-xs font-bold uppercase">
                {{ app()->getLocale() === 'ar' ? 'العلامات التجارية الفاخرة' : 'EXQUISITE FRAGRANCE HOUSES' }}
            </span>
            <h1 class="font-display text-4xl sm:text-5xl md:text-6xl font-bold text-white tracking-wide">
                {{ app()->getLocale() === 'ar' ? 'دور العطور العالمية' : 'Our Partner Brands' }}
            </h1>
            <p class="text-gray-400 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed">
                {{ app()->getLocale() === 'ar' 
                    ? 'اكتشف مجموعتنا المختارة من أرقى دور العطور العالمية، حيث يلتقي الإبداع الفني مع المكونات النادرة لإنتاج تحف عطرية لا تُنسى.' 
                    : 'Discover our curated selection of the world\'s finest fragrance houses, where artistic vision meets rare ingredients to produce unforgettable olfactory masterpieces.' }}
            </p>
        </div>

        <!-- Brands Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12 animate-fade-in-up" style="animation-delay: 0.2s; animation-fill-mode: both;">
            @foreach($brands as $brand)
                <a href="{{ route('shop', ['brand' => $brand->slug]) }}" class="group block relative bg-[#161618] border border-charcoal/50 hover:border-gold-400/50 rounded-sm p-8 transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                    
                    <!-- Background Glow on Hover -->
                    <div class="absolute inset-0 bg-gradient-to-b from-gold-400/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-sm"></div>
                    
                    <div class="relative z-10 flex flex-col items-center text-center h-full">
                        <!-- Brand Logo -->
                        <div class="h-24 w-full flex items-center justify-center mb-6">
                            @if($brand->logo)
                                <img src="{{ asset('uploads/' . $brand->logo) }}" alt="{{ $brand->name }}" class="max-h-full max-w-full object-contain filter drop-shadow-md group-hover:scale-105 transition-transform duration-500">
                            @else
                                <span class="font-display text-3xl font-bold text-gray-500 uppercase tracking-widest group-hover:text-gold-400 transition-colors">
                                    {{ $brand->name }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Brand Details -->
                        <div class="mt-auto space-y-4">
                            <h2 class="font-display text-2xl font-bold text-white tracking-wide group-hover:text-gold-400 transition-colors">
                                {{ $brand->name }}
                            </h2>
                            <p class="text-xs text-gray-400 font-light leading-relaxed line-clamp-3">
                                {{ $brand->description ?? (app()->getLocale() === 'ar' ? 'اكتشف أحدث ابتكارات هذه الدار العريقة.' : 'Explore the latest creations from this esteemed house.') }}
                            </p>
                            
                            <!-- Call to Action Link -->
                            <div class="pt-4 inline-flex items-center gap-2 text-xs font-semibold tracking-widest text-gold-400 uppercase group-hover:text-gold-300 transition-colors">
                                <span>{{ app()->getLocale() === 'ar' ? 'عرض عطور الدار' : 'View Collection' }}</span>
                                <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-300">&rarr;</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($brands->isEmpty())
            <div class="text-center py-24 text-gray-500 animate-fade-in-up">
                <p class="text-lg font-light">{{ app()->getLocale() === 'ar' ? 'لم يتم العثور على أي علامات تجارية.' : 'No brands found.' }}</p>
            </div>
        @endif
        
    </div>
</div>
