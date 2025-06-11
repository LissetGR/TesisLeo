<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Real extends Model
{
    use HasFactory;

    protected $fillable = ['mes', 'anno', 'productos_id', 'cantidad', 'precio'];

    public function productos()
    {
        return $this->belongsTo(Producto::class,'productos_id');
    }
}
