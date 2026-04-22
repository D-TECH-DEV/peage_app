<?php

namespace App\Http\Controllers;

use App\Models\Guichet;
use Illuminate\Http\Request;

class GuichetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guichets = Guichet::all();
        return view('admin.guichets.index', compact('guichets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.guichets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'statut' => 'nullable|string|max:50',
        ], [
            'code.required' => 'Le code du guichet est obligatoire.',
            'code.string' => 'Le code doit être une chaîne de caractères.',
            'code.max' => 'Le code ne doit pas dépasser 50 caractères.',
            'statut.string' => 'Le statut doit être une chaîne de caractères.',
            'statut.max' => 'Le statut ne doit pas dépasser 50 caractères.',
        ]);

        Guichet::create($request->all());

        return redirect()->route('admin.guichets.index')
            ->with('success', 'Guichet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guichet = Guichet::findOrFail($id);
        return view('admin.guichets.show', compact('guichet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guichet = Guichet::findOrFail($id);
        return view('admin.guichets.edit', compact('guichet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'statut' => 'nullable|string|max:50',
        ], [
            'code.required' => 'Le code du guichet est obligatoire.',
            'code.string' => 'Le code doit être une chaîne de caractères.',
            'code.max' => 'Le code ne doit pas dépasser 50 caractères.',
            'statut.string' => 'Le statut doit être une chaîne de caractères.',
            'statut.max' => 'Le statut ne doit pas dépasser 50 caractères.',
        ]);

        $guichet = Guichet::findOrFail($id);
        $guichet->update($request->all());

        return redirect()->route('admin.guichets.index')
            ->with('success', 'Guichet mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guichet = Guichet::findOrFail($id);
        $guichet->delete();

        return redirect()->route('admin.guichets.index')
            ->with('success', 'Guichet supprimé avec succès.');
    }
}
