<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class QuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mengambil data dari API equran.id dan disimpan ke variable $response
        $response = Http::get('https://equran.id/api/v2/surat');

        // mengambil data dari response dan simpan ke variable $qurans
        $quran = $response->json()['data'];

        // mengambil surat dengan id pertama
        // $quran = $qurans[9];
        return view('quran', ['quran' => $quran]);

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
    public function show(string $nomor)
    {
        $response = Http::get('https://equran.id/api/v2/surat/'.$nomor);
        $quran = $response->json()['data'];

        return view('detail', ['quran' => $quran]);
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
