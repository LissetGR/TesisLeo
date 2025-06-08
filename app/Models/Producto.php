<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    protected $fillable= ['nombre', 'u_medida', 'photo', 'id'];

    public function plans(){
        return $this->hasMany(Plan::class, 'id');
    }
    public function reals()
    {
        return $this->hasMany(Real::class);
    }

}
