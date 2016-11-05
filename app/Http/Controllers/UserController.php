<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Auth;
use Mockery\CountValidator\Exception;
use Validator;
use App\User;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Libraries\PasswordHash;

class UserController extends Controller
{
    /**
     * register user view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRegister() {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('user.register');
    }

    /**
     * validate and register user
     *
     * @param Request $request
     * @return $this
     */
    public function postRegister(Request $request) {

        $messages = [
            'name.required' => 'Bitte gebe einen Benutzernamen an.',
            'name.max' => 'Der Benutzername darf nicht länger als 255 Zeichen sein.',
            'email.required' => 'Bitte gebe eine E-Mail-Adresse an.',
            'email.email' => 'Bitte gebe eine korrekte E-Mail-Adresse an.',
            'email.unique' => 'Diese E-Mail-Adresse wird schon verwendet.',
            'email.max' => 'Die E-Mail-Adresse darf nicht länger als 255 Zeichen sein.',
            'password.max' => 'Das Passwort darf nicht länger als 60 Zeichen sein.',
            'password.required' => 'Bitte gebe ein Passwort ein.',
            'password_confirm.required' => 'Bitte gebe das Passwort nochmal ein.',
            'password_confirm.max' => 'Das Passwort darf nicht länger als 60 Zeichen sein.',
            'password_confirm.same' => 'Die Passwörter müssen gleich sein.'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:60',
            'password_confirm' => 'required|same:password|max:60'
        ], $messages);

