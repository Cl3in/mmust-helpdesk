<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
     public function redirectTo() {
        $role = Auth::user()->role; 
        switch ($role) {
          case 'admin':
            $logfile = fopen("logs.txt","a+");
            $firstname =Auth::user()->first_name;
            $lastname =Auth::user()->last_name;
            $time=now();
            fwrite($logfile,"\n$time\t$firstname\t$lastname\tlogged\tin");
            fclose($logfile);
            return '/admin_dashboard';
            break;
          case 'technician':
            $logfile = fopen("logs.txt","a+");
            $firstname =Auth::user()->first_name;
            $lastname =Auth::user()->last_name;
            $time=now();
            fwrite($logfile,"\n$time\t$firstname\t$lastname\tlogged\tin");
            fclose($logfile);
            return '/technician_dashboard';
            break;
            case 'staff':
              $logfile = fopen("logs.txt","a+");
              $firstname =Auth::user()->first_name;
              $lastname =Auth::user()->last_name;
              $time=now();
              fwrite($logfile,"\n$time\t$firstname\t$lastname\tlogged\tin");
              fclose($logfile);
              return '/staff_dashboard';
              break;  
          case 'student':
            $logfile = fopen("logs.txt","a+");
            $firstname =Auth::user()->first_name;
            $lastname =Auth::user()->last_name;
            $time=now();
            fwrite($logfile,"\n$time\t$firstname\t$lastname\tlogged\tin");
            fclose($logfile);
            return '/student_dashboard';
            break;   

          default:
            return '/home'; 
          break;
        }
      }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
