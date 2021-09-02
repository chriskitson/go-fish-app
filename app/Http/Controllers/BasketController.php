<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
use App\Http\Traits\BookingTrait;

class BasketController extends Controller
{

  use BookingTrait;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  function get_basket($user_id)
  {
    return Basket::where([
      ['user_id', '=', $user_id]
    ])->join('tickets', 'basket.ticket_id', 'tickets.id')->join('venues', 'basket.venue_id', 'venues.id')->select('basket.id AS basket_id', 'basket.qty AS basket_qty', 'tickets.id AS ticket_id', 'tickets.name AS ticket_name', 'tickets.cost AS ticket_cost', 'venues.name AS venue_name', 'tickets.description as ticket_description', 'venues.id AS venue_id')->get();
  }

  public function get(Request $request)
  {
    $user = $request->user();
    $user_id = $user->id;
    return response()->json($this->get_basket($user_id));
  }

  public function add(Request $request)
  {

    $user = $request->user();
    $user_id = $user->id;

    $date = gmdate("Y-m-d", $request->date / 1000);

    if ($this->ticket_available($request->venue_id, $request->ticket_id, $date, $request->qty)) {

      // does this combo exist in db?
      $ticket_exists = count(Basket::where([
        ['date', '=', $date],
        ['venue_id', '=', $request->venue_id],
        ['ticket_id', '=', $request->ticket_id],
        ['user_id', '=', $user_id]
      ])->get()) > 0;

      if ($ticket_exists) { // update quantity

        Basket::where([
          ['date', '=', $date],
          ['venue_id', '=', $request->venue_id],
          ['ticket_id', '=', $request->ticket_id],
          ['user_id', '=', $user_id]
        ])->increment('qty', $request->qty);
      } else { // new item
        // save basket against user in db
        $basket = new Basket([
          "date" => $date,
          "venue_id" => $request->venue_id,
          "ticket_id" => $request->ticket_id,
          "qty" => $request->qty,
          "user_id" => $user_id
        ]);
        $basket->save();
      }

      // return updated basket for this user
      return response()->json($this->get_basket($user_id));
    } else {
      return response()->json(array(
        "success" => false,
        "availability" => false,
        "ticket_id" => intval($request->ticket_id)
      ), 500);
    }
  }

  public function basket_increase(Request $request, $id)
  {
    $user = $request->user();
    $user_id = $user->id;

    // look up ticket info
    $basket = Basket::where([
      ['id', '=', $id],
      ['user_id', '=', $user_id]
    ])->first();

    // check ticket is available
    if ($this->ticket_available($basket->venue_id, $basket->ticket_id, $basket->date, 1)) {

      // increase qty
      Basket::where([
        ['id', '=', $id],
        ['user_id', '=', $user_id]
      ])->increment('qty', 1);

      return response()->json(array(
        "success" => true
      ));
    } else {
      return response()->json(array(
        "success" => false,
        "availability" => false
      ), 500);
    }
  }

  public function basket_decrease(Request $request, $id)
  {
    $user = $request->user();
    $user_id = $user->id;

    // decrease qty
    Basket::where([
      ['id', '=', $id],
      ['user_id', '=', $user_id]
    ])->increment('qty', -1);

    return response()->json(array(
      "success" => true
    ));
  }

  public function basket_remove(Request $request, $id)
  {
    $user = $request->user();
    $user_id = $user->id;

    // delete item
    Basket::where([
      ['id', '=', $id],
      ['user_id', '=', $user_id]
    ])->delete();

    return response()->json(array(
      "success" => true
    ));
  }
}
