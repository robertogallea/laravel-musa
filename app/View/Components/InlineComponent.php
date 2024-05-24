<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InlineComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $text)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return "
<div>
    <h1 style=\"color: indigo\">{$this->text}</h1>
</div>";
    }
}
