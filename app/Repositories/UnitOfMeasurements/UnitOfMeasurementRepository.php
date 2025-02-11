<?php

namespace App\Repositories\UnitOfMeasurements;

use App\Models\UnitOfMeasurement;
use Illuminate\Database\Eloquent\Collection;

class UnitOfMeasurementRepository implements UnitOfMeasurementRepositoryInterface
{
    public function getAll(): Collection
    {
        return UnitOfMeasurement::all();
    }

    public function getById(int $id): UnitOfMeasurement|null
    {
        return UnitOfMeasurement::find($id);
    }

    public function create(array $data): UnitOfMeasurement|null
    {
        return UnitOfMeasurement::create($data);
    }

    public function update(UnitOfMeasurement $unitOfMeasurement, array $data): UnitOfMeasurement|null
    {
        $unitOfMeasurement->update($data);
        return $unitOfMeasurement;
    }

    public function delete(UnitOfMeasurement $unitOfMeasurement): bool
    {
        return $unitOfMeasurement->delete();
    }
}