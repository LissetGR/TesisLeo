<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'producto_nombre'=> $this->productos->nombre,
             'producto_unidad'=> $this->productos->u_medida,
             'cantidad'=>$this->cantidad,
             'precio'=>$this->precio,
             'mes'=>$this->mes,
             'anno'=>$this->anno,

        ];
    }
}
