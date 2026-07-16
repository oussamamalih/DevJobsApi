<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     * Public: anyone can browse companies.
     */
    public function index()
    {
        return response()->json(Entreprise::all());
    }

    /**
     * Store a newly created resource in storage.
     * Only a 'company' user can create their own entreprise profile.
     */
    public function store(Request $request)
    {
        // A company user can only have one entreprise profile.
        if ($request->user()->entreprise) {
            return response()->json([
                'message' => 'You already have a company profile.',
            ], 409);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
        ]);

        $entreprise = $request->user()->entreprise()->create($validated);

        return response()->json($entreprise, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entreprise = Entreprise::findOrFail($id);

        return response()->json($entreprise);
    }

    /**
     * Update the specified resource in storage.
     * Only the owning company (or admin) can update it.
     */
    public function update(Request $request, string $id)
    {
        $entreprise = Entreprise::findOrFail($id);

        if ($request->user()->id !== $entreprise->user_id && $request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not authorized to update this company.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'sector' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
        ]);

        $entreprise->update($validated);

        return response()->json($entreprise);
    }

    /**
     * Remove the specified resource from storage.
     * Only the owning company (or admin) can delete it.
     */
    public function destroy(Request $request, string $id)
    {
        $entreprise = Entreprise::findOrFail($id);

        if ($request->user()->id !== $entreprise->user_id && $request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not authorized to delete this company.',
            ], 403);
        }

        $entreprise->delete();

        return response()->json([
            'message' => 'Entreprise deleted successfully.',
        ]);
    }
}
