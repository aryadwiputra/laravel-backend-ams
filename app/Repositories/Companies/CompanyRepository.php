<?php

namespace App\Repositories\Companies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getAll(): Collection
    {
        return Company::all();
    }

    public function getById(int $id): Company
    {
        return Company::find($id);
    }

    public function create(array $data): Company
    {
        return Company::create($data);
    }

    public function update(Company $company, array $data): Company
    {
        $company->update($data);
        return $company;
    }

    public function delete(Company $company): bool
    {
        return $company->delete();
    }

    public function generateUniqueSlug(string $name, ?int $exceptId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Company::where('slug', $slug)->where('id', '!=', $exceptId)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}