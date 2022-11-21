<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\ResetPassword;
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
        VerifyEmail::toMailUsing(function ($notifiable) {
            $params = [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification())
            ];
            $url = env('FRONT_APP') . '/verify-email?';

            foreach ($params as $key => $param) {
                $url .= "{$key}={$param}&";
            }
            return (new MailMessage())->view('verification-verify', ['url' => $url]);
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $params = [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ];

            $url = env('FRONT_APP') . '/reset-password?';

            foreach ($params as $key => $param) {
                $url .= "{$key}={$param}&";
            }

            return (new MailMessage())
            ->view('password-reset', [
                'url'   => $url,
            ]);
        });
    }
}
