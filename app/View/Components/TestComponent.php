<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TestComponent extends Component
{
    public string $type;
    public string $value;

    public int $number;
    public mixed $numberOfIterations;

    /**
     * Create a new component instance.
     */
    public function __construct($type = null, $value = null, $numberOfIterations = null)
    {
        $this->type = strtoupper($type);
        $this->value = strtoupper($value);
        $this->number = rand(1,10);
        $this->numberOfIterations = $numberOfIterations;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.test-component');
    }
}
