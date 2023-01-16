<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The model to policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
		// 'App\Models\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		Auth::viaRequest('custom-auth', function ($request) {
			if (!$request->cookie('access_token'))
			{
				throw new \ErrorException('no token');
			}
			$decoded = JWT::decode(
				request()->cookie('access_token') ?? substr(request()->header('Authorization'), 7),
				new Key(config('auth.jwt_secret'), 'HS256')
			);
			return User::find($decoded->uid);
		});
	}
}
