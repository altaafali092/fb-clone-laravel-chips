<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chirps\StoreChirpsRequest;
use App\Http\Requests\Chirps\UpdateChirpsRequest;
use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        $chirps=Chirp::with('user:id,name')->latest()->get();

        return Inertia::render('Chrips/Index',compact('chirps'));
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
    public function store(StoreChirpsRequest $request)
    {
        Chirp::create($request->validated()+['user_id'=>Auth::user()->id]);
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChirpsRequest $request, Chirp $chirp)
    {
        $chirp->update($request->validated()+['user_id'=>Auth::user()->id]);
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp):RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();
        return back();
    }
}
