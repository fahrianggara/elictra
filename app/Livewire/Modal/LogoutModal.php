<?php

namespace App\Livewire\Modal;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class LogoutModal extends Component
{
    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.logout-modal');
    }

    /**
     * Logout method to handle user logout.
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout(); // Log out the user
        return redirect()->route('login');
    }
}
