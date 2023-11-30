<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\CompanyServiceInterface;
use App\Services\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyServiceInterface $companyService,
        private CompanyRepositoryInterface $companyRepository,
        private UserServiceInterface $useService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isDomain = $this->companyService->isCompanyInfoRegistered();
        if ($isDomain) {
            return to_route('projects.index');
        }

        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        DB::transaction(function () use ($request) {
            try {
                $company = $this->companyService->storeCompany($request->getCompanyName());
                $this->companyService->patchUserByCompanyId(Auth::id(), $company->id);
            } catch(Exception $e) {
                // TODO: throw追記
                Log::error($e->getMessage());
            }
        });

        return to_route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
