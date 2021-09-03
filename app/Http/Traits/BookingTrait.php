<?php

namespace App\Http\Traits;
use App\Models\Ticket;
use App\Models\Booking;

trait BookingTrait {

    public function get_booking_status($user_bookings, $many_left) {

      $status = "";

      if ($user_bookings > 0) {
        $status = $user_bookings === 1 ? "You have already purchased this ticket" : "You have already purchased this ticket " . $user_bookings . " times";
      } elseif ($many_left > 0 && $many_left < env('ALMOST_SOLD_OUT_THRESHOLD', 3)) {
        $status = "This ticket is almost sold out";
      }

      return $status;
    }

    public function ticket_available($venue_id, $ticket_id, $date, $qty) {
       
      // get ticket info
    $ticket = Ticket::where([
      ['venue_id', '=', $venue_id],
      ['id', '=', $ticket_id]
    ])->get(["daily_limit", "cost", "name"])->first();

    if (isset($ticket)) {



      // get daily limit
      $daily_limit = $ticket->daily_limit;

      // count number of bookings
      $bookings = count(Booking::where([
        ['ticket_id', '=', $ticket_id],
        ['confirmed', true]
      ])->whereDate('created_at', $date)->get());

      return $daily_limit > 0 && $daily_limit >= ($bookings + $qty);

    } else {
      return false;
    }

  }

}
