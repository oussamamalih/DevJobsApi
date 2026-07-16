<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOffreRequest;
use App\Http\Requests\UpdateOffreRequest;
use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     * Public: anyone can browse job offers.
     */
    public function index()
    {
        $offres = Offre::with(['entreprise', 'competences'])->latest()->get();

        return response()->json($offres);
    }

    /**
     * Store a newly created resource in storage.
     * Only a 'company' user that already has an entreprise profile can post offers.
     */
    public function store(StoreOffreRequest $request)
    {
        $entreprise = $request->user()->entreprise;

        if (! $entreprise) {
            return response()->json([
                'message' => 'You need to create a company profile before posting offers.',
            ], 422);
        }

        $offre = $entreprise->offres()->create($request->validated());

        // Optional: attach skills if provided
        if ($request->filled('competences')) {
            $offre->competences()->sync($request->input('competences'));
        }

        return response()->json($offre->load('competences'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $offre = Offre::with(['entreprise', 'competences'])->findOrFail($id);

        return response()->json($offre);
    }

    /**
     * Update the specified resource in storage.
     * Only the owning company (or admin) can update it.
     */
    public function update(UpdateOffreRequest $request, string $id)
    {
        $offre = Offre::findOrFail($id);

        if ($request->user()->id !== $offre->entreprise->user_id && $request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not authorized to update this offer.',
            ], 403);
        }

        $offre->update($request->validated());

        if ($request->filled('competences')) {
            $offre->competences()->sync($request->input('competences'));
        }

        return response()->json($offre->load('competences'));
    }

    /**
     * Remove the specified resource from storage.
     * Only the owning company (or admin) can delete it.
     */
    public function destroy(Request $request, string $id)
    {
        $offre = Offre::findOrFail($id);

        if ($request->user()->id !== $offre->entreprise->user_id && $request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not authorized to delete this offer.',
            ], 403);
        }

        $offre->delete();

        return response()->json([
            'message' => 'Offre deleted successfully.',
        ]);
    }
}
