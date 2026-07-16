<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    /**
     * Display a listing of the resource.
     * Public: anyone can see the list of skills.
     */
    public function index()
    {
        return response()->json(Competence::all());
    }

    /**
     * Store a newly created resource in storage.
     * Only admins can create new skills (enforced by route middleware).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:competences,name',
        ]);

        $competence = Competence::create($validated);

        return response()->json($competence, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $competence = Competence::findOrFail($id);

        return response()->json($competence);
    }

    /**
     * Update the specified resource in storage.
     * Only admins can update skills (enforced by route middleware).
     */
    public function update(Request $request, string $id)
    {
        $competence = Competence::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:competences,name,' . $competence->id,
        ]);

        $competence->update($validated);

        return response()->json($competence);
    }

    /**
     * Remove the specified resource from storage.
     * Only admins can delete skills (enforced by route middleware).
     */
    public function destroy(string $id)
    {
        $competence = Competence::findOrFail($id);
        $competence->delete();

        return response()->json([
            'message' => 'Competence deleted successfully.',
        ]);
    }
}
