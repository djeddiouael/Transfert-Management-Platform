<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index()
  {
    return Admin::all();
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'username' => 'required|string|max:255',
      'email' => 'required|email|unique:admins,email',
      'password' => 'required|string|min:8',
      'rank' => 'required|string|max:15',
    ]);

    $admin = Admin::create($validatedData);

    return response()->json($admin, 201);
  }

  public function show(Admin $admin)
  {
    return $admin;
  }

  public function update(Request $request, Admin $admin)
  {
    $validatedData = $request->validate([
      'username' => 'string|max:255',
      'email' => 'email|unique:admins,email,' . $admin->id,
      'password' => 'string|min:8',
      'rank' => 'string|max:15',
    ]);

    $admin->update($validatedData);

    return response()->json($admin, 200);
  }

  public function destroy(Admin $admin)
  {
    $admin->delete();

    return response()->json(null, 204);
  }
}
