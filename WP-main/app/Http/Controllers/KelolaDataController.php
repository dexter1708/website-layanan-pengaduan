<?php

namespace App\Http\Controllers;

use App\Models\KelolaData;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class KelolaDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kotas = Wilayah::select('kota_id', 'kota_nama')->distinct()->get();
        return view('kelola_data.index', compact('kotas'));
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
    public function show(KelolaData $kelolaData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelolaData $kelolaData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KelolaData $kelolaData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KelolaData $kelolaData)
    {
        //
    }
}
