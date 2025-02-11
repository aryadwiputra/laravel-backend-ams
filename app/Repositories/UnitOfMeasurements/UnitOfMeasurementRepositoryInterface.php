<?php

namespace App\Repositories\UnitOfMeasurements;

use App\Models\UnitOfMeasurement;
use Illuminate\Database\Eloquent\Collection;
interface UnitOfMeasurementRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?UnitOfMeasurement;

    public function create(array $data): ?UnitOfMeasurement;

    public function update(UnitOfMeasurement $unitOfMeasurement, array $data): ?UnitOfMeasurement;

    public function delete(UnitOfMeasurement $unitOfMeasurement): bool;
}