<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Real extends Model
{
    protected $fillable= ['plans_id', 'cantidad', 'precio', 'mes', 'anno'];

    public function plans (){
        return $this->belongsTo(Plan::class, 'plans_id');
    }
}
