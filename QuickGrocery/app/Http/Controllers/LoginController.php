<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Sabberworm\CSS\Value\URL;
use function Symfony\Component\String\s;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    //Redirect to pages by role
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status == 'Block') {
                return redirect()->back()->with('error', 'Your account has been blocked!');
        }

        if(Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password
        ])){
            if ($user && $user->email_verified_at == null) {
                $this->guard()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                $details['id'] = $user->id;
                $details['name'] = $user->name;
                $details['links'] = 'http://quickgrocery.test:8080/verify-account/'.$user->id;

                Mail::to($user->email)->send(new VerifyEmail($details));

                return view('pages.verification_page');

            }

            if($user->role == 'systemadmin'){
                return redirect()->route('SystemadminDashboard');
            }

            else if($user->role == 'customer') {
                return redirect()->route('home');
            }

            else if($user->role == 'supplier') {
                return redirect()->route('SupplierDashboard');
            }

            else {
                return redirect()->route('StoreDashboard');
            }
        }

        return redirect()->back()->with('error', 'Email or password is incorrect.');
    }

}
