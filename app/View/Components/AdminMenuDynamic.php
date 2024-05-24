<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminMenuDynamic extends Component
{
    public array $menu;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menu = [
            [
                'route' => route('admin.posts.create'),
                'label' => 'Crea nuovo post',
            ],
            [
                'route' => route('posts.index'),
                'label' => 'Visualizza blog',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-menu-dynamic');
    }
}
