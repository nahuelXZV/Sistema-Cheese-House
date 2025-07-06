<?php

namespace App\Http\Livewire\Sistema\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;


class EditUsuario extends Component
{
    public $userArray = [];
    public $message = '';
    public $showMessage = false;
    public $usuario;

    public $roles = [];

    public function mount($usuario)
    {
        $this->usuario = User::findOrFail($usuario);
        $this->userArray = [
            'name' => $this->usuario->name,
            'email' => $this->usuario->email,
            'password' => '',
            'rol' => $this->usuario->roles()->first()->id ?: ''
        ];
        $this->roles = Role::all();
    }

    public function save()
    {
        $this->validate([
            'userArray.name' => 'required',
            'userArray.email' => 'required|email|unique:users,email,' . $this->usuario->id,
            'userArray.rol' => 'required'
        ], User::$messages);

        $user = User::findOrFail($this->usuario->id);
        $user->name = $this->userArray['name'];
        $user->email = $this->userArray['email'];

        if (!empty($this->userArray['password'])) {
            $user->password = Hash::make($this->userArray['password']);
        }

        $user->save();
        $user->syncRoles([$this->userArray['rol']]);

        return redirect()->route('usuario.list');
    }

    public function render()
    {
        return view('livewire.sistema.usuario.edit-usuario');
    }
}
