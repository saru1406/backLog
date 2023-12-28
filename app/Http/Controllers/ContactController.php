<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmContactRequest;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contact/Create');
    }

    public function confirm(ConfirmContactRequest $request)
    {
        return Inertia::render('Contact/Confirm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }


}
