<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Code;
use App\Lanparty;

class CodeController extends Controller
{
	/**
	 * get code list view
	 */
	public function listing() {
		$codes = Code::where('active', '=', true)->get();
		return view('admin.code.list')
			->with('codes', $codes);
	}
	
	/**
	 * get code add view
	 */
	public function add() {
		$lanparties = array();
		$lanparties = Lanparty::getAllInFuture()->lists('title', 'id')->all();
		$lanparties[0] = 'immer gültig';
		ksort($lanparties);
		
		return view('admin.code.add')
			->with('lanparties', $lanparties);
	}
	
	/**
	 * validate and generate codes
	 */
	public function postAdd(Request $request) {
		if (!empty($request->counter) && is_numeric($request->counter) && $request->counter > 0 && $request->counter <= 100) {
			$i = 0;
			$chars = 'ABCDEFGHJKLMNOPQRSTUVWXYZ23456789';
			srand((double)microtime()*1000000);
			
			do {
				$hash = '';
				
				//generate code
				for ($j=0; $j<10; $j++) {
					if ($j == 3 || $j == 6) {
						$hash .= '-';
						$j++;
					}
					$rnd = rand() % 33;
					$hash .= substr($chars, $rnd, 1);
				}
				
				//check if code exists
				if (Code::where('code', '=', $hash)->count() > 0) {
					//code exists
				}
				else {
					//insert code in table
					$code = new Code();
					$code->code = $hash;
					$code->lanparty_id = ($request->lanparty > 0) ? $request->lanparty : 0;
					$code->save();
					$i++;
				}
			}
			while ($i < $request->counter);
			
			flash('Gutschein-Codes wurden generiert.', 'success');
			return redirect(route('admin.code.list'));
		}
		else {
			flash('Es konnten keine Gutschein-Codes generiert werden.', 'danger');
		}
		return redirect(route('admin.code.add'));
	}
    
}
