<?php

namespace App\Models;

use Dotenv\Parser\Parser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'hora',
        'monto_total',
        'estado',
        'descripcion',
        'tipo_pago',
        'proveedor_id',
        'user_id',
    ];

    // TODO VALIDATIONS
    static public $validate = [
        'compraArray.fecha' => 'required|date',
        'compraArray.hora' => 'required',
        'compraArray.monto_total' => 'required|numeric|min:0',
        'compraArray.estado' => 'required',
        'compraArray.descripcion' => 'min:3|max:255',
        'compraArray.tipo_pago' => 'required',
        'compraArray.proveedor_id' => 'required|numeric|min:1',
        'compraArray.productos' => 'required|array',
    ];
    static public $messages = [
        'compraArray.fecha.required' => 'La fecha es requerida',
        'compraArray.fecha.date' => 'La fecha debe ser una fecha',
        'compraArray.hora.required' => 'La hora es requerida',
        'compraArray.monto_total.required' => 'El monto total es requerido',
        'compraArray.monto_total.numeric' => 'El monto total debe ser numerico',
        'compraArray.monto_total.min' => 'El monto total debe ser mayor a 0',
        'compraArray.estado.required' => 'El estado es requerido',
        'compraArray.descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
        'compraArray.descripcion.max' => 'La descripcion debe tener maximo 255 caracteres',
        'compraArray.tipo_pago.required' => 'El tipo de pago es requerido',
        'compraArray.proveedor_id.required' => 'El proveedor es requerido',
        'compraArray.proveedor_id.numeric' => 'El proveedor debe ser numerico',
        'compraArray.proveedor_id.min' => 'El proveedor debe ser mayor a 0',
        'compraArray.productos.required' => 'Los productos son requeridos',
        'compraArray.productos.array' => 'Los productos deben ser un arreglo',
    ];

    static public $validateProductos = [
        'productosArray.ingrediente_id' => 'required_without:productosArray.producto_id',
        'productosArray.producto_id' => 'required_without:productosArray.ingrediente_id',
        'productosArray.cantidad' => 'required|numeric|min:0',
        'productosArray.precio_unidad' => 'required|numeric|min:0',
        'productosArray.monto_total' => 'required|numeric|min:0',
    ];
    static public $messageProductos = [
        'productosArray.ingrediente_id.required_without' => 'El ingrediente es requerido',
        'productosArray.producto_id.required_without' => 'El producto es requerido',
        'productosArray.cantidad.required' => 'La cantidad es requerida',
        'productosArray.cantidad.numeric' => 'La cantidad debe ser numerica',
        'productosArray.cantidad.min' => 'La cantidad debe ser mayor a 0',
        'productosArray.precio_unidad.required' => 'El precio por unidad es requerido',
        'productosArray.precio_unidad.numeric' => 'El precio por unidad debe ser numerico',
        'productosArray.precio_unidad.min' => 'El precio por unidad debe ser mayor a 0',
        'productosArray.monto_total.required' => 'El monto total es requerido',
        'productosArray.monto_total.numeric' => 'El monto total debe ser numerico',
        'productosArray.monto_total.min' => 'El monto total debe ser mayor a 0',
    ];

    // TODO RELATIONS
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalle_compras()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    // TODO FUNCTIONS
    static public function CreateNotaCompra(array $array)
    {
        $productos = $array['productos'];
        unset($array['productos']);
        $array['user_id'] = auth()->user()->id;
        $new = new NotaCompra($array);
        $new->save();
        foreach ($productos as $producto) {
            $detalleCompra = [
                'nota_compra_id' => $new->id,
                'cantidad' => $producto['cantidad'],
                'precio_unidad' => $producto['precio_unidad'],
                'monto_total' => $producto['monto_total'],
                'descripcion' => $producto['detalles'],
                'producto_id' => intval($producto['producto_id']) == 0 ? null : intval($producto['producto_id']),
                'ingrediente_id' => intval($producto['ingrediente_id']) == 0 ? null : intval($producto['ingrediente_id']),
            ];
            DetalleCompra::CreateDetalleCompra($detalleCompra);
        }
        return $new;
    }

    static public function UpdateNotaCompra($id, array $array)
    {
        $notaCompra = NotaCompra::find($id);

        $productos = $array['productos'];
        unset($array['productos']);

        $notaCompra->fill($array);
        $notaCompra->save();

        DetalleCompra::DeleteAllByNotaCompra($notaCompra->id);
        foreach ($productos as $producto) {
            $detalleCompra = [
                'nota_compra_id' => $notaCompra->id,
                'cantidad' => $producto['cantidad'],
                'precio_unidad' => $producto['precio_unidad'],
                'monto_total' => $producto['monto_total'],
                'descripcion' => $producto['detalles'],
                'producto_id' => intval($producto['producto_id']) == 0 ? null : intval($producto['producto_id']),
                'ingrediente_id' => intval($producto['ingrediente_id']) == 0 ? null : intval($producto['ingrediente_id']),
            ];
            DetalleCompra::CreateDetalleCompra($detalleCompra);
        }
        return $notaCompra;
    }

    static public function DeleteNotaCompra($id)
    {
        $notaCompra = NotaCompra::find($id);
        $notaCompra->delete();
        return $notaCompra;
    }

    static public function GetNotaCompras($attribute, $order, $paginate)
    {
        $notaCompras = NotaCompra::join('proveedors', 'nota_compras.proveedor_id', '=', 'proveedors.id')
            ->join('users', 'nota_compras.user_id', '=', 'users.id')
            ->select('nota_compras.*', 'proveedors.nombre_empresa as proveedor', 'users.name as usuario')
            ->orWhere('proveedors.nombre_empresa', 'LIKE', '%' . $attribute . '%')
            ->orWhere('users.name', 'LIKE', '%' . $attribute . '%')
            ->orWhere('nota_compras.fecha', 'LIKE', '%' . $attribute . '%')
            ->orWhere('nota_compras.hora', 'LIKE', '%' . $attribute . '%')
            ->orWhere('nota_compras.monto_total', 'LIKE', '%' . $attribute . '%')
            ->orWhere('nota_compras.estado', 'LIKE', '%' . $attribute . '%')
            ->orWhere('nota_compras.descripcion', 'LIKE', '%' . $attribute . '%')
            ->orWhere('nota_compras.tipo_pago', 'LIKE', '%' . $attribute . '%')
            ->orderBy('nota_compras.id', 'DESC')
            ->paginate($paginate);
        return $notaCompras;
    }

    static public function GetNotaCompra($id)
    {
        $notaCompra = NotaCompra::find($id);
        return $notaCompra;
    }

    static public function GetNotaComprasAll()
    {
        $notaCompras = NotaCompra::all();
        return $notaCompras;
    }

    static public function GetNotaCompraByProveedor($id)
    {
        $notaCompras = NotaCompra::where('proveedor_id', $id)->orderBy('id', 'DESC')
            ->paginate(10);
        return $notaCompras;
    }
}
