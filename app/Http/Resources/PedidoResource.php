<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'idPedido' => $this->idPedido,
            'idCuenta' => $this->idCuenta,
            'product' => $this->product,
            'amount' => $this->amount,
            'value' => $this->value,           
            'total' => $this->total,           
        ];
    }
}
