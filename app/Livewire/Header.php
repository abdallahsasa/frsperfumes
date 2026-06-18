<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\On;

class Header extends Component
{
    public int $cartCount = 0;

    public function mount(CartService $cartService): void
    {
        $this->cartCount = $cartService->count();
    }

    #[On('cartUpdated')]
    public function updateCartCount(CartService $cartService): void
    {
        $this->cartCount = $cartService->count();
    }

    public function render()
    {
        return view('livewire.header');
    }
}
