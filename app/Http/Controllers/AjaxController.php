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

class AjaxController extends Controller
{
	/**
	 * get users in json format
	 * 
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
    public function users() {
    	if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	return User::where('active', '=', true)->get()->jsonSerialize();
    }
}
