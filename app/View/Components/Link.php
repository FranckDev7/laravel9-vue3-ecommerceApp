<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public string $href;
    public string $color;
    public string $size;
    public bool $fullWidth;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $href = '#',
        string $color = 'primary',
        string $size = 'md',
        bool $fullWidth = false
    )
    {
        $this->href = $href;
        $this->color = $color;
        $this->size = $size;
        $this->fullWidth = $fullWidth;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string|\Closure|\Illuminate\View\View
     */
    public function render(): \Illuminate\Contracts\View\View|string|\Closure|\Illuminate\View\View
    {
        return view('components.link');
    }
}
