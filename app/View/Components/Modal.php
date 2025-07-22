<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public string $id;
    public string $title;
    public string $size;
    public string $closeEvent;
    public string $closeText;
    public bool $showHeader;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id = 'modal',
        string $title = '',
        string $size = 'md',
        string $closeEvent = 'close',
        string $closeText = 'Tutup',
        bool $showHeader = true
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->closeEvent = $closeEvent;
        $this->closeText = $closeText;
        $this->showHeader = $showHeader;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
