<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  public function logout(Request $request)
  {

    $user = Auth::user()->token();
    $user->revoke();

    return response()->json(array(
      "success" => true
    ));

  }
}
