<?php

namespace App\Http\Livewire\Inventario\Receta;

use App\Models\Ingrediente;
use App\Models\Receta;
use Livewire\Component;

class EditReceta extends Component
{
    public $recetaArray = [];
    public $ingredienteArray = [];
    public $message = '';
    public $showMessage = false;
    public $ingredientes = [];
    public $receta;
    private $validateIngrediente = [
        'ingredienteArray.ingrediente_id' => 'required',
        'ingredienteArray.cantidad' => 'required|numeric|min:0'
    ];
    private $messagesIngrediente = [
        'ingredienteArray.ingrediente_id.required' => 'El ingrediente es requerido',
        'ingredienteArray.cantidad.required' => 'La cantidad es requerida',
        'ingredienteArray.cantidad.numeric' => 'La cantidad debe ser numerica',
        'ingredienteArray.cantidad.min' => 'La cantidad debe ser mayor a 0',
    ];

    public function mount($receta)
    {
        $this->receta = Receta::GetReceta($receta);
        $this->ingredientes = Ingrediente::GetIngredientesAll()->toArray();
        $this->recetaArray = [
            'nombre' => $this->receta->nombre,
            'costo_total' => 0.00,
            'descripcion' => $this->receta->descripcion,
            'ingredientes' => []
        ];
        $this->ingredienteArray = [
            "ingrediente_id" => '',
            "nombre" => '',
            "cantidad" => '',
            "unidad" => '',
            "precio_unidad" => 0.00
        ];
        foreach ($this->receta->ingredientes as $ingrediente) {
            $this->ingredienteArray = [
                "ingrediente_id" => $ingrediente->id,
                "cantidad" => $ingrediente->pivot->cantidad,
            ];
            $this->addIngrediente();
        }
    }

    public function save()
    {
        $this->validate(Receta::$validate, Receta::$messages);
        $new = Receta::UpdateReceta($this->receta->id, $this->recetaArray);
        if (!$new) {
            $this->message = 'Error al actualizar la receta';
            $this->showMessage = true;
        }
        return redirect()->route('recetas.list');
    }


    public function addIngrediente()
    {
        $this->validate($this->validateIngrediente, $this->messagesIngrediente);
        $ingrediente = Ingrediente::GetIngrediente($this->ingredienteArray['ingrediente_id']);
        $this->ingredienteArray['nombre'] = $ingrediente->nombre;
        $this->ingredienteArray['unidad'] = $ingrediente->unidad;
        $this->ingredienteArray['precio_unidad'] = $ingrediente->precio_unidad;
        array_push($this->recetaArray['ingredientes'], $this->ingredienteArray);
        $this->ingredientes = array_filter($this->ingredientes, function ($item) {
            return $item['id'] != $this->ingredienteArray['ingrediente_id'];
        });
        $this->recetaArray['costo_total'] += $this->ingredienteArray['cantidad'] * $this->ingredienteArray['precio_unidad'];
        $this->ingredienteArray = [
            "ingrediente_id" => '',
            "nombre" => '',
            "cantidad" => '',
            "unidad" => '',
            "precio_unidad" => ''
        ];
    }

    public function deleteIngrediente($id, $cantidad)
    {
        $ingrediente = Ingrediente::GetIngrediente($id);
        $this->recetaArray['costo_total'] -= $cantidad * $ingrediente->precio_unidad;
        $this->recetaArray['ingredientes'] = array_filter($this->recetaArray['ingredientes'], function ($item) use ($id) {
            return $item['ingrediente_id'] != $id;
        });
        array_push($this->ingredientes, $ingrediente);
    }


    public function render()
    {
        return view('livewire.inventario.receta.edit-receta');
    }
}
