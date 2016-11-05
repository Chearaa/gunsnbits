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

class ServiceController extends Controller
{
    /**
     * contact view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact() {
        return view('service.contact');
    }
    
    /**
     * validate and send contact email
     * 
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postContact(Request $request) {
    	
    	$messages = [
    		'email.required' => 'Bitte gebe eine E-Mail-Adresse an.',
            'email.email' => 'Bitte gebe eine korrekte E-Mail-Adresse an.',
            'email.max' => 'Die E-Mail-Adresse darf nicht länger als 255 Zeichen sein.',
    		'message.required' => 'Bitte hinterlasse eine Nachricht.'
    	];
    	 
    	$validator = Validator::make($request->all(), [
    		'email' => 'required|email|max:255',
    		'message' => 'required'
    	], $messages);
    	 
    	if ($validator->fails()) {
    		return redirect(route('service.contact'))
	    		->withErrors($validator)
	    		->withInput();
    	}
    	else {
    		Mail::send('email.contact', ['request' => $request], function ($m) use ($request) {
    			$m->from($request->email, $request->email);
    		
    			$m->to('chearaa@googlemail.com', 'Guns\'n Bits - Support')->subject('Kontaktanfrage');
    		});
    		
    		$request->session()->flash('alert-success', 'Die Nachricht wurde erfolgreich versendet.');
    		return redirect(route('service.contact'));
    	}
    }

	/**
	 * impressum view
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function impressum() {
		return view('service.impressum');
	}


	public function teamspeak() {
		// load framework files
		require_once("libraries/TeamSpeak3/TeamSpeak3.php");
		// connect to local server, authenticate and spawn an object for the virtual server on port 9987
		$ts3_VirtualServer = \TeamSpeak3::factory("serverquery://85.214.156.40:10011/?server_port=9987");

		return view('service.teamspeak')
			->with('ts3_VirtualServer', $ts3_VirtualServer);
	}
}
