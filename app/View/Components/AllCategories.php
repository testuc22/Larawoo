<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repositories\CategoryRepository;
class AllCategories extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $categories;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categories=$categoryRepository->getAllCategories();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.all-categories');
    }
}
