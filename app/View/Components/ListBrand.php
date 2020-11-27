<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repositories\BrandRepository;
class ListBrand extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $brands;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brands=$brandRepository->getAllBrands();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.list-brand');
    }
}
