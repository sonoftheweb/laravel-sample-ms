<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Instance;
use App\Models\User;
use App\Notifications\SignupActivate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class AuthenticationController extends Controller
{
	/**
	 * Create an instance and a user and send email to confirm registration
	 *
	 * @param RegisterRequest $request
	 * @return JsonResponse
	 */
	public function register(RegisterRequest $request): JsonResponse
	{
		$instance = $request->safe()->only('instance');
		$instance = Instance::query()->create($instance['instance']);
		
		$userData = $request->safe()->only('user');
		$userData = $userData['user'];
		$userData['password'] = bcrypt($userData['password']);
		$userData['current_instance'] = $instance->id;
		$userData['activation_token'] = Str::random(60);
		unset($userData['password_confirmation']);
		
		$user = $instance->users()->create($userData);
		
		$user->notify(new SignupActivate());
		
		return response()->json([
			'needs_activation' => !$user->email_verified_at
		]);
	}
	
	/**
	 * Activate the account
	 *
	 * @param string $activation_token
	 * @return JsonResponse
	 */
	public function activate(string $activation_token): JsonResponse
	{
		$user = User::query()->where('activation_token', $activation_token)->first();
		if (!$user) {
			return response()->json([
				'message' => __('auth.invalid_activation_token')
			], 404);
		}
		
		$user->active = true;
		$user->activation_token = '';
		$user->email_verified_at = Date::now();
		$user->save();
		
		return response()->json([
			'message' => 'user_activated'
		]);
	}
	
	public function login(LoginRequest $request)
	{
		$credentials = $request->safe()->only(['email', 'password']);
		$credentials['active'] = 1;
		$credentials['deleted_at'] = null;
		
		if (!Auth::attempt($credentials)) {
			return response()->json([
				'message' => 'unauthorized'
			], 404);
		}
		
		if ($request->get('remember_me')) {
			Passport::personalAccessTokensExpireIn(now()->addWeeks(2));
		}
		
		$user = $request->user();
		$token = $user->createToken('LoadlyAuth')->accessToken;
		
		return response()->json([
			'token' => $token,
			'token_type' => 'Bearer',
			'expires_at' => Date::parse($token->expires_at)->toDateTimeString()
		]);
	}
}
