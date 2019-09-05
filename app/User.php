<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'blood_group','phone','lat','lng','password','available'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNearbyDonors($query, $lat, $lng, $radius=10)
    {
        $haversine = "(6371 * acos(cos(radians(" . $lat . "))
                    * cos(radians(`lat`))
                    * cos(radians(`lng`)
                    - radians(" . $lng . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(`lat`))))";

        return $query->select('id','name','phone','email')
                     ->selectRaw("{$haversine} AS distance")
                     ->whereRaw("{$haversine} < ?", [$radius]);


    }
}
