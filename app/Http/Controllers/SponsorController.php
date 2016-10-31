<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Sponsor;
use Carbon\Carbon;

class SponsorController extends Controller
{
    /**
     * get sponsor list view
     */
	public function listing() {
		$sponsors = Sponsor::all()->shuffle();

		return view('sponsor.list')
			->with('sponsors', $sponsors->shuffle());
	}

    public function show($slug) {
        $sponsor = Sponsor::where('slug', $slug)->first();

        return view('sponsor.show')
            ->with('sponsor', $sponsor);
    }
	
    /**
     * ADMIN ACTIONS
     */
    
	/**
	 * admin list view
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function adminListing() {
		if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
			return redirect(route('home'));
		}
		
		$sponsors = Sponsor::all();
		
		return view('admin.sponsor.list')
			->with('sponsors', $sponsors);
	}
	
    /**
     * add view
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminAdd() {
    	if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	return view('admin.sponsor.add');
    }
    
    /**
     * validate and add sponsors
     * 
     * @param Request $request
     */
    public function adminPostAdd(Request $request) {
    	if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
            return redirect(route('home'));
        }
    	
    	$messages = [
    		'name.required' => 'Bitte gebe den Namen des Sponsors an.',
    		'name.max' => 'Der Name des Sponsors darf maximal 255 Zeichen lang sein.',
    		'logo.required' => 'Bitte lade ein Bild hoch.',
    		'logo.mimes' => 'Bitte lade ein Bild hoch. (JPG, PNG)',
    		'logo.max' => 'Das Bild darf nicht größer als 500kb sein.',
    		'url.url' => 'Bitte gebe eine korrekte URL an.',
    		'facebook.url' => 'Bitte gebe eine korrekte URL an.',
    		'twitter.url' => 'Bitte gebe eine korrekte URL an.',
    	];
    	
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|max:255',
    		'logo' => 'required|mimes:jpeg,jpg,png|max:500',
    		'url' => 'url',
    		'facebook' => 'url',
    		'twitter' => 'url'
    	], $messages);
    	
    	if ($validator->fails()) {
    		return redirect(route('admin.sponsor.add'))
    		->withErrors($validator)
    		->withInput();
    	}
    	else {
    		$sponsor = new Sponsor();
    		$sponsor->name = $request->name;
            $sponsor->slug = str_slug($request->name);
    		$sponsor->description = $request->description;
    		$sponsor->url = $request->url;
    		$sponsor->facebook = $request->facebook;
    		$sponsor->twitter = $request->twitter;
    		$sponsor->save();

            if (!is_null($request->file('logo')) && $request->cropped_image != '') {
                $orgfile = $request->file('logo');
                $extension = $orgfile->getClientOriginalExtension();

                $cropped_file = str_replace('data:image/png;base64,', '', $request->cropped_image);
                $cropped_image = str_replace(' ', '+', $cropped_file);
                $cropped_data = base64_decode($cropped_image);

                Storage::disk('sponsors')->put('sponsor-' . $sponsor->id . '.' . $extension,  $cropped_data);
                $sponsor->logo = 'sponsor-' . $sponsor->id . '.' . $extension;

                $sponsor->save();
            }

    		flash('Der Sponsor wurde angelegt.', 'success');
			return redirect(route('admin.sponsor.list'));
    	}
    }
    
    /**
     * edit view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminEdit($sponsor_id = 0) {
    	if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	$sponsor = Sponsor::findOrFail($sponsor_id);
    	 
    	return view('admin.sponsor.edit')
    		->with('sponsor', $sponsor);
    }
    
    /**
     * validate and update sponsor
     *
     * @param Request $request
     */
    public function adminPostEdit($sponsor_id = 0, Request $request) {
    	if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	$now = new Carbon();
    	$sponsor = Sponsor::findOrFail($sponsor_id);
    	 
    	$messages = [
    		'name.required' => 'Bitte gebe den Namen des Sponsors an.',
    		'name.max' => 'Der Name des Sponsors darf maximal 255 Zeichen lang sein.',
    		'logo.mimes' => 'Bitte lade ein Bild hoch. (JPG, PNG)',
    		'logo.max' => 'Das Bild darf nicht größer als 200kb sein.',
    		'url.url' => 'Bitte gebe eine korrekte URL an.',
    		'facebook.url' => 'Bitte gebe eine korrekte URL an.',
    		'twitter.url' => 'Bitte gebe eine korrekte URL an.',
    	];
    	 
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|max:255',
    		'logo' => 'mimes:jpeg,jpg,png|max:200',
    		'url' => 'url',
    		'facebook' => 'url',
    		'twitter' => 'url'
    	], $messages);
    	 
    	if ($validator->fails()) {
    		return redirect(route('admin.sponsor.edit', [$sponsor->id]))
    		->withErrors($validator)
    		->withInput();
    	}
    	else {
    		
    		$sponsor->name = $request->name;
            $sponsor->slug = str_slug($request->name);
    		$sponsor->description = $request->description;
    		$sponsor->url = $request->url;
    		$sponsor->facebook = $request->facebook;
    		$sponsor->twitter = $request->twitter;

            if (!is_null($request->file('logo')) && $request->cropped_image != '') {
                $orgfile = $request->file('logo');
                $extension = $orgfile->getClientOriginalExtension();

                $cropped_file = str_replace('data:image/png;base64,', '', $request->cropped_image);
                $cropped_image = str_replace(' ', '+', $cropped_file);
                $cropped_data = base64_decode($cropped_image);

                Storage::disk('sponsors')->put('sponsor-' . $sponsor->id . '.' . $extension, $cropped_data);
                $sponsor->logo = 'sponsor-' . $sponsor->id . '.' . $extension;
            }

    		$sponsor->save();
    
    		flash('Der Sponsor wurde aktualisiert.', 'success');
    		return redirect(route('admin.sponsor.list'));
    	}
    }
    
    public function adminPostDelete(Request $request) {
    	
    	//find sponsor
    	$sponsor = Sponsor::findOrFail($request->sponsor_id);
    	if ($sponsor instanceof Sponsor) {
    		$sponsor->delete();
    		
    		flash('Der Sponsor wurde gelöscht.', 'success');
    	}
    	else {
    		flash('Der Sponsor wurde nicht gefunden.', 'danger');
    	}
    	
    	return redirect(route('admin.sponsor.list'));
    }
}
