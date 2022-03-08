<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      User::created(function($user) {
				Mail::to($user)->send(new UserCreated($user));
      });

	    User::updated(function($user) {
				if($user->isDirty('email')) {
					Mail::to($user)->send(new UserMailChanged($user));
				}
	    });
    }
}
