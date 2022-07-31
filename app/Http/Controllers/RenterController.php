<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRenterRequest;
use App\Http\Requests\UpdateRenterRequest;
use App\Models\Renter;

class RenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRenterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRenterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function show(Renter $renter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function edit(Renter $renter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRenterRequest  $request
     * @param  \App\Models\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRenterRequest $request, Renter $renter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Renter $renter)
    {
        //
    }
}
