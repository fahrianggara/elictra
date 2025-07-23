<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Security extends Component
{
    public $user;
    public $password;
    public $password_confirmation;

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->user = Auth::user();
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.settings.security')
            ->layout('dash')->title('Pengaturan Keamanan');
    }
}
