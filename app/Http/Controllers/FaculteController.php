<?php

namespace App\Http\Controllers;
use App\Models\publisher;
use App\Models\faculte;
use Illuminate\Http\Request;

class FaculteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('faculte.index', [
            'publishers' => publisher::Paginate(5)
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\faculte  $faculte
     * @return \Illuminate\Http\Response
     */
    public function show(faculte $faculte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\faculte  $faculte
     * @return \Illuminate\Http\Response
     */
    public function edit(faculte $faculte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\faculte  $faculte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, faculte $faculte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\faculte  $faculte
     * @return \Illuminate\Http\Response
     */
    public function destroy(faculte $faculte)
    {
        //
    }
}
