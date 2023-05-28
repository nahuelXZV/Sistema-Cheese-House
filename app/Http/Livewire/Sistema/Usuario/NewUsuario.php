<?php

namespace App\Http\Livewire\Sistema\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class NewUsuario extends Component
{
    public $userArray = [];
    public $message = '';
    public $showMessage = false;

    public $roles = [];

    public function mount()
    {
        $this->userArray = [
            'name' => '',
            'email' => '',
            'password' => '',
            'rol' => ''
        ];
        $this->roles = Role::all();
    }

    public function save()
    {
        $this->validate(User::$validate, User::$messages);
        $this->userArray['password'] = Hash::make($this->userArray['password']);
        $new = User::create($this->userArray);
        $new->assignRole($this->userArray['rol']);
        if (!$new) {
            $this->message = 'Error al crear el usuario';
            $this->showMessage = true;
        }
        return redirect()->route('usuario.list');
    }

    public function render()
    {
        return view('livewire.sistema.usuario.new-usuario');
    }
}
