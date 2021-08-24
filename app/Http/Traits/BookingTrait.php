<?php

namespace App\Http\Traits;

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

}
