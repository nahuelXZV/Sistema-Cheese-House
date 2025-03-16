<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboProducto extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // TODO RELATIONS
    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }

    public function productos()
    {
        return $this->belongsTo(Producto::class);
    }
}
