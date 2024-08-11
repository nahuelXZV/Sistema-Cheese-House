<?php

namespace App\Http\Livewire\Inventario\Producto;

use App\Constants\CategoriasProductos;
use App\Models\Producto;
use App\Models\Receta;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Request;

class EditProducto extends Component
{
    use WithFileUploads;

    public $productoArray = [];
    public $message = '';
    public $showMessage = false;
    public $listaCategorias = [];
    public $foto;
    public $producto;
    private $validateFoto = ['foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'];
    private $messagesFoto = ['foto.image' => 'La foto debe ser una imagen', 'foto.mimes' => 'La foto debe ser de tipo jpeg,png,jpg,gif,svg'];

    public function mount($producto)
    {
        $this->producto = Producto::GetProducto($producto);
        $this->productoArray = [
            'nombre' => $this->producto->nombre,
            'descripcion' => $this->producto->descripcion,
            'precio' => $this->producto->precio,
            'tamaño' => $this->producto->tamaño,
            'url_imagen' => $this->producto->url_imagen,
            'is_active' => $this->producto->is_active,
            'categoria' => $this->producto->categoria,
            'tipo_botella' => $this->producto->tipo_botella,
            'stock' => $this->producto->stock,
            'stock_minimo' => $this->producto->stock_minimo,
            'stock_maximo' => $this->producto->stock_maximo,
            'receta_id' => $this->producto->receta_id,
        ];
        $this->listaCategorias = CategoriasProductos::all();
    }

    public function save()
    {
        $this->productoArray['is_active'] = $this->productoArray['is_active'] == 1 ? true : false;
        $this->validate($this->validateFoto, $this->messagesFoto);
        $validate = $this->productoArray['categoria'] == CategoriasProductos::PIZZA || $this->productoArray['categoria'] == CategoriasProductos::POSTRE || $this->productoArray['categoria'] == CategoriasProductos::MITAD;
        if ($validate) {
            $this->validate(Producto::$validatePizzaPostre, Producto::$messagesPizzaPostre);
        } else {
            $this->validate(Producto::$validateBebidaOtro, Producto::$messagesBebidaOtro);
        }
        if ($this->foto) {
            $url = Request::getScheme() . '://' . Request::getHost();
            $this->productoArray['url_imagen'] =  $url . '/storage/' . $this->foto->store('public/productos', 'public');
        }
        $new = Producto::UpdateProducto($this->producto->id, $this->productoArray);
        if (!$new) {
            $this->message = 'Error al crear el ingrediente';
            $this->showMessage = true;
        }
        return redirect()->route('productos.list');
    }

    public function render()
    {
        $recetas = Receta::GetRecetasAll();
        return view('livewire.inventario.producto.edit-producto', compact('recetas'));
    }
}
