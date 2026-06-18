<?php

namespace App\Services;

use App\Models\Perfume;

class CartService
{
    public function get(): array
    {
        return session()->get('cart', []);
    }

    public function add(int $perfumeId, int $quantity = 1): void
    {
        $cart = $this->get();
        $perfume = Perfume::with('brand', 'images')->find($perfumeId);

        if (!$perfume) {
            return;
        }

        if (isset($cart[$perfumeId])) {
            $cart[$perfumeId]['quantity'] += $quantity;
        } else {
            $primaryImage = $perfume->images->firstWhere('is_primary', true) ?: $perfume->images->first();
            $cart[$perfumeId] = [
                'id' => $perfume->id,
                'name_en' => $perfume->name_en,
                'name_ar' => $perfume->name_ar,
                'brand_en' => $perfume->brand->name_en,
                'brand_ar' => $perfume->brand->name_ar,
                'price' => (float) $perfume->price,
                'size_ml' => $perfume->size_ml,
                'image' => $primaryImage ? $primaryImage->image_path : null,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);
    }

    public function remove(int $perfumeId): void
    {
        $cart = $this->get();

        if (isset($cart[$perfumeId])) {
            unset($cart[$perfumeId]);
            session()->put('cart', $cart);
        }
    }

    public function update(int $perfumeId, int $quantity): void
    {
        $cart = $this->get();

        if (isset($cart[$perfumeId]) && $quantity > 0) {
            $cart[$perfumeId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        } elseif (isset($cart[$perfumeId]) && $quantity <= 0) {
            $this->remove($perfumeId);
        }
    }

    public function clear(): void
    {
        session()->forget('cart');
    }

    public function count(): int
    {
        $cart = $this->get();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function total(): float
    {
        $cart = $this->get();
        $total = 0.0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
