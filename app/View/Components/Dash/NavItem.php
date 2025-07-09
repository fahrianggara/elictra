<?php

namespace App\View\Components\Dash;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavItem extends Component
{
    public $href;
    public $icon;
    public $active;
    public $isRoute;

    /**
     * Create a new component instance.
     */
    public function __construct($href, $icon)
    {
        $this->href = $href;
        $this->icon = $icon;

        $uris = explode(',', $href);
        $this->isRoute = !str_starts_with(trim($uris[0]), '#') &&
            !str_starts_with(trim($uris[0]), 'javascript:') &&
            !str_contains($uris[0], '/'); // dianggap bukan route kalau ada slash langsung

        $this->active = setActive(...$uris) ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dash.nav-item');
    }
}
