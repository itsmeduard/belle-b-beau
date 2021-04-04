<?php
namespace App\Http\Controllers;
use Session;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        if(auth()->check() == null){
            auth()->logout();
            Session::flush();
            return redirect()->route('login');

            /*Admin Panel*/
        } elseif( auth()->user()->role == '1' ) {
//            dd('working');
            return redirect()->route('admin.dashboard');

            /*SuperAdmin Panel(For Developers)*/
        } elseif( auth()->user()->role == '3') {
            dd('welcome developer');

        } else {
            auth()->logout();
            Session::flush();
        }

    }

    public function log_out()
    {
        auth()->logout();
        Session::flush();
        return redirect()->route('login');
    }
}
