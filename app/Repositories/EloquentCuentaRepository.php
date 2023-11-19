<?php

namespace App\Repositories;

use App\Contracts\Cuenta\CuentaRepositoryInterface;
use App\Http\Resources\CuentaResource;
use App\Models\Cuenta;
use Ramsey\Uuid\Type\Integer;

class EloquentCuentaRepository implements CuentaRepositoryInterface
{
    public function __construct(private Cuenta $model)
    {
        $this->model = $model;
    }


    public function list()
    {
        $count = Cuenta::all();
        return CuentaResource::collection($count);
    }

    public function create(array $data)
    {

        $count = Cuenta::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
        ]);
        return new CuentaResource($count);
    }

    public function update(array $data, int $idCuenta)
    {
        $count = $this->model->find($idCuenta);

        $count->update(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'telephone' => $data['telephone'],
            ]
        );
        return new CuentaResource($count);
    }

    public function delete(int $id)
    {
        $this->model->find($id);
        return Cuenta::destroy($id);
    }

    public function find(int $id)
    {
        $count = $this->model->find($id);
        return new CuentaResource($count);
    }
}
