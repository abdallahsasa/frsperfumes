<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    class="h-full bg-luxury-gradient text-gray-200 antialiased selection:bg-gold-400 selection:text-black">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\Setting::getValue('site_title_' . app()->getLocale(), 'FRS Perfumes') }}</title>
    <meta name="description"
        content="{{ \App\Models\Setting::getValue('brand_story_' . app()->getLocale(), 'FRS Perfumes Luxury Fragrances') }}">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- SEO Meta tags -->
    <meta property="og:title"
        content="{{ \App\Models\Setting::getValue('site_title_' . app()->getLocale(), 'FRS Perfumes') }}">
    <meta property="og:description"
        content="{{ \App\Models\Setting::getValue('brand_story_' . app()->getLocale(), 'FRS Perfumes Luxury Fragrances') }}">
    <meta property="og:type" content="website">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex min-h-full flex-col bg-luxury-gradient text-gray-200">
    <!-- Header component -->
    <livewire:header />

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-charcoal bg-[#0a0a0a] py-12 text-gray-400">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <!-- Branding & Story -->
                <div class="col-span-1 md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('uploads/logo.webp') }}" alt="FRS PERFUMES Logo" class="h-10 w-auto">
                        <span class="font-display text-xl font-bold tracking-widest text-gold-400">FRS PERFUMES</span>
                    </div>
                    <p class="text-sm max-w-md">
                        {{ \App\Models\Setting::getValue('brand_story_' . app()->getLocale(), 'FRS Perfumes brings you the finest selection of premium niche and designer fragrances.') }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-display font-semibold text-white tracking-wider mb-4">
                        {{ app()->getLocale() === 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-gold-400 transition-colors">
                                {{ __('messages.home') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop') }}" class="hover:text-gold-400 transition-colors">
                                {{ __('messages.shop') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart') }}" class="hover:text-gold-400 transition-colors">
                                {{ __('messages.cart') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Guarantee & Contact -->
                <div>
                    <h3 class="font-display font-semibold text-white tracking-wider mb-4">{{ __('messages.guarantee') }}
                    </h3>
                    <p class="text-xs leading-relaxed mb-4">
                        {{ app()->getLocale() === 'ar' ? 'كل زجاجة عطر تأتي مع عينة تستر 1 مل لتجربتها قبل فتح العبوة.' : 'Each bottle includes a 1ml tester to try the fragrance before opening.' }}
                    </p>
                    <div
                        class="text-xs text-gold-400 border border-gold-400/30 bg-gold-400/5 px-3 py-2 rounded-sm inline-block">
                        ✨ {{ __('messages.guarantee') }}
                    </div>
                </div>
            </div>

            <div
                class="mt-8 border-t border-charcoal pt-8 flex flex-col md:flex-row items-center justify-between text-xs">
                <p>&copy; {{ date('Y') }} FRS Perfumes. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex items-center gap-4 text-gold-400">
                    <span>Designed for luxury</span>
                    <span>&bull;</span>
                    <span>Made by <a href="https://threedigitsoftware.com" target="_blank"
                            class="underline hover:text-white transition-colors">Threedigitsoftware</a></span>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>