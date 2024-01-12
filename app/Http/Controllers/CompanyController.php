<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyServiceInterface $companyService,
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
        Log::info('ドメイン', [$isDomain]);
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
        try {
            DB::transaction(function () use ($request) {
                $company = $this->companyService->storeCompany($request->getCompanyName());
                $this->companyService->patchUserByCompanyId(Auth::id(), $company->id);
            });
        } catch (Exception $e) {
            // TODO: throw追記
            Log::error($e->getMessage());
        }

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
