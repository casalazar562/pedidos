<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Cuenta\CuentaRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CuentaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CuentaController extends Controller
{
    protected $repository;

    public function __construct(CuentaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    private function getCountParams(): array
    {
        return request()->only('name', 'email', 'telephone');
    }

    public function all()
    {
        $counts = $this->repository->list();
        if ($counts->isEmpty()) {
            return new JsonResponse([
                'data' => $counts,
                'message' => 'No hay juegos'
            ], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse([
            'data' => $counts
        ], Response::HTTP_OK);
    }

    public function create(CuentaRequest $request)
    {
        $data = $this->getCountParams();
        DB::beginTransaction();
        try {
            $count = $this->repository->create($data);
            DB::commit();
            return new JsonResponse([
                'data' => $count,
                'message' => 'Cuenta Agregada Correctamente'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR CREATE GAME.', $response);
            DB::rollBack();
            return new JsonResponse([
                'response' => $response
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(CuentaRequest $request, $id)
    {
        Log::info($request);
        $data = $this->getCountParams();
        DB::beginTransaction();
        try {
            $count = $this->repository->update($data, $id);
            DB::commit();
            return new JsonResponse([
                'data' => $count,
                'message' => 'Cuenta Actualizada Correctamente.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR UPDATE GAME.', $response);
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
            'message' => 'Cuenta Eliminada Correctamente.'
        ], Response::HTTP_OK);
    }
}
