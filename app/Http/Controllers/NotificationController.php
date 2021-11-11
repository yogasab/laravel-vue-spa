<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function __construct()
  {
    $this->middleware('jwt');
  }

  public function index()
  {
    return [
      'read' => NotificationResource::collection(Auth::user()->readNotifications),
      'unread' => NotificationResource::collection(Auth::user()->unReadNotifications),
    ];
  }

  public function readNotifications(Request $request)
  {
    $userReadNotifications = Auth::user()->unreadNotifications->where('id', $request->id)->first();
    if ($userReadNotifications) {
      $userReadNotifications->markAsRead();
    }
  }
}
