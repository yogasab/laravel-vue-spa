<?php

namespace App\Http\Controllers;

use App\Events\LikeEvent;
use App\Model\Like;
use App\Model\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

  public function __construct()
  {
    $this->middleware('jwt');
  }


  public function likeReply(Reply $reply)
  {
    $reply->likes()->create([
      'user_id' => Auth::id()
    ]);
    broadcast(new LikeEvent($reply->id, 1))->toOthers();
    return response()->json([
      'message' => 'Like successfully'
    ]);
  }

  public function dislikeReply(Reply $reply)
  {
    $reply->likes()->where('user_id', Auth::id())->first()->delete();
    broadcast(new LikeEvent($reply->id, 0))->toOthers();
    return response()->json([
      'message' => 'Dislike successfully'
    ]);
  }
}
