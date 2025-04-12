<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Routing\Controller as BaseController;

class UserProfileController extends BaseController
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function updateInfo(Request $request)
  {
    $validated = $request->validate([
      'address' => 'required|string|max:1000',
      'phone' => 'required|string|max:20',
    ]);

    User::where('id', Auth::id())->update([
      'address' => $validated['address'],
      'phone' => $validated['phone']
    ]);

    return redirect()->back()->with('success', 'Info updated successfully.');}
}
