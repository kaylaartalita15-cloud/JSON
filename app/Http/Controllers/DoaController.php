<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class DoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response_doa = Http::get('https://equran.id/api/doa');
        $doa = $response_doa->json()['data'];

        return view('doa', ['doa' => $doa]);
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
    public function show(string $id)
    {
        $response_doa = Http::get('https://equran.id/api/doa/'.$id);
        $doa = $response_doa->json()['data'];

        return view('detailDoa', ['doa' => $doa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
