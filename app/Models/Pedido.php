<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPedido';
    protected $fillable = ['idCuenta', 'product', 'amount','value','total'];

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'idCuenta', 'idCuenta');
    }
}
