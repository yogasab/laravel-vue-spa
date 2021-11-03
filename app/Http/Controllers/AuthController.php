<?php

namespace App\Http\Controllers;

use App\User;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('jwt', ['except' => ['login', 'register']]);
  }

  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login()
  {
    $credentials = request(['email', 'password']);

    if (!$token = Auth::attempt($credentials)) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
  }

  public function register(Request $request)
  {
    $validator  = Validator::make(request()->all(), [
      'name' => 'required',
      'email' => 'required|unique:users',
      'password' => 'required|confirmed'
    ]);
    if ($validator->fails()) {
      return response()->json($validator->errors());
    }
    // $user = User::create(array_merge($validator->validated(), ['password' => bcrypt(request()->password)]));
    $user = User::create($validator->validated());
    return $this->login($request);
  }

  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
    return response()->json(auth()->user());
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    Auth::logout();
    return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    return $this->respondWithToken(auth()->refresh());
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    return response()->json([
      'user' => Auth::user()->name,
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60,
    ]);
  }
}
