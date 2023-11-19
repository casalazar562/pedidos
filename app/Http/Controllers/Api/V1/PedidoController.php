<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Cuenta\PedidoRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PedidoController extends Controller
{
    protected $repository;

    public function __construct(PedidoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    private function getOrderParams(): array
    {
        return request()->only('idCuenta', 'product', 'amount', 'value', 'total');
    }

    public function all()
    {
        $counts = $this->repository->list();
        if ($counts->isEmpty()) {
            return new JsonResponse([
                'data' => $counts,
                'message' => 'No hay pedidos'
            ], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse([
            'data' => $counts
        ], Response::HTTP_OK);
    }

    public function create(PedidoRequest $request)
    {
        $data = $this->getOrderParams();
        DB::beginTransaction();
        try {
            $count = $this->repository->create($data);
            DB::commit();
            return new JsonResponse([
                'data' => $count,
                'message' => 'Pedido Agregado Correctamente'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR CREATE ORDER.', $response);
            DB::rollBack();
            return new JsonResponse([
                'response' => $response
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(PedidoRequest $request, $id)
    {
        Log::info($request);
        $data = $this->getOrderParams();
        DB::beginTransaction();
        try {
            $count = $this->repository->update($data, $id);
            DB::commit();
            return new JsonResponse([
                'data' => $count,
                'message' => 'Pedido Actualizado Correctamente.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR UPDATE ORDER.', $response);
            DB::rollBack();
            return new JsonResponse([
                'response' => $response
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function find($id)
    {
        $count = $this->repository->find($id);
        return new JsonResponse([
            'data' => $count
        ], Response::HTTP_OK);
    }


    public function delete($id)
    {
        $this->repository->delete($id);
        return new JsonResponse([
            'message' => 'Pedido Eliminado Correctamente.'
        ], Response::HTTP_OK);
    }
}
