<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Http;
use App\Models\Login as LoginModel;



class LogUserLogin
{
    public function handle(Login $event)
    {
        $ip = request()->ip();

        // Override localhost IP for testing
        if (in_array($ip, ['127.0.0.1', '::1'])) {
            $ip = '85.135.242.151'; // your real IP
        }
        if (app()->environment('local') && in_array($ip, ['127.0.0.1', '::1'])) {
            $ip = '85.135.242.151';
        }


        $geo = \Illuminate\Support\Facades\Http::get("https://ipapi.co/{$ip}/json/")->json();

        \Log::info("Geo city: " . ($geo['city'] ?? 'null'));
        \Log::info("Geo country: " . ($geo['country_name'] ?? 'null'));

        LoginModel::create([
            'user_id' => $event->user->id,
            'ip_address' => $ip,
            'city' => $geo['city'] ?? 'Unknown',
            'country' => $geo['country_name'] ?? 'Unknown',
        ]);
    }

}

