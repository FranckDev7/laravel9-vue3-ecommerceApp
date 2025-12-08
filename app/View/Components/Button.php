<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public string $type;
    public string $color;
    public string $size;
    public bool $disabled;
    public bool $fullWidth;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'submit',
        string $color = 'primary',
        string $size = 'md',
        bool $disabled = false,
        bool $fullWidth = false
    ) {
        $this->type = $type;
        $this->color = $color;
        $this->size = $size;
        $this->disabled = $disabled;
        $this->fullWidth = $fullWidth;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('components.button');
    }
}
