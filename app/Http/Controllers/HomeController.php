<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User,Session;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        $user = User::find( Auth::user()->id );

        if($user == null){
            Auth::logout();
            Session::flush();
            return redirect()->route('login');

            /*Admin Panel*/
        } elseif( $user->role == '1' ) {
            return redirect()->route('dashboard.index');

            /*SuperAdmin Panel(For Developers)*/
        } elseif( $user->role == '3') {
            dd('welcome developer');
//            return redirect()->route('admin.index');

        } else {
            Auth::logout();
            Session::flush();
        }

    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    public function welcome(){
        return view('welcome');
    }
}