        if ($validator->fails()) {
            return redirect(route('user.register'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            //register this user
            $user = new User($request->all());
            $user->password = bcrypt($request->input('password'));
            $user->save();

            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)) {
                // Authentication passed...
                return redirect()->intended(route('home'));
            }
        }
    }

    public function getLogin() {
        if (Auth::check()) {
            return redirect(route('home'))
                ->with('flash_message', 'Du bist bereits eingeloggt.');
        }
        return view('user.login');
    }

    /**
     * validate and login user
     *
     * @param Request $request
     * @return $this
     */
    public function postLogin(Request $request) {

        $messages = [
            'email.required' => 'Bitte gebe eine E-Mail-Adresse an.',
            'email.email' => 'Bitte gebe eine korrekte E-Mail-Adresse an.',
            'email.max' => 'Die E-Mail-Adresse darf nicht länger als 255 Zeichen sein.',
            'password.max' => 'Das Passwort darf nicht länger als 60 Zeichen sein.',
            'password.required' => 'Bitte gebe ein Passwort ein.'
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:60',
        ], $messages);

        if ($validator->fails()) {
            return redirect(route('user.login'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            //login

            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)) {
                // Authentication passed...
                return redirect()->intended(route('home'));
            }
            else {
            	//check if user logs in with old typo3password
            	$pwh = new PasswordHash(8, true);
            	$user = User::findByEmailOrFail($request->email);
            	
            	if ($user instanceof User && $pwh->CheckPassword($request->password, $user->typo3password)) {
            		//set password and then login
            		$user->password = bcrypt($request->password);
            		$user->save();
            		
            		if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)) {
            			// Authentication passed...
            			return redirect()->intended(route('home'));
            		}
            	}
            	else {
	                $errors = array(
	                    'login' => 'Wir konnten dich leider nicht einloggen.'
	                );
	                return redirect(route('user.login'))
	                    ->withErrors($errors)
	                    ->withInput();
            	}
            }
        }
    }

    /**
     * logout user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout() {
        Auth::logout();
        return redirect(route('home'))
            ->with('flash_message', 'Du hast dich erfolgreich ausgeloggt.');
    }

    /**
     * view to reset the password
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPasswordReset() {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('user.passwordreset');
    }

    /**
     * validate user and send reset email
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postPasswordReset(Request $request) {
        if (Auth::check()) {
            return redirect(route('home'));
        }

        $messages = [
            'email.required' => 'Bitte gebe eine E-Mail-Adresse an.',
            'email.email' => 'Bitte gebe eine korrekte E-Mail-Adresse an.',
            'email.max' => 'Die E-Mail-Adresse darf nicht länger als 255 Zeichen sein.'
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ], $messages);

        if ($validator->fails()) {
            return redirect(route('user.passwordreset'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $user = User::findByEmailOrFail($request->get('email'));

            if (!is_null($user)) {
                $hash = Hash::make($request->get('email'));
                DB::table('password_resets')->insert([
                    ['email' => $request->get('email'), 'token' => $hash]
                ]);

                Mail::send('email.passwordreset', ['user' => $user, 'hash' => $hash], function ($m) use ($user) {
                    $m->from('info@gunsnbits.de', 'Guns`n`Bits');

                    $m->to($user->email, $user->name)->subject('Du hast dein Passwort vergessen?');
                });

                $errors = array(
                    'userfound' => 'Wir haben dir eine E-Mail geschickt, um dein Passwort zurücksetzen zu können.'
                );
                return redirect(route('user.passwordreset'))
                    ->withErrors($errors);
            }
            else {
                $errors = array(
                    'usernotfound' => 'Diese E-Mail-Adresse konnten wir leider nicht finden.'
                );
                return redirect(route('user.passwordreset'))
                    ->withErrors($errors);
            }
        }
    }

    /**
     * view for resetting password
     *
     * @param Request $request
     * @return $this
     */
    public function getPasswordResetHash(Request $request) {
        if (!empty($request->get('hash'))) {
            if ($data = DB::table('password_resets')->where('token', '=', $request->get('hash'))->first()) {
                return view('user.newpassword')
                    ->with('data', $data);
            }
        }

        $invalidHash = 'Validierung fehlgeschlagen. Leider kannst du kein neues Passwort vergeben.';

        return view('user.newpassword')
            ->with('invalidHash', $invalidHash);
    }

    /**
     * reset password and log in
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postNewPassword(Request $request) {

        $messages = [
            'password.max' => 'Das Passwort darf nicht länger als 60 Zeichen sein.',
            'password.required' => 'Bitte gebe ein Passwort ein.',
            'password_confirm.required' => 'Bitte gebe das Passwort nochmal ein.',
            'password_confirm.max' => 'Das Passwort darf nicht länger als 60 Zeichen sein.',
            'password_confirm.same' => 'Die Passwörter müssen gleich sein.'
        ];

        $validator = Validator::make($request->all(), [
            'password' => 'required|max:60',
            'password_confirm' => 'required|same:password|max:60'
        ], $messages);

        if ($validator->fails()) {
            return redirect(route('user.passwordreset.hash') . '?hash=' . $request->hash)
                ->withErrors($validator)
                ->withInput();
        }
        else {

            //find user
            if ($user = User::findByPasswordHashOrFail($request->get('hash'))) {

                //set new password
                $user->password = bcrypt($request->get('password'));
                $user->update();

                if (Auth::attempt(['email' => $user->email, 'password' => $request->get('password')], true)) {
                    // Authentication passed...
                    return redirect()->intended(route('home'));
                }
            }

            $invalidHash = 'Validierung fehlgeschlagen. Leider kannst du kein neues Passwort vergeben.';

            return view('user.newpassword')
                ->with('invalidHash', $invalidHash);
        }
    }

    /**
     * show user profile
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getProfile() {
        if (!Auth::check()) {
            return redirect()->intended(route('home'));
        }
        
        return view('user.profile')
            ->with('user', Auth::user());
    }

    /**
     * edit user profile
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editProfile() {
        if (!Auth::check()) {
            return redirect()->intended(route('home'));
        }

        return view('user.editprofile')
            ->with('user', Auth::user());
    }

    /**
     * validate and update profile data
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postEditProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->intended(route('home'));
        }
        
        $messages = [
            'email.required' => 'Bitte gebe eine E-Mail-Adresse an.',
            'email.email' => 'Bitte gebe eine korrekte E-Mail-Adresse an.',
            'email.max' => 'Die E-Mail-Adresse darf nicht länger als 255 Zeichen sein.',
            'email.unique' => 'Diese E-Mail-Adresse wird bereits genutzt.',
            'birthdate.date' => 'Bitte gebe ein korrektes Datum an.',
            'birthdate.date_format' => 'Bitte gebe das Datum im Format 00.00.0000 an.',
        	'avatar.mimes' => 'Bitte lade ein Bild hoch. (JPG, PNG)',
        	'avatar.max' => 'Das Bild darf nicht größer als 1MB sein.'
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,id,' . Auth::user()->id . '|max:255',
            'birthdate' => 'date|date_format:d.m.Y',
            'avatar' => 'mimes:jpeg,jpg,png|max:1024'
        ], $messages);

        if ($validator->fails()) {
            return redirect(route('user.editprofile.post'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
        	$user = Auth::user();
        	$user->email = $request->get('email');

            if ($request->get('birthdate') != '') {
                $birthdate = Carbon::createFromFormat('d.m.Y', $request->get('birthdate'))->startOfDay();
                $user->birthday = $birthdate;
            }

            if (!is_null($request->file('avatar')) && $request->cropped_image != '') {
                $orgfile = $request->file('avatar');
                $extension = $orgfile->getClientOriginalExtension();

                $cropped_file = str_replace('data:image/png;base64,', '', $request->cropped_image);
                $cropped_image = str_replace(' ', '+', $cropped_file);
                $cropped_data = base64_decode($cropped_image);

                Storage::disk('avatar')->put('avatar-' . $user->id . '.' . $extension,  $cropped_data);
                $user->avatar = 'avatar-' . $user->id . '.' . $extension;
            }

            //save
            $user->save();

            return redirect(route('user.profile'));
        }
    }
    
    public function coins() {
    	if (!Auth::check()) {
    		return redirect()->intended(route('home'));
    	}
    	
    	$user = Auth::user();
    	return view('user.coins')
    		->with('user', $user);
    }
}
