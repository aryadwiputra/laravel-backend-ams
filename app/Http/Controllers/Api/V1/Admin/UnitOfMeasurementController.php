<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitOfMeasurement\StoreUnitOfMeasurementRequest;
use App\Http\Requests\UnitOfMeasurement\UpdateUnitOfMeasurementRequest;
use App\Models\UnitOfMeasurement;
use App\Services\UnitOfMeasurementService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UnitOfMeasurementController extends Controller
{
    use ApiResponse;

    protected $unitOfMeasurementService;

    public function __construct(UnitOfMeasurementService $unitOfMeasurementService) {
        $this->unitOfMeasurementService = $unitOfMeasurementService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unitOfMeasurement = $this->unitOfMeasurementService->getAllUnitOfMeasurement();

        if(count($unitOfMeasurement) > 0) {
            return $this->success($unitOfMeasurement);
        }

        return $this->notFound();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitOfMeasurementRequest $request)
    {
        $validatedData = $request->validated(); // Ambil data yang sudah divalidasi
        try {
            $unitOfMeasurement = $this->unitOfMeasurementService->createUnitOfMeasurement($validatedData);
            return $this->success($unitOfMeasurement, 'Unit of measurement created successfully', 201); // Berikan response 201 Created
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $unitOfMeasurement = $this->unitOfMeasurementService->getUnitOfMeasurement($id);

        if ($unitOfMeasurement) {
            return $this->success($unitOfMeasurement);
        }

        return $this->notFound('Unit of measurement not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitOfMeasurementRequest $request, UnitOfMeasurement $unitOfMeasurement)
    {
        $validatedData = $request->validated();

        try{
            $unitOfMeasurement = $this->unitOfMeasurementService->updateUnitOfMeasurement($unitOfMeasurement, $validatedData);
            return $this->success($unitOfMeasurement);
        }
        catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitOfMeasurement $unitOfMeasurement)
    {
        $this->unitOfMeasurementService->deleteUnitOfMeasurement($unitOfMeasurement);

        return $this->success(null);
    }
}
