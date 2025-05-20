<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
  public function index()
  {
    return Commentaire::all();
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'text' => 'required|string|max:255',
      'date' => 'required|date',
      'id_emprunt' => 'required|exists:emprunts,id',
    ]);

    $commentaire = Commentaire::create($validatedData);

    return response()->json($commentaire, 201);
  }

  public function show(Commentaire $commentaire)
  {
    return $commentaire;
  }

  public function update(Request $request, Commentaire $commentaire)
  {
    $validatedData = $request->validate([
      'text' => 'string|max:255',
      'date' => 'date',
      'idemprent' => 'exists:emprunts,id',
    ]);

    $commentaire->update($validatedData);

    return response()->json($commentaire, 200);
  }

  public function destroy(Commentaire $commentaire)
  {
    $commentaire->delete();

    return response()->json(null, 204);
  }
}
