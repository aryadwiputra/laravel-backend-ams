<?php

namespace App\Repositories\Companies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
interface CompanyRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): Company;

    public function create(array $data): Company;

    public function update(Company $company, array $data): Company;

    public function delete(Company $company): bool;

    public function generateUniqueSlug(string $name, ?int $exceptId = null): string;
}