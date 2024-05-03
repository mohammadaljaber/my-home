<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];
    protected $middlewareGroups =[
        'web' => [
            \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ],
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable,$url){
            $spaUrl = "http://spa.test?email_verify_url=".$url;

            return (new MailMessage)
            ->subject('verify Email Address')
            ->line('click the button below to verify your email address')
            ->action('verify email address',$spaUrl);
        });
    }
}
