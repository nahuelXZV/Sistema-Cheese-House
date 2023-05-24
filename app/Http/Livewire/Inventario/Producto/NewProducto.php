<?php

namespace App\Http\Livewire\Inventario\Producto;

use App\Models\Producto;
use App\Models\Receta;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Request;

class NewProducto extends Component
{
    use WithFileUploads;

    public $productoArray = [];
    public $message = '';
    public $showMessage = false;
    public $foto;

    public function mount()
    {
        $this->productoArray = [
            'nombre' => '',
            'descripcion' => '',
            'precio' => 0,
            'tamaño' => '',
            'url_imagen' => '',
            'is_active' => 'true',
            'categoria' => '',
            'tipo_botella' => '',
            'stock' => 0,
            'stock_minimo' => 0,
            'stock_maximo' => 0,
            'receta_id' => '',
        ];
    }

    public function save()
    {
        if ($this->productoArray['categoria'] == 'Pizza' || $this->productoArray['categoria'] == 'Bebida')
            $this->validate(Producto::$validatePizzaPostre, Producto::$messagesPizzaPostre);
        else
            $this->validate(Producto::$validateBebidaOtro, Producto::$messagesBebidaOtro);

        $url = Request::getScheme() . '://' . Request::getHost();
        $this->productoArray['url_imagen'] =  $url . '/storage/' . $this->foto->store('public/productos', 'public');
        $new = Producto::CreateProducto($this->productoArray);
        if (!$new) {
            $this->message = 'Error al crear el ingrediente';
            $this->showMessage = true;
        }
        return redirect()->route('productos.list');
    }

    public function render()
    {
        $recetas = Receta::GetRecetasAll();
        return view('livewire.inventario.producto.new-producto', compact('recetas'));
    }
}
