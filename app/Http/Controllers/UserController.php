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

  public function loginGoogle(Request $request)
  {
      $request->validate(['token' => 'required|string']);

      $response = \Illuminate\Support\Facades\Http::get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $request->token);

      if ($response->failed()) {
          return response()->json(['success' => false, 'message' => 'Invalid Google token'], 401);
      }

      $data = $response->json();

      if (!isset($data['email']) || !isset($data['sub'])) {
          return response()->json(['success' => false, 'message' => 'Google verification failed'], 401);
      }

      // Match the client ID to prevent spoofing
      if (env('GOOGLE_CLIENT_ID') && $data['aud'] !== env('GOOGLE_CLIENT_ID')) {
           return response()->json(['success' => false, 'message' => 'Unauthorized Client ID'], 401);
      }

      $user = \App\Models\User::where('email', $data['email'])->first();

      if ($user) {
          if (empty($user->google_id)) {
              $user->google_id = $data['sub'];
              $user->save();
          }
      } else {
          $user = \App\Models\User::create([
              'name' => $data['name'] ?? explode('@', $data['email'])[0],
              'email' => $data['email'],
              'google_id' => $data['sub'],
              'password' => bcrypt(\Illuminate\Support\Str::random(32)),
              'email_verified_at' => now(), // Assume Google emails are verified
          ]);
      }

      $token = $user->createToken('Google Login')->accessToken;

      return response()->json([
          'success' => true,
          'access_token' => $token,
          'token_type' => 'Bearer',
      ]);
  }

}
