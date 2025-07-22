<?php

namespace App\View\Components\Dash;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $headers;

    /**
     * Create a new component instance.
     */
    public function __construct($headers = null)
    {
        $this->headers = $headers;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dash.table');
    }
}
