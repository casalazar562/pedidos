<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Cuenta\{
    CuentaRepositoryInterface,
    PedidoRepositoryInterface
};
use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{
    DB,
    Http,
    Log
};
use Symfony\Component\HttpFoundation\Response;

class PedidoController extends Controller
{

    public function __construct(
        private PedidoRepositoryInterface $repositoryPedido,
        private CuentaRepositoryInterface $repositoryCliente
    ) {
    }

    private function getOrderParams(): array
    {
        return request()->only('idCuenta', 'product', 'amount', 'value', 'total');
    }

    /**
     * Retrieve all Pedido (Order) counts and return a JsonResponse.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $counts = $this->repositoryPedido->list();

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

    /**
     * Create a new Pedido (Order) using the provided data.
     *
     * @param PedidoRequest $request
     * @return JsonResponse
     */
    public function create(PedidoRequest $request): JsonResponse
    {
        $data = $this->getOrderParams();

        DB::beginTransaction();

        try {

            $order = $this->repositoryPedido->create($data);
            $cliente = $this->repositoryCliente->find($data['idCuenta']);

            $datosPedido = [
                'order' => $order,
                'cliente' => $cliente
            ];

            Http::post(env('WEBSOKET_SERVER') . "crear-pedido", [
                'json' => json_encode($datosPedido)
            ]);

            DB::commit();

            return new JsonResponse([
                'data' => $order,
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

    /**
     * Update a Pedido (Order) based on the provided request and order ID.
     *
     * @param PedidoRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PedidoRequest $request, $id)
    {
        Log::info($request);

        $data = $this->getOrderParams();

        DB::beginTransaction();

        try {
            $count = $this->repositoryPedido->update($data, $id);

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

    /**
     * Find a Pedido (Order) by its ID and return a JsonResponse.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function find($id): JsonResponse
    {
        $count = $this->repositoryPedido->find($id);

        return new JsonResponse([
            'data' => $count
        ], Response::HTTP_OK);
    }

    /**
     * Delete a Pedido (Order) by its ID and return a JsonResponse.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $this->repositoryPedido->delete($id);

        return new JsonResponse([
            'message' => 'Pedido Eliminado Correctamente.'
        ], Response::HTTP_OK);
    }
}
