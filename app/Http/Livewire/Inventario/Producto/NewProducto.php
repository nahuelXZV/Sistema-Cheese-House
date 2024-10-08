<?php

namespace App\Http\Livewire\Inventario\Producto;

use App\Constants\CategoriasProductos;
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
    private $validateFoto = ['foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg'];
    private $messagesFoto = ['foto.image' => 'La foto debe ser una imagen', 'foto.mimes' => 'La foto debe ser de tipo jpeg,png,jpg,gif,svg', 'foto.required' => 'La foto es requerida'];

    public $listaCategorias = [];

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
            'pedidos_ya' => false,
            'receta_id' => null,
        ];
        $this->listaCategorias = CategoriasProductos::all();
    }

    public function save()
    {
        $this->validate($this->validateFoto, $this->messagesFoto);
        $validate = $this->productoArray['categoria'] == CategoriasProductos::PIZZA || $this->productoArray['categoria'] == CategoriasProductos::POSTRE || $this->productoArray['categoria'] == CategoriasProductos::MITAD;
        if ($validate) {
            $this->validate(Producto::$validatePizzaPostre, Producto::$messagesPizzaPostre);
        } else {
            $this->validate(Producto::$validateBebidaOtro, Producto::$messagesBebidaOtro);
        }
        $url = Request::getScheme() . '://' . Request::getHost();
        $this->productoArray['url_imagen'] =  $url . '/storage/' . $this->foto->store('public/productos', 'public');
        $new = Producto::CreateProducto($this->productoArray);
        if (!$new) {
            $this->message = 'Error al crear el producto';
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
