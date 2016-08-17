<?php

namespace App\Http\Controllers\Auth;

use App\Facebookuser;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Validator;
use App\Http\Controllers\Controller;

class FacebookController extends Controller
{
    /**
     * Callback function.
     *
     * @param LaravelFacebookSdk $fb
     */
    public function callback(LaravelFacebookSdk $fb) {

        // Obtain an access token.
        try {
            $token = $fb->getAccessTokenFromRedirect();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }

        // Access token will be null if the user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if (! $token) {
            // Get the redirect helper
            $helper = $fb->getRedirectLoginHelper();

            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            // User denied the request
            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }

        if (! $token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $fb->getOAuth2Client();

            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }

        $fb->setDefaultAccessToken($token);

        // Save for later
        Session::put('fb_user_access_token', (string) $token);

        // Get basic info on the user from Facebook.
        try {
            $response = $fb->get('/me?fields=id,name,email');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }

        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $facebook_user = $response->getGraphUser();

        /**
         * now we have a GraphUser
         *
         * GraphUser {
         *  'id' => '...'
         *  'name' => '...'
         *  'email' => '...'
         * }
         *
         * lets see what we do...
         */

        //login
        if (Session::get('facebook_function') == 'login') {

            //check if facebook user exists in facebookusers table
            $facebookuser = Facebookuser::where('id', $facebook_user['id'])->first();
            if (! $facebookuser) {
                //if facebook-id not exists in facebookusers table, lets try to find someone with the same email-address
                $user = User::where('email', $facebook_user['email'])->first();
                if (! $user) {
                    //cant find a user with same email-address
                    return redirect( route('facebook.error') )
                        ->with('alerts', [
                            [
                                'class' => 'danger',
                                'msg' =>'<h4>Wir konnten deinen Benutzer-Account leider nicht finden</h4><br/>
                                         Bitte <a href="' . route('auth.register') . '"><i class="fa fa-user-plus"></i> registriere</a> einen neuen Account oder verbinde deinen bestehenden Benutzer-Account mit Facebook auf deiner Profil-Seite.<br/><br/>
                                         <a href="' . route('auth.login') . '" class="btn btn-default"><i class="fa fa-chevron-left"></i> zurück zum Login</a>'
                            ]
                        ]);
                }
                else {
                    //user found with same email-address
                    //let's connect facebookuser with user

                    //create new facebookuser
                    $facebookuser = new Facebookuser([
                        'id' => $facebook_user['id'],
                        'name' => $facebook_user['name'],
                        'email' => $facebook_user['email']
                    ]);
                    $user->facebookuser()->save($facebookuser);

                    //login user with id and the "remember me" cookie
                    if (Auth::loginUsingId($user->id, true)) {
                        // Authentication passed...
                        return redirect()->intended( route('home') );
                    }
                    else {
                        return redirect( route('facebook.error') )
                            ->with('alerts', [
                                [
                                    'class' => 'danger',
                                    'msg' =>'<h4>Login fehlgeschlagen</h4><br/>
                                         Es gab ein technisches Problem beim Login. Bitte versuche es später noch einmal.<br/><br/>
                                         <a href="' . route('auth.login') . '" class="btn btn-default"><i class="fa fa-chevron-left"></i> zurück zum Login</a>'
                                ]
                            ]);
                    }
                }
            }
            else {
                //facebookuser exists in facebookusers table

                //get user
                $user = $facebookuser->user()->first();

                //login user with id and the "remember me" cookie
                if (Auth::loginUsingId($user->id, true)) {
                    // Authentication passed...
                    return redirect()->intended( route('home') );
                }
                else {
                    return redirect( route('facebook.error') )
                        ->with('alerts', [
                            [
                                'class' => 'danger',
                                'msg' =>'<h4>Login fehlgeschlagen</h4><br/>
                                         Es gab ein technisches Problem beim Login. Bitte versuche es später noch einmal.<br/><br/>
                                         <a href="' . route('auth.login') . '" class="btn btn-default"><i class="fa fa-chevron-left"></i> zurück zum Login</a>'
                            ]
                        ]);
                }
            }
        }
    }

    public function error() {
        return view('auth.error', [
            'alerts' => (session()->has('alerts')) ? session('alerts') : []
        ]);
    }
}
