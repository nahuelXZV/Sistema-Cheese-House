<?php

namespace App\Http\Livewire\Sistema\Rol;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditRol extends Component
{
    public $rol;
    public $name;
    public $permisosSeleccionados = [];
    public $arrayPermisos = [];

    public $messages = [
        'name.required' => 'El campo nombre es requerido',
        'name.unique' => 'El nombre ya existe',
        'permisosSeleccionados.required' => 'Debe seleccionar al menos un permiso',
        'permisosSeleccionados.array' => 'Debe seleccionar al menos un permiso',
        'permisosSeleccionados.min' => 'Debe seleccionar al menos un permiso'
    ];

    public function mount($rol)
    {
        $this->rol = Role::find($rol);
        $this->name = $this->rol->name;
        $this->arrayPermisos = $this->rol->getAllPermissions()->pluck('id')->toArray();
        foreach ($this->arrayPermisos as $permiso) {
            $this->permisosSeleccionados[$permiso] = $permiso;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->rol->id,
            'permisosSeleccionados' => 'required|array|min:1'
        ], $this->messages);
        $name = $this->name;
        $array = $this->permisosSeleccionados;
        try {
            DB::transaction(function () use ($name, $array) {
                $this->rol->name = $name;
                $this->rol->syncPermissions($array);
                $this->rol->save();
                return true;
            });
        } catch (\Throwable $th) { }
        return redirect()->route('roles.list');
    }

    public function render()
    {
        $permisos = Permission::all();
        return view('livewire.sistema.rol.edit-rol', compact('permisos'));
    }
}
