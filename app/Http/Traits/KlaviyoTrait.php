<?php

namespace App\Http\Traits;

use Klaviyo\Client;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Venue;
use App\Models\Transaction;
use App\Models\User;

trait KlaviyoTrait
{

  public function add_profile($list_id, $email, $first_name, $last_name)
  {
    $client = new Client($_ENV['KLAVIYO_PRIVATE'], $_ENV['KLAVIYO_PUBLIC']);
    $profiles = array(
      "profiles" => [
        array(
          "email" => $email,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "role" => "Fisher"
        )
      ]
    );
    return $client->ListsSegments->subscribe($list_id, $profiles);
  }

  public function add_connected_account_link_to_profile($list_id, $email, $first_name, $last_name, $venue_name, $stripe_link)
  {
    $client = new Client($_ENV['KLAVIYO_PRIVATE'], $_ENV['KLAVIYO_PUBLIC']);
    $profiles = array(
      "profiles" => [
        array(
          "email" => $email,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "role" => "Fishery",
          "$" . "venue_name" => $venue_name,
          "$" . "stripe_link" => $stripe_link,
        )
      ]
    );
    return $client->ListsSegments->subscribe($list_id, $profiles);
  }

  /**
   * Track a successful ticket payment event in Klaviyo.
   *
   * @param  Transaction  $transaction
   * @return void
   */
  public function track_payment_success($transaction)
  {
    $event_properties = $this->build_payment_event_properties($transaction);
    $this->send_klaviyo_track_event("Payment Success", $event_properties);
  }

  /**
   * Track a failed ticket payment event in Klaviyo.
   *
   * @param  Transaction  $transaction
   * @return void
   */
  public function track_payment_failed($transaction)
  {
    $event_properties = $this->build_payment_event_properties($transaction);
    $event_properties['properties']['payment_status'] = 'failed';
    $this->send_klaviyo_track_event("Payment Failed", $event_properties);
  }

  /**
   * Build the event properties array for a Klaviyo track event
   * from a transaction and its associated bookings/tickets/venue.
   *
   * @param  Transaction  $transaction
   * @return array
   */
  private function build_payment_event_properties($transaction)
  {
    // get the user who made the booking
    $booking = Booking::where('transaction_id', $transaction->id)->first();
    $user = $booking ? User::find($booking->user_id) : null;

    // get all bookings for this transaction with ticket & venue details
    $bookings = Booking::join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
      ->join('venues', 'tickets.venue_id', '=', 'venues.id')
      ->where('bookings.transaction_id', $transaction->id)
      ->get([
        'bookings.id as booking_id',
        'bookings.cost as booking_cost',
        'bookings.date as booking_date',
        'tickets.id as ticket_id',
        'tickets.name as ticket_name',
        'tickets.description as ticket_description',
        'tickets.cost as ticket_price',
        'venues.id as venue_id',
        'venues.name as venue_name',
        'venues.address as venue_address',
      ]);

    $tickets = $bookings->map(function ($booking) {
      return [
        'ticket_id' => $booking->ticket_id,
        'ticket_name' => $booking->ticket_name,
        'ticket_description' => $booking->ticket_description,
        'ticket_price' => $booking->ticket_price,
        'booking_cost' => $booking->booking_cost,
        'booking_date' => $booking->booking_date,
        'venue_id' => $booking->venue_id,
        'venue_name' => $booking->venue_name,
        'venue_address' => $booking->venue_address,
      ];
    })->toArray();

    return [
      'token' => $_ENV['KLAVIYO_PUBLIC'],
      'customer_properties' => [
        '$email' => $user ? $user->email : '',
        '$first_name' => $user ? $user->name : '',
      ],
      'properties' => [
        'payment_status' => 'success',
        'transaction_id' => $transaction->id,
        'total' => $transaction->total,
        'booking_fee' => $transaction->booking_fee,
        'ticket_fee' => $transaction->ticket_fee,
        'qty' => $transaction->qty,
        'receipt_link' => $transaction->receipt_link,
        'tickets' => $tickets,
        'venue_name' => count($tickets) > 0 ? $tickets[0]['venue_name'] : '',
        'venue_address' => count($tickets) > 0 ? $tickets[0]['venue_address'] : '',
      ],
      'time' => time(),
    ];
  }

  /**
   * Send a track event to Klaviyo using the legacy track API.
   *
   * @param  string  $event_name
   * @param  array   $payload
   * @return void
   */
  private function send_klaviyo_track_event($event_name, $payload)
  {
    try {
      $payload['event'] = $event_name;
      $data = base64_encode(json_encode($payload));
      $client = new Client($_ENV['KLAVIYO_PRIVATE'], $_ENV['KLAVIYO_PUBLIC']);
      $client->TrackIdentify->trackGet($data);
    } catch (\Exception $e) {
      // log error but don't block the webhook
      \Log::error('Klaviyo track event failed: ' . $e->getMessage());
    }
  }
}
