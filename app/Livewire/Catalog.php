<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Perfume;
use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\Url;

class Catalog extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'brand')]
    public string $selectedBrand = '';

    #[Url(as: 'gender')]
    public string $selectedGender = '';

    #[Url(as: 'concentration')]
    public string $selectedConcentration = '';

    #[Url(as: 'season')]
    public string $selectedSeason = '';

    #[Url(as: 'sort')]
    public string $sortBy = 'featured';

    public string $successMessage = '';

    public function resetFilters(): void
    {
        $this->reset(['search', 'selectedBrand', 'selectedGender', 'selectedConcentration', 'selectedSeason', 'sortBy']);
    }

    public function quickAddToCart(int $perfumeId, CartService $cartService): void
    {
        $perfume = Perfume::find($perfumeId);

        if (!$perfume || $perfume->stock_status === 'out_of_stock') {
            return;
        }

        $cartService->add($perfume->id, 1);
        $this->dispatch('cartUpdated');

        $this->successMessage = __('messages.item_added');
    }

    public function render()
    {
        $query = Perfume::with(['brand', 'images', 'dupe'])
            ->where('is_active', true);

        // Apply Search Filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name_en', 'like', '%' . $this->search . '%')
                  ->orWhere('name_ar', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description_en', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description_ar', 'like', '%' . $this->search . '%')
                  ->orWhere('perfumer', 'like', '%' . $this->search . '%')
                  ->orWhereHas('brand', function ($b) {
                      $b->where('name_en', 'like', '%' . $this->search . '%')
                        ->orWhere('name_ar', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply Brand Filter
        if (!empty($this->selectedBrand)) {
            $query->whereHas('brand', function ($b) {
                $b->where('slug', $this->selectedBrand);
            });
        }

        // Apply Gender Filter
        if (!empty($this->selectedGender)) {
            $query->where('gender', $this->selectedGender);
        }

        // Apply Concentration Filter
        if (!empty($this->selectedConcentration)) {
            $query->where('concentration', $this->selectedConcentration);
        }

        // Apply Season Filter
        if (!empty($this->selectedSeason)) {
            $query->whereJsonContains('season', $this->selectedSeason);
        }

        // Apply Sorting
        if ($this->sortBy === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sortBy === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($this->sortBy === 'year_desc') {
            $query->orderBy('year_launched', 'desc');
        } else {
            // Featured / Default sorting
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
        }

        $perfumes = $query->get();
        $brands = Brand::where('is_active', true)->get();

        $activeFilterCount = collect([
            $this->search,
            $this->selectedBrand,
            $this->selectedGender,
            $this->selectedConcentration,
            $this->selectedSeason,
        ])->filter(fn ($val) => !empty($val))->count();

        return view('livewire.catalog', [
            'perfumes' => $perfumes,
            'brands' => $brands,
            'activeFilterCount' => $activeFilterCount,
        ]);
    }
}
