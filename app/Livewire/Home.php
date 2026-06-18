<?php

namespace App\Livewire;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Perfume;
use Livewire\Component;

class Home extends Component
{
    public $banners = [];
    public $featuredPerfumes = [];
    public $brands = [];

    public function mount(): void
    {
        $this->banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $this->featuredPerfumes = Perfume::with(['brand', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(8)
            ->get();

        $this->brands = Brand::where('is_active', true)
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.home');
    }
}
