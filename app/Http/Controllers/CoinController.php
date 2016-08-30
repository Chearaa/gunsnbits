<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Coin;
use App\User;

class CoinController extends Controller
{
	/**
	 * get user choice view
	 */
	public function user() {
		if (!Auth::check() || !Auth::user()->hasRole('admin')) {
			return redirect(route('home'));
		}
		
		return view('admin.coin.user');
	}
	
	/**
	 * validate user choice
	 *
	 * @param Request $request
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function postUser(Request $request) {
		if (!Auth::check() || !Auth::user()->hasRole('admin')) {
			return redirect(route('home'));
		}
		 
		if (!empty($request->user_id) && is_numeric($request->user_id) && $request->user_id > 0) {
			$user = User::findOrFail($request->user_id);
		}
		//try to find user by name
		elseif (DB::table('users')->where('name', 'like', $request->name)->count() == 1) {
			$user = DB::table('users')->where('name', 'like', $request->name)->first();
		}
		else {
			$request->session()->flash('alert-danger', 'Benutzer wurde nicht gefunden!');
			return redirect(route('admin.coin.user'));
		}
		
		if (!is_null($user)) {
			return redirect(route('admin.coin.user.list', [$user->id]));
		}
		else {
			$request->session()->flash('alert-danger', 'Benutzer wurde nicht gefunden!');
			return redirect(route('admin.coin.user'));
		}
	}
	
	/**
	 * get user choice view
	 */
	public function listUser($user_id = 0) {
		if (!Auth::check() || !Auth::user()->hasRole('admin')) {
			return redirect(route('home'));
		}
	
		$user = User::findOrFail($user_id);
		
		return view('admin.coin.userlist')
			->with('user', $user);
	}
	
	/**
	 * add coins manually
	 * 
	 * @param number $user_id
	 * @param Request $request
	 */
	public function addUser($user_id = 0, Request $request) {
		if (!Auth::check() || !Auth::user()->hasRole('admin')) {
			return redirect(route('home'));
		}
		
		$user = User::findOrFail($user_id);
		
		$messages = [
			'coins.required' => 'Bitte gebe an, wie viele Coins der Benutzer hinzugefügt/abgezogen bekommt.',
			'coins.numeric' => 'Bitte gebe eine Zahl ein.',
			'description.required' => 'Bitte gebe eine Beschreibung an.',
			'description.max' => 'Die Beschreibung darf nicht länger als 255 Zeichen sein.'
		];
		 
		$validator = Validator::make($request->all(), [
			'coins' => 'required|numeric',
			'description' => 'required|max:255',
		], $messages);
		 
		if ($validator->fails()) {
			return redirect(route('admin.coin.user.list', [$user->id]))
			->withErrors($validator)
			->withInput();
		}
		else {
			$coin = new Coin($request->all());
			$user->coins()->save($coin);
			
			$request->session()->flash('alert-success', 'Die Coins wurden hinzugefügt/abgezogen.');
		}
		
		return redirect(route('admin.coin.user.list', [$user->id]));
	}
    
	
	public function deleteCoin($user_id = 0, Request $request) {
		if (!Auth::check() || !Auth::user()->hasRole('admin')) {
			return redirect(route('home'));
		}
		
		$user = User::findOrFail($user_id);
		
		if (!empty($request->coin_id) && is_numeric($request->coin_id)) {
			$coin = Coin::findOrFail($request->coin_id);
			
			if ($coin instanceof Coin) {
				$coin->delete();
				
				$request->session()->flash('alert-success', 'Der Eintrag wurde gelöscht.');
			}
			else {
				$request->session()->flash('alert-danger', 'Wir konnten keinen Eintrag zur Löschung finden.');
			}
		}
		
		return redirect(route('admin.coin.user.list', [$user->id]));
	}
}
