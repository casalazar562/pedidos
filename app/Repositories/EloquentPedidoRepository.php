<?php

namespace App\Repositories;

use App\Contracts\Cuenta\PedidoRepositoryInterface;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;

class EloquentPedidoRepository implements PedidoRepositoryInterface
{

    public function __construct(private Pedido $model)
    {
        $this->model = $model;
    }


    public function list()
    {
        $order = Pedido::all();
        return PedidoResource::collection($order);
    }

    public function create(array $data)
    {
        $order = Pedido::create([
            'idCuenta' => $data['idCuenta'],
            'product' => $data['product'],
            'amount' => $data['amount'],
            'value' => $data['value'],
            'total' => $data['total'],
        ]);
        return new PedidoResource($order);
    }

    public function update(array $data, int $idPedido)
    {
        $order = $this->model->find($idPedido);

        $order->update([
            'idCuenta' => $data['idCuenta'],
            'product' => $data['product'],
            'amount' => $data['amount'],
            'value' => $data['value'],
            'total' => $data['total'],
        ]);
        return new PedidoResource($order);
    }

    public function delete(int $id)
    {
        $this->model->find($id);
        return Pedido::destroy($id);
    }

    public function find(int $id)
    {
        $order = $this->model->find($id);
        return new PedidoResource($order);
    }
}
