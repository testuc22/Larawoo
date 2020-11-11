<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductCombinations extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $productV;
    public $data;
    public function __construct($product,$data)
    {
        $this->productV=$product->productVariants;
        $this->data=$this->getProductVariations();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('back.components.product-combinations');
    }

    public function getProductVariations()
    {
        return $this->productV[0]->id;
    }
}
