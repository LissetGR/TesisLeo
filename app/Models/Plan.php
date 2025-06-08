<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{

    protected $fillable= ['cantidad', 'precio', 'mes', 'anno', 'productos_id'];

    public function productos(){
        return $this->belongsTo(Producto::class);
    }
}
