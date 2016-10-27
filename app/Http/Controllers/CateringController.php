<?php

namespace App\Http\Controllers;

use App\Catering;
use Auth;
use Validator;
use Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CateringController extends Controller
{
    /**
     * catering list view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listing() {
        $caterings = Catering::all()->sortBy('sorting');

        return view('catering.list')
            ->with('caterings', $caterings);
    }

    /**
     * catering admin list view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminList() {
        if (!Auth::check() || !Auth::user()->hasRole('cateringmanager')) {
            return redirect(route('home'));
        }

        $caterings = Catering::all()->sortBy('sorting');

        return view('admin.catering.list')
            ->with('caterings', $caterings);
    }

    /**
     * catering admin add view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminAdd() {
        if (!Auth::check() || !Auth::user()->hasRole('cateringmanager')) {
            return redirect(route('home'));
        }
        return view('admin.catering.add');
    }

    /**
     * catering admin add check
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminAddCheck(Request $request) {

        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            return redirect(route('home'));
        }

        $now = new Carbon();

        $messages = [
            'title.required' => 'Bitte gebe eine Bezeichnung an.',
            'title.max' => 'Die Bezeichnung darf nicht länger als 255 Zeichen sein.',
            'image.required' => 'Bitte lade ein Bild hoch.',
            'image.mimetypes' => 'Falsches Format. Nur JPG und PNG sind erlaubt.',
            'image.max' => 'Das Bild darf nicht größer als 200kb sein.',
            'description.required' => 'Bitte gebe eine Beschreibung an.',
            'costs.required' => 'Bitte gebe einen Preis an',
            'costs.regex' => 'Bitte gebe eine Kommazahl im Format 0,00 an.'
        ];

        $rules = [
            'title' => 'required|max:255',
            'image' => 'required|mimetypes:image/jpeg,image/png|max:200',
            'description' => 'required',
            'costs' => 'required|regex:"[0-9]*\,[0-9]*"'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('admin.catering.add'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $catering = new Catering();
            $catering->title = $request->title;
            $catering->description = $request->description;
            $catering->costs = str_replace(',', '.', $request->costs);
            $catering->save();
            
            if (!is_null($request->file('image'))) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                Storage::disk('catering')->put('catering-' . $catering->id . '.' . $extension,  File::get($file));
                $catering->image = 'catering-' . $catering->id . '.' . $extension;
            }

            $catering->save();

            flash('Der Eintrag wurde hinzugefügt.', 'success');
            return redirect(route('admin.catering.list'));
        }
    }

    /**
     * sort catering list
     *
     * @param Request $request
     * @return string
     */
    public function adminAjaxSort(Request $request) {
        if ($request->has('data') && !empty($request)) {
            $rows = explode('&', $request->data);

            foreach ($rows as $key=>$row) {
                if (preg_match('/catering\[\]\=([0-9]+)/', $row, $m) && isset($m[1]) && is_numeric($m[1])) {
                    $catering = Catering::findOrFail($m[1]);
                    if ($catering instanceof Catering) {
                        $catering->sorting = $key;
                        $catering->save();
                    }
                }

            }
        }

        return '';
    }

    public function adminAjaxFileUpload(Request $request) {
        dd($request);
        return true;
    }

    /**
     * delete a catering
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function adminPostDelete(Request $request) {

        //find catering
        $catering = Catering::findOrFail($request->catering_id);
        if ($catering instanceof Catering) {
            $catering->delete();

            flash('Die Speise wurde gelöscht.', 'success');
        }
        else {
            flash('Die Speise wurde nicht gefunden.', 'danger');
        }

        return redirect(route('admin.catering.list'));
    }
}
