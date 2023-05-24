<?php

namespace App\Http\Livewire\Sistema\Rol;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ListRol extends Component
{
    use WithPagination;
    public $attribute = '';
    public $message = '';
    public $showMessage = false;

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $rol = Role::find($id);
        $rol->delete();
        if ($rol) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }


    public function render()
    {
        $roles = Role::where('name', 'ILIKE', '%' . $this->attribute . '%')
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view('livewire.sistema.rol.list-rol', compact('roles'));
    }
}
