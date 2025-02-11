<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Company\StoreCompanyRequest; // Import request untuk store
use App\Http\Requests\Company\UpdateCompanyRequest; // Import request untuk update
use App\Models\Company;

class CompanyController extends Controller
{
    use ApiResponse;

    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = $this->companyService->getAllCompany();
        if (count($companies) > 0) {
            return $this->success($companies);
        }
        return $this->notFound('Company not found');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request) // Gunakan StoreCompanyRequest
    {
        $validatedData = $request->validated(); // Ambil data yang sudah divalidasi
        try {
            $company = $this->companyService->createCompany($validatedData);
            return $this->success($company, 'Company created successfully', 201); // Berikan response 201 Created
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = $this->companyService->getCompany($id);

        if ($company) {
            return $this->success($company);
        }

        return $this->notFound('Company not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, string $id) // Gunakan UpdateCompanyRequest
    {
        $company = $this->companyService->getCompany($id);

        if (!$company) {
            return $this->notFound('Company not found');
        }

        $validatedData = $request->validated();
        try {
            $updatedCompany = $this->companyService->updateCompany($company, $validatedData);
            return $this->success($updatedCompany, 'Company updated successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = $this->companyService->getCompany($id);

        if (!$company) {
            return $this->notFound('Company not found');
        }

        try {
            $this->companyService->deleteCompany($company);
            return $this->success(null, 'Company deleted successfully', 204); // Berikan response 204 No Content
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}