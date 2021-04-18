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
        } elseif( auth()->user()->role == 'admin' ) {
            return redirect()->route('admin.dashboard');

            /*SuperAdmin Panel(For Developers)*/
        } elseif( auth()->user()->role == 'cashier' ) {
            return redirect()->route('cashier.dashboard');

            /*SuperAdmin Panel(For Developers)*/
        } elseif( auth()->user()->role == 'manager' ) {
            return redirect()->route('manager.dashboard');

            /*SuperAdmin Panel(For Developers)*/
        } elseif( auth()->user()->role == 'employee' ) {
            return redirect()->route('employee.dashboard');

            /*SuperAdmin Panel(For Developers)*/
        } elseif( auth()->user()->role == 'superadmin') {
            return redirect()->route('superadmin.dashboard');

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
