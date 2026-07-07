<?php

namespace App\Livewire;

use App\Models\Perfume;
use App\Services\CartService;
use Livewire\Component;

class ProductShow extends Component
{
    public Perfume $perfume;
    public int $quantity = 1;
    public string $activeImage = '';
    public string $successMessage = '';

    public function mount(string $slug): void
    {
        $this->perfume = Perfume::with([
            'brand',
            'images',
            'notes',
            'accords'
        ])->where('slug', $slug)->firstOrFail();

        $primaryImage = $this->perfume->images->firstWhere('is_primary', true) ?: $this->perfume->images->first();
        $this->activeImage = $primaryImage ? $primaryImage->image_path : '';
    }

    public function selectImage(string $path): void
    {
        $this->activeImage = $path;
    }

    public function incrementQuantity(): void
    {
        if ($this->quantity < 10) {
            $this->quantity++;
        }
    }

    public function decrementQuantity(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(CartService $cartService): void
    {
        if ($this->perfume->stock_status === 'out_of_stock') {
            return;
        }

        $cartService->add($this->perfume->id, $this->quantity);
        $this->dispatch('cartUpdated');

        $this->successMessage = __('messages.item_added');
    }

    public function render()
    {
        return view('livewire.product-show');
    }
}
