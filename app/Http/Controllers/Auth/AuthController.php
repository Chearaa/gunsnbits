<?php

namespace App\Http\Controllers\Auth;

use App\User;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Register success view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerSuccess() {
        return view('auth.registersuccess');
    }

    /**
     * OVERRIDE!
     *
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(LaravelFacebookSdk $fb)
    {
        session(['facebook_function' => 'login']);
        $login_url = $fb->getLoginUrl(['email'], '/facebook/callback');

        $view = property_exists($this, 'loginView')
            ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view, [
                'login_url' => $login_url
            ]);
        }

        return view('auth.login', [
            'login_url' => $login_url
        ]);
    }

    /**
     * OVERRIDE!
     *
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(LaravelFacebookSdk $fb)
    {
        session(['facebook_function' => 'register']);
        $login_url = $fb->getLoginUrl(['email'], '/facebook/callback');

        if (property_exists($this, 'registerView')) {
            return view($this->registerView, [
                'login_url' => $login_url
            ]);
        }

        return view('auth.register', [
            'login_url' => $login_url
        ]);
    }
}
