<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmContactRequest;
use App\Http\Requests\StoreContactRequest;
use App\Services\ContactServiceInterface;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct(
        private ContactServiceInterface $contactService
    ) {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contact/Create');
    }

    public function Postconfirm(ConfirmContactRequest $request)
    {
        $this->contactService->confirm($request->getParams());

        return to_route('contacts.confirm');
    }

    public function confirm()
    {
        return Inertia::render('Contact/Confirm', [
            'category' => session()->get('category'),
            'content' => session()->get('content'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $this->contactService->store($request->getParams());

        return to_route('projects.index');
    }
}
