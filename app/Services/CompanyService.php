<?php

namespace App\Services;

use App\Models\Company;
use App\Traits\HandleImageUpload;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Repositories\Companies\CompanyRepositoryInterface;

class CompanyService
{
    use HandleImageUpload;

    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getCompany($company_id)
    {
        $company = $this->companyRepository->getById($company_id);

        return $company;
    }

    public function getAllCompany()
    {
        return $this->companyRepository->getAll();
    }

    public function createCompany(array $data)
    {
        try {
            DB::beginTransaction();

            $data['slug'] = $this->companyRepository->generateUniqueSlug($data['name']);

            // Handle image upload
            if (isset($data['logo'])) {
                $path = 'companies'; // Tentukan path penyimpanan
                $data['logo'] = $this->uploadImage($data['logo'], $path);
            }

            $company = $this->companyRepository->create($data);

            DB::commit();

            return $company;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to create company: " . $e->getMessage());
        }
    }

    public function updateCompany(Company $company, array $data)
    {
        try {
            DB::beginTransaction();

            // Handle image update
            if (isset($data['logo'])) {
                $path = 'companies';
                $data['logo'] = $this->updateImage($data['logo'], $company->logo, $path);
            }

            $this->companyRepository->update($company, $data);

            DB::commit();

            return $company;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to update company: " . $e->getMessage());
        }
    }

    public function deleteCompany(Company $company) {
        try {
            DB::beginTransaction();

            $this->companyRepository->delete($company);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to delete company: " . $e->getMessage());
        }
    }
}