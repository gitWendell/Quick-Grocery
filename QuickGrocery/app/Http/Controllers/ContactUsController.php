<?php

namespace App\Http\Controllers;

use App\Mail\SendContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    //
    public function view(){
        return view('contactus');
    }

    public function send(Request $request) {
        $details = $request->all();

        Mail::to('casulwendell12@gmail.com')->send(new SendContactUs($details));

        return redirect()->back()->with('success', 'Your message has been sent!');
    }
}
