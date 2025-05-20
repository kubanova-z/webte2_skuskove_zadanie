<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'city',
        'country',
    ];
    protected $casts = [
        'login_time' => 'datetime',
        'used_features' => 'array',
    ];


    public $timestamps = false; // because your table has `login_time`, not created_at/updated_at

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
