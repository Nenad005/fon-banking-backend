<?php

namespace App\Http\Controllers;

use App\Models\ActivationCode;
use Illuminate\Http\Request;

class ActivationCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activationCodes = ActivationCode::with('user:id,first_name')->get();

        return view('welcome', compact('activationCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivationCode $activationCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivationCode $activationCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivationCode $activationCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivationCode $activationCode)
    {
        //
    }
}
