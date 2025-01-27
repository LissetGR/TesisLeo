<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'producto'=> $this->productos->nombre,
             'cantidad'=>$this->cantidad,
             'precio'=>$this->precio,
             'mes'=>$this->mes,
             'anno'=>$this->anno,
        ];
    }
}
