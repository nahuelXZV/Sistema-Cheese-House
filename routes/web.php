<?php

use App\Http\Livewire\Compra\Compra\EditCompra;
use App\Http\Livewire\Compra\Compra\ListCompra;
use App\Http\Livewire\Compra\Compra\NewCompra;
use App\Http\Livewire\Compra\Proveedor\EditProveedor;
use App\Http\Livewire\Compra\Proveedor\ListProveedor;
use App\Http\Livewire\Compra\Proveedor\NewProveedor;
use App\Http\Livewire\Example;
use App\Http\Livewire\Inventario\Ingrediente\EditIngrediente;
use App\Http\Livewire\Inventario\Ingrediente\ListIngrediente;
use App\Http\Livewire\Inventario\Ingrediente\NewIngrediente;
use App\Http\Livewire\Inventario\Ingrediente\ShowIngrediente;
use App\Http\Livewire\Inventario\Producto\EditProducto;
use App\Http\Livewire\Inventario\Producto\ListProducto;
use App\Http\Livewire\Inventario\Producto\NewProducto;
use App\Http\Livewire\Inventario\Receta\EditReceta;
use App\Http\Livewire\Inventario\Receta\ListReceta;
use App\Http\Livewire\Inventario\Receta\NewReceta;
use App\Http\Livewire\Inventario\Receta\ShowReceta;
use App\Http\Livewire\Sistema\Rol\EditRol;
use App\Http\Livewire\Sistema\Rol\ListRol;
use App\Http\Livewire\Sistema\Rol\NewRol;
use App\Http\Livewire\Sistema\Usuario\EditUsuario;
use App\Http\Livewire\Sistema\Usuario\ListUsuario;
use App\Http\Livewire\Sistema\Usuario\NewUsuario;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/example', Example::class)->name('example');

    // MODULO SISTEMA
    Route::group(['prefix' => 'usuario'], function () {
        Route::get('/list', ListUsuario::class)->name('usuario.list');
        Route::get('/new', NewUsuario::class)->name('usuario.new');
        Route::get('/edit/{usuario}', EditUsuario::class)->name('usuario.edit');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/list', ListRol::class)->name('roles.list');
        Route::get('/new', NewRol::class)->name('roles.new');
        Route::get('/edit/{rol}', EditRol::class)->name('roles.edit');
    });


    // MODULO INVENTARIO
    Route::group(['prefix' => 'ingredientes'], function () {
        Route::get('/list', ListIngrediente::class)->name('ingredientes.list');
        Route::get('/new', NewIngrediente::class)->name('ingredientes.new');
        Route::get('/edit/{ingrediente}', EditIngrediente::class)->name('ingredientes.edit');
        Route::get('/show/{ingrediente}', ShowIngrediente::class)->name('ingredientes.show');
    });

    Route::group(['prefix' => 'recetas'], function () {
        Route::get('/list', ListReceta::class)->name('recetas.list');
        Route::get('/new', NewReceta::class)->name('recetas.new');
        Route::get('/edit/{receta}', EditReceta::class)->name('recetas.edit');
        Route::get('/show/{receta}', ShowReceta::class)->name('recetas.show');
    });

    Route::group(['prefix' => 'productos'], function () {
        Route::get('/list', ListProducto::class)->name('productos.list');
        Route::get('/new', NewProducto::class)->name('productos.new');
        Route::get('/edit/{producto}', EditProducto::class)->name('productos.edit');
    });

    // MODULO COMPRAS
    Route::group(['prefix' => 'proveedores'], function () {
        Route::get('/list', ListProveedor::class)->name('proveedores.list');
        Route::get('/new', NewProveedor::class)->name('proveedores.new');
        Route::get('/edit/{proveedor}', EditProveedor::class)->name('proveedores.edit');
    });

    Route::group(['prefix' => 'compras'], function () {
        Route::get('/list', ListCompra::class)->name('compras.list');
        Route::get('/new', NewCompra::class)->name('compras.new');
        Route::get('/edit/{compra}', EditCompra::class)->name('compras.edit');
    });
});
