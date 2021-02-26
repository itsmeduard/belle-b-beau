<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite,Redirect;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($service): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver ( $service )->redirect ();
    }
    public function callback($service) {
        $user = Socialite::with ( $service )->user ();
        return redirect()->route('dashboard.index')->withDetails ( $user )->withService ( $service );
    }
}
