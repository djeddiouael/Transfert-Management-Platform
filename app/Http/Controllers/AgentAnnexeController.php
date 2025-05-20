<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgentAnnexe;

class AgentAnnexeController extends Controller
{
  public function index()
  {
    return AgentAnnexe::all();
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'username' => 'required|string|max:255',
      'email' => 'required|email|unique:agent_annexes,email',
      'password' => 'required|string|min:8',
    ]);

    $AgentAnnexe = AgentAnnexe::create($validatedData);

    return response()->json($AgentAnnexe, 201);
  }

  public function show(AgentAnnexe $AgentAnnexe)
  {
    return $AgentAnnexe;
  }

  public function update(Request $request, AgentAnnexe $AgentAnnexe)
  {
    $validatedData = $request->validate([
      'username' => 'string|max:255',
      'email' => 'email|unique:agent_annexes,email,' . $AgentAnnexe->id,
      'password' => 'string|min:8',
    ]);

    $AgentAnnexe->update($validatedData);

    return response()->json($AgentAnnexe, 200);
  }

  public function destroy(AgentAnnexe $AgentAnnexe)
  {
    $AgentAnnexe->delete();

    return response()->json(null, 204);
  }
}
