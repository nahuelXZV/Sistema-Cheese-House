<?php

namespace App\Http\Livewire\Sistema\Usuario;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListUsuario extends Component
{
    use WithPagination;
    public $attribute = '';

    //Metodo de reinicio de buscador
    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::GetUsuarios($this->attribute, 'ASC', 20);
        return view('livewire.sistema.usuario.list-usuario', compact('users'));
    }
}
