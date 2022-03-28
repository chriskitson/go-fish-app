<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Venue;
use App\Http\Traits\StripeTrait;

class RegisterController extends Controller
{

  use StripeTrait;

  public function __construct()
  {
  }

  public function register(Request $request) // fisherman
  {

    $data = $request->all();

    $validator = Validator::make($data, [
      "name" => ["required", "string", "max:255"],
      "email" => ["required", "string", "email", "max:255", "unique:users"],
      "password" => ["required", "string", "min:8", "confirmed"],
    ]);

    if ($validator->fails()) {
      return response()->json(array(
        "success" => false,
        "errors" => $validator->messages()
      ));
    }

    $user = User::create([
      "name" => $data["name"],
      "email" => $data["email"],
      "password" => Hash::make($data["password"]),
      "user_type" => 1
    ]);
    $user->save();

    return response()->json(array(
      "success" => true,
      "email" => $user->email
    ));
  }

  public function signup(Request $request)  // fishery
  {

    $data = $request->all();

    $validator = Validator::make($data, [
      "fisheryName" => ["required", "string", "max:255"],
      "placeId" => ["required", "string", "max:255"],
      "address" => ["required", "string", "max:255"],
      "name" => ["required", "string", "max:255"],
      "email" => ["required", "string", "email", "max:255", "unique:users"],
      "password" => ["required", "string", "min:8", "confirmed"],
    ]);

    if ($validator->fails()) {
      return response()->json(array(
        "success" => false,
        "errors" => $validator->messages()
      ));
    }

    // does venue exist by place_id?
    $venue = Venue::where("place_id", "=", $data["placeId"]);
    if ($venue->count() > 0) {

      // venue exists get id
      $venue_id = $venue->first()->id;

      // does venue have active stripe account?
      $account_id =  $venue->first()->account;

    } else {

      $venue = Venue::create([
        "name" => $data["fisheryName"],
        "address" => $data["address"],
        "place_id" => $data["placeId"]
      ]);

      $venue->save();
      $venue_id = $venue->first()->id;

      $account_id = "";

    }

    if (!isset($account_id) || $account_id === "") { // create stripe account and generate link
      
      // create connected account
      $account_id = $this->connected_account_create($data["email"]);

      // update venue with account
      Venue::where([
        ["id", "=", $venue_id]
      ])->update(array(
        "account" => $account_id
      ));

    }

    // generate signup link
    $signup_url = $this->connected_account_link_create($venue_id, $account_id);

    // finally, create new user
    $user = User::create([
      "name" => $data["name"],
      "email" => $data["email"],
      "password" => Hash::make($data["password"]),
      "account" => $account_id,
      "user_type" => 2,
      "venue_id" => $venue_id
    ]);
    $user->save();

    return response()->json(array(
      "success" => true,
      "email" => $user->email,
      "stripe" => $signup_url
    ));

  }
}
