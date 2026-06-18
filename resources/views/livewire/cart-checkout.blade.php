<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="border-b border-charcoal pb-6 mb-8 text-center sm:text-left rtl:sm:text-right">
        <h1 class="font-display text-2xl sm:text-4xl font-bold text-white tracking-wide uppercase">
            {{ __('messages.your_cart') }}
        </h1>
    </div>

    @if(empty($cartItems))
        <!-- Empty Cart -->
        <div class="border border-charcoal bg-[#161618] rounded-sm py-20 px-4 text-center space-y-4">
            <svg class="mx-auto h-16 w-16 text-gray-600 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <h3 class="font-display text-lg font-bold text-white tracking-wide">
                {{ __('messages.cart_empty') }}
            </h3>
            <div class="pt-2">
                <a href="{{ route('shop') }}" class="inline-block bg-gold-gradient text-black font-semibold text-xs tracking-widest uppercase px-8 py-3 hover:opacity-90 transition-opacity rounded-sm">
                    {{ app()->getLocale() === 'ar' ? 'الذهاب للمتجر' : 'Continue Shopping' }}
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- LEFT: Cart Items (2 Cols) -->
            <div class="lg:col-span-2 space-y-4">
                @if (session()->has('message'))
                    <div class="bg-gold-400/10 border border-gold-400/40 text-gold-400 text-xs px-4 py-3 rounded-sm">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="border border-charcoal bg-[#161618] rounded-sm divide-y divide-charcoal">
                    @foreach($cartItems as $id => $item)
                        <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                            <!-- Image and Details -->
                            <div class="flex items-center space-x-4 rtl:space-x-reverse w-full sm:w-auto">
                                <div class="h-20 w-20 bg-[#0f0f10] border border-charcoal rounded-sm overflow-hidden flex-shrink-0 flex items-center justify-center p-2">
                                    @if($item['image'])
                                        <img src="{{ asset('uploads/' . $item['image']) }}" alt="{{ $item['name_' . app()->getLocale()] }}" class="h-full w-full object-contain">
                                    @else
                                        <svg class="h-8 w-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                    @endif
                                </div>
                                
                                <div class="space-y-1">
                                    <span class="text-[9px] uppercase tracking-wider text-gold-400 font-semibold">
                                        {{ $item['brand_' . app()->getLocale()] }}
                                    </span>
                                    <h3 class="font-display font-bold text-white text-sm tracking-wide">
                                        {{ $item['name_' . app()->getLocale()] }}
                                    </h3>
                                    <div class="flex space-x-3 rtl:space-x-reverse text-[10px] text-gray-400">
                                        <span>{{ $item['size_ml'] }} ml</span>
                                        <span>&bull;</span>
                                        <span>${{ number_format($item['price'], 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Qty & Price Actions -->
                            <div class="flex items-center justify-between sm:justify-end gap-8 w-full sm:w-auto border-t border-charcoal/50 pt-4 sm:pt-0 sm:border-0">
                                <!-- Qty -->
                                <div class="flex items-center border border-charcoal bg-matte-black rounded-sm">
                                    <button wire:click="decrementQty({{ $id }})" class="px-2 py-1 text-gray-400 hover:text-white transition-colors">&minus;</button>
                                    <span class="px-3 py-1 text-xs font-bold text-white w-8 text-center">{{ $item['quantity'] }}</span>
                                    <button wire:click="incrementQty({{ $id }})" class="px-2 py-1 text-gray-400 hover:text-white transition-colors">&plus;</button>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-right rtl:text-left min-w-[70px]">
                                    <span class="text-xs font-bold text-gold-400">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>

                                <!-- Remove -->
                                <button wire:click="removeItem({{ $id }})" class="text-gray-500 hover:text-red-400 transition-colors p-1" title="{{ __('messages.remove') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT: Pricing Summary & Checkout Form (1 Col) -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="border border-charcoal bg-[#161618] p-6 rounded-sm space-y-4">
                    <h3 class="font-display font-bold text-white text-base tracking-wider uppercase border-b border-charcoal pb-3">
                        {{ app()->getLocale() === 'ar' ? 'ملخص الحساب' : 'Order Summary' }}
                    </h3>

                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between text-gray-400">
                            <span>{{ __('messages.subtotal') }}</span>
                            <span class="text-white font-medium">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>{{ __('messages.shipping') }}</span>
                            <span class="text-white font-medium">${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-gold-400 pt-3 border-t border-charcoal">
                            <span>{{ __('messages.total') }}</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Guarantee Badge Callout -->
                    <div class="bg-gold-400/5 border border-gold-400/20 p-4 rounded-sm text-[11px] leading-relaxed text-gray-400 flex gap-2">
                        <span>🛡️</span>
                        <span>{{ __('messages.guarantee_desc') }}</span>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="border border-charcoal bg-[#161618] p-6 rounded-sm space-y-4">
                    <h3 class="font-display font-bold text-white text-base tracking-wider uppercase border-b border-charcoal pb-3">
                        {{ __('messages.checkout_details') }}
                    </h3>

                    <form wire:submit.prevent="placeOrder" class="space-y-4">
                        <!-- Full Name -->
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-gray-400 tracking-wider font-semibold">{{ __('messages.customer_name') }} <span class="text-red-400">*</span></label>
                            <input type="text" wire:model="customer_name" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2.5 rounded-sm outline-none transition-colors">
                            @error('customer_name') <span class="text-[10px] text-red-400 font-medium block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone & WhatsApp Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase text-gray-400 tracking-wider font-semibold">{{ __('messages.phone') }} <span class="text-red-400">*</span></label>
                                <input type="text" wire:model="phone" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2.5 rounded-sm outline-none transition-colors">
                                @error('phone') <span class="text-[10px] text-red-400 font-medium block">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase text-gray-400 tracking-wider font-semibold">{{ __('messages.whatsapp') }} <span class="text-red-400">*</span></label>
                                <input type="text" wire:model="whatsapp" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2.5 rounded-sm outline-none transition-colors">
                                @error('whatsapp') <span class="text-[10px] text-red-400 font-medium block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- City & Area Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase text-gray-400 tracking-wider font-semibold">{{ __('messages.city') }} <span class="text-red-400">*</span></label>
                                <input type="text" wire:model="city" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2.5 rounded-sm outline-none transition-colors">
                                @error('city') <span class="text-[10px] text-red-400 font-medium block">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase text-gray-400 tracking-wider font-semibold">{{ __('messages.area') }} <span class="text-red-400">*</span></label>
                                <input type="text" wire:model="area" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2.5 rounded-sm outline-none transition-colors">
                                @error('area') <span class="text-[10px] text-red-400 font-medium block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Full Address -->
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-gray-400 tracking-wider font-semibold">{{ __('messages.full_address') }} <span class="text-red-400">*</span></label>
                            <textarea wire:model="full_address" rows="3" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2.5 rounded-sm outline-none transition-colors"></textarea>
                            @error('full_address') <span class="text-[10px] text-red-400 font-medium block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Delivery Notes -->
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-gray-400 tracking-wider font-semibold">{{ __('messages.notes') }}</label>
                            <textarea wire:model="notes" rows="2" class="w-full bg-matte-black border border-charcoal focus:border-gold-400/50 text-white text-xs px-3 py-2.5 rounded-sm outline-none transition-colors"></textarea>
                            @error('notes') <span class="text-[10px] text-red-400 font-medium block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" wire:loading.attr="disabled" class="w-full bg-gold-gradient text-black font-bold text-xs tracking-widest uppercase py-3.5 hover:opacity-90 hover:scale-[1.01] transition-all rounded-sm flex items-center justify-center space-x-2 rtl:space-x-reverse">
                            <span wire:loading.remove>📲</span>
                            <span wire:loading.remove>{{ __('messages.place_order') }}</span>
                            
                            <span wire:loading class="h-4 w-4 border-2 border-black border-t-transparent rounded-full animate-spin"></span>
                            <span wire:loading>{{ __('messages.order_processing') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
