<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $role = 'admin';
    public $status = 'active';

    public function render()
    {
      
        return view('livewire.user-management', [
            'users' => User::paginate(10),
        ]);
    }

    public function updateStatus(User $user, $status)
    {
        $user->update(['status' => $status]);
    }

    public function updateRole(User $user, $role)
    {
        $user->update(['role' => $role]);
    }
}
