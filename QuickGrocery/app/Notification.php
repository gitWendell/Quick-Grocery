<?php

namespace App;

use App\Services\PagesServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $fillable = ['user_id', 'madeby_id', 'type', 'message'];

    public function getNotification() {
        $pagesServices = new PagesServices();

        Auth::user()->role == 'customer'
            ? $id = Auth::id()
            : $id =  $pagesServices->storeByRole()->id;

        return $this->where('user_id', $id)->get();
    }

    public function notificationCount() {
        $pagesServices = new PagesServices();

        Auth::user()->role == 'customer'
            ? $id = Auth::id()
            : $id =  $pagesServices->storeByRole()->id;

        $count_to = count($this->where('user_id', $id)->where('status', 0)->get());

        return $count_to;
    }
}
