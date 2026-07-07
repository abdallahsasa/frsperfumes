<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class BrandsIndex extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', true)->orderBy('name_en')->get();
        return view('livewire.brands-index', [
            'brands' => $brands,
        ]);
    }
}

