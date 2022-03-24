<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Venue;

class PageController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  public function get_title($route)
  {
    $title = "GoFish! - Find the best fisheries near you";
    // login
    if ($route === "login") {
      return "Join " .  $title;
    }
    // basket 
    if ($route === "basket") {
      return "Basket - " .  $title;
    }
    // manage venues 
    if ($route === "manage-venues" || str_contains($route, "manage-venues/")) {
      return "Manage Venues - " .  $title;
    }
    // tickets
    if ($route === "tickets") {
      return "Tickets - " .  $title;
    }
    // categories
    if (str_contains($route, "category/")) {
      $category = explode("/", $route)[1];
      if ($category === "latest") {
        return "Latest Fisheries - " .  $title;
      } elseif ($category === "near") {
        return "Fisheries Near Me - " .  $title;
      } elseif ($category === "best") {
        return "Best Fisheries - " .  $title;
      } elseif (is_numeric($category)) {
        $item = Category::find($category);
        return $item->name . " - " . $title;
      } else {
        return $title;
      }
    }
    // venue
    if (str_contains($route, "venue/")) {
      $venue = explode("/", $route)[1];
      if (is_numeric($venue)) {
        $item = Venue::find($venue);
        return $item->name . " - " . $title;
      }
    }
    // search 
    if (str_contains($route, "search/")) {
      return "Search - " .  $title;
    }
    // confirm 
    if (str_contains($route, "confirm/")) {
      return "Confirmation - " .  $title;
    }
    // TODO - dynamically generate based on route
    return $title;
  }
}
