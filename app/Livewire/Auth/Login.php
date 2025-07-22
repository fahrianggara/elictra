<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.auth.login')->layout('auth')->title('Login');
    }
}
