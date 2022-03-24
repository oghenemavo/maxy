<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Hash;


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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $username = $request->email; //the input field has name='username' in form
        $password = $request->password; 

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            //user sent their email 
            $loggedIn = Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
            //they sent their username instead 
            $loggedIn = Auth::attempt(['username' => $username, 'password' => $password]);
        }

        // //was any of those correct ?
        // if ( Auth::check() ) {
        //     //send them where they are going 
        //     return redirect()->intended('dashboard');
        // }

        // //Nope, something wrong during authentication 
        // return redirect()->back()->withErrors([
        //     'credentials' => 'Please, check your credentials'
        // ]);

        

        // // Attempt Logins
        // $credentials = $request->only('email', 'password');

        
        if ($loggedIn) {
            // Authentication passed...
            log_action(Auth::id(), 'User Login', 'App\Models\User', Auth::id(), 'User login.');

            $request->session()->regenerate();
            $previous_session = Auth::User()->session_id;
            if ($previous_session) {
                Session::getHandler()->destroy($previous_session);
            }

            Auth::user()->session_id = Session::getId();
            Auth::user()->save();

            // dd(Auth::user());

            $this->clearLoginAttempts($request);

            if(!Auth::user()->is_active ) {
                Auth::logout();
                return ['status' => '500', 'message' => 'Your account has been deactivated. Please contact your administrator'];
            }else {
                return ['status' => '200', 'data' => Auth::user()];
            }

        }

        return ['status' => '500', 'message' => 'Invalid email/ staff ID or password.<br/>Please input correct login details.'];
    }


    public function register(Request $request)
    {

           $user = User::FirstorCreate([ 'first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'username' => $request->username, 'staff_id' => $request->staff_id, 'password' => Hash::make($request->password) ]);

            return ['status' => '200', 'data' => $user ];
    }



    /**
     * Send the response after the user was authenticated.
     * Remove the other sessions of this user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = Session::getId();
        Auth::user()->save();

        // dd(Auth::user());

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}
