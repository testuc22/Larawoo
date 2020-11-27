<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repositories\CategoryRepository;
class MainMenuCategories extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $mainMenuCategories;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $mainMenu=1;
        $this->mainMenuCategories=$categoryRepository->getMainMenuCategories();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.main-menu-categories');
    }
}
