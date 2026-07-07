<header x-data="{ mobileMenuOpen: false }" class="fixed top-0 left-0 right-0 z-50 bg-matte-black/85 border-b border-charcoal/50 backdrop-blur-lg">
    <!-- Top Announcement Bar -->
    <div class="bg-gold-gradient text-black text-[10px] tracking-[0.15em] font-semibold py-2 text-center uppercase">
        {{ app()->getLocale() === 'ar' ? 'عينة تستر 1 مل مجانية مع كل عطر - الضمان الذهبي' : 'Free 1ml Tester with every fragrance - FRS Golden Guarantee' }}
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-85 transition-opacity">
                    <img src="{{ asset('uploads/logo.webp') }}" alt="FRS PERFUMES Logo" class="h-14 w-auto">
                    <span class="font-display text-sm sm:text-lg font-bold tracking-[0.15em] text-gold-400">FRS PERFUMES</span>
                </a>
            </div>

            <!-- Main Navigation Links (Fixed overlapping by using gap-8 instead of space-x) -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-xs uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('home') ? 'text-gold-400' : 'text-gray-300 hover:text-gold-400' }} transition-colors">
                    {{ __('messages.home') }}
                </a>
                <a href="{{ route('shop') }}" class="text-xs uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('shop') ? 'text-gold-400' : 'text-gray-300 hover:text-gold-400' }} transition-colors">
                    {{ __('messages.shop') }}
                </a>
                <a href="{{ route('brands') }}" class="text-xs uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('brands') ? 'text-gold-400' : 'text-gray-300 hover:text-gold-400' }} transition-colors">
                    {{ app()->getLocale() === 'ar' ? 'العلامات التجارية' : 'Brands' }}
                </a>
                <a href="{{ route('cart') }}" class="text-xs uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('cart') ? 'text-gold-400' : 'text-gray-300 hover:text-gold-400' }} transition-colors">
                    {{ __('messages.cart') }}
                </a>
            </nav>

            <!-- Actions (Lang Switcher & Cart) -->
            <div class="flex items-center gap-6">
                <!-- Language Switcher -->
                <a href="{{ route('lang.switch', __('messages.language_code')) }}" class="text-[9px] tracking-[0.15em] font-bold border border-gold-400/30 text-gold-400 px-3 py-1.5 hover:bg-gold-gradient hover:text-black hover:border-transparent transition-all rounded-sm uppercase">
                    {{ __('messages.language') }}
                </a>

                <!-- Cart Icon -->
                <a href="{{ route('cart') }}" class="relative group p-2 text-gray-300 hover:text-gold-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    
                    @if($cartCount > 0)
                        <span class="absolute top-0 right-0 flex h-4.5 w-4.5 items-center justify-center rounded-full bg-gold-400 text-[9px] font-bold text-black animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-300 hover:text-gold-400 focus:outline-none transition-colors p-2" aria-label="Toggle mobile menu">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileMenuOpen" style="display: none;" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden bg-matte-black/95 border-t border-charcoal/60 px-6 py-6 space-y-4 backdrop-blur-lg"
         style="display: none;">
        <nav class="flex flex-col gap-2">
            <a href="{{ route('home') }}" class="text-sm uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('home') ? 'text-gold-400' : 'text-gray-300' }} hover:text-gold-400 transition-colors py-3 border-b border-charcoal/30 block">
                {{ __('messages.home') }}
            </a>
            <a href="{{ route('shop') }}" class="text-sm uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('shop') ? 'text-gold-400' : 'text-gray-300' }} hover:text-gold-400 transition-colors py-3 border-b border-charcoal/30 block">
                {{ __('messages.shop') }}
            </a>
            <a href="{{ route('brands') }}" class="text-sm uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('brands') ? 'text-gold-400' : 'text-gray-300' }} hover:text-gold-400 transition-colors py-3 border-b border-charcoal/30 block">
                {{ app()->getLocale() === 'ar' ? 'العلامات التجارية' : 'Brands' }}
            </a>
            <a href="{{ route('cart') }}" class="text-sm uppercase tracking-[0.15em] font-semibold {{ request()->routeIs('cart') ? 'text-gold-400' : 'text-gray-300' }} hover:text-gold-400 transition-colors py-3 block">
                {{ __('messages.cart') }}
            </a>
        </nav>
    </div>
</header>
