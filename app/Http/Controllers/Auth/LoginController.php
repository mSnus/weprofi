<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

include_once(base_path().'/app/helpers.php');
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }
 
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function attemptLogin(Request $request)
    {
        $request['phone'] = parsePhone($request->phone);

        if (isset($request->return)) {
            $this->redirectTo = $request->return;
        }

        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }
}
