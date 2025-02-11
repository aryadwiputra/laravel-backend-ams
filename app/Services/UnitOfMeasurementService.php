<?php

namespace App\Services;

use App\Models\UnitOfMeasurement;
use App\Traits\HandleImageUpload;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Repositories\UnitOfMeasurements\UnitOfMeasurementRepositoryInterface;

class UnitOfMeasurementService
{
    use HandleImageUpload;

    protected $unitOfMeasurementRepository;

    public function __construct(UnitOfMeasurementRepositoryInterface $unitOfMeasurementRepository)
    {
        $this->unitOfMeasurementRepository = $unitOfMeasurementRepository;
    }

    public function getUnitOfMeasurement($unit_of_measurement_id)
    {
        $unit_of_measurement = $this->unitOfMeasurementRepository->getById($unit_of_measurement_id);

        return $unit_of_measurement;
    }

    public function getAllUnitOfMeasurement()
    {
        return $this->unitOfMeasurementRepository->getAll();
    }

    public function createUnitOfMeasurement(array $data)
    {
        try {
            DB::beginTransaction();

            $unit_of_measurement = $this->unitOfMeasurementRepository->create($data);

            DB::commit();

            return $unit_of_measurement;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to create unit of measurement: " . $e->getMessage());
        }
    }

    public function updateUnitOfMeasurement(UnitOfMeasurement $unit_of_measurement, array $data)
    {
        try {
            DB::beginTransaction();

            $this->unitOfMeasurementRepository->update($unit_of_measurement, $data);

            DB::commit();

            return $unit_of_measurement;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to update unit of measurement: " . $e->getMessage());
        }
    }

    public function deleteUnitOfMeasurement(UnitOfMeasurement $unit_of_measurement) {
        try {
            DB::beginTransaction();

            $this->unitOfMeasurementRepository->delete($unit_of_measurement);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to delete unit of measurement: " . $e->getMessage());
        }
    }
}