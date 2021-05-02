<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Store;
use App\Notification;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'status',
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

    public function store(){
        return $this->hasOne('App\Store', 'admin_id', 'id');
    }

    public function cart(){
        return $this->hasMany('App\Cart', 'user_id', 'id');
    }

    public function notifications(){
        return $this->hasMany('App\Notification', 'madeby_id', 'id');
    }

    public function getNotification() {
        return $this->where('user_id', Auth::id())->get();
    }

//    Scopes
//    Get Email by email
    public function scopeGetEmailByEmail($query, $email){
        return $query->where('email', $email);
    }

    public function cartAvailable() {
        $isAvail = 1;

        foreach ($this->cart as $cart) {
            if($cart->getStoreTotal($this->cart) < 500) {
                $isAvail = 0;
            }
        }

        return $isAvail;
    }

    public function scopeGetCountRegistered($query) {
        $count = 0;
        $users = User::whereMonth('created_at', '=', ''.Carbon::now()->month)->get();

        return count($users);
    }

}
