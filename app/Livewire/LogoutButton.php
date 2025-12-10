<?php

namespace App\Livewire;

use Livewire\Component;use App\Livewire\Actions\Logout;
class LogoutButton extends Component
{
    public function logout(Logout $logoutAction)
    {
        $logoutAction();
        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.logout-button');
    }
}